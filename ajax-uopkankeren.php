<?php
/*
** Template name: ajax-uopkankeren
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

$uid = $_POST['uid'];

$udata = get_userdata($uid);



if(!$udata) die;

update_user_meta($uid, 'application_status', 0);
update_user_meta($uid, 'extra_day_pre', '');
update_user_meta($uid, 'extra_day_post', '');
update_user_meta($uid, 'revoke_round', '11');
update_user_meta($uid, 'preferred_accomodation', '');
update_user_meta($uid, 'excursion', '');
echo '1';

