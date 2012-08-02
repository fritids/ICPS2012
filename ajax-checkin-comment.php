<?php
/*
** Template name: ajax-ucheckin-comment
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

$user_id = $_GET['user_id'];

$udata = get_userdata($user_id);



if(!$udata) { header('HTTP/1.0 403 Forbidden'); die; }

if(!empty($_GET['comments'])) 
    update_user_meta($user_id, 'comment', $_GET['comments']);
else header('HTTP/1.0 500 Internal Server Error');
