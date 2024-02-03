<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Grid_Post_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'custom_grid_post';
    }

    public function get_title()
    {
        return __('Grid Post View', 'vasux');
    }

    public function get_icon()
    {
        return 'eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['Vasux'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'query_settings',
            [
                'label' => __('Query Settings', 'vasux'),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'vasux'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 8, // Set a default value
            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Select Category', 'vasux'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_all_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Post Offset', 'vasux'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $posts_per_page = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 5;
        $category = isset($settings['category']) ? $settings['category'] : [];
        $offset = isset($settings['offset']) ? $settings['offset'] : 0;

        // Query posts
        $query_args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'category__in' => $category,
            'offset' => $offset,
        );

        $query = new WP_Query($query_args);

        // Check if there are posts
        if ($query->have_posts()) {
            echo '<div class="Grid-Post-Style1">'; // Added a unique class here

            // Start the loop
            while ($query->have_posts()) {
                $query->the_post();

                // Output post content in grid format
                echo '<div class="grid-item">';

                // Display post thumbnail (featured image) with a clickable link to the post
                if (has_post_thumbnail()) {
                    echo '<a href="' . get_permalink() . '" class="post-thumbnail">';
                    echo get_the_post_thumbnail();
                    // Display post category on top of the post thumbnail image
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        $category = $categories[0]; // Display the first category only
                        echo '<span class="post-category">' . esc_html($category->name) . '</span>';
                    }
                    echo '</a>';
                }

                // Display post title with a clickable link to the post
                echo '<h1><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>';

                // Display post author image and name
                $author_id = get_the_author_meta('ID');
                $author_avatar = get_avatar_url($author_id, array('size' => 50));
                $author_name = get_the_author_meta('display_name');
                echo '<div class="author-info">';
                echo '<img src="' . esc_url($author_avatar) . '" alt="' . esc_attr($author_name) . '" class="author-avatar" />';
                echo '<span class="author-name">' . esc_html($author_name) . '</span>';
                echo '<span class="post-date"> ⏱️ ' . get_the_date("j F Y" ) . '</span>';
                echo '</div>';

                // Display post excerpt
                echo '<div class="post-content">' . get_the_excerpt() . '</div>';

                echo '</div>';
            }

            echo '</div>';

            // Reset post data
            wp_reset_postdata();
        } else {
            echo '<p>No posts found.</p>';
        }
    }

    // Helper function to get all categories
    private function get_all_categories()
    {
        $categories = get_categories();
        $options = [];
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        return $options;
    }
}
