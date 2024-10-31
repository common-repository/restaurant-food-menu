<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// hook metabox
add_action('admin_init', 'dkrfm_menu_add_settings', 1);
function dkrfm_menu_add_settings()
{
    add_meta_box(
        'dkrfm_menu_settings',
        __('Settings', 'restaurant-food-menu'),
        'dkrfm_menu_settings_display',
        'rfm_food_menu',
        'side',
        'high'
    );
}

// metabox display
function dkrfm_menu_settings_display()
{ ?>

<div class="re-rfm">
    <div class="r_bg-[whitesmoke] r_p-3 r_mt-3">
        <div class="">
            <div class="r_text-sm r_mb-1">
                <?php echo esc_html(__('Show images on menu', 'restaurant-food-menu')); ?>
                <span
                    data-tip="<?php echo esc_html(__('Whether food images will show on your website for this menu.', 'restaurant-food-menu')); ?>">[?]</span>
            </div>

            <div class="r_flex">
                <select class="rjs_shFoodImages">
                    <option value="yes">
                        <?php echo esc_html(__('Yes', 'restaurant-food-menu')); ?>
                    </option>
                    <option value="no">
                        <?php echo esc_html(__('No', 'restaurant-food-menu')); ?>
                    </option>
                </select>
            </div>

        </div>
        <hr class="r_mt-3">
        <div class="">
            <div class="r_text-sm r_mb-1 r_mt-2">
                <?php echo esc_html(__('Image shape', 'restaurant-food-menu')); ?>
                <span
                    data-tip="<?php echo esc_html(__('The shape of the food images for this menu.', 'restaurant-food-menu')); ?>">[?]</span>
            </div>
            <div class="r_flex">
                <select class="rjs_foodImageShape">
                    <option value="circle">
                        <?php echo esc_html(__('Circle', 'restaurant-food-menu')); ?>
                    </option>
                    <option value="rounded">
                        <?php echo esc_html(__('Rounded', 'restaurant-food-menu')); ?>
                    </option>
                    <option value="squared">
                        <?php echo esc_html(__('Squared', 'restaurant-food-menu')); ?>
                    </option>
                </select>
            </div>
        </div>
        <hr class="r_mt-3">
        <div class="">
            <div class="r_text-sm r_mb-1 r_mt-2">
                <?php echo esc_html(__('Image size', 'restaurant-food-menu')); ?>
                <span
                    data-tip="<?php echo esc_html(__('The size of the food images for this menu.', 'restaurant-food-menu')); ?>">[?]</span>
            </div>

            <div class="r_flex">
                <select class="rjs_foodImageSize">
                    <option value="normal">
                        <?php echo esc_html(__('Normal', 'restaurant-food-menu')); ?>
                    </option>
                    <option value="large">
                        <?php echo esc_html(__('Large', 'restaurant-food-menu')); ?>
                    </option>
                </select>
            </div>

        </div>
    </div>
</div>

<?php } ?>