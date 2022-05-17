<?php  get_header(); 
	while ( have_posts() ) { the_post(); 
	$post_thumbnail_id=get_post_thumbnail_id();
	$image_post_url = wp_get_attachment_image_src($post_thumbnail_id,'full');							
?>
	<div class="container">
		<div class="single-container">
			<div class="single-content">
					<div class="single-header">
						<div class="single-data"><?php the_time('d M Y')?></div>
						<?php the_title( '<h1 class="single-header__title">', '</h1>' );?>						
					</div>
					<div class="single-images">
						<img src="<?php echo custom_image_url($post_thumbnail_id,'large'); ?>" alt="">
					</div>
					<div class="single-elementor">
						<?php the_content();?>
					</div>
			</div>
			<div class="single-sidebar">

			</div>
		</div>
	</div>
<?php } ?>
	
<?php get_footer();
