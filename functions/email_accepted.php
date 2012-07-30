<?php
			       
 $users = get_users('role=applicant&orderby=id&fields=id&meta_key=admission_round&meta_value=13');

// $users = array(29,28);
//var_dump($users);
$archive_address = 'registration@icps2012.com';


$i=0;
foreach($users as $user_id) :

    $user = get_userdata($user_id);


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

    $file = 'accepted_fullfee.txt';
    if($user->ID < 586) $file = 'accepted.txt';

    $email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/'.$file);


    $email = icps_format_email($email_tmpl, $user_email_params);


    $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/acceptance_archive.txt');


    $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);




 /*  if(!wp_mail($user->user_email, $email['subject'], $email['body'], array('Reply-To: registration@icps2012.com'))) 
        die('user ' . $user->ID);
    if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
        die('archief probleem' . $user->ID);
*/

$i++;

echo $user_id . ' ' . $user->user_firstname . ' ' . $user->user_lastname . ' ' . $file . '<br>';    
endforeach;
echo $i;
