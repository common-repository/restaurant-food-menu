<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

add_action('save_post', 'dkrfm_menu_meta_box_save');
function dkrfm_menu_meta_box_save($post_id)
{
    if (
        !isset($_POST['rfm_menu_meta_box_nonce'])
        || !wp_verify_nonce(sanitize_key($_POST['rfm_menu_meta_box_nonce']), 'rfm_menu_meta_box_nonce')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $old_menu_data = get_post_meta($post_id, 'rfm_menu_data', true);
    $old_menu_settings = get_post_meta($post_id, 'rfm_menu_settings', true);

    $new_menu_data = '';
    (isset($_POST['rfm_menu_data']) && $_POST['rfm_menu_data']) ? $new_menu_data = stripslashes(wp_kses_post($_POST['rfm_menu_data'])) : $new_menu_data = '';
    $new_menu_settings = '';
    (isset($_POST['rfm_menu_settings']) && $_POST['rfm_menu_settings']) ? $new_menu_settings = stripslashes(sanitize_text_field($_POST['rfm_menu_settings'])) : $new_menu_settings = '';

    // update menu data
    if (!empty($new_menu_data) && $new_menu_data != $old_menu_data) {
        update_post_meta($post_id, 'rfm_menu_data', $new_menu_data);
    }
    if (!empty($new_menu_settings) && $new_menu_settings != $old_menu_settings) {
        update_post_meta($post_id, 'rfm_menu_settings', $new_menu_settings);
    }
}
