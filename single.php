<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            while (have_posts()) :
                the_post();

                // Display post title
                the_title('<h1>', '</h1>');

                // Display featured image with a custom class
                if (has_post_thumbnail()) :
                    $thumbnail_id = get_post_thumbnail_id();
                    $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'large', true);
                    $thumbnail_class = 'custom-thumbnail-class'; // Add your custom class here

                    echo '<div class="post-thumbnail ' . $thumbnail_class . '">';
                    echo '<img src="' . esc_url($thumbnail_url[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="' . esc_attr($thumbnail_class) . '">';
                    echo '</div>';
                endif;

                // Display post content
                the_content();

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

    <?php get_sidebar(); ?>
    <?php get_footer(); ?>
</body>
</html>
