<?php
/*
** Template name: ajax-ucheckin
*/

require_once 'functions/register.php';


if( !isset($current_user) )
  $current_user = wp_get_current_user();

if(!((in_array('administrator', $current_user->roles) || in_array('editor', $current_user->roles)) )) { require '404.php'; die; }

$user_id = $_GET['user_id'];


$user_data = get_userdata($user_id);
if(!$user_data) { header('HTTP/1.0 403 Forbidden'); die; }

//if(!update_user_meta($user_data->ID, 'checked_in', 'on')) { header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error'); die; }
update_user_meta($user_data->ID, 'comment', $_GET['comments']);

$form_information = array();
$form_information['standard'] = array(icps_cast_field('first_name', 'First name'),
				      icps_cast_field('last_name', 'Last name'));
$form_information['meta'] = array(icps_cast_field('passport_nr', 'Passport number'),
				  icps_cast_field('date_of_birth', 'Date of birth'));

$form_receipt = array();
$form_receipt['standard'] = array('ID', 'first_name', 'last_name');
$form_receipt['meta'] = array('payment_amount', 'gender', 'shirt_size', 'extra_day_pre', 'extra_day_post', 'iaps_member');

$receiptdata = array();
foreach($form_receipt['standard'] as $sfield) :
  $receiptdata[$sfield] = $user_data->{$sfield};
endforeach;

foreach($form_receipt['meta'] as $mfield) :
  $receiptdata[$mfield] = get_user_meta($user_data->ID, $mfield, true);
endforeach;


foreach($form_information['standard'] as &$sfield) { $sfield['value'] = $user_data->{$sfield['name']}; }

foreach($form_information['meta'] as &$mfield) { $mfield['value'] = get_user_meta($user_data->ID, $mfield['name'], true); }

foreach($form_receipt['standard'] as &$sfield) { $sfield['value'] = $user_data->{$sfield['name']}; }

foreach($form_receipt['meta'] as &$mfield) { $mfield['value'] = get_user_meta($user_data->ID, $mfield['name'], true); }


$return = array('information' => call_user_func_array('array_merge', $form_information),
		'receipt' => $receiptdata);

echo json_encode($return);
