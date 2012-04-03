<?php

function icps_add_app_field($name, $default) {
  $user_ids = get_users(array('role' => 'applicant', 'fields' => 'ID'));

  foreach($user_ids as $uid) :
    add_user_meta($uid, $name, $default, true);
  endforeach;
}