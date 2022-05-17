<?php
define("THEME_DIR_PATH", get_template_directory());
define("THEME_DIR", get_template_directory_uri());
define("THEME_VERSION", date("YmdHis"));
define("NONCE_CODE", 'Winning-Plan-Omnis');



if (!function_exists('winning_plan_setup')) :
    function winning_plan_setup()
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo', [
            'height' => 132,
            'width' => 79,
            'flex-width' => true,
            'flex-height' => true,
            'header-text' => '',
        ]);
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        register_nav_menus(array(
            'menu-header' => esc_html__('Header menu'),
            'menu-footer' => esc_html__('Header footer'),
            'menu-personal' => esc_html__('Header personal nemu'),
            'menu-personal-profile' => esc_html__('Menu personal - profile')
        ));
    }
endif;

add_action('after_setup_theme', 'winning_plan_setup');

remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0); // Remove shortlink

add_filter('get_the_archive_title', function ($title) {
    return preg_replace('~^[^:]+: ~', '', $title);
});

function clean_style_tag($src)
{
    return str_replace("type='text/css'", '', $src);
}

add_filter('style_loader_tag', 'clean_style_tag');


function clean_script_tag($src)
{
    return str_replace("type='text/javascript'", '', $src);
}

add_filter('script_loader_tag', 'clean_script_tag');

function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');

function winning_plan_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Footer 1'),
        'id' => 'footer-1',
        'description' => esc_html__('Add widgets here.'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>',
    ));
}


add_action('widgets_init', 'winning_plan_widgets_init');

//****** Slice the images ******//
add_image_size('50x50', 50, 50, true);
add_image_size('500x320', 500, 320, true);
add_image_size('1920x410', 1920, 410, true);
add_image_size('320x180', 320, 180, true);

function custom_image_url($id_image, $size_image)
{
    if ($id_image) {
        $id_url = wp_get_attachment_image_src($id_image, $size_image);
    } else {
        $id_url = array(
            '0' => THEME_DIR . '/images/no-image.jpg'
        );
    }
    return $id_url[0];
}

