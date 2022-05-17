<?php
/*
Template Name: GL exercise
*/
get_header('personal'); ?>

    <div class="container">
        <?php the_title('<h1 class="wrapper-personal__title">', '</h1>'); ?>

        <div class="gallery-сategory">
            <div class="gallery-сategory__title">
                <span>
                    <img src="<?php echo THEME_DIR; ?>/images/svg/cat-icon-title.svg" alt="icon-title">
                    <?php _e('קטגוריות התרגילים', 'winning_plan'); ?>
                </span>
            </div>

            <?php
            $args = array(
                'taxonomy' => array('drills_сategory'),
                'hide_empty' => false,
                'fields' => 'all',
                'count' => true,
                'parent' => 0
            );

            $term_query = get_terms($args);
            if ($term_query) {
                ?>
                <div class="gallery-сategory__list">
                    <?php foreach ($term_query as $term) {
                        $allDrills = new WP_Query([
                            'post_type' => 'drill',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'drills_сategory',
                                    'field' => 'id',
                                    'terms' => $term->term_id
                                )
                            )
                        ]);
                        $allDrillsCount = 0;
                        if ($allDrills->posts) {
                            $allDrillsCount = count($allDrills->posts);
                        }
                        ?>
                        <div class="gallery-сategory__item">
                            <div class="head" style="background-color: <?php the_field('color', $term); ?>">
                                <img src="<?php echo THEME_DIR; ?>/images/svg/player-category.svg" alt="icon-title">
                            </div>
                            <div class="body">
                                <div class="body-title">
                                    <?php echo $term->name; ?>
                                </div>
                                <div class="body-count">
                                    <span><?php echo $allDrillsCount; ?></span> תרגילים
                                </div>
                                <a href="<?php echo get_permalink(get_field('gallery-exercise-filter', 'option')); ?>?drills_сategory=<?php echo $term->term_id; ?>">
                                    <?php _e('לצפיה', 'winning_plan'); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>


        <div style="display: none;" class="popup-mc" id="add-manager-category">
            <div class="fancybox__title">
                <?php _e('יצירת קטגוריה חדשה', 'winning_plan'); ?>
            </div>

            <form class="popup-mc__form">
                <input type="hidden" value="add_manager_drill_сategory" name="action">
                <div class="form-grey__box">
                    <label><?php _e('שם:', 'winning_plan'); ?></label>
                    <input required name="title_category" type="text" value=""
                           placeholder="<?php _e('שם קטגוריה...', 'winning_plan'); ?>">
                </div>
                <button class="btn-wrapper center blue small">
                    <?php _e('שמירה', 'winning_plan'); ?>
                </button>
            </form>
        </div>


        <div style="display: none;" class="popup-mc" id="edit-manager-category">
            <div class="fancybox__title">
                <?php _e('ערוך קטגוריה', 'winning_plan'); ?>
            </div>
            <form class="popup-mc__form">
                <input type="hidden" value="edit_manager_drill_сategory" name="action">
                <input class="term_id" type="hidden" value="" name="term_id">
                <div class="form-grey__box">
                    <label><?php _e('שם:', 'winning_plan'); ?></label>
                    <input class="term_name" required name="title_category" type="text" value=""
                           placeholder="<?php _e('שם קטגוריה...', 'winning_plan'); ?>">
                </div>
                <button class="btn-wrapper center blue small">
                    <?php _e('להציל', 'winning_plan'); ?>
                </button>
            </form>
        </div>

        <div style="display: none;" class="popup-mc" id="delete-manager-category">
            <div class="fancybox__title">
                <?php _e('יצירת קטגוריה חדשה', 'winning_plan'); ?>
            </div>

            <form class="">
                <input type="hidden" value="delete_manager_drill_сategory" name="action">
                <input class="term_id" type="hidden" value="" name="term_id">
                <div class="popup-mc__content">
                    <p>
                        <?php _e('קטגוריה', 'winning_plan'); ?>
                        <span id="title-manager-category">"title"</span>
                        <?php _e('כוללת תרגילים.', 'winning_plan'); ?>
                    </p>
                    <p><?php _e('התרגילים המשוייכים לקטגוריה זו לא ימחקו, וישארו', 'winning_plan'); ?></p>
                    <p><?php _e('משוייכים לקטגוריות המערכת.', 'winning_plan'); ?></p>
                </div>
                <button class="btn-wrapper center blue small">
                    <?php _e('מחיקה', 'winning_plan'); ?>
                </button>
            </form>
        </div>

        <div class="gallery-сategory">
            <div class="gallery-сategory__title">
                <span>
                    <img src="<?php echo THEME_DIR; ?>/images/svg/cat-icon-title.svg" alt="icon-title">
                    <?php _e('תרגילים אחרונים באתר', 'winning_plan'); ?>
                </span>
                <a href="<?php echo get_permalink(get_field('gallery-exercise-filter', 'option')); ?>">
                    <?php _e('לגלריה המלאה', 'winning_plan'); ?>
                </a>
            </div>

            <?php
            $args = array(
                'post_type' => 'drill',
                'posts_per_page' => 6
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                ?>
                <div class="gallery-drills__list">
                    <?php while ($query->have_posts()) {
                        $query->the_post();
                        $post_thumbnail_id = get_post_thumbnail_id();
                        $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                        $vimeo_video = get_field('video');
                        $class_video = '';
                        if ($vimeo_video) {
                            $class_video = 'video hover-play-video';
                        }
                        echo drill_item_box(get_the_ID());
                    } ?>
                </div>
            <?php } ?>
        </div>
    </div>

<?php get_footer('personal'); ?>