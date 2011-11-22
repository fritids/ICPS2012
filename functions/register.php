<?php

require_once( ABSPATH . WPINC . '/registration.php' );

function icps_register_user($data) {
    $userdata = array(
        'first_name' => $_POST['first_name'],
	'last_name' => $_POST['last_name'],
	'email' => $_POST['email'],
	'country' => $_POST['country'],
	'university' => $_POST['university'],
	'study' => $_POST['study'],
	'level' => $_POST['level'],
	'contribute' => $_POST['contribute']
    );

    array_walk($userdata, esc_attr);

    
}