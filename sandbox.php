<?php
/*
** Template name: Sandbox
*/


if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

var_dump(htmlentities('Eötvös Loránd University'));

die;
/*
require 'functions/register.php';

$uids = get_users( array('role' => 'applicant', 'fields' => 'ID', 'orderby' => 'ID') );

$archive_address = 'registration@icps2012.com';

$ii = 0;
$user_ids = array_slice($uids, 502, 100);

var_dump($user_ids);  die;
/*


foreach($user_ids as $user_id) :

    $user = get_userdata($user_id);
    $a_status = get_user_meta($user_id, 'application_status', true);
    $accepted_email_params = array(
        'first_name' => $user->user_firstname,
	'email_id' => substr($user->user_email, 0, strpos($user->user_email, '@'))
    );

    $notyet_email_params = array(
        'first_name' => $user->user_firstname,
    );

    $archive_email_params = array(
        'first_name' => $user->user_firstname,
	'last_name' => $user->user_lastname,
	'email' => $user->user_email,
	'uuid' => $user->ID,
	'accepted' => $a_status == 3 ? 'yes' : 'no'
    );


    if($a_status == 3) :
        $email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/accepted.txt');
        $email = icps_format_email($email_tmpl, $accepted_email_params);
    elseif($a_status == 1) :
        $email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/notyet.txt');
        $email = icps_format_email($email_tmpl, $notyet_email_params);
    endif;
    $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/tmpls/acceptance_archive.txt');


    $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);

    if(!wp_mail($user->user_email, $email['subject'], $email['body'], array('Reply-To: registration@icps2012.com'))) 
        die('user ' . $user->ID);
    if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
        die('archief probleem' . $user->ID);

echo $ii . 'gelukt';

$ii++;
endforeach;
