<div id="Post_Grid" class="sidebar">
	<?php dynamic_sidebar('Post_Grid'); ?>

	<div class="post-grid">
		<?php
		$args = array(
			'post_type'      => 'post', // Change 'post' to the desired post type
			'posts_per_page' => -1, // Display all posts
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



