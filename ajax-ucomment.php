<?php
/*
** Template name: ajax-ucomment
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!((in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles)) )) { require '404.php'; die; }

$uid = $_POST['uid'];

$udata = get_userdata($uid);



if(!$udata) die;

$return = get_metadata('user', $uid);

echo json_encode($return);

