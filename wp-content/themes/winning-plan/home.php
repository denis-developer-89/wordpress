<?php get_header();
	$page_for_posts = get_option( 'page_for_posts' );
	$post_thumbnail_id = get_post_thumbnail_id($page_for_posts);
	$image_post_url = wp_get_attachment_image_src($post_thumbnail_id,'full');	
 ?>

	<div class="section head">
		<div class="container">
			<h1 class="section__title">
				<?php _e('Blog','winning_plan'); ?>
			</h1>
		</div>
	</div>

	<div class="section articles">
		<div class="container">
			<div class="articles-list">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); 
					$article_thumbnail_id = get_post_thumbnail_id();									
				?>
					<div class="section-articles__item">
						<div class="image">
							<a href="<?php echo get_permalink(); ?>">
								<img src="<?php echo custom_image_url($article_thumbnail_id,'large'); ?>" alt="<?php the_title()?>">
							</a>
						</div>
						<div class="content">
							<div class="title">
								<a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
							</div>
							<div class="description">
								<?php
									$cont = get_the_content();
									$content = preg_replace( '~\[[^\]]+\]~', '', $cont );
									$trimmed_content = wp_trim_words( $content, 30);
									echo $trimmed_content;				   
								?>
							</div>
							<div class="more">
								<a href="<?php echo get_permalink(); ?>">
									<?php _e( 'Read More', 'winning_plan' );?>
								</a>
							</div>
						</div>
					</div>

				<?php endwhile;

					the_posts_navigation();

					else :

						_e('The section is empty.','winning_plan');

					endif;
				?>			

			</div>
		</div>
	</div>

<?php get_footer();
