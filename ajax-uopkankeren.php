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
echo '1';

