<?php
/*
** Template name: Sandbox
*/


if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

require 'functions/register.php';
require 'functions/check-in.php';


$users = array(28, 29, 443, 659, 110);
foreach($users as $u) {
  var_dump( icps_full_cost($u) );
  echo '<br>';
}







