
<div id="content" class="simple-post">
    <div id="primary" class="simple-post-area">
        <main id="main" class="simple-post-site-main">

            <!-- Your post grid code goes here -->
            <div id="Post_Grids" class="posts">
                <?php dynamic_sidebar('Post_Grids'); ?>

                <div class="post-grids">
                    <?php
                    $args = array(
                        'post_type'      => 'post', // Change 'post' to the desired post type
                        'posts_per_page' => 10, // Display all posts
                    );

                    $posts_query = new WP_Query($args);

                    if ($posts_query->have_posts()) :
                        while ($posts_query->have_posts()) : $posts_query->the_post();
                    ?>
                            <div class="post-grid-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                                    </div>
                                <?php endif; ?>
                                <h2><?php the_title(); ?></h2>
                                <div class="post-content"><?php the_excerpt(); ?></div>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo 'No posts found.';
                    endif;
                    ?>
                </div>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- #content -->

