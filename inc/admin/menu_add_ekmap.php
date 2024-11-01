<div class="menu_ekmap menu_ekmap_add">
    <ul>
        <li id="ek_tab1" class="<?php if(isset($_GET['tab']) && $_GET['tab'] != 2 || !isset($_GET['tab'])){echo 'active';} ?>"><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=add-vietnam-map&tab=1'; ?>">Cài đặt chung</a></li>
        <li id="ek_tab2" class="<?php if(isset($_GET['tab']) && $_GET['tab'] == 2){echo 'active';} ?>"><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=add-vietnam-map&tab=2'; ?>">Marker</a></li>
    </ul>
</div>
<?php
    if(isset($_POST['add_map_sub'])){
        $ekmap_add_list_marker = sanitize_text_field(stripslashes($_POST["ekmap_add_list_marker"]));
        $ekmap_add_list_marker = json_decode($ekmap_add_list_marker, true);

        $data = array(
            'post_type' => 'vietnam-map',
            'post_status' => 'publish',
            'post_title' => sanitize_text_field($_POST['ekmap_add_title']),
        );

        $id = wp_insert_post( $data );
        update_post_meta($id,'ekmap_lon', sanitize_text_field($_POST['ekmap_add_lon']));
        update_post_meta($id,'ekmap_lat', sanitize_text_field($_POST['ekmap_add_lat']));
        update_post_meta($id,'ekmap_zoom', sanitize_text_field($_POST['ekmap_add_zoom']));
        update_post_meta($id,'ekmap_bearing', sanitize_text_field($_POST['ekmap_add_bearing']));
        update_post_meta($id,'ekmap_pitch', sanitize_text_field($_POST['ekmap_add_pitch']));
        update_post_meta($id,'ekmap_width', sanitize_text_field($_POST['ekmap_add_width']));
        update_post_meta($id,'ekmap_heigth', sanitize_text_field($_POST['ekmap_add_height']));
        update_post_meta($id,'ekmap_type', sanitize_text_field($_POST['ekmap_add_type']));
        update_post_meta($id,'ekmap_theme', sanitize_text_field($_POST['ekmap_add_theme']));
        update_post_meta($id,'ekmap_custom_class', sanitize_text_field($_POST['ekmap_add_custom_class']));
        update_post_meta($id,'ekmap_direction', sanitize_text_field($_POST['ekmap_add_direction']));

        foreach ($ekmap_add_list_marker as $item){
            $data_marker = array(
                'post_type' => 'ekmap_marker',
                'post_status' => 'publish',
                'post_title' => sanitize_text_field($item['title']),
            );

            $id_marker = wp_insert_post( $data_marker );
            update_post_meta($id_marker,'ekmap_marker_content', wp_kses_post($item['content']));
            update_post_meta($id_marker,'ekmap_marker_icon', sanitize_hex_color($item['color']));
            update_post_meta($id_marker,'ekmap_marker_icon_img', sanitize_text_field($item['image']));
            update_post_meta($id_marker,'ekmap_marker_icon_width', sanitize_text_field($item['width']));
            update_post_meta($id_marker,'ekmap_marker_icon_height', sanitize_text_field($item['height']));
            update_post_meta($id_marker,'ekmap_marker_phone', sanitize_text_field($item['phone']));
            update_post_meta($id_marker,'ekmap_marker_lon', sanitize_text_field($item['lon']));
            update_post_meta($id_marker,'ekmap_marker_lat', sanitize_text_field($item['lat']));
            update_post_meta($id_marker,'ekmap_marker_text_button', sanitize_text_field($item['button_text']));
            update_post_meta($id_marker,'ekmap_marker_text_button_color', sanitize_hex_color($item['button_color']));
            update_post_meta($id_marker,'ekmap_marker_text_button_ground', sanitize_hex_color($item['button_ground']));
            update_post_meta($id_marker,'ekmap_marker_link', sanitize_url($item['link']));
            update_post_meta($id_marker,'ekmap_marker_open', sanitize_text_field($item['open']));
            update_post_meta($id_marker,'ekmap_marker_id', sanitize_text_field($id));
        }

        $link_direct = get_home_url().'/wp-admin/admin.php?page=edit-vietnam-map&id='.$id;
        ?>
        <script>
            window.location.href = "<?php echo $link_direct; ?>";
        </script>
        <?php

        $alert_success = true;
    }
