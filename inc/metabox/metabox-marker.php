<?php
    add_action('init', function (){
        $uploads = wp_upload_dir();
        if (!file_exists($uploads['basedir'].'/ekmap_img')) {
            mkdir($uploads['basedir'].'/ekmap_img', 0777, true);
        }
    });
?>

<?php
/**
 * Register meta boxes.
 */
function vnm_ekmap_marker_meta_box()
{
    add_meta_box( 'ekmap_marker_data_metabox', 'Infomation', 'vnm_ekmap_marker_output', 'ekmap_marker' );
}
add_action( 'add_meta_boxes', 'vnm_ekmap_marker_meta_box' );


/**
Create callback function
 **/
function vnm_ekmap_marker_output( $post )
{
    $ekmap_marker_content = get_post_meta( $post->ID, 'ekmap_marker_content', true );
    $ekmap_marker_icon = get_post_meta( $post->ID, 'ekmap_marker_icon', true );
    $ekmap_marker_icon_img = get_post_meta( $post->ID, 'ekmap_marker_icon_img', true );
    $ekmap_marker_icon_width = get_post_meta( $post->ID, 'ekmap_marker_icon_width', true );
    $ekmap_marker_icon_height = get_post_meta( $post->ID, 'ekmap_marker_icon_height', true );
    $ekmap_marker_address = get_post_meta( $post->ID, 'ekmap_marker_address', true );
    $ekmap_marker_phone = get_post_meta( $post->ID, 'ekmap_marker_phone', true );
    $ekmap_marker_lon = get_post_meta( $post->ID, 'ekmap_marker_lon', true );
    $ekmap_marker_lat = get_post_meta( $post->ID, 'ekmap_marker_lat', true );
    $ekmap_marker_text_button = get_post_meta( $post->ID, 'ekmap_marker_text_button', true );
    $ekmap_marker_text_button_color = get_post_meta( $post->ID, 'ekmap_marker_text_button_color', true );
    $ekmap_marker_text_button_ground = get_post_meta( $post->ID, 'ekmap_marker_text_button_ground', true );
    $ekmap_marker_link = get_post_meta( $post->ID, 'ekmap_marker_link', true );
    $ekmap_marker_open = get_post_meta( $post->ID, 'ekmap_marker_open', true );
    $ekmap_marker_id = get_post_meta( $post->ID, 'ekmap_marker_id', true );
    ?>
    <span>Mô tả</span><br>
    <input type="text" name="ekmap_marker_content" value="<?php echo esc_html($ekmap_marker_content); ?>" /><br>
    <span>Icon</span><br>
    <input type="text" name="ekmap_marker_icon" value="<?php echo esc_attr($ekmap_marker_icon); ?>" /><br>
    <span>Icon Image</span><br>
    <input type="text" name="ekmap_marker_icon_img" value="<?php echo esc_attr($ekmap_marker_icon_img); ?>" /><br>
    <span>Icon Image width</span><br>
    <input type="text" name="ekmap_marker_icon_width" value="<?php echo esc_attr($ekmap_marker_icon_width); ?>" /><br>
    <span>Icon Image height</span><br>
    <input type="text" name="ekmap_marker_icon_height" value="<?php echo esc_attr($ekmap_marker_icon_height); ?>" /><br>
    <span>Địa chỉ</span><br>
    <input type="text" name="ekmap_marker_address" value="<?php echo esc_attr($ekmap_marker_address); ?>" /><br>
    <span>SĐT</span><br>
    <input type="text" name="ekmap_marker_phone" value="<?php echo esc_attr($ekmap_marker_phone); ?>" /><br>
    <span>Kinh độ</span><br>
    <input type="text" name="ekmap_marker_lon" value="<?php echo esc_attr($ekmap_marker_lon); ?>" /><br>
    <span>Vĩ độ</span><br>
    <input type="text" name="ekmap_marker_lat" value="<?php echo esc_attr($ekmap_marker_lat); ?>" /><br>
    <span>Title button</span><br>
    <input type="text" name="ekmap_marker_text_button" value="<?php echo esc_attr($ekmap_marker_text_button); ?>" /><br>
    <span>Title button color</span><br>
    <input type="text" name="ekmap_marker_text_button_color" value="<?php echo esc_attr($ekmap_marker_text_button_color); ?>" /><br>
    <span>Title button background</span><br>
    <input type="text" name="ekmap_marker_text_button_ground" value="<?php echo esc_attr($ekmap_marker_text_button_ground); ?>" /><br>
    <span>Link</span><br>
    <input type="text" name="ekmap_marker_link" value="<?php echo esc_url($ekmap_marker_link); ?>" /><br>
    <span>Open popup</span><br>
    <input type="text" name="ekmap_marker_open" value="<?php echo esc_attr($ekmap_marker_open); ?>" /><br>
    <span>ID</span><br>
    <input type="text" name="ekmap_marker_id" value="<?php echo esc_attr($ekmap_marker_id); ?>" /><br>
    <?php
}

