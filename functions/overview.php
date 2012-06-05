<?php

function icps_cast_ov($name, $nicename) {
  return array('name' => $name, 'nicename' => $nicename);
}

function icps_overview_metafields() {
  return array(icps_cast_ov('country', 'Country'), icps_cast_ov('level', 'Level'), icps_cast_ov('application_status', 'Gay'), icps_cast_ov('admission_round', 'Round'), icps_cast_ov('payment_amount', 'Geld'), icps_cast_ov('passport_nr', 'Paspoort'), icps_cast_ov('lecture_sub', 'Lecture'), icps_cast_ov('poster_sub', 'Poster'), icps_cast_ov('date_of_birth', 'Geb.datum'), icps_cast_ov('revoke_round', 'Opkankerronde'));
}

function icps_overview_standardfields() {
  return array(icps_cast_ov('ID', 'ID'), icps_cast_ov('first_name', 'Given name'), icps_cast_ov('last_name', 'Family name'), icps_cast_ov('user_email', 'Email'));
}

function icps_overview_fields() {
  return array_merge(icps_overview_standardfields(), icps_overview_metafields());
}