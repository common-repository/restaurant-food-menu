<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// text domain
add_action('plugins_loaded', 'rfm_load_plugin_textdomain');
function rfm_load_plugin_textdomain()
{
    load_plugin_textdomain('restaurant-food-menu', false, plugin_dir_path(__FILE__).'lang/');
}
