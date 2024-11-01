<?php
/**
 * Register meta boxes.
 */
function vnm_ekmap_meta_box()
{
    add_meta_box( 'ekmap_data_metabox', 'Infomation', 'vnm_ekmap_output', 'vietnam-map' );
}
add_action( 'add_meta_boxes', 'vnm_ekmap_meta_box' );


/**
Create callback function
 **/
function vnm_ekmap_output( $post )
{
    $ekmap_lon = get_post_meta( $post->ID, 'ekmap_lon', true );
    $ekmap_lat = get_post_meta( $post->ID, 'ekmap_lat', true );
    $ekmap_zoom = get_post_meta( $post->ID, 'ekmap_zoom', true );
    $ekmap_width = get_post_meta( $post->ID, 'ekmap_width', true );
    $ekmap_heigth = get_post_meta( $post->ID, 'ekmap_heigth', true );
    $ekmap_type = get_post_meta( $post->ID, 'ekmap_type', true );
    $ekmap_theme = get_post_meta( $post->ID, 'ekmap_theme', true );
    $ekmap_custom_class = get_post_meta( $post->ID, 'ekmap_custom_class', true );
    ?>
    <span>Kinh độ</span><br>
    <input type="text" name="ekmap_lon" value="<?php echo esc_attr($ekmap_lon); ?>" /><br>
    <span>Vĩ độ</span><br>
    <input type="text" name="ekmap_lat" value="<?php echo esc_attr($ekmap_lat); ?>" /><br>
    <span>Zoom</span><br>
    <input type="text" name="ekmap_zoom" value="<?php echo esc_attr($ekmap_zoom); ?>" /><br>
    <span>Độ rộng %</span><br>
    <input type="text" name="ekmap_width" value="<?php echo esc_attr($ekmap_width); ?>" /><br>
    <span>Độ cao px</span><br>
    <input type="text" name="ekmap_heigth" value="<?php echo esc_attr($ekmap_heigth); ?>" /><br>
    <span>Loại bản đồ</span><br>
    <input type="text" name="ekmap_type" value="<?php echo esc_attr($ekmap_type); ?>" /><br>
    <span>Chủ đề</span><br>
    <input type="text" name="ekmap_theme" value="<?php echo esc_attr($ekmap_theme); ?>" /><br>
    <span>Custom class</span><br>
    <input type="text" name="ekmap_custom_class" value="<?php echo esc_attr($ekmap_custom_class); ?>" /><br>
    <?php
}


/**
Save data field meta box
 **/
function vnm_ekmap_save( $post_id )
{
    if(isset($_POST['ekmap_lon'])){
        $data_json = sanitize_text_field( $_POST['ekmap_lon'] );
        update_post_meta( $post_id, 'ekmap_lon', $data_json );
    }
    if(isset($_POST['ekmap_lat'])){
        $data_json = sanitize_text_field( $_POST['ekmap_lat'] );
        update_post_meta( $post_id, 'ekmap_lat', $data_json );
    }
    if(isset($_POST['ekmap_zoom'])){
        $data_json = sanitize_text_field( $_POST['ekmap_zoom'] );
        update_post_meta( $post_id, 'ekmap_zoom', $data_json );
    }
    if(isset($_POST['ekmap_width'])){
        $data_json = sanitize_text_field( $_POST['ekmap_width'] );
        update_post_meta( $post_id, 'ekmap_width', $data_json );
    }
    if(isset($_POST['ekmap_heigth'])){
        $data_json = sanitize_text_field( $_POST['ekmap_heigth'] );
        update_post_meta( $post_id, 'ekmap_heigth', $data_json );
    }
    if(isset($_POST['ekmap_type'])){
        $data_json = sanitize_text_field( $_POST['ekmap_type'] );
        update_post_meta( $post_id, 'ekmap_type', $data_json );
    }
    if(isset($_POST['ekmap_theme'])){
        $data_json = sanitize_text_field( $_POST['ekmap_theme'] );
        update_post_meta( $post_id, 'ekmap_theme', $data_json );
    }
    if(isset($_POST['ekmap_custom_class'])){
        $data_json = sanitize_text_field( $_POST['ekmap_custom_class'] );
        update_post_meta( $post_id, 'ekmap_custom_class', $data_json );
    }
}
add_action( 'save_post', 'vnm_ekmap_save' );
