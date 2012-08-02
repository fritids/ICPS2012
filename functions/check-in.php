<?php

function icps_full_cost($user_id) {
  $user_data = get_userdata($user_id);
  if(!$user_data) return false;

  $amount = 180;
  if($user_id > 586) $amount = 200; 
    if(get_user_meta($user_id, 'iaps_member', true) == '0') $amount += 10;
    
    if(get_user_meta($user_id, 'extra_day_pre', true) == 'on') $amount += 25;
    if(get_user_meta($user_id, 'extra_day_post', true) == 'on') $amount += 25;

    if(get_user_meta($user_id, 'preferred_accommodation', true) == 'No accommodation') $amount = 100;
  return $amount;
}