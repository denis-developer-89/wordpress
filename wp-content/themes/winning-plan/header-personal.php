<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper-personal">
    <header class="header-personal">
        <div class="header-personal__container">
            <div class="header-personal__logo">
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

            <div class="header-personal__nav">

                <?php if (is_user_logged_in()) { ?>

                    <?php wp_nav_menu([
                        'menu_class' => 'wrapper-personal__menu',
                        'theme_location' => 'menu-personal',
                        'container' => false,
                        'menu_id' => 'personal-menu',
                    ]); ?>

                    <div class="btns">
                        <a class="green" href="<?php echo get_home_url(); ?>/create-drill">
                            <?php _e('יצירת תרגיל', 'winning_plan'); ?>
                        </a>
                        <a class="blue" href="<?php echo get_home_url(); ?>/create-training">
                            <?php _e('יצירת מערך אימון', 'winning_plan'); ?>
                        </a>
                        <a class="yellow" href="#">
                            <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 16">
                                <path d="M7.5.702a7.2 7.2 0 1 0 0 14.4 7.2 7.2 0 0 0 0-14.4Zm-1.498 1.08a6.315 6.315 0 0 1 2.997 0l-1.5.873-1.497-.873Zm-1.12.388 2.17 1.265v1.53L4.56 6.722l-1.404-.51-.564-2.261a6.323 6.323 0 0 1 2.29-1.782v.001ZM1.922 4.974l.353 1.422-1.047.93a6.253 6.253 0 0 1 .695-2.352H1.92Zm-.69 3.551 1.644-1.458 1.391.505.94 2.961-.645.966H2.327A6.264 6.264 0 0 1 1.23 8.525ZM3.086 12.4h1.399l.459 1.264a6.313 6.313 0 0 1-1.858-1.264Zm2.948 1.633-.733-2.022.639-.957h3.12l.64.957-.733 2.02c-.964.23-1.969.23-2.933 0v.002Zm4.024-.371.46-1.262h1.393a6.316 6.316 0 0 1-1.853 1.262Zm2.614-2.162h-2.23l-.648-.968.922-2.958 1.41-.508 1.642 1.46a6.264 6.264 0 0 1-1.096 2.974Zm1.1-4.174-1.043-.928.353-1.415c.373.71.614 1.503.69 2.343Zm-1.362-3.368L11.85 6.21l-1.426.513-2.472-1.757v-1.53l2.168-1.267a6.321 6.321 0 0 1 2.293 1.787ZM5.157 7.404 7.5 5.749l2.327 1.653-.857 2.75H6.03l-.873-2.75v.002Z"
                                      fill="#091932"/>
                            </svg>
                            <?php _e('הכנה למשחק', 'winning_plan'); ?>
                        </a>
                    </div>
                <?php } ?>
                <div class="header-personal__profile">
                    <?php wp_nav_menu([
                        'menu_class' => 'wrapper-personal__menu',
                        'theme_location' => 'menu-personal-profile',
                        'container' => false,
                        'menu_id' => 'menu-personal-profile',
                    ]); ?>
                </div>
            </div>

        </div>
    </header>

    <?php box_logged_error() ?>

    <div class="wrapper-personal__content">

<?php
if (function_exists('yoast_breadcrumb')) {
    yoast_breadcrumb('<div class="breadcrumbs"><div class="container">', '</div></div>');
}
?>