<?php

add_action('init', 'custom_post_types', 0);
function custom_post_types()
{
    register_post_type(
        'training',
        array(
            'labels' => array(
                'name' => 'Training',
                'singular_name' => 'Training',
                'add_new' => 'Add training',
                'add_new_item' => 'Add New training',
                'edit_item' => 'Edit training',
                'new_item' => 'New training',
                'view_item' => 'View training',
                'search_items' => 'Search training',
                'not_found' => 'Training Not Found',
                'not_found_in_trash' => 'is empty',
                'menu_name' => 'Training'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'menu_icon' => 'dashicons-clipboard',
            'supports'  => array('title', 'thumbnail', 'custom-fields'),
            '_builtin'  => false
        )
    );

    register_post_type(
        'drill',
        array(
            'labels' => array(
                'name' => 'Drill',
                'singular_name' => 'Drill',
                'add_new' => 'Add drill',
                'add_new_item' => 'Add New drill',
                'edit_item' => 'Edit drill',
                'new_item' => 'New drill',
                'view_item' => 'View drill',
                'search_items' => 'Search drill',
                'not_found' => 'Drill Not Found',
                'not_found_in_trash' => 'is empty',
                'menu_name' => 'Drill'
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'menu_icon' => 'dashicons-clipboard',
            'supports'  => array('title', 'thumbnail', 'custom-fields'),
            '_builtin'  => false
        )
    );


    register_taxonomy(
        'drills_сategory',    // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        array('drill', 'training'),           // post type name
        array(
            'hierarchical' => true,
            'label' => 'Category', // display name
            'query_var' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => 'drill_сategory',    // This controls the base slug that will display before each term
                'with_front' => false  // Don't display the category base before
            )
        )
    );

    register_taxonomy(
        'manager_drills_сategory',
        'drill',
        array(
            'hierarchical' => true,
            'label' => 'Manager category',
            'query_var' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => 'manager_drills_сategory',
                'with_front' => false
            )
        )
    );


    register_taxonomy(
        'type',
        array('drill', 'training'),
        array(
            'hierarchical' => true,
            'label' => 'Types',
            'query_var' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => 'types',
                'with_front' => false
            )
        )
    );

    register_taxonomy(
        'goal',
        array('drill', 'training'),
        array(
            'hierarchical' => true,
            'label' => 'Goals',
            'query_var' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => 'goals',
                'with_front' => false
            )
        )
    ); 

      register_taxonomy(
        'param',
        array('drill', 'training'),
        array(
            'hierarchical' => true,
            'label' => 'Params',
            'query_var' => true,
            'show_in_nav_menus' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
            'show_admin_column' => true,
            'rewrite' => array(
                'slug' => 'params',
                'with_front' => false
            )
        )
    );
}