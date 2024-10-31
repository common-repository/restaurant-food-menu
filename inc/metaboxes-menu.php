<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// hook metabox
add_action('admin_init', 'dkrfm_add_menu', 1);
function dkrfm_add_menu()
{
    add_meta_box(
        'dkrfm_menu',
        __('Menu builder', 'restaurant-food-menu'),
        'dkrfm_menu_display',
        'rfm_food_menu',
        'normal',
        'high'
    );
}

// metabox display
function dkrfm_menu_display()
{
    global $post;

    // get menu data
    $rfm_menu_data = get_post_meta($post->ID, 'rfm_menu_data', true);
    $rfm_menu_settings = get_post_meta($post->ID, 'rfm_menu_settings', true);
    wp_nonce_field('rfm_menu_meta_box_nonce', 'rfm_menu_meta_box_nonce'); ?>

<div class="re-rfm">

    <div class="rjs_backdrop re_backdrop r_hidden"></div>
    <div class="rjs_menuEditor r_pt-2">

        <div class="r_relative r_flex r_flex-col sm:r_flex-row r_justify-stretch r_mt-3">

            <div
                class="rjs_sidebar r_z-[900] r_flex r_flex-col r_rounded-t-lg sm:r_rounded-tr-none sm:r_rounded-l-lg r_relative r_box-border r_w-full sm:r_w-1/3 r_bg-gray-200 r_p-3 r_pb-7 sm:r_pb-3">

                <div class="re_sidebarInner">
                    <div class="r_p-1">
                        <span class="r_uppercase r_font-bold r_text-gray-600 ">
                            <?php echo esc_html(__('General', 'restaurant-food-menu')); ?>
                        </span>
                        <span class="r_relative r_top-[-1px]"
                            data-tip="<?php echo esc_html(__('These items are editable and you can add as many as you need to your menu.', 'restaurant-food-menu')); ?>">[?]</span>
                    </div>
                    <div class="r_text-gray-600 r_p-1 r_mb-1 r_text-[12px]">
                        <?php echo esc_html(__('Drag and drop custom content in your menu.', 'restaurant-food-menu')); ?>
                    </div>
                    <div class="rjs_miscItemList r_flex r_flex-col">
                        <div data-type="heading" class="r_relative rjs_item re_misc-item"><span
                                class="re_item r_block rjs_itemTextContent re_item-text-content"><?php echo esc_html(__('Heading', 'restaurant-food-menu')); ?></span>
                        </div>
                        <div data-type="paragraph" class="r_relative rjs_item re_misc-item"><span
                                class="re_item r_block rjs_itemTextContent re_item-text-content"><?php echo esc_html(__('Paragraph', 'restaurant-food-menu')); ?></span>
                        </div>
                    </div>

                    <div class="r_mt-4 r_p-1">
                        <span class="r_uppercase r_font-bold r_text-gray-600">
                            <?php echo esc_html(__('Food items', 'restaurant-food-menu')); ?>
                        </span>
                        <span class="r_relative r_top-[-1px]"
                            data-tip="<?php echo esc_html(__('Food items are created separately and can only be added once to a menu.', 'restaurant-food-menu')); ?>">[?]</span>
                    </div>

                    <?php

                    $args = [
                        'post_type' => 'rfm_food_item',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC',
                    ];

    $loop = new WP_Query($args);

    if ($loop->have_posts()) { ?>
                    <div class="r_text-gray-600 r_p-1 r_mb-1 r_text-[12px]">
                        <?php echo esc_html(__('Drag and drop food items in your menu.', 'restaurant-food-menu')); ?>
                    </div>
                    <input type="text" placeholder="Search food..."
                        class="rjs_foodSearch r_py-0 r_px-2 r_w-full r_border-2 r_border-solid r_border-gray-300 r_mb-1" />
                    <div class="rjs_foodItemList r_max-h-[400px] r_overflow-y-auto r_flex r_flex-col">
                        <?php while ($loop->have_posts()) { ?>

                        <?php
                    $loop->the_post();
                            $food_title = (get_the_title()) ? get_the_title() : 'Untitled';
                            echo '<div data-type="food" data-food-id="'.esc_attr(get_post_meta(get_the_ID(), 'rfm_id', true)).'" class="r_relative re_item rjs_item re_food-item">'.esc_html($food_title).'</div>';
                        }
                        echo '</div>';
    } else {
        echo esc_attr('<div class="r_mt-1 r_ml-0.5 r_p-2 r_rounded r_border-blue-400 r_border r_border-solid r_bg-blue-100 r_text-blue-700 r_mb-1 r_text-[12px]">Please <a target="_blank" class="r_font-bold !r_text-blue-700" href="'.admin_url('post-new.php?post_type=rfm_food_item').'">create food items</a> in order to add them to your menu.</div>');
    }
    wp_reset_postdata();
    ?>
                    </div>
                </div>

                <div
                    class="rjs_editorBody r_box-border r_relative r_w-full r_bg-[whitesmoke] r_p-3 r_pt-10 sm:r_pt-3 r_rounded-b-lg sm:r_rounded-l-none sm:r_rounded-tr-lg">
                    <div class="r_relative rjs_menuSections r_w-full r_grid r_px-1 r_pt-2 r_pb-3 r_box-border">
                    </div>
                    <div
                        class="rjs_sectionNotice r_mx-auto r_max-w-[400px] r_mt-1 r_p-2 r_rounded r_border-green-400 r_border r_border-solid r_bg-green-100 r_text-green-700 r_text-sm r_p-3 r_m-4 r_text-center r_rounded">
                        <?php echo esc_html(__('Your menu doesn\'t have any sections yet, click the green button below to add some.', 'restaurant-food-menu')); ?>
                    </div>
                    <div class="r_flex r_justify-center r_w-full">
                        <div data-tip="<?php echo esc_html(__('Add a new empty section to your menu.', 'restaurant-food-menu')); ?>"
                            class="rjs_menuSectionAdd r_cursor-pointer hover:r_opacity-70 r_flex r_justify-center r_items-center r_w-[40px] r_h-[40px] r_rounded r_bg-green-200">
                            <span class="dashicons dashicons-plus-alt2 r_text-green-600"></span>
                        </div>
                    </div>
                    <div
                        class="r_translate-y-1/2 r_absolute r_left-0 r_top-0 sm:r_-top-[30px] r_flex r_justify-center r_w-full r_mb-3">
                        <div data-tip="<?php echo esc_html(__('Switch between 1 to 3 column menu layouts.', 'restaurant-food-menu')); ?>"
                            class="rjs_menuSectionLayout r_cursor-pointer hover:r_opacity-80 r_flex r_justify-center r_items-center r_w-[30px] r_h-[30px] r_rounded r_bg-purple-200">
                            <span class="dashicons dashicons-screenoptions r_text-purple-600"></span>
                        </div>
                        <div
                            class="r_ml-2 rjs_enterFullScreen r_cursor-pointer hover:r_opacity-80 r_flex r_justify-center r_items-center r_w-[30px] r_h-[30px] r_rounded r_bg-slate-200">
                            <span class="dashicons dashicons-fullscreen-alt r_text-gray-600"></span>
                        </div>
                        <div
                            class="r_ml-2 rjs_exitFullScreen r_cursor-pointer hover:r_opacity-80 r_hidden r_justify-center r_items-center r_w-[30px] r_h-[30px] r_rounded r_bg-slate-400">
                            <span class="dashicons dashicons-fullscreen-exit-alt r_text-white"></span>
                        </div>
                        <div data-tip="<?php echo esc_html(__('When yellow, click this to save changes.', 'restaurant-food-menu')); ?>"
                            class="r_ml-2 rjs_saveData r_flex r_justify-center r_items-center r_w-[30px] r_h-[30px] r_rounded r_bg-gray-100">
                            <span class="dashicons dashicons-cloud-saved r_text-gray-400"></span>
                        </div>
                    </div>
                    <div
                        class="!r_hidden sm:!r_flex rjs_toggleSidebar hover:r_opacity-80 r_z-80 r_absolute r_-left-1 r_top-1 r_cursor-pointer r_flex r_justify-center r_items-center r_w-[26px] r_h-[26px] r_rounded-r r_bg-gray-200">
                        <span class="dashicons dashicons-editor-outdent r_text-gray-500"></span>
                    </div>
                </div>

            </div>

            <div class="r_hidden rjs_menuSectionEmpty re_menu-section r_relative r_mt-8">
                <div
                    class="rjs_menuSectionDelete r_cursor-pointer hover:r_opacity-70 r_absolute r_w-[20px] r_h-[20px] r_top-[-20px] r_rounded-t r_right-0 r_bg-orange-200">
                    <span class="dashicons dashicons-no-alt r_text-orange-600"></span>
                </div>
                <div
                    class="rjs_menuSectionHandle r_cursor-move hover:r_opacity-70 r_absolute r_w-[20px] r_h-[20px] r_top-[-20px] r_rounded-t r_left-0 r_bg-blue-200">
                    <span class="dashicons dashicons-move r_text-lg r_text-blue-600 r_relative r_top-[-4px]"></span>
                </div>
            </div>

            <textarea name="rfm_menu_data" rows="10"
                class="rjs_dataDump !r_hidden"><?php echo esc_html($rfm_menu_data); ?></textarea>

            <textarea name="rfm_menu_settings" rows="10"
                class="rjs_settingsDump !r_hidden"><?php echo esc_html($rfm_menu_settings); ?></textarea>

        </div>
    </div>

    <?php }
?>