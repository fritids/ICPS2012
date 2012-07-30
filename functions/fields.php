<?php

function icps_user_editable_fields($uid) {
    $sfields = icps_user_editable_standardfields();
    $udata = get_userdata($uid);

    for($i=0; $i < sizeof($sfields); $i++) :
        $sfields[$i]['value'] = $udata->{$sfields[$i]['name']};   
    endfor;
    
    $mfields = icps_user_editable_metafields();
    for($i=0; $i < sizeof($mfields); $i++) :
        $mfields[$i]['value'] = get_user_meta($uid, $mfields[$i]['name'], true);    
    endfor;

return array_merge($sfields, $mfields);
}

function icps_user_editable_standardfields() {
    return array(icps_cast_field('first_name', 'First name', 'text', true, true),
        icps_cast_field('last_name', 'Last name', 'text', true, true));
}

function icps_user_editable_metafields() {
return array( 
    icps_cast_field('study', 'Field of study', 'text', true),
    icps_cast_field('university', 'University', 'text', true), 
    icps_cast_field('address', 'Address', 'text', true), 
    icps_cast_field('postal_code', 'Postal code', 'text', true), 
    icps_cast_field('city', 'City', 'text', true), 
    icps_cast_field('country', 'Country', 'country', true), 
    icps_cast_field('date_of_birth', 'Date of birth', 'date', true), 
    icps_cast_field('passport_nr', 'Passport number', 'text', true),
/*    icps_cast_field('poster_b', 'Poster', 'labeled-checkbox', true, true),
    icps_cast_field('poster_sub', 'Subject', 'checkbox-sub', true, true),*/
    icps_cast_field('lecture_b', 'Lecture', 'labeled-checkbox', true, true),
    icps_cast_field('lecture_sub', 'Subject', 'checkbox-sub', true, true),
) ;
}

function icps_additional_detail_fields($uid) {
    $fields = array( 

    icps_cast_field('preferred_accommodation', 'Preferred accommodation', 'custom-acco-select', true),
    icps_cast_field('roommate_one', 'Preferred roommate 1', 'text'),
    icps_cast_field('roommate_two', 'Preferred roommate 2', 'text'),
    icps_cast_field('roommate_three', 'Preferred roommate 3', 'text'),
    icps_cast_field('excursion', 'Excursion', 'custom-excursion'),
    icps_cast_field('gender', 'If so, please specify your gender:', 'labeled-checkbox'),
    icps_cast_field('mixed_room', 'Would you rather NOT stay in a mixed-gender room?', 'labeled-checkbox'),
    icps_cast_field('shirt_size', 'Shirt size', 'custom-shirtsize'),
    icps_cast_field('vegetarian', 'Vegetarian', 'labeled-checkbox'),
    icps_cast_field('allergies', 'Allergies/food intolerance', 'text'),
    icps_cast_field('eta', 'Estimated time of arrival', 'text'),
    icps_cast_field('car', 'Are you travelling by car?', 'labeled-checkbox'),
/*	icps_cast_field('poster_abstract', 'Poster abstract', 'textarea'),
	icps_cast_field('lecture_abstract', 'Lecture abstract', 'textarea')*/
	
) ;

    for($i=0; $i < sizeof($fields); $i++) :
        $fields[$i]['value'] = get_user_meta($uid, $fields[$i]['name'], true);    
    endfor;
    return $fields;
}
