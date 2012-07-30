<?php
			       
  $users = get_users('role=applicant&fields=user_id&order=ASC');
sort($users);
//$users = array(28, 29, 443, 659);


$archive_address = 'registration@icps2012.com';

echo '<ul>';
$i=0;
foreach($users as $user_id) {
  if(get_user_meta($user_id, 'application_status', true) < 3) continue;
    if($i < 200) { $i++; continue; }
      if($i > 299) break;
  $user = get_userdata($user_id);

  $total_fee = 180;
  if($user->ID > 586) $total_fee = 200;

  $completed_payment = (int) get_user_meta($user->ID, 'payment_amount', true);
  var_dump($completed_payment);
  $extra_night_pre = get_user_meta($user->ID, 'extra_day_pre', true);
  $extra_night_post = get_user_meta($user->ID, 'extra_day_post', true);
  $member = get_user_meta($user->ID, 'iaps_member', true);

  if($extra_night_pre == 'on') $total_fee += 25;
  if($extra_night_post == 'on') $total_fee += 25;
  if($member != '1') $total_fee += 10;

  $required_payment = $total_fee - $completed_payment;
  var_dump($required_payment);
  if($required_payment < 0) $required_payment = 0;

  $accommodation = get_user_meta($user->ID, 'preferred_accommodation', true);


  $user_email_params = array(
			     'first_name' => $user->user_firstname,
			     'required_payment' => $required_payment
			     );

  $archive_email_params = array(
				'first_name' => $user->user_firstname,
				'last_name' => $user->user_lastname,
				'email' => $user->user_email,
				'uuid' => $user->ID
				);
  $template_dir = '/../tmpls/arrival/';
  $template = '';

  $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'head.txt');

  if($required_payment > 0) $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'guaps.txt');

  $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'middle.txt');

  if($accommodation == 'University College Utrecht') $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'UCU.txt');
  else if($accommodation == 'Bed&Breakfast Utrecht') $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'BB.txt');

  /*    if($lecture) $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'lecture.txt');
	if($poster) $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'poster.txt');*/

  $template .= file_get_contents(dirname(__FILE__) . $template_dir . 'tail.txt');


  $email = icps_format_email($template, $user_email_params);


  if($extra_night_pre == 'on') {
    $template_early = file_get_contents(dirname(__FILE__) . $template_dir . 'early-arrival.txt');
    $email_early = icps_format_email($template_early, $user_email_params);



  }

  $archive_email_tmpl = file_get_contents(dirname(__FILE__) . '/../tmpls/arrival/archive.txt');


  $archive_email = icps_format_email($archive_email_tmpl, $archive_email_params);




  /* if(!wp_mail($user->user_email, $email['subject'], $email['body'], array('Reply-To: registration@icps2012.com'))) 
       die('user ' . $user->ID);
     if($extra_night_pre == 'on') {
	if(!wp_mail($user->user_email, $email_early['subject'], $email_early['body'], array('Reply-To: registration@icps2012.com'))) 
       die('user early ' . $user->ID);
       }
     if(!wp_mail($archive_address, $archive_email['subject'], $archive_email['body'])) 
       die('archief probleem' . $user->ID);
  */



  echo '<li>';
  echo $i . ' - ' . $user_id . ' ' . $user->user_firstname . ' ' . $user->user_lastname . '<br>';    
  /*  echo '<strong>' . $email['subject'] . '</strong><br>';
  echo nl2br($email['body']);
  if($extra_night_pre == 'on')  {
    echo '<hr/>';
    echo '<strong>' . $email_early['subject'] . '</strong><br>';
    echo nl2br($email_early['body']);
    }*/
  var_dump(array($user->user_email, $email['subject'])); echo '<br>';
     if($extra_night_pre == 'on') {
       var_dump(array($user->user_email, $email_early['subject'])); echo '<br>';
       }
  echo '</li>';
  $i++;
}
echo '</ul>';
echo $i;
