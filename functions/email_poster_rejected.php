<?php


//$users = get_users('role=applicant&orderby=id&fields=id');

//$users = array(443, 659);

$users = array(28,29,34,54,62,63,83,88,109,117,149,161,173,178,217,264,289,309,330,348,357,386,415,429,443,447,470,498,515,530,568,620,641,659,700,705,731,736,742,851);

$archive_address = 'registration@icps2012.com';


$i=0;
foreach($users as $user_id) :

$user = get_userdata($user_id);
if(get_user_meta($user_id, 'application_status', true) == 0) continue;

    $user_email_params = array(
        'first_name' => $user->user_firstname,
	'email_id' => substr($user->user_email, 0, strpos($user->user_email, '@'))
    );

    $archive_email_params = array(
        'first_name' => $user->user_firstname,
	'last_name' => $user->user_lastname,
	'email' => $user->user_email,
	'uuid' => $user->ID,
	'accepted' => 'yes'
    );

    $file = 'poster_rejected.txt';

    $email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/'.$file);


    $email = icps_format_email($email_tmpl, $user_email_params);


    $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/poster_rejected.txt');


    $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);



/*
    if(!wp_mail($user->user_email, $email['subject'], $email['body'], array('Reply-To: registration@icps2012.com'))) 
        die('user ' . $user->ID);
    if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
        die('archief probleem' . $user->ID);
 */

$i++;

echo $user_id . ' - ' . $user->first_name . ' - ' . $file . '<br>';    
endforeach;
echo $i;