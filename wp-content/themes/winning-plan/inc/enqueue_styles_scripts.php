<?php

function winning_plan_styles_header()
{
    wp_enqueue_style('default-header', THEME_DIR . '/css/header.css', array(), THEME_VERSION);
    wp_enqueue_style('default-footer', THEME_DIR . '/css/footer.css', array(), THEME_VERSION);

    wp_enqueue_style('bootstrap-grid', THEME_DIR . '/assets/css/bootstrap-grid.min.css', array(), THEME_VERSION);
    wp_enqueue_style('default-style', THEME_DIR . '/style.css', array(), THEME_VERSION);
    wp_enqueue_style('winning_plan-main', THEME_DIR . '/css/main.css', array(), THEME_VERSION);
    wp_enqueue_style('fonts', THEME_DIR . '/fonts/fonts.css', array(), THEME_VERSION);
    wp_enqueue_style('font-awesome', THEME_DIR . '/assets/fonts/FontAwesome/css/all.min.css', array(), THEME_VERSION);

    wp_dequeue_style('wp-block-library');
    wp_dequeue_script('jquery-core');
    wp_dequeue_script('wpcf7cf-scripts');
    wp_dequeue_style('contact-form-7');
    wp_dequeue_style('toc-screen');
    wp_dequeue_style('wpm-main');
    wp_dequeue_style('global-styles-inline');

    if (!is_user_logged_in()) {
        wp_enqueue_style('logged-error', THEME_DIR . '/css/logged-error.css', array(), THEME_VERSION);
    }

    if (is_page_template('template/home.php')) {
        wp_enqueue_style('home', THEME_DIR . '/css/home.css', array(), THEME_VERSION);
    }

    if (is_page() && !is_page_template()) {
        wp_enqueue_style('page-default', THEME_DIR . '/css/page-default.css', array(), THEME_VERSION);
    }

    if (is_page_template('template/buy-package.php') || is_page_template('template/packages.php')) {
        wp_enqueue_style('page-default', THEME_DIR . '/css/page-default.css', array(), THEME_VERSION);
        wp_enqueue_style('home', THEME_DIR . '/css/home.css', array(), THEME_VERSION);
        wp_enqueue_style('packages', THEME_DIR . '/css/packages.css', array(), THEME_VERSION);
    }

    if (
        is_page_template('template/gallery-departmental.php') ||
        is_page_template('template/gallery-departmental-filter.php') ||
        is_page_template('template/gallery-exercise.php') ||
        is_page_template('template/gallery-exercise-filter.php') ||
        is_page_template('template/gallery-exercise-filter.php') ||
        is_page_template('template/create-drill-page.php') ||
        is_page_template('template/gallery-training-filter.php') ||
        is_page_template('template/create-training-page.php')
    ) {
        wp_enqueue_style('personal', THEME_DIR . '/css/personal.css', array(), THEME_VERSION);
        wp_enqueue_style('gallery', THEME_DIR . '/css/gallery.css', array(), THEME_VERSION);
    }
}

add_action('wp_enqueue_scripts', 'winning_plan_styles_header');

function winning_plan_styles_footer()
{
    wp_enqueue_style('slick', THEME_DIR . '/moduls/slick/slick.css');
    wp_enqueue_style('nice', THEME_DIR . '/moduls/nice-select/css/nice-select.css');
    wp_enqueue_style('fancybox-4', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css', array(), THEME_VERSION);
    wp_enqueue_style('contact-form-7');
    wp_enqueue_style('toc-screen');
}

add_action('get_footer', 'winning_plan_styles_footer');

function winning_plan_scripts()
{
    wp_enqueue_script('slick', THEME_DIR . '/moduls/slick/slick.min.js', array('jquery'), null, true);
    wp_enqueue_script('nice-select', THEME_DIR . '/moduls/nice-select/js/jquery.nice-select.min.js', array('jquery'), null, true);
    wp_enqueue_script('fancybox-4', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js', array('jquery'), null, true);
    wp_enqueue_script('swiper-jss', 'https://unpkg.com/swiper@8/swiper-bundle.min.js', array('jquery'), null, true);
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css', array(), THEME_VERSION);
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper@8/swiper-bundle.min.css', array(), THEME_VERSION);


    wp_enqueue_script('auth', THEME_DIR . '/inc/auth/auth-js.js', array('jquery'), THEME_VERSION, true);

    if (is_page_template('template/buy-package.php') || is_page_template('template/packages.php')) {
        wp_enqueue_script('package', THEME_DIR . '/js/package-page.js', array('jquery'), THEME_VERSION, true);
    }

    if (is_page_template('template/home.php')) {
        wp_enqueue_script('home', THEME_DIR . '/js/home-page.js', array('jquery'), THEME_VERSION, true);
    }

    if (is_page_template('template/create-drill-page.php')) {
        wp_enqueue_style('jquery-ui-css', THEME_DIR . '/assets/css/jquery-ui.min.css', array(), THEME_VERSION);
        wp_enqueue_script('query-ui-js', THEME_DIR . '/assets/js/jquery-ui.min.js', array('jquery'), null, true);
        wp_enqueue_script('fabric-js', THEME_DIR . '/assets/js/fabric.min.js', array('jquery'), null, true);
        wp_enqueue_script('create-drill-js', THEME_DIR . '/js/create-drill-page.js', array('jquery'), THEME_VERSION, true);
    }

    if (is_page_template('template/create-training-page.php')) {
        wp_enqueue_style('timepicker', THEME_DIR . '/moduls/timepicker/jquery.timepicker.min.css', array(), THEME_VERSION);
        wp_enqueue_style('jquery-ui-css', THEME_DIR . '/assets/css/jquery-ui.min.css', array(), THEME_VERSION);
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('timepicker', THEME_DIR . '/moduls/timepicker/jquery.timepicker.min.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('create-training', THEME_DIR . '/js/create-training-page.js', array('jquery'), THEME_VERSION, true);
    }

    if (
        is_page_template('template/gallery-departmental.php') ||
        is_page_template('template/gallery-departmental-filter.php') ||
        is_page_template('template/gallery-exercise.php') ||
        is_page_template('template/gallery-exercise-filter.php') ||
        is_page_template('template/gallery-training-filter.php')
    ) {
        wp_enqueue_script('gallery', THEME_DIR . '/js/gallery-page.js', array('jquery'), THEME_VERSION, true);
    }

    wp_enqueue_script('winning_plan-main', THEME_DIR . '/js/main.js', array('jquery'), THEME_VERSION, true);

    wp_localize_script('winning_plan-main', 'winning_plan_ajax_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'home_url' => get_home_url(),
        'curent_ID' => get_the_ID(),
        'curent_url' => get_permalink(),
        'current_user_id' => get_current_user_id(),
        'nonce' => wp_create_nonce(NONCE_CODE),
        'loadingmessage' => __('Wait for the data to be verified', 'winning-plan'),
        'text_advanced_filtering' => __('סינון מתקדם', 'winning_plan'),
        'text_closure' => __('סגירה', 'winning_plan'),
    ));
}

add_action('wp_enqueue_scripts', 'winning_plan_scripts', 99);
