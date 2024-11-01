<div class="menu_ekmap">
    <ul>
        <li class="active"><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=vietnam-map' ?>">Bản đồ</a></li>
        <li><a href="<?php echo get_home_url().'/wp-admin/admin.php?page=vietnam-map-api-key' ?>">API Key</a></li>
    </ul>
</div>
<?php
    if(isset($_GET['remove_map'])){
        $query_marker = new WP_Query(array(
            'post_type' => 'ekmap_marker',
            'posts_per_page' => 10,
            'fields'     => 'all',
            'order' => 'ASC',
            'meta_query'	=> array(
                'relation'		=> 'AND',
                array(
                    'key'		=> 'ekmap_marker_id',
                    'value'		=> sanitize_text_field($_GET['remove_map']),
                    'compare'	=> '='
                )
            )
        ));
        if($query_marker->have_posts()) : while ($query_marker->have_posts()) : $query_marker->the_post();
            wp_delete_post( get_the_ID() );
        endwhile;
        endif;
        wp_reset_query();
        wp_delete_post( esc_attr($_GET['remove_map']) );
        $alert_success = 'true';
    }
?>
<div class="ekmap_list">
    <div class="item <?php if(isset($_GET['tab']) && $_GET['tab'] != 2 || !isset($_GET['tab'])){echo 'active';} ?>">
        <h2>Quản lý bản đồ</h2>
        <?php
        if(isset($alert_success)){
            ?><div class="alert_remove_ekmap">Xoá thành công !</div><?php
        }
        ?>
        <a href="<?php echo get_home_url().'/wp-admin/admin.php?page=add-vietnam-map' ?>" class="add_map"><i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;font-size: 14px;"></i>Thêm bản đồ</a>
        <?php
            if(isset($_GET['p'])){
                $paged = sanitize_text_field($_GET['p']);
            }else{
                $paged = 1;
            }
            $query_ekmap = new WP_Query(array(
               'post_type' => 'vietnam-map',
               'posts_per_page' => 10,
               'order' => 'DESC',
                'paged' => $paged,
            ));
        ?>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <th>Tiêu đề</th>
                    <th>Shortcode</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Hành động</th>
                </thead>
                <tbody>
                    <?php
                        if($query_ekmap->have_posts()) : while ($query_ekmap->have_posts()) : $query_ekmap->the_post();
                    ?>
                    <tr>
                        <td><?php echo get_the_title(); ?></td>
                        <td><input type="text" value='[vietnam-map id="<?php echo get_the_ID(); ?>"]' readonly></td>
                        <td><?php echo get_the_date('d/m/Y'); ?></td>
                        <td><?php echo get_the_author(); ?></td>
                        <td>
                            <div class="action">
                                <a href="<?php echo get_home_url().'/wp-admin/admin.php?page=edit-vietnam-map&id='.get_the_ID(); ?>" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="<?php echo get_home_url().'/wp-admin/admin.php?page=vietnam-map&tab=1&remove_map='.get_the_ID(); ?>" class="remove"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                        else:
                            ?>
                            <tr><td colspan="5" style="text-align: center;">Dữ liệu trông !</td></tr>
                            <?php
                        endif;
                        wp_reset_query();
                    ?>
                </tbody>
            </table>
        </div>
        

        <?php
        $total_pages = $query_ekmap->max_num_pages;

        if ($total_pages > 1){
            ?>
            <div class="ekmap_pagi_form">
                <?php
                if(isset($_GET['p']) && $_GET['p'] > 1){
                    ?>
                    <a href="<?php echo esc_url(get_home_url().'/wp-admin/admin.php?page=vietnam-map&p='.(esc_attr($_GET['p']) - 1)); ?>" class="prev">Quay Lại</a>
                    <?php
                }

                for($i = 1; $i <= $total_pages; $i++) {
                    if(!isset($_GET['p']) && $i == 1){
                        ?>
                        <span><?php echo esc_attr($i); ?></span>
                        <?php
                    }else{
                        if(isset($_GET['p']) && $i == $_GET['p']){
                            ?>
                            <span><?php echo esc_attr($i); ?></span>
                            <?php
                        }else{
                            ?>
                            <a href="<?php echo esc_url(get_home_url().'/wp-admin/admin.php?page=vietnam-map&p='.esc_attr($i)); ?>"><?php echo esc_attr($i); ?></a>
                            <?php
                        }
                    }
                }

                if(isset($_GET['p']) && $_GET['p'] < $total_pages){
                    ?>
                    <a href="<?php echo esc_attr(get_home_url().'/wp-admin/admin.php/page/admin.php?page=vietnam-map&p='.(esc_attr($_GET['p']) + 1)); ?>" class="next">Tiếp theo</a>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>


<?php
// Save attachment ID
if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
    update_option( 'media_selector_attachment_id', absint( sanitize_text_field($_POST['image_attachment_id']) ) );
endif;

wp_enqueue_media();

?>

