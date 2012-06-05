<?php
/*
** Template name: Sandbox
*/


if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) )) { require '404.php'; die; }

require 'functions/register.php';

