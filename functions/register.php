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

    $random_pw = wp_generate_password();
    $user_id = wp_create_user( $username, $random_pw, $safedata['email'] );

    if(! wp_update_user( array(
        'ID' => $user_id,
        'first_name' => $safedata['first_name'],
        'last_name' => $safedata['last_name'],
        'display_name' => $safedata['display_name']
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

    return array(true, $user_id);
}