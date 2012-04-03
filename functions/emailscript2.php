<?php

/*
require 'functions/register.php';
			       
$users = get_users('role=applicant&meta_key=admission_round&meta_value=2&orderby=id&fields=id');

$archive_address = 'registration@icps2012.com';

$i=0;
foreach($users as $user_id) :

    $user = get_userdata($user_id);
    $a_status = get_user_meta($user_id, 'application_status', true);
    $a_round = get_user_meta($user_id, 'admission_round', true);


    $accepted_email_params = array(
        'first_name' => $user->user_firstname,
	'email_id' => substr($user->user_email, 0, strpos($user->user_email, '@'))
    );

    $archive_email_params = array(
        'first_name' => $user->user_firstname,
	'last_name' => $user->user_lastname,
	'email' => $user->user_email,
	'uuid' => $user->ID,
	'accepted' => $a_status == 3 ? 'yes' : 'no'
    );


    if($user_id <= 586)
        $email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/accepted.txt');
    else
        $email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/accepted_fullfee.txt');    

    $email = icps_format_email($email_tmpl, $accepted_email_params);


    $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/acceptance_archive.txt');


    $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);



    if(!wp_mail($user->user_email, $email['subject'], $email['body'], array('Reply-To: registration@icps2012.com'))) 
        die('user ' . $user->ID);
    if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
        die('archief probleem' . $user->ID);

echo $user_id . '<br>';    
$i++;

endforeach;
echo $i;