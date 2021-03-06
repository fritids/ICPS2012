<?php

function icps_check_status($uid, $item) {
  $status = (int) get_user_meta($uid, 'application_status', true);

  $mod = 0;

  switch($item) {
    case 'revoked' : return ($status == 0); break;
    case 'approved' : $mod = 4; break;
    case 'personal_info' : $mod = 8; break;
    case 'payment_complete' : $mod = 16; break;
  }

  return ($status % $mod >= ($mod/2));
}