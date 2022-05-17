<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper">
    <header id="header" class="wrapper-header">
        <div class="container wrapper-header__container">
            <div class="wrapper-header-logo">
                <div class="wrapper-header__burger">
                    <a href="#show-menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <?php if (!is_front_page()) { ?>
                <a href="<?php echo get_home_url(); ?>">
                    <?php } ?>
                    <?php
                    $custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');

                    if ($custom_logo__url) {
                        ?>
                        <img src="<?php echo $custom_logo__url[0]; ?>" alt="<?php bloginfo('title'); ?>">
                    <?php } else { ?>
                        <?php bloginfo('title'); ?>
                    <?php } ?>

                    <?php if (!is_front_page()) { ?> </a> <?php } ?>
            </div>
            <div class="wrapper-header__info">
                <div class="wrapper-header-nav">
                    <?php wp_nav_menu([
                        'menu_class' => 'wrapper-header__menu',
                        'theme_location' => 'menu-header',
                        'container' => false,
                        'menu_id' => 'header-menu',
                    ]); ?>
                </div>
                <div class="wrapper-header__auth">
                    <a class="btn-wrapper small" data-fancybox data-src="#call-auth" href="javascript:;">
                        <?php _e('כניסה', 'winning_plan'); ?>
                    </a>
                </div>
                <div class="wrapper-header__lan">
                    <?php
                    if (function_exists('wpm_language_switcher'))
                        wpm_language_switcher('list', 'name');
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="wrapper-content">
        <?php box_logged_error() ?>
