<?php
/*
** Template name: ajax-uapprove
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles))) { require '404.php'; die; }

require 'functions/overview.php';

$uid = (int) $_POST['uid'];

echo update_user_meta( $uid, 'application_status', 101, 1 ) ? '1' : '0';