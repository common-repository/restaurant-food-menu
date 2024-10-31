<?php

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// hook metabox
add_action('admin_init', 'dkrfm_menu_add_help', 1);
function dkrfm_menu_add_help()
{
    add_meta_box(
        'dkrfm_menu_help',
        __('Shortcode', 'restaurant-food-menu'),
        'dkrfm_menu_help_display',
        'rfm_food_menu',
        'side',
        'high'
    );
}

// metabox display
function dkrfm_menu_help_display()
{ ?>

<div class="dmb_side_block">
    <p>
        <?php
            global $post;
    $slug = '';
    $slug = $post->post_name; ?>

        <?php if ('' != $slug) { ?>
        <span
            style="background: white; padding: 4px; border: dashed 2px #add595; border-radius:4px; font-size: 13px;">[rfm
            name="<?php echo esc_attr($slug); ?>"]</span>
        <?php } else { ?>
        <span style='display:inline-block;color:#849d3a'>
            <?php /* translators: Leave HTML tags */ esc_attr_e('Publish your menu before you can see your shortcode.', 'restaurant-food-menu'); ?>
        </span>
        <?php } ?>
    </p>
    <p>
        <?php /* translators: Leave HTML tags */ esc_attr_e('To display your menu on your site, copy-paste the shortcode above in your post/page.', 'restaurant-food-menu'); ?>
    </p>
</div>

<div class="dmb_side_block">
    <div class="dmb_help_title">
        Get support
    </div>
    <a target="_blank" href="https://wpdarko.com/support/submit-a-request/">Submit a ticket</a><br />
    <a target="_blank" href="https://help.wpdarko.com/en/articles/409669-get-started-with-restaurant-food-menu">View
        documentation</a>
</div>

<?php } ?>