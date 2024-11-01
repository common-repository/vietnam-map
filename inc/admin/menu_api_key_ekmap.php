<div class="menu_ekmap">
    <ul>
        <li><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=vietnam-map' ?>">Bản đồ</a></li>
        <li class="active"><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=vietnam-map-api-key' ?>">API Key</a></li>
    </ul>
</div>

<?php
if(isset($_POST['apply_map'])){
    update_option('ekmap_field', sanitize_text_field($_POST['map_key']));
}
?>
<div class="ekmap_list">
    <div class="item active">
        <h2>API key</h2>
        <form action="<?php echo get_home_url().'/wp-admin/admin.php/page/admin.php?page=vietnam-map-api-key'; ?>" method="post" class="api_key_frm">
            <?php
            settings_fields('ekmap_form_theme_settings');
            do_settings_sections('ekmap_form_theme_settings');
            ?>
            <span>Nhập API key</span>
            <div class="input">
                <input type="text" name="map_key" value="<?php if(!empty(get_option('ekmap_field'))){echo '***************';} ?>"/>
                <button type="submit" name="apply_map">Áp dụng</button>
            </div>
            <a href="<?php echo esc_url('https://ekgis.com.vn/contact-map'); ?>" target="_blank" class="buy_map">Mua API Key</a>
        </form>
    </div>
</div>
