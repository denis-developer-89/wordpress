<?php
/*
Template Name: Packages - page
*/
get_header();
while (have_posts()) {
    the_post();
    $post_thumbnail_id = get_post_thumbnail_id();
    $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
    ?>

    <div class="page-container">
        <img class="page-container__bg" src="<?php echo custom_image_url($post_thumbnail_id, 'large'); ?>"
             alt="<?php the_title(); ?>">
        <div class="container">
            <div class="page-content">
                <div class="page-header">
                    <?php the_title('<h1 class="page-header__title">', '</h1>'); ?>
                </div>
                <?php if (have_rows('packagess_list', 'option')) : ?>
                    <div class="routes-list">
                        <?php while (have_rows('packagess_list', 'option')) :
                            the_row();
                            $class_btns = '';
                            if (get_sub_field('button_individual_offer')) {
                                $class_btns = 'dub';
                            } else {

                            }
                            $buy_page = get_permalink(get_field('package_purchase_page', 'option'));
                            ?>
                            <div data-free-trial="<?php the_sub_field('free_trial_period'); ?>"
                                 data-rout-key="<?php the_sub_field('key'); ?>"
                                 class="routes-list__item <?php echo $class_btns; ?>">
                                <div class="routes-list__head">
                                    <div class="routes-list__title">
                                        <?php the_sub_field('title'); ?>
                                    </div>
                                    <div class="routes-list__subtitle">
                                        <?php the_sub_field('subtitle'); ?>
                                    </div>
                                    <div class="routes-list__cost">
                                        <b>
                                            ₪<?php the_sub_field('price'); ?>.<i>00</i>
                                        </b>
                                        <span>
                                            / <?php the_sub_field('text_after_price'); ?>
                                        </span>
                                    </div>

                                    <div class="routes-list__description">
                                        <?php the_sub_field('description'); ?>
                                    </div>

                                    <a class="btn-wrapper" href="<?php echo $buy_page . '?package=';
                                    the_sub_field('key'); ?>">
                                        <?php the_sub_field('text_button_purchase_now'); ?>
                                    </a>

                                    <?php if (get_sub_field('button_individual_offer') && wp_is_mobile()) { ?>
                                        <a class="btn-wrapper individ <?php echo $class_btns; ?> mobile"
                                           target="_blank"
                                           href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', get_field('whatsapp', 'option')); ?>">
                                            <?php the_sub_field('button_individual_offer'); ?>
                                            <img src="<?php echo THEME_DIR; ?>/images/svg/whatsapp.svg" alt="whatsapp">
                                        </a>
                                    <?php } ?>

                                </div>
                                <div class="routes-list_content">
                                    <div class="routes-list_tit">
                                        <?php the_sub_field('title_content'); ?>
                                    </div>
                                    <?php if (have_rows('advantages')) { ?>
                                        <div class="routes-list_advantages">
                                            <?php while (have_rows('advantages')) {
                                                the_row(); ?>
                                                <div class="advantages-item">
                                                    <div class="title"><?php the_sub_field('title'); ?></div>
                                                    <div class="description"><?php the_sub_field('description'); ?></div>
                                                </div>
                                            <?php }; ?>
                                        </div>
                                        <?php if (wp_is_mobile()) { ?>
                                            <a href="" class="show-list_advantages">
                                                <?php _e('לפרטים המלאים', 'winning_plan'); ?>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="routes-list_btns">
                                    <a class="btn-wrapper <?php echo $class_btns; ?>"
                                       href="<?php echo $buy_page . '?package=';
                                       the_sub_field('key'); ?>">
                                        <?php the_sub_field('text_button_purchase_now'); ?>
                                    </a>
                                    <?php if (get_sub_field('button_individual_offer') && !wp_is_mobile()) { ?>
                                        <a class="btn-wrapper individ <?php echo $class_btns; ?>"
                                           target="_blank"
                                           href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', get_field('whatsapp', 'option')); ?>">
                                            <?php the_sub_field('button_individual_offer'); ?>
                                            <img src="<?php echo THEME_DIR; ?>/images/svg/whatsapp.svg" alt="whatsapp">
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php get_footer();