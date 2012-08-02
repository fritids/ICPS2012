<?php

function icps_cast_ov($name, $nicename) {
  return array('name' => $name, 'nicename' => $nicename);
}


/*function icps_overview_metafields() {
  return array(icps_cast_ov('application_status','straight'),icps_cast_ov('payment_amount','Geld'),icps_cast_ov('admission_round','ronde'),icps_cast_ov('gender','SEX'),icps_cast_ov('country', 'Country'), icps_cast_ov('passport_nr', 'Paspoort'), icps_cast_ov('excursion','excursie'),icps_cast_ov('revoke_round', 'Opkanker'));
}*/

/*function icps_overview_standardfields() {
  return array(icps_cast_ov('ID', 'ID'), icps_cast_ov('first_name', 'Given name'), icps_cast_ov('last_name', 'Family name'), icps_cast_ov('user_email', 'Email'));
}*/


//huisvesting

function icps_overview_metafields() {
  return array(icps_cast_ov('excursion', 'Excursie'),
	       icps_cast_ov('country', 'Country'), icps_cast_ov('allergies', 'Allergie'), icps_cast_ov('vegetarian', 'Vega'), icps_cast_ov('application_status', 'Gay'), icps_cast_ov('passport_nr','pasnr'), icps_cast_ov('preferred_accommodation','Acco'), icps_cast_ov('roommate_one', 'Roommate#1'), icps_cast_ov('roommate_two', 'Roommate#2'), icps_cast_ov('roommate_three', 'Roommate#3'),icps_cast_ov('gender','m/v'), icps_cast_ov('mixed_room','apart'),icps_cast_ov('extra_day_pre','voor'),icps_cast_ov('extra_day_post','na'),icps_cast_ov('admission_round','ronde'),icps_cast_ov('payment_amount','betaald')
);
}


function icps_overview_standardfields() {
  return array(icps_cast_ov('ID', 'ID'), icps_cast_ov('first_name', 'Given name'), icps_cast_ov('last_name', 'Family name'));
}

//end huisvesting


function icps_overview_fields() {
  return array_merge(icps_overview_standardfields(), icps_overview_metafields());
}
