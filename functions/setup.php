<?php

add_action('after_setup_theme', 'icps_setup');

function icps_setup() {
    register_nav_menus(array(
        'primary' => 'Main'
    ));

    wp_register_style('register', get_template_directory_uri() . '/styles/register.css');
    wp_register_style('overview', get_template_directory_uri() . '/styles/overview.css');
    wp_register_style('jquicss', get_template_directory_uri() . '/scripts/jqui/css/smoothness/jquery-ui-1.8.18.custom.css');

    wp_deregister_script('jquery');
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_register_script( 'jqui', get_template_directory_uri() . '/scripts/jqui/js/jquery-ui-1.8.18.custom.min.js');

    wp_register_script('programme', get_template_directory_uri() . '/scripts/programme.js');
    wp_register_script('overview', get_template_directory_uri() . '/scripts/overview.js');

    remove_theme_support('automatic-feed-links');

}

remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

add_filter('show_admin_bar', '__return_false');
remove_action('personal_options', '_admin_bar_preferences');


add_filter('wp_mail_from', 'icps_wp_mail_from');
function icps_wp_mail_from($content_type) { return 'mail@icps2012.com'; }

add_filter('wp_mail_from_name', 'icps_wp_mail_from_name');
function icps_wp_mail_from_name($content_type) { return 'ICPS 2012'; }