<?php
//ajax remove
add_action( 'wp_ajax_removeMarkerAdmin', 'vnm_removeMarkerAdmin_init' );
add_action( 'wp_ajax_nopriv_removeMarkerAdmin', 'vnm_removeMarkerAdmin_init' );
function vnm_removeMarkerAdmin_init() {
    wp_delete_post( sanitize_text_field($_POST['id']) );
    wp_send_json_success(true);
    die();
}
