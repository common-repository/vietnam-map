<?php
function vnm_ekmap_data_post_type() {
    $labels = array(
        'name'                => 'vietnam-map',
        'singular_name'       => 'vietnam-map',
        'menu_name'           => 'vietnam-map',
        'parent_item_colon'   => 'Parent eKMap',
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
        'label'               => 'vietnam-map',
        'description'         => 'eKMap news and reviews',
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

    register_post_type( 'vietnam-map', $args );

}

add_action( 'init', 'vnm_ekmap_data_post_type', 0 );

function vnm_remove_menus() {
    remove_menu_page('edit.php?post_type=kinesisten_data');
    if(isset($_GET['post_type']) && $_GET['post_type'] == 'vietnam-map' || isset($_GET['post_type']) && $_GET['post_type'] == 'ekmap_marker'){
        wp_redirect( admin_url( 'index.php' ) );
        exit();
    }
}
add_action('admin_init', 'vnm_remove_menus');

function vnm_delete_post_type(){
    unregister_post_type( 'vietnam-map' );
    unregister_post_type( 'ekmap_marker' );
}
add_action('init','vnm_delete_post_type', 100);
