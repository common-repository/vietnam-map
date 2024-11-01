<?php
function vnm_marker_data_post_type() {
    $labels = array(
        'name'                => 'Marker',
        'singular_name'       => 'Marker',
        'menu_name'           => 'Marker',
        'parent_item_colon'   => 'Parent Marker',
        'all_items'           => 'All',
        'view_item'           => 'View',
        'add_new_item'        => 'Add New',
        'add_new'             => 'Add New',
        'edit_item'           => 'Edit',
        'update_item'         => 'Update',
        'search_items'        => 'Search',
        'not_found'           => 'Not Found',
        'not_found_in_trash'  => 'Not found in Trash',
    );

    $args = array(
        'label'               => 'Marker',
        'description'         => 'Marker news and reviews',
        'labels'              => $labels,
        'supports'            => array( 'title' ),
        'taxonomies'          => array( '' ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    );

    register_post_type( 'ekmap_marker', $args );

}

add_action( 'init', 'vnm_marker_data_post_type', 0 );
