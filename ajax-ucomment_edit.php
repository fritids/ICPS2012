<?php
/*
** Template name: ajax-ucomment_edit
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

$uid = $_POST['uid'];

$udata = get_userdata($uid);



if(!$udata) die;
update_user_meta($uid, 'comment', $_POST['comment']);

echo '1';

