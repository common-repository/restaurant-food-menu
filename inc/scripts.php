<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// admin scripts and styles
add_action('admin_enqueue_scripts', 'dkrfm_add_admin_rfm_style');
function dkrfm_add_admin_rfm_style()
{
    // check if food or menu
    global $post_type;
    if ('rfm_food_item' == $post_type || 'rfm_food_menu' == $post_type) {
        // css
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('rfm_admin_styles', plugins_url('css/back.min.css', __FILE__));

        // js
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-touch-punch'); // mobile drag and drop
        wp_enqueue_script('rfm_admin_scripts', plugins_url('js/back.min.js', __FILE__), ['jquery', 'jquery-ui-draggable', 'thickbox', 'wp-color-picker']);
    }
}

// front scripts and styles
add_action('wp_enqueue_scripts', 'dkrfm_add_rfm_scripts', 99);
function dkrfm_add_rfm_scripts()
{
    // css
    wp_enqueue_style('rfm_front_styles', plugins_url('css/front.min.css', __FILE__));
}
