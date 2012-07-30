<?php
/*
** Template name: json-user-checkin-data
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

$id = $_GET['id'];

$u = get_userdata($id);

$metas = array( 'passport_nr', 'date_of_birth','comment', 'total_payment', 'payment_amount');


$udata = array();
$udata['user_id'] = $u->ID;
$udata['first_name'] = $u->first_name;
$udata['last_name'] = $u->last_name;

foreach($metas as $meta) :
  $udata[$meta] = get_user_meta($id, $meta, true);
endforeach;

echo json_encode($udata);

