<?php

add_action('after_setup_theme', 'icps_setup');

function icps_setup() {
    register_nav_menus(array(
        'primary' => 'Main'
    ));

    wp_register_style('register', get_template_directory_uri() . '/styles/register.css');

    wp_register_script('programme', get_template_directory_uri() . '/scripts/programme.js');

}

add_filter('wp_mail_from', 'icps_wp_mail_from');
function icps_wp_mail_from($content_type) { return 'mail@icps2012.com'; }

add_filter('wp_mail_from_name', 'icps_wp_mail_from_name');
function icps_wp_mail_from_name($content_type) { return 'ICPS 2012'; }