/**
Save data field meta box
 **/
function vnm_ekmap_marker_save( $post_id )
{
    if(isset($_POST['ekmap_marker_content'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_content'] );
        update_post_meta( $post_id, 'ekmap_marker_content', $data_json );
    }
    if(isset($_POST['ekmap_marker_icon'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_icon'] );
        update_post_meta( $post_id, 'ekmap_marker_icon', $data_json );
    }
    if(isset($_POST['ekmap_marker_icon_img'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_icon_img'] );
        update_post_meta( $post_id, 'ekmap_marker_icon_img', $data_json );
    }
    if(isset($_POST['ekmap_marker_icon_img_width'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_icon_img_width'] );
        update_post_meta( $post_id, 'ekmap_marker_icon_img_width', $data_json );
    }
    if(isset($_POST['ekmap_marker_icon_height'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_icon_height'] );
        update_post_meta( $post_id, 'ekmap_marker_icon_height', $data_json );
    }
    if(isset($_POST['ekmap_marker_address'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_address'] );
        update_post_meta( $post_id, 'ekmap_marker_address', $data_json );
    }
    if(isset($_POST['ekmap_marker_phone'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_phone'] );
        update_post_meta( $post_id, 'ekmap_marker_phone', $data_json );
    }
    if(isset($_POST['ekmap_marker_lon'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_lon'] );
        update_post_meta( $post_id, 'ekmap_marker_lon', $data_json );
    }
    if(isset($_POST['ekmap_marker_lat'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_lat'] );
        update_post_meta( $post_id, 'ekmap_marker_lat', $data_json );
    }
    if(isset($_POST['ekmap_marker_text_button'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_text_button'] );
        update_post_meta( $post_id, 'ekmap_marker_text_button', $data_json );
    }
    if(isset($_POST['ekmap_marker_text_button_color'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_text_button_color'] );
        update_post_meta( $post_id, 'ekmap_marker_text_button_color', $data_json );
    }
    if(isset($_POST['ekmap_marker_text_button_ground'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_text_button_ground'] );
        update_post_meta( $post_id, 'ekmap_marker_text_button_ground', $data_json );
    }
    if(isset($_POST['ekmap_marker_link'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_link'] );
        update_post_meta( $post_id, 'ekmap_marker_link', $data_json );
    }
    if(isset($_POST['ekmap_marker_open'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_open'] );
        update_post_meta( $post_id, 'ekmap_marker_open', $data_json );
    }
    if(isset($_POST['ekmap_marker_id'])){
        $data_json = sanitize_text_field( $_POST['ekmap_marker_id'] );
        update_post_meta( $post_id, 'ekmap_marker_id', $data_json );
    }
}
add_action( 'save_post', 'vnm_ekmap_marker_save' );
