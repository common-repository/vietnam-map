<?php
//add settings page to menu
function vnm_add_options_ekmap() {
    add_menu_page( 'eKMap Map', 'eKMap Map', 'manage_options', 'vietnam-map', 'vnm_FunctionEkmap', vnm_URL_CORE.'assets/images/icon.png', '50');
    $count = 0;
    add_submenu_page(
        'vietnam-map',
        'Danh sách bản đồ',
        'Danh sách bản đồ',
        'administrator',
        'vietnam-map',
        'vnm_FunctionEkmap',
        $count++
    );
    add_submenu_page(
        'vietnam-map',
        'Thêm',
        'Thêm',
        'administrator',
        'add-vietnam-map',
        'vnm_FunctionAddEkmap',
        $count++
    );
    add_submenu_page(
        'vietnam-map',
        'Api Key',
        'Api Key',
        'administrator',
        'vietnam-map-api-key',
        'vnm_FunctionAPIKey',
        $count++
    );
    add_submenu_page(
        'vietnam-map',
        'Sửa',
        'Sửa',
        'administrator',
        'edit-vietnam-map',
        'vnm_FunctionEditEkmap',
        $count++
    );
}

add_action( 'admin_menu', 'vnm_add_options_ekmap' );

//register settings
function vnm_theme_options_add(){
    register_setting( 'ekmap_form_theme_settings', 'ekmap_field' );
}

//menu list eKMap
function vnm_FunctionEkmap() {
    require_once "menu_ekmap.php";
}

//menu add eKMap
function vnm_FunctionAddEkmap() {
    require_once "menu_add_ekmap.php";
}

//menu add eKMap
function vnm_FunctionAPIKey() {
    require_once "menu_api_key_ekmap.php";
}

//menu edit eKMap
function vnm_FunctionEditEkmap() {
    require_once "menu_edit_ekmap.php";
}

//media library
add_action( 'admin_footer', 'vnm_media_selector_print_scripts' );

function vnm_media_selector_print_scripts() {

    $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

    ?><script type='text/javascript'>

        jQuery( document ).ready( function( $ ) {

            // Uploading files
            var file_frame;
            var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
            //var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

            jQuery(document).find('.ekmap_add .icon_group .ekmap_add_icon').on('click', function( event ){

                event.preventDefault();

                // If the media frame already exists, reopen it.
                /*if ( file_frame ) {
                    // Set the post ID to what we want
                    file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
                    // Open frame
                    file_frame.open();
                    return;
                } else {
                    // Set the wp.media post id so the uploader grabs the ID we want when initialised
                    wp.media.model.settings.post.id = set_to_post_id;
                }*/

                // Create the media frame.
                file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select a image to upload',
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false	// Set to true to allow multiple files to be selected
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    // We set multiple to false so only get one image from the uploader
                    attachment = file_frame.state().get('selection').first().toJSON();

                    // Do something with attachment.id and/or attachment.url here
                    jQuery( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
                    jQuery('.ekmap_add .icon_group .ekmap_img_icon').html('<img src="'+attachment.url+'" alt="logo" />');
                    jQuery(document).find('.ekmap_add .icon_group .ekmap_add_icon').val( attachment.url );

                    // Restore the main post ID
                    wp.media.model.settings.post.id = wp_media_post_id;
                });

                // Finally, open the modal
                file_frame.open();
            });

            // Restore the main ID when the add media button is pressed
            jQuery( 'a.add_media' ).on( 'click', function() {
                wp.media.model.settings.post.id = wp_media_post_id;
            });
        });

    </script><?php

}
