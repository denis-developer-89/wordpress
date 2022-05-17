<?php get_header(); ?>

	<div class="section head">
		<div class="container">
			<h1 class="section__title">
				<?php
					printf( esc_html__( 'Search results: %s', 'winning_plan' ), '<span>' . get_search_query() . '</span>' );
				?>
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

					else : ?>

					<p>
						<?php _e('Nothing was found for this query on the site. Please change your request and try again.','winning_plan')?>
					</p>
					<p>
						<?php get_search_form(); ?>
					</p>
					
					<div class="search__button">
						<a href="<?php echo get_home_url(); ?>" class="btn-wrapper">
							<?php _e( 'Back to Homepage', 'winning_plan' );?>
						</a>
					</div>					

				<?php endif; ?>			
			</div>
		</div>
	</div>


<?php get_footer();
