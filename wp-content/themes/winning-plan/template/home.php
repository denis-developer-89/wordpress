<?php
/*
Template Name: Home Page
*/
get_header();

?>

    <div class="main-banner"
         style="background-image: url('<?php echo custom_image_url(get_field('image_banner'), '1920x410'); ?>')">
        <div class="container">
            <div class="main-banner__container">
                <div class="main-banner__content">
                    <h1><?php the_field('title_banner'); ?></h1>
                    <p><?php the_field('description_banner'); ?></p>
                    <div class="main-banner__btn">
                        <a class="btn-wrapper" href="<?php the_field('link_button_banner'); ?>">
                            <?php the_field('text_button_banner'); ?>
                        </a>
                    </div>
                </div>
                <?php
                $video_group = get_field('video_banner');
                if ($video_group) { ?>
                    <div class="main-banner__video">
                        <?php
                        if ($video_group["type"] == 'link') {
                            $video_link = $video_group["link"];
                        } else {
                            $video_link = $video_group["file"];
                        }
                        echo '<a data-fancybox href="' . $video_link . '">
                                <img src="' . custom_image_url($video_group["poster"], '500x320') . '">
                                <span class="play-icon"></span>
                                </a>';
                        ?>
                    </div>
                <?php } ?>
                <div class="main-banner__mobile">
                    <a class="btn-wrapper" href="<?php the_field('link_button_banner'); ?>">
                        <?php the_field('text_button_banner'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="main-about">
        <div class="container">
            <div class="section-title center">
                <?php the_field('title_section_about'); ?>
            </div>
            <?php if (have_rows('content_section_about')): ?>
                <div class="main-about__contents">
                    <?php while (have_rows('content_section_about')): the_row(); ?>
                        <div class="main-about__item">
                            <div class="content">
                                <?php if (get_sub_field('title')) { ?>
                                    <div class="content-title"> <?php the_sub_field('title'); ?> </div>
                                <?php } ?>
                                <?php if (get_sub_field('description')) { ?>
                                    <div class="content-description"> <?php the_sub_field('description'); ?> </div>
                                <?php } ?>
                                <?php if (get_sub_field('link_button')) { ?>
                                    <div class="content-btn">
                                        <?php if (is_user_logged_in()) { ?>
                                            <a class="btn-wrapper" href="<?php the_sub_field('link_button'); ?>">
                                                <?php the_sub_field('text_button'); ?>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn-wrapper" data-fancybox data-src="#call-auth"
                                               href="javascript:;">
                                                <?php the_sub_field('text_button'); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="image">
                                <?php if (get_sub_field('image')) { ?>
                                    <img src="<?php the_sub_field('image'); ?>">
                                <?php } ?>
                            </div>
                            <?php if (get_sub_field('link_button')) { ?>
                                <div class="content-btn__mobile">
                                    <a class="btn-wrapper" href="<?php the_sub_field('link_button'); ?>">
                                        <?php the_sub_field('text_button'); ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-gallery">
        <div class="container">
            <div class="section-title center">
                <?php the_field('title_section_gallery'); ?>
            </div>

            <?php if (have_rows('video_gallery')): ?>
                <div class="main-gallery__carousel">
                    <?php while (have_rows('video_gallery')) {
                        the_row(); ?>
                        <div class="main-gallery__item">
                            <?php
                            $video_box = get_sub_field('video_box');
                            if ($video_box["type"] == 'link') {
                                $video_link = $video_box["link"];
                            } else {
                                $video_link = $video_box["file"];
                            }
                            echo '<a data-fancybox href="' . $video_link . '">
                                <img src="' . custom_image_url($video_box["poster"], '500x320') . '">
                                <span class="play-icon"></span>
                                </a>';
                            ?>
                        </div>
                    <?php }; ?>
                </div>
            <?php endif; ?>

            <div class="section-description center">
                <?php the_field('description_gallery'); ?>
            </div>
            <div class="main-gallery__btn">
                <a class="btn-wrapper" href="<?php the_field('link_button_gallery'); ?>">
                    <?php the_field('text_button_gallery'); ?>
                </a>
            </div>
        </div>
    </div>

    <div class="main-train">
        <div class="container">
            <div class="section-title center">
                <?php the_field('title_section_train'); ?>
            </div>
            <?php if (have_rows('list_train')): ?>
                <div class="main-train__list">
                    <?php while (have_rows('list_train')): the_row(); ?>
                        <div class="main-train__item">
                            <?php if (get_sub_field('icon')) { ?>
                                <div class="item-icon">
                                    <span><img src="<?php the_sub_field('icon'); ?>"></span>
                                </div>
                            <?php } ?>
                            <?php if (get_sub_field('title')) { ?>
                                <div class="item-title"> <?php the_sub_field('title'); ?> </div>
                            <?php } ?>
                            <?php if (get_sub_field('description')) { ?>
                                <div class="item-description"> <?php the_sub_field('description'); ?> </div>
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-system">
        <div class="container">
            <div class="main-system__container">
                <div class="section-title center">
                    <?php the_field('title_section_system'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="main-reviews"
         style="background-image: url('<?php echo custom_image_url(get_field('background_section_reviews'), 'full'); ?>')">
        <div class="container">
            <div class="main-reviews__container">
                <div class="section-title center">
                    <?php the_field('title_section_reviews'); ?>
                </div>
                <?php if (have_rows('list_reviews')): ?>
                    <div class="main-reviews__list main-reviews__carousel">
                        <?php while (have_rows('list_reviews')): the_row(); ?>
                            <div class="main-reviews__item">
                                <?php if (get_sub_field('text')) { ?>
                                    <div class="item-text">
                                        <?php the_sub_field('text'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (get_sub_field('name')) { ?>
                                    <div class="item-name">
                                        <?php the_sub_field('name'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (get_sub_field('position')) { ?>
                                    <div class="item-position">
                                        <?php the_sub_field('position'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (get_sub_field('logo')) { ?>
                                    <div class="item-icon">
                                        <img src="<?php the_sub_field('logo'); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main-partners">
        <div class="container">
            <div class="section-title center">
                <?php the_field('section_title_partners'); ?>
            </div>
            <?php if (have_rows('list_partners')): ?>
                <div class="main-partners__list">
                    <?php while (have_rows('list_partners')): the_row(); ?>
                        <div class="main-partners__item">
                            <?php if (get_sub_field('logo')) { ?>
                                <div class="item-icon">
                                    <img src="<?php the_sub_field('logo'); ?>">
                                </div>
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php if (have_rows('list_faq')) { ?>
    <div id="faq" class="section faq">
        <div class="container">
            <div class="section-title center">
                <?php the_field('section_title_faq'); ?>
            </div>
            <?php $faqs = get_field('list_faq');
            if ($faqs) {
                echo '<div class="faq-list">';
                foreach ($faqs as $item) {
                    echo '<div class="faq-list__item">
                                    <div class="faq-list__title">
                                         ' . $item['question'] . '
                                         <span></span>
                                    </div>
                                    <div class="faq-list__description">
                                       ' . $item['answer'] . '
                                    </div>
                                </div>';
                }
                echo '</div>';
            } ?>

            <div class="section-description center">
                <?php the_field('description_faq'); ?>
            </div>
            <div class="main-gallery__btn">
                <a class="btn-wrapper" href="<?php the_field('link_button_faq'); ?>">
                    <?php the_field('text_button_faq'); ?>
                </a>
            </div>

        </div>
    </div>
<?php } ?>
<?php get_footer(); ?>