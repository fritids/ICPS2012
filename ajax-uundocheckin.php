<?php
/*
** Template name: ajax-uundocheckin
*/

require_once 'functions/register.php';


if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!((in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles)) )) { require '404.php'; die; }

$user_id = $_GET['user_id'];


$user_data = get_userdata($user_id);
if(!$user_data) { header('HTTP/1.0 403 Forbidden'); die; }

if(!update_user_meta($user_data->ID, 'checked_in', '')) { header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error'); die; }

