<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// hook metabox
add_action('admin_init', 'dkrfm_add_food', 1);
function dkrfm_add_food()
{
    add_meta_box(
        'dkrfm_food',
        __('Food item details', 'restaurant-food-menu'),
        'dkrfm_food_display',
        'rfm_food_item',
        'normal',
        'high'
    );
}

// display metabox
function dkrfm_food_display()
{
    global $post;
    // get data
    $rfm_description = get_post_meta($post->ID, 'rfm_description', true);
    $rfm_price = get_post_meta($post->ID, 'rfm_price', true);
    $rfm_sale_price = get_post_meta($post->ID, 'rfm_sale_price', true);
    $rfm_image_url = get_post_meta($post->ID, 'rfm_image_url', true);
    $rfm_additional_info = get_post_meta($post->ID, 'rfm_additional_info', true);
    $rfm_id = get_post_meta($post->ID, 'rfm_id', true);

    wp_nonce_field('rfm_food_meta_box_nonce', 'rfm_food_meta_box_nonce'); ?>

<div class="re-rfm">

    <div class="r_w-full r_flex r_flex-col lg:r_flex-row r_bg-[whitesmoke] r_mt-3 r_pb-2 r_px-2 r_box-border">

        <input type="hidden" name="rfm_id" type="text" name=""
            value="<?php echo (empty($rfm_id)) ? esc_html(substr(md5(openssl_random_pseudo_bytes(20)), -32)) : esc_html($rfm_id); ?>" />

        <div class="r_w-4/6 r_mx-auto lg:r_w-3/12 r_flex r_flex-col r_p-3">
            <label class="r_mt-1 re_label"><?php echo esc_html(__('Image', 'restaurant-food-menu')); ?></label>
            <div class="r_h-full r_min-h-[140px] re_image-area rjs_ImageUrlArea r_flex r_flex-col r_items-center r_justify-center r_bg-no-repeat r_bg-cover"
                style="background-image: url(<?php echo (!empty($rfm_image_url)) ? esc_url($rfm_image_url) : 'none'; ?>);">
                <input class="rjs_ImageUrl" type="hidden" name="rfm_image_url" type="text" name=""
                    value="<?php echo esc_url($rfm_image_url); ?>" />
                <div
                    class="r_drop-shadow r_rounded r_py-2 r_px-3 r_cursor-pointer r_bg-indigo-400 r_text-white rjs_uploadFoodImageButton <?php echo (!empty($rfm_image_url)) ? 'r_hidden' : ''; ?>">
                    <?php echo esc_html(__('Upload', 'restaurant-food-menu')); ?>
                </div>
                <div
                    class="r_drop-shadow r_rounded r_py-2 r_px-3 r_cursor-pointer r_bg-red-400 r_text-white rjs_removeFoodImageButton <?php echo (!empty($rfm_image_url)) ? '' : 'r_hidden'; ?>">
                    <?php echo esc_html(__('Remove', 'restaurant-food-menu')); ?>
                </div>
            </div>
        </div>

        <div class="r_w-full lg:r_w-4/12 r_flex r_flex-col r_box-border r_p-3">
            <div class="r_w-full r_mr-1 r_mt-0.5">
                <label class="re_label"><?php echo esc_html(__('Regular price', 'restaurant-food-menu')); ?></label>
                <input class="re_input" type="text" value="<?php echo esc_attr($rfm_price); ?>" name="rfm_price"
                    placeholder="<?php echo esc_html(__('e.g. $6', 'restaurant-food-menu')); ?>" />
            </div>
            <div class="r_w-full r_mt-2">
                <label class="re_label"><?php echo esc_html(__('Sale price', 'restaurant-food-menu')); ?></label>
                <input class="re_input" type="text" value="<?php echo esc_attr($rfm_sale_price); ?>"
                    name="rfm_sale_price"
                    placeholder="<?php echo esc_html(__('e.g. $4', 'restaurant-food-menu')); ?>" />
            </div>
            <div class="r_mt-2">
                <label class="re_label"><?php echo esc_html(__('Additional info', 'restaurant-food-menu')); ?></label>
                <input class="re_input " type="text" value="<?php echo esc_attr($rfm_additional_info); ?>"
                    name="rfm_additional_info"
                    placeholder="<?php echo esc_html(__('e.g. spicy, gluten-free', 'restaurant-food-menu')); ?>" />
            </div>
        </div>

        <div class="r_w-full lg:r_w-5/12 r_mt-1 r_flex r_flex-col r_box-border r_justify-stretch r_p-3">
            <label class="re_label"><?php echo esc_html(__('Description', 'restaurant-food-menu')); ?></label>
            <textarea name="rfm_description" class="re_textarea r_h-full"
                placeholder="<?php echo esc_html(__('e.g. veggie protein fusion: fresh, savory, and aromatic.', 'restaurant-food-menu')); ?>"><?php echo esc_html($rfm_description); ?></textarea>
        </div>
    </div>

</div>

<?php }
?>