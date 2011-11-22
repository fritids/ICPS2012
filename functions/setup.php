<?php

add_action('after_setup_theme', 'icps_setup');

function icps_setup() {
    register_nav_menus(array(
        'primary' => 'Main'
    ));

    wp_register_style('register', get_template_directory_uri() . '/styles/register.css');

}