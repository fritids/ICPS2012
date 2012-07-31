<?php

// UCU
/*if (($handle = fopen(dirname(__FILE__) . "/incl/UCU-rooms.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if(empty($data[0])) continue;
      echo "UPDATE icps_usermeta SET meta_value = '" . $data[0] . "' WHERE meta_key = 'room_number' AND user_id = " . $data[1] . ";<br/>";
        

    }
    fclose($handle);
    }*/

// StayOkay Ridderhofstraat
/*if (($handle = fopen(dirname(__FILE__) . "/../incl/StayOkay-RID-rooms.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if(empty($data[0])) continue;
      $user_ids = explode('.', $data[1]);
    foreach($user_ids as $user_id) :
      $room_str = 'RID-' . $data[0];
      echo "UPDATE icps_usermeta SET meta_value = '" . $room_str . "' WHERE meta_key = 'room_number' AND user_id = " . $user_id . ";<br/>";
      endforeach;

    }
    fclose($handle);
    }*/


/*if (($handle = fopen(dirname(__FILE__) . "/../incl/StayOkay-BONG-rooms.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if(empty($data[0])) continue;
      $user_ids = explode('.', $data[1]);
    foreach($user_ids as $user_id) :
      $room_str = 'BONG-' . $data[0];
      echo "UPDATE icps_usermeta SET meta_value = '" . $room_str . "' WHERE meta_key = 'room_number' AND user_id = " . $user_id . ";<br/>";
      endforeach;

    }
    fclose($handle);
    }
*/

if (($handle = fopen(dirname(__FILE__) . "/../incl/BB-rooms.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if(empty($data[0])) continue;
      $user_ids = explode('.', $data[1]);
    foreach($user_ids as $user_id) :
      $room_str = 'BB-' . $data[0];
      echo "UPDATE icps_usermeta SET meta_value = '" . $room_str . "' WHERE meta_key = 'room_number' AND user_id = " . $user_id . ";<br/>";
      endforeach;

    }
    fclose($handle);
    }
