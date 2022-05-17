<?php


function wpseo_breadcrumb_add_woo_shop_link( $links ) {
    global $post;

    if (is_page_template('template/gallery-departmental.php') ||
        //is_page_template('template/gallery-departmental-filter.php') ||
        is_page_template('template/gallery-exercise.php') ||
        //is_page_template('template/gallery-exercise-filter.php') ||
        is_page_template('template/gallery-training-filter.php')){
        $breadcrumb[] = array(
            'url' => '',
            'text' => __('גלריה מקצועית', 'winning_plan'),
        );
        array_splice( $links, 1, -2, $breadcrumb );

    }
    return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'wpseo_breadcrumb_add_woo_shop_link' );

function drill_item_box($drill_id)
{
    $post_thumbnail_id = get_post_thumbnail_id($drill_id);
    $vimeo_video = get_field('video', $drill_id);
    $class_video = '';
    if ($vimeo_video) {
        $class_video = 'video hover-play-video';
    }
    $current_user = wp_get_current_user();
    $user_favorits = get_user_meta($current_user->ID, 'drill_favorit_user', true);

    $favorit_class = '';
    if ($user_favorits) {
        if (in_array($drill_id, $user_favorits)) {
            $favorit_class = 'added';
        }
    }

    $check_divisions = get_post_meta($drill_id, 'maneger_recommended', true);
    $divisions_class = '';
    if ($check_divisions) {
        $divisions_class = 'added';
    }

    $post_data = get_post($drill_id);
    $author_id = $post_data->post_author;

    ob_start();
    ?>
    <a href="<?php echo get_permalink($drill_id); ?>" class="gallery-drills__item">
        <div class="title">
            <?php the_title(); ?>
            <?php if (user_role_check('manager') /*|| user_role_check('administrator')*/) { ?>
                <span data-id="<?php echo $drill_id; ?>" class="drill-divisions <?php echo $divisions_class; ?>">
                <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 30">
                    <path class="b"
                          d="M0 4A3.667 3.667 0 0 1 3.667.334h14.666A3.667 3.667 0 0 1 22 4v24.75a.917.917 0 0 1-1.425.763L11 24.352l-9.576 5.16A.917.917 0 0 1 0 28.75V4Zm3.667-1.833A1.833 1.833 0 0 0 1.833 4v23.038l8.659-4.55a.916.916 0 0 1 1.016 0l8.658 4.55V4a1.833 1.833 0 0 0-1.833-1.833H3.667Z"
                          fill="#9A9AB0"/>
                    <path
                            class="b"
                            d="M3.667 2.167A1.833 1.833 0 0 0 1.833 4v23.038l8.659-4.55a.916.916 0 0 1 1.016 0l8.658 4.55V4a1.833 1.833 0 0 0-1.833-1.833H3.667Z"
                            fill="#fff"/>
                    <path class="w"
                          d="M10.707 7.85a.326.326 0 0 1 .586 0l1.163 2.356a.326.326 0 0 0 .245.18l2.603.377a.325.325 0 0 1 .18.556l-1.88 1.835a.327.327 0 0 0-.094.29l.443 2.592a.327.327 0 0 1-.473.343l-2.328-1.225a.327.327 0 0 0-.302 0L8.52 16.379a.326.326 0 0 1-.471-.343l.444-2.593a.326.326 0 0 0-.092-.29L6.514 11.32a.326.326 0 0 1 .18-.556l2.603-.377a.326.326 0 0 0 .245-.18l1.165-2.356Z"
                          fill="#9A9AB0"/>
                </svg>
                <i>
                    <?php _e('הוספה לתרגילים מחלקתיים', 'winning_plan'); ?>
                </i>
            </span>
            <?php } ?>
        </div>
        <div data-vimeo="<?php echo $vimeo_video; ?>" class="head <?php echo $class_video; ?>">
            <?php if ($vimeo_video) { ?>
                <span class="hover-play-iframe">
                    <iframe id="<?php echo $vimeo_video; ?>"
                            src="https://player.vimeo.com/video/<?php echo $vimeo_video; ?>?h=53a1e27e93&amp;badge=0&amp;autopause=0&amp;autoplay=1&amp;loop=1&amp;muted=1"
                            width="1080" height="1350" frameborder="0"
                            allow="autoplay; fullscreen; picture-in-picture">
                    </iframe>
                </span>
            <?php } ?>
            <img src="<?php echo custom_image_url($post_thumbnail_id, 'large'); ?>">
        </div>
        <div class="system">
            <span data-id="<?php echo $drill_id; ?>" href="#" class="drill-favorit <?php echo $favorit_class; ?>">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path class="body"
                          d="M20.6328 4.6696C20.3187 3.94218 19.8657 3.28301 19.2992 2.72897C18.7323 2.17328 18.064 1.73168 17.3305 1.42819C16.5699 1.11224 15.7541 0.950513 14.9305 0.952409C13.775 0.952409 12.6477 1.26882 11.668 1.86647C11.4336 2.00944 11.2109 2.16647 11 2.33757C10.7891 2.16647 10.5664 2.00944 10.332 1.86647C9.35234 1.26882 8.225 0.952409 7.06953 0.952409C6.2375 0.952409 5.43125 1.11178 4.66953 1.42819C3.93359 1.73288 3.27031 2.17116 2.70078 2.72897C2.13359 3.28238 1.6805 3.94171 1.36719 4.6696C1.04141 5.42663 0.875 6.23053 0.875 7.05788C0.875 7.83835 1.03438 8.65163 1.35078 9.47897C1.61563 10.1704 1.99531 10.8876 2.48047 11.6118C3.24922 12.7579 4.30625 13.9532 5.61875 15.1649C7.79375 17.1735 9.94766 18.561 10.0391 18.6173L10.5945 18.9735C10.8406 19.1305 11.157 19.1305 11.4031 18.9735L11.9586 18.6173C12.05 18.5587 14.2016 17.1735 16.3789 15.1649C17.6914 13.9532 18.7484 12.7579 19.5172 11.6118C20.0023 10.8876 20.3844 10.1704 20.6469 9.47897C20.9633 8.65163 21.1227 7.83835 21.1227 7.05788C21.125 6.23053 20.9586 5.42663 20.6328 4.6696ZM11 17.1196C11 17.1196 2.65625 11.7735 2.65625 7.05788C2.65625 4.6696 4.63203 2.73366 7.06953 2.73366C8.78281 2.73366 10.2688 3.68991 11 5.08678C11.7312 3.68991 13.2172 2.73366 14.9305 2.73366C17.368 2.73366 19.3438 4.6696 19.3438 7.05788C19.3438 11.7735 11 17.1196 11 17.1196Z"
                          fill="#9A9AB0"/>
                    <path class="border"
                          d="M11 17.1196C11 17.1196 2.65625 11.7735 2.65625 7.05788C2.65625 4.6696 4.63203 2.73366 7.06953 2.73366C8.78281 2.73366 10.2688 3.68991 11 5.08678C11.7312 3.68991 13.2172 2.73366 14.9305 2.73366C17.368 2.73366 19.3438 4.6696 19.3438 7.05788C19.3438 11.7735 11 17.1196 11 17.1196Z"
                          fill="#9A9AB0"/>
                </svg>
            </span>
            <?php
            $user_meta = get_userdata($author_id);
            $author_roles = $user_meta->roles;
            if (in_array('manager', (array)$author_roles)) {
                $author_image_profile_id = get_the_author_meta( 'profile_image', $author_id );
                echo '<img class="oval" src="'.custom_image_url($author_image_profile_id, '50x50').'">';
                General::get_post_author($drill_id);
                //echo $user_meta->display_name;
                //$General->get_post_author($author_id);
            } else { ?>
                <img src="<?php echo THEME_DIR; ?>/images/svg/winning-plan-icon.svg" alt="winning-plan/">
                <?php _e('מערכת Winning Plan', 'winning_plan'); ?>
            <?php } ?>

        </div>
        <div class="description">
            <?php the_field('short-description', $drill_id); ?>
        </div>
        <div class="meta">
            <div class="meta-data">
                <span class="data">
                    <?php the_time('d.m.y') ?>
                </span>
            </div>
            <div class="meta-info">
                <?php if (get_post_type(get_the_ID()) == 'training') { ?>
                    <span class="exercises">
                        <?php _e('תרגילים', 'winning_plan'); ?>
                        <b>
                            <?php
                                $training_drill = get_field('drill_step_list', $drill_id);
                                if(is_array($training_drill)){
                                    $training_drill_count = 0;
                                    foreach ($training_drill as $d_item){
                                        if(is_array($d_item['drills'])){
                                            $training_drill_count = $training_drill_count + count($d_item['drills']);
                                        }
                                    }
                                    if ($training_drill_count) {
                                        echo $training_drill_count;
                                    } else {
                                        echo '0';
                                    }
                                } else {
                                    echo '0';
                                }
                            ?>
                        </b>
                    </span>
                <?php } ?>
                <span class="age">
                    <?php
                        if (get_post_type(get_the_ID()) == 'training') {
                            _e('גיל', 'winning_plan');
                        } else {
                            _e('גיל:', 'winning_plan');
                        }
                    ?>
                    <b><?php the_field('age', $drill_id); ?></b>
                </span>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}

