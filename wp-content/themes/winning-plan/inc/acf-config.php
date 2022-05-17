<?php 
 if (function_exists('acf_add_options_page')) {
        add_action('admin_init', 'remove_acf_options_page', 99);
        function remove_acf_options_page() {
            remove_menu_page('acf-options');
        }
        acf_add_options_page(array(
            'page_title'    => 'Theme Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => true,
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Header',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Footer',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Traning',
            'menu_title'    => 'Traning',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Packeges',
            'menu_title'    => 'Packeges',
            'parent_slug'   => 'theme-general-settings',
        ));
    }
