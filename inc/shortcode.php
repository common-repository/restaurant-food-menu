<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// shortcode to display a menu
add_shortcode('rfm', 'rfm_sc');
function rfm_sc($atts)
{
    global $post;

    // get slug
    $all_attr = shortcode_atts(['name' => ''], $atts);
    $name = $all_attr['name'];

    // get menu data
    $args = ['post_type' => 'rfm_food_menu', 'name' => $name];
    $custom_posts = get_posts($args);
    $output = '';

    foreach ($custom_posts as $post) {
        setup_postdata($post);
        $sections = json_decode(get_post_meta($post->ID, 'rfm_menu_data', true));
        $settings = (array) json_decode(get_post_meta($post->ID, 'rfm_menu_settings', true));

        // clean data
        $setting_layout = (isset($settings['layout'])) ? esc_attr($settings['layout']) : '2';
        $setting_sh_food_images = (isset($settings['sh_food_images'])) ? esc_attr($settings['sh_food_images']) : 'yes';
        $setting_food_image_shape = (isset($settings['food_image_shape'])) ? esc_attr($settings['food_image_shape']) : 'rounded';
        $setting_food_image_size = (isset($settings['food_image_size'])) ? esc_attr($settings['food_image_size']) : 'normal';

        // corrupted data
        if (!(array) $settings) {
            return;
        }

        $style_trigger = '<div class="min-[959px]:r_grid-cols-2"></div>';
        $style_trigger .= '<div class="min-[959px]:r_grid-cols-3"></div>';

        $output .= '<div class="re-rfm">';

        require 'templates/default.php';

        $output .= '</div>';
    }
    wp_reset_postdata();

    return wp_kses_post($output);
}