?>
<form action="" method="post">
<div class="ekmap_list ekmap_add ekmap_add_fix">
    <div class="item <?php if(isset($_GET['tab']) && $_GET['tab'] != 2 || !isset($_GET['tab'])){echo 'active';} ?>">
        <h2><?php echo __('Thêm bản đồ', 'vietnam-map'); ?></h2>
        <?php
        if(isset($alert_success)){
            ?><div class="alert_add_ekmap"><?php echo __('Thêm thành công !', 'vietnam-map'); ?></div><?php
        }
        ?>

        <div class="ekmap_add_ul">
            <div class="ite">
                <ul class="ek_ul">
                    <li>
                        <span style="display: flex;">Tiêu đề<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_title" class="ekmap_add_title" maxlength="40" required/>
                    </li>
                    <li>
                        <span style="display: flex;">Kinh độ<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_lon" class="ekmap_add_lon" value="105" required/>
                    </li>
                    <li>
                        <span style="display: flex;">Vĩ độ<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_lat" class="ekmap_add_lat" value="17" required/>
                    </li>
                    <li>
                        <span>Zoom</span>
                        <select name="ekmap_add_zoom" class="ekmap_add_zoom">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4" selected>4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                        </select>
                    </li>
                    <li>
                        <span style="display: flex;">Độ nghiêng<span style="color:red">*</span></span>
                        <input type="number" min="0" max="60" step="any" name="ekmap_add_pitch" class="ekmap_add_pitch" required value="0" style="padding: 0 0 0 8px;"/>
                    </li>
                    <li>
                        <span style="display: flex;">Góc xoay<span style="color:red">*</span></span>
                        <input type="number" min="-180" max="180" name="ekmap_add_bearing" class="ekmap_add_bearing" required value="0" style="padding: 0 0 0 8px;"/>
                    </li>
                    <li>
                        <span style="display: flex;">Độ rộng<span style="color:red">*</span> (%,px,em,rem,vh,vw)</span>
                        <input type="text" name="ekmap_add_width" class="ekmap_add_width" value="100%" required/>
                    </li>
                    <li>
                        <span style="display: flex;">Độ cao<span style="color:red">*</span> (%,px,em,rem,vh,vw)</span>
                        <input type="text" name="ekmap_add_height" class="ekmap_add_height" value="500px" required/>
                    </li>
                    <li>
                        <span style="display: flex;">Loại bản đồ<span style="color:red">*</span></span>
                        <select name="ekmap_add_type" class="ekmap_add_type">
                            <option value="0">Standard (Tiêu chuẩn)</option>
                            <option value="1">Bright (Sáng)</option>
                            <option value="2">Gray (Xám)</option>
                            <option value="3">Dark (Đêm)</option>
                            <option value="4">Night (Đêm xanh cô ban)</option>
                            <option value="5">Pencil (Bút chì)</option>
                            <option value="6">Pirates (Cổ điển)</option>
                            <option value="7">Wood (Gỗ)</option>
                            <option value="8">Bản đồ Hành chính Việt Nam</option>
                        </select>
                        <input type="hidden" name="ekmap_add_theme" class="ekmap_add_theme" value="1" />
                    </li>
                    <li>
                        <span class="label">Chế độ chỉ đường</span>
                        <select name="ekmap_add_direction" class="ekmap_add_direction">
                            <option value="0">Không</option>
                            <option value="1">Chỉ đường với eKMap</option>
                            <option value="2">Chỉ đường với GoogleMap</option>
                        </select>
                    </li>
                    <li>
                        <span>Custom Class (Nếu có)</span>
                        <input type="text" name="ekmap_add_custom_class" />
                    </li>
                </ul>
            </div>

            <div class="ite">
                <ul class="ek_ul">
                    <li style="display:flex;align-items:flex-end;justify-content: space-between;">
                        <div style ="width: calc(100% - 150px);">
                            <span class="label">Shortcode</span>
                            <input type="text" name="ekmap_add_shortcode" value="" readonly/>
                        </div>
                        <button type="submit" name="add_map_sub" class="add_map_sub"><i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;font-size: 14px;"></i>Thêm bản đồ</button>
                    </li>
                    <li>
                        <div id="ek_map_admin" style="width:100%;height: 800px;"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="item <?php if(isset($_GET['tab']) && $_GET['tab'] == 2){echo 'active';} ?>">
        <h2>Marker</h2>
        <?php
            if(isset($alert_success)){
                ?><div class="alert_add_ekmap">Thêm thành công !</div><?php
            }
        ?>

        <div class="ekmap_add_ul">
            <div class="ite">
                <ul class="ek_ul">
                    <li>
                        <span class="label" style="display: flex;">Tiêu đề<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_title_marker" class="ekmap_add_title_marker"  maxlength="40"/>
                    </li>
                    <li>
                        <span class="label">Mô tả</span>
                        <?php
                        $content   = '';
                        $editor_id = 'ekmap_add_content';
                        $settings  = array( 'media_buttons' => false );

                        wp_editor( $content, $editor_id, $settings );
                        ?>
                    </li>
                    <li style="display:flex; align-items: baseline; flex-wrap: wrap;">
                        <span class="label" style=" margin-right: 14px;">Luôn hiển thị PopUp</span>
                        <select name="ekmap_add_open_marker" class="ekmap_add_open_marker" style="width: 100px;">
                            <option value="1" selected>Có</option>
                            <option value="">Không</option>
                        </select>
                    </li>
                    <li style="display: flex; align-items: center;">
                        <span class="label">Màu sắc marker</span>
                        <input type="color" name="ekmap_add_color_marker" class="ekmap_add_color_marker" style="width: 100px; margin-left: 14px;" value="#FF0000"/>
                    </li>
                    <li>
                        <span class="label" style="display: flex;">Kinh độ<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_lon_marker" class="ekmap_add_lon_marker"/>
                    </li>
                    <li>
                    <span class="label" style="display: flex;">Vĩ độ<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_lat_marker" class="ekmap_add_lat_marker"/>
                    </li>
                    <li>
                        <div class="icon_group"  style="flex-wrap: wrap;">
                            <span style="width: 100%; margin-bottom: 5px;">Logo</span>
                            <img class="ekmap_img_icon" src="">
                            <div class="up_icon">Tải logo</div>
                            <div class="remove_icon">Xóa logo</div>
                            <input type="file" name="ekmap_add_icon" class="ekmap_add_icon" value="" hidden accept="image/*"/>
                        </div>
                    </li>
                    <li>
                        <span class="label">Độ rộng logo<span style="color:red">*</span> (%,px,vh...)</span>
                        <input type="text" name="ekmap_add_width_marker" class="ekmap_add_width_marker" value="100px"/>
                    </li>
                    <li>
                        <span class="label">Độ cao logo<span style="color:red">*</span> (%,px,vh...)</span>
                        <input type="text" name="ekmap_add_height_marker" class="ekmap_add_height_marker" value="auto"/>
                    </li>
                    <li>
                        <span style="display:flex;" class="label">Số điện thoại<span style="color:red">*</span></span>
                        <input type="text" name="ekmap_add_number_marker" class="ekmap_add_number_marker"/>
                    </li>
                    <li>
                        <span class="label">Liên kết</span>
                        <input type="text" name="ekmap_add_link_marker" class="ekmap_add_link_marker"/>
                    </li>
                    <li>
                        <span class="label">Tiêu đề nút</span>
                        <input type="text" name="ekmap_add_title_btn_marker" class="ekmap_add_title_btn_marker" maxlength="20"/>
                    </li>
                    <li style="display: flex; align-items: center;">
                        <span class="label">Màu chữ tiêu đề nút</span>
                        <input type="color" name="ekmap_add_title_btn_color_marker" class="ekmap_add_title_btn_color_marker" value="#FFFFFF" style="width: 100px; margin-left: 14px;"/>
                    </li>
                    <li style="display: flex; align-items: center;">
                        <span class="label">Màu nền tiêu đề nút</span>
                        <input type="color" name="ekmap_add_title_btn_backgroud_marker" class="ekmap_add_title_btn_backgroud_marker" value="#000000" style="width: 100px; margin-left: 14px;"/>
                    </li>
                    <li>
                        <a href="#" class="btn_add_marker active"><i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;font-size: 14px;"></i>Thêm marker</a>
                        <a href="#" class="btn_edit_marker"><i class="fa fa-floppy-o" aria-hidden="true" style="margin-right: 5px;font-size: 14px;"></i>Lưu marker</a>
                    </li>
                </ul>
            </div>

            <div class="ite">
                <ul class="ek_ul">
                    <li style="display:flex;align-items:flex-end;justify-content: space-between;">
                        <div style ="width: calc(100% - 150px);">
                            <span class="label">Shortcode</span>
                            <input type="text" name="ekmap_add_shortcode" value="" readonly/>
                        </div>
                        <button type="submit" name="add_map_sub" class="add_map_sub"><i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;font-size: 14px;"></i>Thêm bản đồ</button>
                    </li>
                    <li>
                        <div id="ek_map_admin2" style="width:100%;height: 800px;"></div>
                    </li>
                </ul>

                <div class="ekmap_list ekmap_list_marker">
                    <h2>Danh sách Marker</h2>
                    <div class="map_over">
                        <table>
                            <thead>
                            <th>Tiêu đề</th>
                            <th>Biểu tượng</th>
                            <th>Số điện thoại</th>
                            <th>Kinh độ</th>
                            <th>Vĩ độ</th>
                            <th>Link</th>
                            <th>Hành động</th>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="7">Dữ liệu trống !</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="ekmap_add_list_marker" class="ekmap_add_list_marker /">
                    <input type="hidden" name="ekmap_check_edit" class="ekmap_check_edit" value="0" />
                    <input type="hidden" name="ekmap_api_key" class="ekmap_api_key" value="<?php echo get_option('ekmap_field'); ?>" />
                    <input type="hidden" class="ekmap_add_text_alert_empty" value="Dữ liệu trống !"/>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