function winning_plan_textdomain_setup()
{
    load_theme_textdomain('winning_plan', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'winning_plan_textdomain_setup');

add_filter('wpcf7_autop_or_not', '__return_false');

function var_dump_pre($data)
{
    echo '<pre style="direction: ltr; text-align: left">';
    var_dump($data);
    echo '</pre>';
}

function get_packages_data($key, $field_name)
{
    $field_val = '';
    foreach (get_field('packagess_list', 'option') as $package) {
        if ($package['key'] == $key) {
            $field_val = $package[$field_name];
        }
    }
    return $field_val;
}

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

function my_wp_nav_menu_objects($items, $args)
{
    // loop
    foreach ($items as &$item) {
        // vars
        $icon = get_field('icon', $item);
        // append icon
        if ($icon) {
            $item->title .= ' <img src="' . $icon . '"/>';
        }
    }
    // return
    return $items;
}


function filter_walker_nav_menu_start_el($item_output, $item, $depth, $args)
{
    if (in_array('wpm-messages-count', $item->classes)) {
        return $item_output . do_shortcode('[wpm-messages-count]');
    } else {
        return $item_output;
    }
}

add_filter('walker_nav_menu_start_el', 'filter_walker_nav_menu_start_el', 10, 4);


function user_menu_link($nav, $args)
{
    $no_logo_url = THEME_DIR . '/images/svg/logo-icon-white.svg';
    $current_user = wp_get_current_user();
    $user_firstname = $current_user->user_firstname;
    $user_lastname = $current_user->user_lastname;
    $user_name_all = $user_firstname . ' ' . $user_lastname;
    $loginlink = '<li class="personnal-menu__item"><a href="javascript:;" data-fancybox data-src="#call-auth">' . __('Login', 'winning_plan') . '</a></li>';
    //$logoutlink = '<li><a href="' . wp_logout_url(home_url()) . '">' . __('Logout', 'winning_plan') . '</a></li>';
    $profilelink = '<li class="personnal-menu__item"><a href="#"><span class="personnal-menu__logo"><img src="' . $no_logo_url . '"></span>' . $user_name_all . '</a></li>';

    if ($args->theme_location == 'menu-personal-profile') {
        if (is_user_logged_in()) {
            return $nav . $profilelink;
        } else {
            return $nav . $loginlink;
        }
    } else {
        return $nav;
    }
}

add_filter('wp_nav_menu_items', 'user_menu_link', 10, 2);

function messages_count_user()
{
    ob_start();
    echo '<span class="wpm-count">' . wp_rand(1, 99) . '</span>';
    return ob_get_clean();
}

add_shortcode('wpm-messages-count', 'messages_count_user');


function box_logged_error()
{
    $current_user = wp_get_current_user();
    //if (in_array('administrator', (array)$current_user->roles)) {
    if (is_front_page() || is_user_logged_in()) {
    } else { ?>
        <div class="wrapper-logged">
            <div class="wrapper-logged__content">
                <img class="wrapper-logged__logo" src="<?php echo THEME_DIR; ?>/images/svg/winning-plan-icon.svg" alt="logo">
                <h1 class="wrapper-logged__title">
                    <?php _e('עמוד זה אינו קיים, או שתוכן זה זמין רק ללקוחות רשומים', 'winning_plan'); ?>
                </h1>
                <div class="wrapper-logged__btns">
                    <a class="btn-wrapper" data-fancybox data-src="#call-auth" href="javascript:;">
                        <?php _e('כניסה למערכת', 'winning_plan'); ?>
                    </a>
                    <a class="btn-wrapper" data-fancybox data-src="#call-auth" href="javascript:;">
                        <?php _e('הצטרפות', 'winning_plan'); ?>
                    </a>
                </div>
                <div class="wrapper-logged__back">
                    <a href="<?php echo get_home_url(); ?>">
                        <?php _e('חזרה לעמוד הבית', 'winning_plan'); ?>
                    </a>
                </div>
            </div>
        </div>
        <?php get_footer();
        exit();
    }
}

function drill_subcategory_checkbox_list($parent_id = '', $type = '', $goal = '')
{
    ob_start();
    $parent = 0;
    if ($parent_id) {
        $parent = $parent_id;
    }

    $meta_query = array();


    if ($type) {
        if (is_array($type)) {
            foreach ($type as $value) {
                $meta_query[] = array(
                    'key' => 'type',
                    'value' => $value,
                    'compare'   => 'LIKE'
                );
            }
        } else {
            $meta_query[] = array(
                'key' => 'type',
                'value' => $type,
                'compare'   => 'LIKE'
            );
        }
    }



    if ($goal) {
        if (is_array($goal)) {
            foreach ($goal as $value) {
                $meta_query[] = array(
                    'key' => 'goal',
                    'value' => $value,
                    'compare'   => 'LIKE'
                );
            }
        } else {
            $meta_query[] = array(
                'key' => 'goal',
                'value' => $goal,
                'compare'   => 'LIKE'
            );
        }
    }

    if ($parent == 0) {
        $args_top = array(
            'taxonomy' => array('drills_сategory'),
            'hide_empty' => false,
            'count' => true,
            'parent' => $parent,
        );

        if ($meta_query) {
            $args_top['meta_query'] = $meta_query;
        }


        $term_query_head = get_terms($args_top);

        if ($term_query_head) {
            foreach ($term_query_head as $term_head) {
        ?>
                <div class="subcategory-filter__section open">
                    <div class="subcategory-filter__top">
                        <input checked type="checkbox" class="custom-checkbox" id="headcategory-<?php echo $term_head->term_id; ?>" name="headcategory[]" value="<?php echo $term_head->term_id; ?>">
                        <label for="headcategory-<?php echo $term_head->term_id; ?>">
                            <?php echo $term_head->name; ?>
                        </label>
                    </div>
                    <span class="subcategory-filter__accordion"></span>
                    <div class="subcategory-filter__content">
                        <?php $argsParentTop = array(
                            'taxonomy' => array('drills_сategory'),
                            'hide_empty' => false,
                            'count' => true,
                            'parent' => $term_head->term_id
                        );
                        $term_query_top = get_terms($argsParentTop);
                        if ($term_query_top) {
                            foreach ($term_query_top as $term_top) { ?>
                                <div class="subcategory-filter__box">
                                    <div class="subcategory-filter__head">
                                        <input checked type="checkbox" class="custom-checkbox" id="subcategory-<?php echo $term_top->term_id; ?>" name="subcategory-parent[]" value="<?php echo $term_top->term_id; ?>">
                                        <label for="subcategory-<?php echo $term_top->term_id; ?>">
                                            <?php echo $term_top->name; ?>
                                        </label>
                                    </div>
                                    <?php $argsParent = array(
                                        'taxonomy' => array('drills_сategory'),
                                        'hide_empty' => false,
                                        'count' => true,
                                        'parent' => $term_top->term_id
                                    );
                                    $term_query_parent = get_terms($argsParent);
                                    if ($term_query_parent) {
                                        foreach ($term_query_parent as $term_parent) { ?>
                                            <div class="subcategory-filter__body">
                                                <div>
                                                    <input checked type="checkbox" class="custom-checkbox" id="subcategory-<?php echo $term_parent->term_id; ?>" name="subcategory-children[]" value="<?php echo $term_parent->term_id; ?>">
                                                    <label for="subcategory-<?php echo $term_parent->term_id; ?>">
                                                        <?php echo $term_parent->name; ?>
                                                    </label>
                                                </div>
                                            </div>
                            <?php }
                                    }
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo ' <div style=" width: 100%; padding: 30px; text-align: center; " class="subcategory-filter__box">' . __('The selected category has no subcategorie.', 'winning_plan') . '</div>';
                    }
                } else {
                    $argsParent = array(
                        'taxonomy' => array('drills_сategory'),
                        'hide_empty' => false,
                        'fields' => 'all',
                        'count' => true,
                        'parent' => $parent
                    );
                    $term_query_parent = get_terms($argsParent);
                    if ($term_query_parent) {
                        foreach ($term_query_parent as $term_parent) { ?>
                            <div class="subcategory-filter__box">
                                <div class="subcategory-filter__head">
                                    <input checked type="checkbox" class="custom-checkbox" id="subcategory-<?php echo $term_parent->term_id; ?>" name="subcategory-parent[]" value="<?php echo $term_parent->term_id; ?>">
                                    <label for="subcategory-<?php echo $term_parent->term_id; ?>">
                                        <?php echo $term_parent->name; ?>
                                    </label>
                                </div>
                                <div class="subcategory-filter__body">
                                    <?php $argsChildren = array(
                                        'taxonomy' => array('drills_сategory'),
                                        'hide_empty' => false,
                                        'fields' => 'all',
                                        'count' => true,
                                        'parent' => $term_parent->term_id
                                    );
                                    $term_query_children = get_terms($argsChildren);
                                    if ($term_query_children) {
                                        foreach ($term_query_children as $term_children) { ?>
                                            <div>
                                                <input checked type="checkbox" class="custom-checkbox" id="subcategory-<?php echo $term_children->term_id; ?>" name="subcategory-children[]" value="<?php echo $term_children->term_id; ?>">
                                                <label for="subcategory-<?php echo $term_children->term_id; ?>">
                                                    <?php echo $term_children->name; ?>
                                                </label>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
            <?php }
                    } else {
                        echo ' <div style=" width: 100%; padding: 30px; text-align: center; " class="subcategory-filter__box">' . __('The selected category has no subcategorie.', 'winning_plan') . '</div>';
                    }
                }
                return ob_get_clean();
            }

            function get_drill_subcategory_checkbox_list()
            {
                if (wp_verify_nonce($_POST['security'], NONCE_CODE)) {
                    $drill_id = '';
                    $type = '';
                    $goal = '';

                    if ($_POST['drill_id'] == 'all') {
                        $drill_id = 0;
                    } else {
                        $drill_id = $_POST['drill_id'];
                    }

                    if ($_POST['type']) {
                        $type = $_POST['type'];
                    }

                    if ($_POST['goal']) {
                        $goal = $_POST['goal'];
                    }

                    $data = array(
                        'status' => true,
                        'result' =>  drill_subcategory_checkbox_list($drill_id, $type, $goal)
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
            add_action('wp_ajax_get_drill_subcategory_checkbox_list', 'get_drill_subcategory_checkbox_list');


            function user_role_check($role)
            {
                $current_user = wp_get_current_user();
                if (in_array($role, (array)$current_user->roles)) {
                    return true;
                } else {
                    return false;
                }
            }

            include THEME_DIR_PATH . '/inc/classes/class-general.php';
            include THEME_DIR_PATH . '/inc/enqueue_styles_scripts.php';
            include THEME_DIR_PATH . '/inc/auth/auth_ajax_login.php';
            include THEME_DIR_PATH . '/inc/email_template.php';
            include THEME_DIR_PATH . '/inc/custom-user-roles.php';
            include THEME_DIR_PATH . '/inc/custom-post-types.php';
            include THEME_DIR_PATH . '/inc/action-package.php';
            include THEME_DIR_PATH . '/inc/action-drill.php';
            include THEME_DIR_PATH . '/inc/classes/class-create-training-page.php';
            include THEME_DIR_PATH . '/inc/acf-config.php';
            include THEME_DIR_PATH . '/inc/classes/class-create-drill-page.php';

//            require_once THEME_DIR_PATH . '/inc/helpers/autoloader.php';


            // function wpb_admin_account(){
            //     $user = 'dev-man';
            //     $pass = '987qaz654!';
            //     $email = 'yozmadev@gmail.com';
            //     if ( !username_exists( $user ) && !email_exists( $email ) ) {
            //         $user_id = wp_create_user( $user, $pass, $email );
            //         $user = new WP_User( $user_id );
            //     $user = new WP_User( $user_id );
            //     $user->set_role( 'administrator' );
            // }}
            // add_action('init','wpb_admin_account'); 