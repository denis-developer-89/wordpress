<?php get_header(); ?>

	<div class="section error-404">
		<div class="container">
			<div class="error-404__content">
				<h1>
					<?php _e( '404', 'winning_plan' );?>
				</h1>
				<div class="section__title">
					<?php _e( 'Page not found', 'winning_plan' );?>
				</div>
				<div class="section__description">
					<?php _e( 'The page you requested could not be found.', 'winning_plan' );?>
				</div>	
				<div class="error-404__button">
					<a href="<?php echo get_home_url(); ?>" class="btn-wrapper">
						<?php _e( 'Back to Homepage', 'winning_plan' );?>
					</a>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();
