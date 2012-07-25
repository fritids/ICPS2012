<?php

require_once( ABSPATH . WPINC . '/registration.php' );


function icps_cast_data($first_name, $last_name, $study, $level) {
	
}

function icps_cast_field($name, $nicename, $type, $editable, $double = false) {
    return array('name' => $name, 'value' => null, 'nicename' => $nicename, 'type' => $type, 'editable' => $editable, 'double' => $double);
}

function icps_populate_fields( $fields, $uid ) {
 return $fields;
}

require 'fields.php';


function icps_register_user($data) {
    $userdata = array(
    	'first_name' => $_POST['first_name'],
	'last_name' => $_POST['last_name'],
        'display_name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
	'email' => $_POST['email'],
	'country' => $_POST['country'],
	'university' => $_POST['university'],
	'study' => $_POST['study'],
	'level' => $_POST['level'],
	'contribute' => $_POST['contribute'],
        'application_status' => 1,
	'admission_round' => 0,
	'address' => '',
	'postal_code' => '',
	'city' => '',
	'date_of_birth' => '',
	'passport_nr' => '',
	'poster_b' => '',
	'lecture_b' => '',
	'poster_sub' => '',
	'lecture_sub' => '',
	'payment_amount' => 0,
	'preferred_accommodation' => '',
	'lecture_abstract' => '',
	'poster_abstract' => '',
	'extra_day_pre' => '',
	'extra_day_post' => ''
    );

    $safedata = array_map('strip_tags', $userdata);
    $safedata = array_map('htmlentities', $safedata);
    $safedata = array_map('mysql_real_escape_string', $safedata);
    

    if( !is_email($safedata['email']) ) return array(false, 1);

    $username = $safedata['email'];
    if( username_exists( $username ) ) return array(false, 2);
    $email = $safedata['email'];
    if( email_exists( $email ) ) return array(false, 2);

    $random_pw = wp_generate_password(8, false);
    $user_id = wp_create_user( $username, $random_pw, $safedata['email'] );

    if(! wp_update_user( array(
        'ID' => $user_id,
        'first_name' => $safedata['first_name'],
        'last_name' => $safedata['last_name'],
        'display_name' => $safedata['display_name'],
	'role' => 'applicant'
        )) 
    ) :
        wp_delete_user( $user_id );
	return array(false, 99);
    endif; // update basic user info
        

    $user_metas = array('country', 'university', 'study', 'level', 'contribute', 'application_status', 	'address','postal_code','city','date_of_birth','passport_nr','poster_b','lecture_b','poster_sub','lecture_sub', 'admission_round', 'payment_amount', 'preferred_accommodation', 'lecture_abstract', 'poster_abstract', 'extra_day_pre', 'extra_day_post');

    foreach($user_metas as $field) :
        if(!update_user_meta( $user_id, $field, $safedata[$field] ) ) {
            wp_delete_user( $user_id );
	    return array(false, 99);
        }
    endforeach; // user meta fields

    $mail_sent = icps_send_registration_email($user_id, $random_pw);

    return array(true, $user_id);
}

function icps_send_registration_email($user_id, $password) {
    $archive_address = 'registration@icps2012.com';
    $user = get_userdata($user_id);

    $user_email_params = array(
        'first_name' => $user->user_firstname,
	'email' => $user->user_email,
	'password' => $password
    );

    $archive_email_params = array(
        'first_name' => $user->user_firstname,
	'last_name' => $user->user_lastname,
	'email' => $user->user_email,
	'country' => get_usermeta($user_id, 'country'),
	'university' => get_usermeta($user_id, 'university'),
	'study' => get_usermeta($user_id, 'study'),
	'level' => get_usermeta($user_id, 'level'),
	'contribute' => get_usermeta($user_id, 'contribute')
    );

    $user_email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/user_email.txt');
    $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/archive_email.txt');

    $user_email = icps_format_email($user_email_tmpl, $user_email_params);
    $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);

    if(!wp_mail($user->user_email, $user_email['subject'], $user_email['body'], array('Reply-To: registration@icps2012.com'))) 
        return false;
    if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
        return false;

    return true;
}

function icps_format_email($text, $params) {
    $firstline_end = strpos($text, "\n");
    $subject = substr($text, 0, $firstline_end);
    $body_tmpl = substr($text, $firstline_end + 1);
    
    foreach($params as $key => $value) :
        $body_tmpl = str_replace('{$'.$key.'}', $value, $body_tmpl);
    endforeach; // templating
    
    $body = $body_tmpl; 

    return array('subject' => $subject, 'body' => $body);
}

function icps_update_udetails($uid, $data) {
        $sfields = icps_user_editable_standardfields();
	$mfields = icps_user_editable_metafields();

        $safepost = array_map('strip_tags', $data);
	//$safepost = array_map('htmlentities', $safepost);
	$safepost = array_map('mysql_real_escape_string', $safepost);

	$complete = true;

	$sdata = array('ID'=>$uid);
	foreach($sfields as $sfield) :
	    $sdata[$sfield['name']] = $safepost[$sfield['name']];
	    if(empty($safepost[$sfield['name']])) $complete = false;
	endforeach; // sfields
        wp_update_user($sdata);

	foreach($mfields as $mfield) :
	    update_user_meta($uid, $mfield['name'], $safepost[$mfield['name']]);
	    if(empty($safepost[$mfield['name']])) :
	        if(!in_array($mfield['name'], array('poster_b', 'lecture_b', 'poster_sub', 'lecture_sub'))) $complete = false;
	    endif;
	endforeach; // mfields

        $appstatus = get_user_meta($uid, 'application_status', true);
	if($complete) {
            if($appstatus % 8 < 4) :
                if($data['term_agree'] !== 'on') return false;
	        update_user_meta($uid, 'application_status', $appstatus + 4);
            endif;
	} else {
	    if($appstatus % 8 > 4) update_user_meta($uid, 'application_status', $appstatus - 4);
	}
        return true;
}

function icps_update_adetails($uid, $data) {
        $afields = icps_additional_detail_fields();

        $safepost = array_map('strip_tags', $data);
	//$safepost = array_map('htmlentities', $safepost);
	$safepost = array_map('mysql_real_escape_string', $safepost);

	$complete = true;

	$sdata = array('ID'=>$uid);

	foreach($afields as $afield) :
	    update_user_meta($uid, $afield['name'], $safepost[$afield['name']]);
	endforeach; // afields

        return true;
}