function update_drill_favorit_user()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $current_user = wp_get_current_user();
        $list_user_favorits = array();
        $user_favorits = get_user_meta($current_user->ID, 'drill_favorit_user', true);
        $new_favorit_id = $_POST['drill_id'];
        if ($user_favorits) {
            if ($_POST['act'] == 'minus') {
                foreach ($user_favorits as $user_favorit) {
                    if ($new_favorit_id != $user_favorit) {
                        $list_user_favorits[] = $user_favorit;
                    }
                }
            } else {
                $user_favorits[] = $new_favorit_id;
                $list_user_favorits = $user_favorits;
            }
        } else {
            $list_user_favorits = array($new_favorit_id);
        }
        update_user_meta($current_user->ID, 'drill_favorit_user', $list_user_favorits);
        $data = array(
            'status' => true,
            'message' => __('This drill added to favorite', 'winning_plan'),
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_drill_favorit_user', 'update_drill_favorit_user');

function update_maneger_recommended()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

        update_post_meta($_POST['drill_id'], 'maneger_recommended', true);
        //if($_POST['manager_сategory']){
        wp_set_post_terms($_POST['drill_id'], $_POST['manager_сategory'], 'manager_drills_сategory');
        //}

        $data = array(
            'status' => true,
            'message' => __('Successfully added to the recommended manager list', 'winning_plan')
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_maneger_recommended', 'update_maneger_recommended');


function show_modal_form_maneger_recommend()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $data = array(
            'status' => true,
            'result' => modal_form_maneger_recommend($_POST['drill_id'])
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();

}

add_action('wp_ajax_show_modal_form_maneger_recommend', 'show_modal_form_maneger_recommend');

function clear_maneger_recommend()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

        update_post_meta($_POST['drill_id'], 'maneger_recommended', false);

        $data = array(
            'status' => true,
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();

}

add_action('wp_ajax_clear_maneger_recommend', 'clear_maneger_recommend');


function update_drill_divisions_user()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {

        $current_user = wp_get_current_user();
        $list_user_divisions = array();
        $user_divisions = get_user_meta($current_user->ID, 'drill_divisions_user', true);
        $new_division_id = $_POST['drill_id'];

        if ($user_divisions) {
            if ($_POST['act'] == 'minus') {
                foreach ($user_divisions as $user_division) {
                    if ($new_division_id != $user_division) {
                        $list_user_divisions[] = $user_division;
                    }
                }
            } else {
                $user_divisions[] = $new_division_id;
                $list_user_divisions = $user_divisions;
            }
        } else {
            $list_user_divisions = array($new_division_id);
        }

        update_user_meta($current_user->ID, 'drill_divisions_user', $list_user_divisions);

        $data = array(
            'status' => true,
            'message' => __('This drill added to favorite', 'winning_plan'),
        );
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_update_drill_divisions_user', 'update_drill_divisions_user');


function add_manager_drill_сategory()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $current_user = wp_get_current_user();

        $title_category = $_POST['title_category'];

        if ($title_category) {
            $new_category = wp_insert_term(
                $title_category,
                'manager_drills_сategory',
                array(
                    'parent' => 0
                )
            );
            $category_id = $new_category['term_id'];
            add_term_meta($category_id, 'creator_term', $current_user->ID);
            $data = array(
                'status' => true,
                'message' => __('<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 14"><path d="M5.8 10.6 1.6 6.4.2 7.8l5.6 5.6 12-12L16.4 0 5.8 10.6Z" fill="#26AF77"/></svg>', 'winning_plan'),
            );
        } else {
            $data = array(
                'status' => false,
                'message' => __('Title category in corect', 'winning_plan'),
            );
        }
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_add_manager_drill_сategory', 'add_manager_drill_сategory');


function delete_manager_drill_сategory()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        wp_delete_term($_POST['term_id'], 'manager_drills_сategory');
        $data = array(
            'status' => true,
            'message' => __('Category successfully deleted.', 'winning_plan'),
        );

    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_delete_manager_drill_сategory', 'delete_manager_drill_сategory');

function edit_manager_drill_сategory()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $title_category = $_POST['title_category'];
        if ($title_category) {
            wp_update_term($_POST['term_id'], 'manager_drills_сategory', array(
                'name' => $title_category,
                'slug' => $title_category
            ));

            $data = array(
                'status' => true,
                'message' => __('Category successfully deleted.', 'winning_plan'),
            );
        }
    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_edit_manager_drill_сategory', 'edit_manager_drill_сategory');


function modal_form_maneger_recommend($post_id)
{
    ob_start();
    $manager_category_check = array();
    ?>
    <div class="modal-recommend">
        <div class="modal-recommend__content">
            <div class="modal-recommend__head">
                <a class="modal-recommend__close" href="#">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.82227 1.72552C0.725509 1.82333 0.72597 1.98095 0.823301 2.07819L5.74941 7L0.823302 11.9218C0.725971 12.0191 0.725511 12.1767 0.822271 12.2745L1.71391 13.1758C1.76069 13.2231 1.82439 13.2498 1.89091 13.25C1.95743 13.2502 2.02128 13.2239 2.06834 13.1769L7 8.2495L11.9317 13.1769C11.9787 13.2239 12.0426 13.2502 12.1091 13.25C12.1756 13.2498 12.2393 13.2231 12.2861 13.1758L13.1777 12.2745C13.2745 12.1767 13.274 12.0191 13.1767 11.9218L8.25059 7L13.1767 2.07819C13.274 1.98095 13.2745 1.82333 13.1777 1.72552L12.2861 0.824182C12.2393 0.776892 12.1756 0.750195 12.1091 0.750001C12.0426 0.749807 11.9787 0.77613 11.9317 0.823146L7 5.7505L2.06834 0.823146C2.02128 0.77613 1.95743 0.749807 1.89091 0.750001C1.82439 0.750195 1.76069 0.776892 1.71391 0.824182L0.82227 1.72552Z"
                              fill="#091932" stroke="black" stroke-width="0.5" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </a>
                <span>
                    <?php _e('שיוך תרגיל לתרגילים מחלקתיים', 'winning_plan'); ?>
                 </span>
            </div>
            <div class="modal-recommend__body">
                <div class="modal-recommend__category">
                    <div class="modal-recommend__cat">
                        <b>
                            <?php _e('קטגוריות המערכת', 'winning_plan'); ?>
                        </b>
                        <span>
                                    <?php _e('התרגיל נוסף אוטומטית לתרגילים המחלקתיים.', 'winning_plan'); ?>
                                </span>
                        <ul>
                            <?php
                            $cur_terms = get_the_terms($post_id, 'drills_сategory');
                            if (is_array($cur_terms)) {
                                foreach ($cur_terms as $cur_term) {
                                    echo '<li>
                                        <div>
                                            <input disabled checked="" type="checkbox" class="custom-checkbox" value="' . $cur_term->term_id . '">
                                            <label>
                                               ' . $cur_term->name . '
                                            </label>
                                        </div>
                                    </li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="modal-recommend__cat m">
                        <b>
                            <?php _e('קטגוריות שלי', 'winning_plan'); ?>
                        </b>
                        <span>
                              <?php _e('כאן תוכל לשייך אותו גם לקטגוריות שלך.', 'winning_plan'); ?>
                        </span>
                        <form id="manager_сategory_list">
                            <input type="hidden" name="drill_id" value="<?php echo $post_id; ?>">
                            <ul>
                                <?php
                                $cur_terms = get_the_terms($post_id, 'manager_drills_сategory');
                                $cur_terms_Arr = array();
                                if (is_array($cur_terms)) {
                                    foreach ($cur_terms as $cur_term) {
                                        $cur_terms_Arr[] = $cur_term->term_id;
                                    }
                                }
                                $args = array(
                                    'taxonomy' => array('manager_drills_сategory'),
                                    'hide_empty' => false,
                                    'fields' => 'all',
                                    'count' => true,
                                    'parent' => 0
                                );
                                $term_query = get_terms($args);
                                if (is_array($term_query)) {
                                    foreach ($term_query as $cur_term) {
                                        $checked = '';
                                        if (in_array($cur_term->term_id, $cur_terms_Arr)) {
                                            $manager_category_check[] = $cur_term->term_id;
                                            $checked = 'checked=""';
                                        }
                                        echo '<li>
                                            <div>
                                                <input ' . $checked . ' type="checkbox" class="custom-checkbox" id="manager_сategory-' . $cur_term->term_id . '"
                                                       name="manager_сategory[]" value="' . $cur_term->term_id . '">
                                                <label for="manager_сategory-' . $cur_term->term_id . '">
                                                    ' . $cur_term->name . '
                                                </label>
                                            </div>
                                        </li>';
                                    }
                                }
                                ?>
                            </ul>
                            <button style="display: none">Update</button>
                        </form>
                    </div>
                </div>

                <?php
                   if($manager_category_check){
                       echo '<span class="modal-recommend__presave m-close">';
                   }
                ?>
                    <a class="modal-recommend__save" href="#">
                        <?php _e('שמירה', 'winning_plan'); ?>
                    </a>
                <?php
                if($manager_category_check){
                    echo '</span>';
                }
                ?>
                <a data-id="<?php echo $post_id; ?>" class="modal-recommend__clear" href="#">
                    <?php _e('םייתקלחמ םיליגרתמ הרסה', 'winning_plan'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


function gallery_filter_drill()
{
    if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
        $current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;
        $arr_favorits = get_user_meta($current_user_id, 'drill_favorit_user', true);
        if ($arr_favorits) {
            $arr_favorits = $arr_favorits;
        } else {
            $arr_favorits = array(0);
        }

        $ajax_more = 0;
        if ($_POST['ajax_more'] == '1') {
            $ajax_more = $_POST['ajax_more'];
        }

        $curent_page = 1;
        if ($_POST['curent_page'] > '1') {
            $curent_page = $_POST['curent_page'];
        }

        if ($_POST['posts_per_page']) {
            $posts_per_page = $_POST['posts_per_page'];
        } else {
            $posts_per_page = 3;
        }

        $post_pype = 'drill';
        if ($_POST['post_type']) {
            $post_pype = $_POST['post_type'];
        }

        $args = array(
            'post_type' => $post_pype,
            'posts_per_page' => $posts_per_page,
            'paged' => $curent_page + $ajax_more,
        );

        if ($_POST['recommended']) {
            $args['meta_key'] = 'maneger_recommended';
            $args['meta_value'] = true;
        }

        if ($_POST['drills'] != NULL) {

            if ($_POST['drills'] == 'favorite-drills') {
                $args['post__in'] = $arr_favorits;
            }

            if ($_POST['drills'] == 'created-drills') {
                $args['author'] = $current_user_id;
            }

            if ($_POST['drills'] == 'systems-drills') {
                $administrators = $user_ids = get_users([
                    'role' => 'administrator',
                    'fields' => 'ID'
                ]);
                $args['author__in'] = $administrators;
            }
        }

        if ($_POST['sort'] != NULL) {
            if ($_POST['sort'] == 'title') {
                $args['orderby'] = 'title';
            } elseif ($_POST['sort'] == 'age') {
                $args['meta_key'] = 'age';
                $args['orderby'] = 'meta_value ';
            } else {
                $args['orderby'] = 'data';
            }
        }

       if($post_pype != 'training') {
            $subcategory_parent = array();
            if ($_POST['subcategory-parent']) {
                $subcategory_parent = $_POST['subcategory-parent'];
            }

            $subcategory_children = array();
            if ($_POST['subcategory-children']) {
                $subcategory_children = $_POST['subcategory-children'];
            }
            $all_category = array_merge($subcategory_parent, $subcategory_children);

            if($_POST['headcategory']){
                $all_category = array_merge($all_category, $_POST['headcategory']);
            }

            if($_POST['drills_сategory'] == 'all'){
                $new_all_category = $all_category;
            } else {
                $new_all_category = array_merge($all_category, array($_POST['drills_сategory']));
            }

            $args['tax_query'] = array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'drills_сategory',
                    'field' => 'id',
                    'terms' => $new_all_category,
                    'include_children' => false
                ),
                array(
                    'taxonomy' => 'manager_drills_сategory',
                    'field' => 'id',
                    'terms' => $new_all_category
                )
            );
        } else {
           if ($_POST['type'] != NULL) {
               $args['tax_query'][] = array(
                   'taxonomy' => 'type',
                   'field' => 'id',
                   'terms' => $_POST['type'],
                   'include_children' => false
               );
           }

           if ($_POST['goal'] != NULL) {
               $args['tax_query'][] = array(
                   'taxonomy' => 'goal',
                   'field' => 'id',
                   'terms' => $_POST['goal'],
                   'include_children' => false
               );
           }
       }

        $meta_query = array();

        if ($_POST['age'] != NULL) {
            $meta_query[] = array(
                'key' => 'age',
                'value' => $_POST['age'],
                'compare'=>'IN'
            );
        }

        if ($meta_query) {
            $args['meta_query'] = $meta_query;
        }

        if ($_POST['search'] != NULL) {
            $args['s'] = $_POST['search'];
        }

        //var_dump_pre($args);

        $result = '';
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_thumbnail_id = get_post_thumbnail_id();
                $image_post_url = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                $vimeo_video = get_field('video');
                $class_video = '';
                if ($vimeo_video) {
                    $class_video = 'video hover-play-video';
                }
                $result .= drill_item_box(get_the_ID());
            }

            if ($query->max_num_pages > 1) {
                $paged = $query->max_num_pages;
                $current_paged = $query->query_vars['paged'];
                //var_dump($current_paged);
                $result .= '<div class="gallery-filter__nav"> ';
                for ($i = 1; $i <= $paged; $i++) {
                    $class = '';
                    if ($current_paged == $i) {
                        $class = 'current active';
                    }
                    $result .= '<a href="#" data-page="' . $i . '" class="' . $class . '">
									' . $i . '
                            </a>';
                }
                $result .= '</div>';
            }

        } else {
            $result .= '
            <div class="gallery-drills__item nothing">
                <div class="title">
                   ' . __('Nothing was found for this query. Change your request.', 'winning_plan') . '
                </div>
            </div>';
        }

        $all_args = $args;
        $all_args['posts_per_page'] = '-1';
        unset($all_args['post__in']);
        unset($all_args['author']);
        unset($all_args['author__in']);
        $allDrills = new WP_Query($all_args);
        $allDrillsCount = 0;
        if ($allDrills->posts) {
            $allDrillsCount = $allDrills->post_count;
        }

        $fav_args = $args;
        $fav_args['post__in'] = $arr_favorits;
        $fav_args['posts_per_page'] = '-1';
        unset($fav_args['author']);
        unset($fav_args['author__in']);
        $favoriteDrills = new WP_Query($fav_args);
        $favoriteDrillsCount = 0;
        if ($favoriteDrills->posts) {
            $favoriteDrillsCount = $favoriteDrills->post_count;
        }

        $cre_args = $args;
        $cre_args['author'] = $current_user_id;
        $cre_args['posts_per_page'] = '-1';
        unset($cre_args['post__in']);
        unset($cre_args['author__in']);
        $createdDrills = new WP_Query($cre_args);
        $createdDrillsCount = 0;
        if ($createdDrills->posts) {
            $createdDrillsCount = count($createdDrills->posts);
        }

        $administrators = $user_ids = get_users([
            'role' => 'administrator',
            'fields' => 'ID'
        ]);

        $sys_args = $args;
        $sys_args['author__in'] = $administrators;
        $sys_args['posts_per_page'] = '-1';
        unset($sys_args['post__in']);
        unset($sys_args['author']);
        $systemsDrills = new WP_Query($sys_args);

        $systemsDrillsCount = 0;
        if ($systemsDrills->posts) {
            $systemsDrillsCount = count($systemsDrills->posts);
        }

        $data = array(
            'status' => false,
            'message' => __('Category list', 'winning_plan'),
            'result' => $result,
            'allCount' => $allDrillsCount,
            'favoriteCount' => $favoriteDrillsCount,
            'createdCount' => $createdDrillsCount,
            'systemsCount' => $systemsDrillsCount,
        );

    } else {
        $data = array(
            'status' => false,
            'message' => __('Nonce code in corect', 'winning_plan')
        );
    }
    wp_send_json_success($data);
    die();
}

add_action('wp_ajax_gallery_filter_drill', 'gallery_filter_drill');