<?php

// Theme Setup
function theme_setup()
{
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for automatic feed links
    add_theme_support('automatic-feed-links');

    // Add support for title tag
    add_theme_support('title-tag');

    // Register navigation menus
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'your-theme-textdomain'),
    ));
}

add_action('after_setup_theme', 'theme_setup');

// Enqueue Styles and Scripts
function enqueue_styles_and_scripts()
{
    // Enqueue main stylesheet
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Enqueue custom stylesheet
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/Style/single_post.css');
}

function enqueue_custom_styles()
{
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/Style/Gridpost.css');

}



add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
add_action('wp_enqueue_scripts', 'enqueue_styles_and_scripts');

// Custom Excerpt Length
function custom_excerpt_length($length)
{
    return 20; // Adjust the number of words as needed
}

add_filter('excerpt_length', 'custom_excerpt_length');

// Custom Excerpt "Read More" Link
function custom_excerpt_more($more)
{
    return '... <a class="read-more" href="' . get_permalink() . '">' . __('Read More', 'your-theme-textdomain') . '</a>';
}

add_filter('excerpt_more', 'custom_excerpt_more');

// Custom Sidebar
function custom_sidebar()
{
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'your-theme-textdomain'),
        'id'            => 'main-sidebar',
        'description'   => __('Widgets in this area will be shown on the main sidebar.', 'your-theme-textdomain'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}

add_action('widgets_init', 'custom_sidebar');

// Register oEmbed Widget
// ... (Your existing code)

// Register oEmbed Widget
if (!function_exists('register_oembed_widget')) {
    function register_oembed_widget($widgets_manager)
    {
        require_once(__DIR__ . '/widgets/oembed-widget.php');
        $widgets_manager->register(new \Elementor_oEmbed_Widget());
    }
    add_action('elementor/widgets/register', 'register_oembed_widget');
}

// Register Custom Grid Post Widget
if (!function_exists('register_custom_grid_post_widget')) {
    function register_custom_grid_post_widget($widgets_manager)
    {
        require_once(__DIR__ . '/widgets/grid-post.php');
        $widgets_manager->register_widget_type(new \Custom_Grid_Post_Widget());
        // Include the widget class definition

    }

    add_action('elementor/widgets/register', 'register_custom_grid_post_widget');
}

function add_elementor_widget_categories($elements_manager)
{
    // Define the new category
    $new_category = [
        'title' => 'Vasux',
        'icon' => 'fa fa-plug',
    ];

    // Get the existing categories
    $old_categories = $elements_manager->get_categories();

    // Merge the new category at the beginning of the existing categories
    $categories = ['Vasux' => $new_category] + $old_categories;

    // Set the updated categories array
    $set_categories = function ($categories) {
        $this->categories = $categories;
    };

    // Call the set_categories function with the updated categories
    $set_categories->call($elements_manager, $categories);
}

add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');




// Add custom fields to user profile
function add_social_media_fields($user)
{
    ?>
    <h3><?php _e('Social Media Links', 'textdomain'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="twitter"><?php _e('Twitter', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="facebook"><?php _e('Facebook', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>">
            </td>
        </tr>
        <tr>
            <th><label for="instagram"><?php _e('Instagram', 'textdomain'); ?></label></th>
            <td>
                <input type="text" name="instagram" id="instagram" value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>">
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_social_media_fields');
add_action('edit_user_profile', 'add_social_media_fields');

// Save custom fields
function save_social_media_fields($user_id)
{
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'twitter', sanitize_text_field($_POST['twitter']));
        update_user_meta($user_id, 'facebook', sanitize_text_field($_POST['facebook']));
        update_user_meta($user_id, 'instagram', sanitize_text_field($_POST['instagram']));
    }
}
add_action('personal_options_update', 'save_social_media_fields');
add_action('edit_user_profile_update', 'save_social_media_fields');
