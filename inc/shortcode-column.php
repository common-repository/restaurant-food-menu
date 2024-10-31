<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// shortcode column display
add_action('manage_rfm_food_menu_posts_custom_column', 'dkrfm_custom_columns', 10, 2);
function dkrfm_custom_columns($column, $post_id)
{
    switch ($column) {
        case 'dk_shortcode':
            global $post;
            $slug = '';
            $slug = $post->post_name;
            $shortcode = '<span style="background: white; padding: 4px; border: dashed 2px #add595; border-radius:4px; font-size: 13px;">[rfm name="'.$slug.'"]</span>';
            echo wp_kses_post($shortcode);
            break;
    }
}

// add column to menu list in admin
add_filter('manage_rfm_food_menu_posts_columns', 'dkrfm_add_rfm_columns');
function dkrfm_add_rfm_columns($columns)
{
    return array_merge($columns, ['dk_shortcode' => 'Shortcode']);
}
