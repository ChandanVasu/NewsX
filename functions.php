<?php

// Theme Setup
function theme_setup() {
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
function enqueue_styles_and_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Enqueue custom stylesheet
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/Style/single_post.css');
}

function enqueue_custom_styles() {
    wp_enqueue_style('custom-styles', get_template_directory_uri() . '/Style/Gridpost.css');

}



add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
add_action('wp_enqueue_scripts', 'enqueue_styles_and_scripts');

// Custom Excerpt Length
function custom_excerpt_length($length) {
    return 20; // Adjust the number of words as needed
}

add_filter('excerpt_length', 'custom_excerpt_length');

// Custom Excerpt "Read More" Link
function custom_excerpt_more($more) {
    return '... <a class="read-more" href="' . get_permalink() . '">' . __('Read More', 'your-theme-textdomain') . '</a>';
}

add_filter('excerpt_more', 'custom_excerpt_more');

// Custom Sidebar
function custom_sidebar() {
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
    function register_oembed_widget($widgets_manager) {
        require_once(__DIR__ . '/widgets/oembed-widget.php');
        $widgets_manager->register(new \Elementor_oEmbed_Widget());
    }
    add_action('elementor/widgets/register', 'register_oembed_widget');
}

// Register Custom Grid Post Widget
if (!function_exists('register_custom_grid_post_widget')) {
    function register_custom_grid_post_widget($widgets_manager) {
        require_once(__DIR__ . '/widgets/grid-post.php');
        $widgets_manager->register_widget_type(new \Custom_Grid_Post_Widget());
        // Include the widget class definition
        
    }

    add_action('elementor/widgets/register', 'register_custom_grid_post_widget');
}
