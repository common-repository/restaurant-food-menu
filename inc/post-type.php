<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// register food post type
add_action('init', 'dkrfm_register_rfm_food_type');
function dkrfm_register_rfm_food_type()
{
    // labels
    $labels = [
        'name' => __('Food Items', 'restaurant-food-menu'),
        'singular_name' => __('Food Item', 'restaurant-food-menu'),
        'menu_name' => __('Food Items', 'restaurant-food-menu'),
        'name_admin_bar' => __('Food Item', 'restaurant-food-menu'),
        'add_new' => __('Add New', 'restaurant-food-menu'),
        'add_new_item' => __('Add New Food Item', 'restaurant-food-menu'),
        'new_item' => __('New Food Item', 'restaurant-food-menu'),
        'edit_item' => __('Edit Food Item', 'restaurant-food-menu'),
        'view_item' => __('View Food Item', 'restaurant-food-menu'),
        'all_items' => __('All Food Items', 'restaurant-food-menu'),
        'search_items' => __('Search Food Items', 'restaurant-food-menu'),
        'not_found' => __('No Food Item found.', 'restaurant-food-menu'),
        'not_found_in_trash' => __('No Food Item found in Trash.', 'restaurant-food-menu'),
    ];

    // permissions
    $args = [
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_admin_bar' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'supports' => ['title'],
        'menu_icon' => 'dashicons-food',
    ];

    // register
    register_post_type('rfm_food_item', $args);
}

// customize update messages
add_filter('post_updated_messages', 'dkrfm_food_updated_messages');
function dkrfm_food_updated_messages($messages)
{
    $post = get_post();
    $post_type = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    // update messages
    $messages['rfm_food_item'] = [
        1 => __('Food Item updated.', 'restaurant-food-menu'),
        4 => __('Food Item updated.', 'restaurant-food-menu'),
        6 => __('Food Item published.', 'restaurant-food-menu'),
        7 => __('Food Item saved.', 'restaurant-food-menu'),
        10 => __('Food Item draft updated.', 'restaurant-food-menu'),
    ];

    return $messages;
}

// register food menu post type
add_action('init', 'dkrfm_register_rfm_menu_type');
function dkrfm_register_rfm_menu_type()
{
    // labels
    $labels = [
        'name' => __('Food Menus', 'restaurant-food-menu'),
        'singular_name' => __('Food Menu', 'restaurant-food-menu'),
        'menu_name' => __('Food Menus', 'restaurant-food-menu'),
        'name_admin_bar' => __('Food Menu', 'restaurant-food-menu'),
        'add_new' => __('Add New', 'restaurant-food-menu'),
        'add_new_item' => __('Add New Food Menu', 'restaurant-food-menu'),
        'new_item' => __('New Food Menu', 'restaurant-food-menu'),
        'edit_item' => __('Edit Food Menu', 'restaurant-food-menu'),
        'view_item' => __('View Food Menu', 'restaurant-food-menu'),
        'all_items' => __('All Food Menus', 'restaurant-food-menu'),
        'search_items' => __('Search Food Menus', 'restaurant-food-menu'),
        'not_found' => __('No Food Menu found.', 'restaurant-food-menu'),
        'not_found_in_trash' => __('No Food Menu found in Trash.', 'restaurant-food-menu'),
    ];

    // permissions
    $args = [
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_admin_bar' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'supports' => ['title'],
        'menu_icon' => 'dashicons-columns',
    ];

    // register
    register_post_type('rfm_food_menu', $args);
}

// customize update messages
add_filter('post_updated_messages', 'dkrfm_menu_updated_messages');
function dkrfm_menu_updated_messages($messages)
{
    $post = get_post();
    $post_type = get_post_type($post);
    $post_type_object = get_post_type_object($post_type);

    // update messages
    $messages['rfm_food_menu'] = [
        1 => __('Food Menu updated.', 'restaurant-food-menu'),
        4 => __('Food Menu updated.', 'restaurant-food-menu'),
        6 => __('Food Menu published.', 'restaurant-food-menu'),
        7 => __('Food Menu saved.', 'restaurant-food-menu'),
        10 => __('Food Menu draft updated.', 'restaurant-food-menu'),
    ];

    return $messages;
}
