<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Plugin Name: Restaurant Food Menu by WP Darko – Drag & Drop Restaurant Menu Builder for WordPress
 * Plugin URI: https://wpdarko.com/all-plugins/
 * Description: Quickly set up and display a restaurant menu on your website, fully responsive and easy to use. Create food items, add them to your restaurant menu and copy-paste the shortcode into any posts/pages.
 * Version: 1.0.2
 * Author: WP Darko
 * Author URI: https://wpdarko.com/
 * Text Domain: restaurant-food-menu
 * Domain Path: /lang/
 * License: GPL2.
 */

// text domain
require_once 'inc/text-domain.php';

// scripts and styles
require_once 'inc/scripts.php';

// post types
require_once 'inc/post-type.php';

// shortcodes
require_once 'inc/shortcode-column.php';
require_once 'inc/shortcode.php';

// metaboxes
require_once 'inc/metaboxes-food.php';
require_once 'inc/metaboxes-menu.php';
require_once 'inc/metaboxes-menu-settings.php';
require_once 'inc/metaboxes-menu-help.php';

// saving metaboxes
require_once 'inc/save-metaboxes-food.php';
require_once 'inc/save-metaboxes-menu.php';
