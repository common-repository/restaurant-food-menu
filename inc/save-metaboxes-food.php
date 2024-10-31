<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

add_action('save_post', 'dkrfm_food_meta_box_save');
function dkrfm_food_meta_box_save($post_id)
{
    if (
        !isset($_POST['rfm_food_meta_box_nonce'])
        || !wp_verify_nonce(sanitize_key($_POST['rfm_food_meta_box_nonce']), 'rfm_food_meta_box_nonce')
    ) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $old_description = get_post_meta($post_id, 'rfm_description', true);
    $old_price = get_post_meta($post_id, 'rfm_price', true);
    $old_sale_price = get_post_meta($post_id, 'rfm_sale_price', true);
    $old_image_url = get_post_meta($post_id, 'rfm_image_url', true);
    $old_additional_info = get_post_meta($post_id, 'rfm_additional_info', true);
    $old_id = get_post_meta($post_id, 'rfm_id', true);

    $new_description = '';
    (isset($_POST['rfm_description']) && !empty($_POST['rfm_description']) && $_POST['rfm_description']) ? $new_description = stripslashes(wp_kses_post($_POST['rfm_description'])) : $new_description = '';
    $new_price = '';
    (isset($_POST['rfm_price']) && !empty($_POST['rfm_price']) && $_POST['rfm_price']) ? $new_price = stripslashes(wp_kses_post($_POST['rfm_price'])) : $new_price = '';
    $new_sale_price = '';
    (isset($_POST['rfm_sale_price']) && !empty($_POST['rfm_sale_price']) && $_POST['rfm_sale_price']) ? $new_sale_price = stripslashes(wp_kses_post($_POST['rfm_sale_price'])) : $new_sale_price = '';
    $new_image_url = '';
    (isset($_POST['rfm_image_url']) && !empty($_POST['rfm_image_url']) && $_POST['rfm_image_url']) ? $new_image_url = stripslashes(wp_kses_post($_POST['rfm_image_url'])) : $new_image_url = '';
    $new_additional_info = '';
    (isset($_POST['rfm_additional_info']) && !empty($_POST['rfm_additional_info']) && $_POST['rfm_additional_info']) ? $new_additional_info = stripslashes(wp_kses_post($_POST['rfm_additional_info'])) : $new_additional_info = '';
    $new_id = '';
    (isset($_POST['rfm_id']) && $_POST['rfm_id']) ? $new_id = stripslashes(wp_kses_post($_POST['rfm_id'])) : $new_id = '';

    // update food
    if ($new_description != $old_description) {
        update_post_meta($post_id, 'rfm_description', $new_description);
    }
    if ($new_price != $old_price) {
        update_post_meta($post_id, 'rfm_price', $new_price);
    }
    if ($new_sale_price != $old_sale_price) {
        update_post_meta($post_id, 'rfm_sale_price', $new_sale_price);
    }
    if ($new_image_url != $old_image_url) {
        update_post_meta($post_id, 'rfm_image_url', $new_image_url);
    }
    if ($new_additional_info != $old_additional_info) {
        update_post_meta($post_id, 'rfm_additional_info', $new_additional_info);
    }
    if (!empty($new_id) && $new_id != $old_id) {
        update_post_meta($post_id, 'rfm_id', $new_id);
    }
}
