<?php
/*
** Template name: ajax-upayment
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

$uid = $_POST['uid'];
$amount = (int) $_POST['amount'];

$udata = get_userdata($uid);
$a_status = get_user_meta($uid, 'application_status', true);


if(!$udata) die;

update_user_meta($uid, 'payment_amount', $amount);
if(($a_status % 16 < 8) && ($amount >= 180)) 
    update_user_meta($uid, 'application_status', $a_status + 8);

