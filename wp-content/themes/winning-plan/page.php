<?php get_header();
while (have_posts()) {
    the_post();
    $post_thumbnail_id = get_post_thumbnail_id();
    $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
    ?>

    <div class="page-container">
       <img class="page-container__bg" src="<?php echo custom_image_url($post_thumbnail_id, 'large'); ?>" alt="<?php the_title(); ?>">
    <div class="container">
        <div class="page-content">
            <div class="page-header">
                <?php the_title('<h1 class="page-header__title">', '</h1>'); ?>
            </div>
            <div class="page-elementor">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    </div>
<?php } ?>

<?php get_footer();
