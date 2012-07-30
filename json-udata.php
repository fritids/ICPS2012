<?php

/*
** Template name: json-userdata
*/

if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!(in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles))) { require '404.php'; die; }

require 'functions/overview.php';

$uids = get_users( array('role' => 'applicant', 'fields'=> 'ID', 'orderby' => 'ID') );


$applicants = array();
$sfields = icps_overview_standardfields();
$mfields = icps_overview_metafields();

$appldata = null;
$udata = null;
foreach($uids as $uid) :
  $udata = get_userdata($uid);
  $appldata = new stdClass();


  foreach($sfields as $sfield) :
    $label = $sfield['name'];
    $appldata->$label = $udata->$label;
  endforeach;

  foreach($mfields as $mfield) :
    $label = $mfield['name'];
    $appldata->$label = get_user_meta($uid, $label, true);
  endforeach;

  $total = 180;
  if($uid > 586) $total = 200;
  if(get_user_meta($uid, 'iaps_member', true) == 0) $total += 10;

  $total_zonder = $total;

  if(get_user_meta($uid, 'extra_day_pre', true) == 'on') $total += 25;
  if(get_user_meta($uid, 'extra_day_post', true) == 'on') $total += 25;
  $appldata->total_payment = $total;

  $appldata->difference = $total_zonder - $appldata->payment_amount;
  

  $applicants[] = $appldata;
endforeach;

echo json_encode($applicants);


