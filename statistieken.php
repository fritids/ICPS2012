<?php
/*
** Template name: Statistieken
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

wp_enqueue_script('jquery');

$users = 'adsf';