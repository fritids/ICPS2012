<?php

require_once( ABSPATH . WPINC . '/registration.php' );

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
	'contribute' => $_POST['contribute']
    );

    $safedata = array_map('mysql_real_escape_string', $userdata);

    if( !is_email($safedata['email']) ) return array(false, 1);

    $username = $safedata['email'];
    if( username_exists( $username ) ) return array(false, 2);

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
        

    $user_metas = array('country', 'university', 'study', 'level', 'contribute');

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