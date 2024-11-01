<?php
/*
Plugin Name: Vietnam Map
Plugin URI: https://ekgis.com.vn/
Description: Design by eK Geoinformation Technology Joint Stock Company
Version: 2.0.8
Author: ekmap
Author URI: https://ekgis.com.vn/our-story/
Text Domain: vietnam-map
Domain Path: /languages/
*/

class vnm_eKMap{
    private static $instance;

    public static function getInstance(){
        if(! isset(self::$instance)){
            self::$instance = new vnm_eKMap();
            self::$instance->vnm_setup();
            self::$instance->vnm_ajax();
            self::$instance->vnm_admin();
            self::$instance->vnm_posttype();
            self::$instance->vnm_metabox();
            self::$instance->vnm_shortcode();
        }
    }

    public function vnm_setup(){
        if(!defined('vnm_DIR')){
            define('vnm_DIR',plugin_dir_path(__FILE__));
        }

        if(!defined('vnm_URL_CORE')){
            define('vnm_URL_CORE', plugin_dir_url(__FILE__));
        }

        add_action( 'wp_enqueue_scripts', array($this,'vnm_add_plugin_scripts') );
        add_action( 'admin_enqueue_scripts', array($this,'vnm_add_plugin_scripts_admin') );
    }

    function vnm_add_plugin_scripts() {
        wp_enqueue_style( 'style-ekmap-platform', 'https://files.ekgis.vn/sdks/v2.0.0/ekmap-platform.min.css', array(), '1.0', 'all');
        wp_enqueue_style( 'style-ekmap', plugin_dir_url(__FILE__) . '/assets/css/frontend.css', array(), '1.0', 'all');
        wp_enqueue_script( 'script-ekmap-platform', 'https://files.ekgis.vn/sdks/v2.0.0/ekmap-platform.min.js', array ( 'jquery' ), 1.0, true);
    }

    function vnm_add_plugin_scripts_admin(){
        wp_enqueue_style( 'style-ekmap-admin', plugin_dir_url(__FILE__) . '/assets/css/admin.css', array(), '1.0', 'all');
        wp_enqueue_style( 'awesome-ekmap-admin', plugin_dir_url(__FILE__) . 'assets/css/font-awesome.min.css', array(), '1.0', 'all');
        wp_enqueue_style( 'style-ekmap-platform', 'https://files.ekgis.vn/sdks/v2.0.0/ekmap-platform.min.css', array(), '1.0', 'all');
        wp_enqueue_script( 'script-ekmap-platform', 'https://files.ekgis.vn/sdks/v2.0.0/ekmap-platform.min.js', array ( 'jquery' ), 1.0, true);
        wp_enqueue_script( 'script-ekmap-admin', plugin_dir_url(__FILE__) . '/assets/js/admin.js', array ( 'jquery' ), 1.0, true);
        wp_localize_script('script-ekmap-admin', 'ajax_admin', array('url_admin' => admin_url('admin-ajax.php')));
    }

    public function vnm_ajax(){
        require_once vnm_DIR . '/inc/ajax/ajax.php';
    }

    public function vnm_admin(){
        require_once vnm_DIR . '/inc/admin/menu.php';
    }

    public function vnm_posttype(){
        require_once vnm_DIR . '/inc/posttype/ekmap-posttype.php';
        require_once vnm_DIR . '/inc/posttype/marker-posttype.php';
    }

    public function vnm_metabox(){
        require_once vnm_DIR . '/inc/metabox/metabox-ekmap.php';
        require_once vnm_DIR . '/inc/metabox/metabox-marker.php';
    }

    public function vnm_shortcode(){
        require_once vnm_DIR . '/inc/shortcode/shortcode-ekmap.php';
    }
}

function vnm_geteKMap(){
    return vnm_eKMap::getInstance();
}

vnm_geteKMap();
?>