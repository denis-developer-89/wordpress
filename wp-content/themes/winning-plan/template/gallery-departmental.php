<?php
/*
Template Name: GL departmental
*/
get_header('personal');
?>

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
                            ),
                            'meta_key'  => 'maneger_recommended',
                            'meta_value' => true
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
                                <a href="<?php echo get_permalink(get_field('gallery-departmental-filter', 'option')); ?>?drills_сategory=<?php echo $term->term_id; ?>">
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
                    <?php _e('קטגוריות שלי', 'winning_plan'); ?>
                </span>
                <?php if (user_role_check('manager')) { ?>
                    <a id="add-drill-category" data-fancybox="" data-src="#add-manager-category" href="javascript:;">
                        <?php _e('הוספת קטגוריה', 'winning_plan'); ?>
                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M7.1 5.3h4.5v1.8H7.1v4.5H5.3V7.1H.8V5.3h4.5V.8h1.8v4.5Z" fill="#2C62FF"/>
                        </svg>
                    </a>
                <?php } ?>
            </div>

            <?php
            $args = array(
                'taxonomy' => array('manager_drills_сategory'),
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
                                    'taxonomy' => 'manager_drills_сategory',
                                    'field' => 'id',
                                    'terms' => $term->term_id
                                )
                            ),
                            'meta_key'  => 'maneger_recommended',
                            'meta_value' => true
                        ]);
                        $allDrillsCount = 0;
                        if ($allDrills->posts) {
                            $allDrillsCount = count($allDrills->posts);
                        }
                        ?>
                        <div class="gallery-сategory__item" data-title="<?php echo $term->name; ?>"
                             data-term="<?php echo $term->term_id; ?>">
                            <div class="head">
                                <?php if (user_role_check('manager')) { ?>
                                    <a class="gallery-сategory__edit" href="#">
                                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 16">
                                            <path d="M2 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2Zm0 2C.9 6 0 6.9 0 8s.9 2 2 2 2-.9 2-2-.9-2-2-2Zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2Z"
                                                  fill="#fff"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                                <img src="<?php echo THEME_DIR; ?>/images/svg/player-category.svg" alt="icon-title">
                                <?php if (user_role_check('manager')) { ?>
                                    <ul class="сategory-edit__box">
                                        <li data-fancybox="" data-src="#delete-manager-category" href="javascript:;"
                                            data-action="delete">
                                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 19">
                                                <path d="M1 16.5c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-12H1v12Zm2.46-7.12 1.41-1.41L7 10.09l2.12-2.12 1.41 1.41-2.12 2.12 2.12 2.12-1.41 1.41L7 12.91l-2.12 2.12-1.41-1.41 2.12-2.12-2.13-2.12ZM10.5 1.5l-1-1h-5l-1 1H0v2h14v-2h-3.5Z"
                                                      fill="#9A9AB0"/>
                                            </svg>
                                            <span><?php _e('מחיקה', 'winning_plan'); ?></span>
                                        </li>
                                        <li data-fancybox="" data-src="#edit-manager-category" href="javascript:;"
                                            data-action="edit">
                                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 17">
                                                <path d="M0 13.164v3.333h3.333l9.83-9.83L9.83 3.334 0 13.164ZM15.74 4.09a.885.885 0 0 0 0-1.253L13.66.757a.885.885 0 0 0-1.253 0l-1.626 1.626 3.333 3.333L15.74 4.09Z"
                                                      fill="#9A9AB0"/>
                                            </svg>
                                            <span><?php _e('שינוי שם', 'winning_plan'); ?></span>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                            <div class="body">
                                <div class="body-title">
                                    <?php echo $term->name; ?>
                                </div>
                                <div class="body-count">
                                    <span><?php echo $allDrillsCount; ?></span>
                                    <?php _e('תרגילים', 'winning_plan'); ?>
                                </div>
                                <a href="<?php echo get_permalink(get_field('gallery-departmental-filter', 'option')); ?>?drills_сategory=<?php echo $term->term_id; ?>">
                                    <?php _e('לצפיה', 'winning_plan'); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <div class="gallery-сategory">
            <div class="gallery-сategory__title">
                <span>
                    <img src="<?php echo THEME_DIR; ?>/images/svg/cat-icon-title.svg" alt="icon-title">
                    <?php _e('תרגילים אחרונים באתר', 'winning_plan'); ?>
                </span>
                <a href="<?php echo get_permalink(get_field('gallery-departmental-filter', 'option')); ?>">
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