<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (1 != $setting_layout) {
    $gap_class = 'r_gap-[40px] ';
} else {
    $gap_class = '';
}

$output .= '<div class="r_grid '.esc_attr($gap_class).'min-[959px]:r_grid-cols-'.esc_attr($setting_layout).'">';

// looping through sections
foreach ($sections as $section) {
    $output .= '<div class="re_section">';
    // fill in sections
    foreach ($section as $item) {
        if ('heading' === $item->type) {
            $output .= '<div class="re_heading">'.esc_html($item->content).'</div>';
        }
        if ('paragraph' === $item->type) {
            $output .= '<div class="re_paragraph">'.esc_html($item->content).'</div>';
        }
        if ('food' === $item->type) {
            // grab food item
            $food_item = get_posts([
            'post_type' => 'rfm_food_item',
            'number' => 1,
            'meta_query' => [['key' => 'rfm_id', 'value' => $item->id]],
            ])[0];

            // get food data
            $description = get_post_meta($food_item->ID, 'rfm_description', true);
            $img_url = get_post_meta($food_item->ID, 'rfm_image_url', true);
            $additional_info = get_post_meta($food_item->ID, 'rfm_additional_info', true);
            $price = get_post_meta($food_item->ID, 'rfm_price', true);
            $sale_price = get_post_meta($food_item->ID, 'rfm_sale_price', true);

            // food item
            $output .= '<div class="re_food r_flex r_items-start r_justify-between">';

            $output .= '<div class="r_flex r_items-start r_justify-stretch r_w-full">';

            // food image
            if ('yes' === $setting_sh_food_images) {
                $output .= '<div class="r_flex r_items-center r_mr-6 r_mt-2">';
                $output .= $img_url
                ? '<img src="'.esc_url($img_url).'"
                        class="re_food-image re_food-image-'.esc_html($setting_food_image_shape).' re_food-image-'.esc_html($setting_food_image_size).'" />'
                : '<div
                        class="re_food-image re_food-image-'.esc_html($setting_food_image_shape).' re_food-image-'.esc_html($setting_food_image_size).'">
                    </div>';
                $output .= '</div>';
            }

            // food text
            $output .= '<div class="r_w-full">';
            $output .= '<div class="re_food-title r_mr-2">'.esc_html($food_item->post_title).'</div>';
            $output .= ($description)
            ? '<div class="re_food-description r_mr-6">'.wp_kses_post($description).'</div>'
            : '';
            $output .= ($additional_info)
            ? '<div class="re_food-additional-info r_mr-6">'.esc_html($additional_info).'</div>'
            : '';
            $output .= '</div>';

            $output .= '</div>';

            // food price
            $output .= '<div>';
            if (!empty($price) || !empty($sale_price)) {
                // if both
                if (!empty($price) && !empty($sale_price)) {
                    $output .= '<span class="r_line-through r_text-gray-500 r_mr-2">'.esc_html($price).'</span>';
                    $output .= '<span>'.esc_html($sale_price).'</span>';
                // only price
                } elseif (!empty($price)) {
                    $output .= '<span>'.esc_html($price).'</span>';
                // only sale price
                } elseif (!empty($sale_price)) {
                    $output .= '<span>'.esc_html($sale_price).'</span>';
                }
            }
            $output .= '</div>';

            // end re_food
            $output .= '</div>';
        }
    }
    // end re_section
    $output .= '</div>';
}

$output .= '</div>';
