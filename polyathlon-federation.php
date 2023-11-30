<?php

/*
* Plugin Name: Polyathlon Federation
* Plugin URI: http://base.rsu.edu.ru
* Description: WordPress multipurpose plugin to showcase polyathlon federation!
* Author: Vladislav Antoshkin
* Author URI: http://base.rsu.edu.ru
* License: GPLv2 or later
* Version: 1.0.0
*/


//Load configs
require_once( dirname(__FILE__).'/feder-config.php');
require_once( FEDER_CLASSES_DIR_PATH.'/feder-ajax-action.php');
require_once( FEDER_CLASSES_DIR_PATH.'/FEDERHelper.php');
require_once( FEDER_CLASSES_DIR_PATH.'/FEDERDBInitializer.php');

//Register activation & deactivation hooks
register_activation_hook( __FILE__, 'feder_activation_hook');
register_uninstall_hook( __FILE__, 'feder_uninstall_hook');
register_deactivation_hook( __FILE__, 'feder_deactivation_hook');

//Register action hooks
add_action('init', 'feder_init_action');
add_action('admin_enqueue_scripts', 'feder_admin_enqueue_scripts_action' );
add_action('wp_enqueue_scripts', 'feder_wp_enqueue_scripts_action' );
add_action('admin_menu', 'feder_admin_menu_action');
add_action('admin_head', 'feder_admin_head_action');
add_action('admin_footer', 'feder_admin_footer_action');
add_action('upgrader_process_complete', 'feder_update_complete_action', 10, 2);
add_action('plugins_loaded', 'feder_plugins_loaded_action');

//Register filter hooks

//Register feder shortcode handlers
add_shortcode('feder_federation', 'feder_shortcode_handler');
add_shortcode('feder', 'feder_shortcode_handler');

//Register Ajax actions
add_action( 'wp_ajax_feder_get_portfolio', 'wp_ajax_feder_get_portfolio');
add_action( 'wp_ajax_feder_save_portfolio', 'wp_ajax_feder_save_portfolio');
add_action( 'wp_ajax_feder_get_options', 'wp_ajax_feder_get_options');
add_action( 'wp_ajax_feder_save_options', 'wp_ajax_feder_save_options');

//Global vars
$feder_portfolios;

function feder_update_complete_action( $upgrader_object, $options ) {
    $our_plugin = plugin_basename( __FILE__ );
    if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
        foreach( $options['plugins'] as $plugin ) {
            if( $plugin == $our_plugin ) {
                set_transient( 'federation_updated', 1 );
            }
        }
    }
}

function feder_plugins_loaded_action()
{
    if (get_transient('federation_updated')) {
        $dbInitializer = new FEDERDBInitializer();
        $dbInitializer->checkForChanges();

        delete_transient('federation_updated');
    }
}

//Registered activation hook
function feder_activation_hook(){
    $dbInitializer = new FEDERDBInitializer();
    if($dbInitializer->needsConfiguration()){
        $dbInitializer->configure();
    }
    $dbInitializer->checkForChanges();
}

function feder_uninstall_hook(){
    delete_option(FEDER_BANNERS_CONTENT);
    delete_option(FEDER_BANNERS_LAST_LOADED_AT);
}

function feder_deactivation_hook(){
}

//Registered hook actions
function feder_init_action() {
    global $wp_version;
    if ( version_compare( $wp_version, '5.0.0', '>=' ) ) {
        wp_register_script(
            'feder-shortcode-block-script',
            FEDER_JS_URL . '/feder-shortcode-block.js',
            array('wp-blocks', 'wp-element')
        );

        wp_register_style(
            'feder-shortcode-block-style',
            FEDER_CSS_URL . '/feder-admin-editor-block.css',
            array('wp-edit-blocks'),
            filemtime(plugin_dir_path(__FILE__) . 'css/feder-admin-editor-block.css')
        );

        register_block_type('polyathlon-federation/feder-shortcode-block', array(
            'editor_script' => 'feder-shortcode-block-script',
            'editor_style' => 'feder-shortcode-block-style',
        ));
    }
    ob_start();
}

function feder_admin_enqueue_scripts_action($hook) {
    if (stripos($hook, FEDER_PLUGIN_SLAG) !== false) {
        feder_enqueue_admin_scripts();
        feder_enqueue_admin_csss();
    }
}

function feder_wp_enqueue_scripts_action(){
    feder_enqueue_front_scripts();
    feder_enqueue_front_csss();
}

function feder_admin_menu_action() {
    feder_setup_admin_menu_buttons();
}

function feder_admin_head_action(){
    feder_include_inline_scripts();
    feder_setup_media_buttons();
}

function feder_admin_footer_action() {
    feder_include_inline_htmls();
}

//Registered hook filters
function feder_mce_external_plugins_filter($pluginsArray){
    return feder_register_tinymce_plugin($pluginsArray);
}

function feder_mce_buttons_filter($buttons){
    return feder_register_tc_buttons($buttons);
}

//Shortcode Hanlders
function feder_shortcode_handler($attributes){
	ob_start();

    //Prepare render data
    global $feder_portfolios;
    $feder_portfolios = FEDERHelper::getPortfolios($attributes['id']);
    require_once(FEDER_FRONT_VIEWS_DIR_PATH."/feder-front.php");

    $result = ob_get_clean();
    return $result;
}

//Internal functionality
function feder_setup_admin_menu_buttons(){
    add_menu_page(FEDER_PLUGIN_NAME, FEDER_PLUGIN_NAME, 'edit_posts', FEDER_PLUGIN_SLAG, "feder_admin_portfolio_page", 'dashicons-portfolio', 76);
    add_submenu_page(FEDER_PLUGIN_SLAG, FEDER_SUBMENU_PORTFOLIOS_TITLE, FEDER_SUBMENU_PORTFOLIOS_TITLE, 'edit_posts', FEDER_PLUGIN_SLAG, 'feder_admin_portfolio_page');
}

function feder_admin_page() {
  require_once(FEDER_ADMIN_VIEWS_DIR_PATH.'/feder-admin.php');
}

function feder_admin_portfolio_page(){
    global $feder_adminPageType;
    $feder_adminPageType = FEDERTableType::PORTFOLIO;
    require_once(FEDER_ADMIN_VIEWS_DIR_PATH.'/feder-admin.php');
}

function feder_setup_media_buttons(){
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }

    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;

    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "feder_mce_external_plugins_filter");
        add_filter('mce_buttons', 'feder_mce_buttons_filter');
    }
}

function feder_register_tinymce_plugin($pluginsArray) {
    $pluginsArray['feder_tc_buttons'] = FEDER_JS_URL."/feder-tc-buttons.js";
    return $pluginsArray;
}

function feder_register_tc_buttons($buttons) {
    array_push($buttons, "feder_insert_tc_button");
    return $buttons;
}

function feder_include_inline_scripts(){
?>
    <script type="text/javascript">

        jQuery(document).ready(function() {
        });
    </script>
<?php
}

function feder_include_inline_htmls(){
?>

<?php
}

function feder_enqueue_admin_scripts(){
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-core");
    wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("jquery-ui-autocomplete");

    //Enqueue JS files
    wp_enqueue_script( 'feder-helper-js', FEDER_JS_URL.'/feder-helper.js', array('jquery'), "", false );
    wp_enqueue_script( 'feder-main-admin-js', FEDER_JS_URL.'/feder-main-admin.js', array('jquery'), "", true );
    wp_enqueue_script( 'feder-ajax-admin-js', FEDER_JS_URL.'/feder-ajax-admin.js', array('jquery'), "", true );

    wp_register_script('feder-tooltipster', FEDER_JS_URL."/jquery/jquery.tooltipster.js", array('jquery'), "", true );
    wp_enqueue_script('feder-tooltipster');

    wp_register_script('feder-caret', FEDER_JS_URL."/jquery/jquery.caret.js", array('jquery'), "", true );
    wp_enqueue_script('feder-caret');

    wp_register_script('feder-tageditor', FEDER_JS_URL."/jquery/jquery.tageditor.js", array('jquery'), "", true );
    wp_enqueue_script('feder-tageditor');

    wp_enqueue_media();
    wp_enqueue_script('wp-color-picker');
}

function feder_enqueue_admin_csss(){
    //Enqueue CSS files

    wp_register_style('feder-main-admin-style', FEDER_CSS_URL.'/feder-main-admin.css');
    wp_enqueue_style('feder-main-admin-style');

    wp_register_style('feder-tc-buttons', FEDER_CSS_URL.'/feder-tc-buttons.css');
    wp_enqueue_style('feder-tc-buttons');

    wp_register_style('feder-tooltipster', FEDER_CSS_URL.'/tooltipster/tooltipster.css');
    wp_enqueue_style('feder-tooltipster');
    wp_register_style('feder-tooltipster-theme', FEDER_CSS_URL.'/tooltipster/themes/tooltipster-shadow.css');
    wp_enqueue_style('feder-tooltipster-theme');

    wp_register_style('feder-accordion', FEDER_CSS_URL.'/accordion/accordion.css');
    wp_enqueue_style('feder-accordion');

    wp_register_style('feder-tageditor', FEDER_CSS_URL.'/tageditor/tageditor.css');
    wp_enqueue_style('feder-tageditor');

    wp_enqueue_style( 'wp-color-picker' );

    wp_register_style('feder-font-awesome', FEDER_CSS_URL.'/fontawesome/font-awesome.css');
    wp_enqueue_style('feder-font-awesome');
}

function feder_enqueue_front_scripts(){
    //Enqueue JS files
    wp_enqueue_script( 'feder-main-front-js', FEDER_JS_URL.'/feder-main-front.js', array('jquery') );
    wp_enqueue_script( 'feder-helper-js', FEDER_JS_URL.'/feder-helper.js', array('jquery') );

    wp_enqueue_script( 'feder-modernizr', FEDER_JS_URL."/jquery/jquery.modernizr.js", array('jquery') );
    wp_enqueue_script( 'feder-tiled-layer', FEDER_JS_URL."/feder-tiled-layer.js", array('jquery') );
    wp_enqueue_script( 'feder-fs-viewer', FEDER_JS_URL.'/feder-fs-viewer.js', array('jquery') );
    wp_enqueue_script( 'feder-lg-viewer', FEDER_JS_URL.'/jquery/jquery.lightgallery.js', array('jquery') );
    wp_enqueue_script( 'feder-owl', FEDER_JS_URL.'/owl-carousel/owl.carousel.js', array('jquery') );
}

function feder_enqueue_front_csss(){
    //Enqueue CSS files
    wp_register_style('feder-main-front-style', FEDER_CSS_URL.'/feder-main-front.css');
    wp_enqueue_style('feder-main-front-style');

    wp_register_style('feder-tc-buttons', FEDER_CSS_URL.'/feder-tc-buttons.css');
    wp_enqueue_style('feder-tc-buttons');

    wp_register_style('feder-tiled-layer', FEDER_CSS_URL.'/feder-tiled-layer.css');
    wp_enqueue_style('feder-tiled-layer');

    wp_register_style('feder-fs-viewer', FEDER_CSS_URL.'/fsviewer/feder-fs-viewer.css');
    wp_enqueue_style('feder-fs-viewer');

    wp_register_style('feder-font-awesome', FEDER_CSS_URL.'/fontawesome/font-awesome.css');
    wp_enqueue_style('feder-font-awesome');

    wp_register_style('feder-lg-viewer', FEDER_CSS_URL.'/lightgallery/lightgallery.css');
    wp_enqueue_style('feder-lg-viewer');

    wp_register_style('feder-captions', FEDER_CSS_URL.'/feder-captions.css');
    wp_enqueue_style('feder-captions');

    wp_register_style('feder-captions', FEDER_CSS_URL.'/feder-captions.css');
    wp_enqueue_style('feder-captions');

    wp_register_style('feder-owl', FEDER_CSS_URL.'/owl-carousel/assets/owl.carousel.css');
    wp_enqueue_style('feder-owl');

    wp_register_style('feder-layout', FEDER_CSS_URL.'/owl-carousel/layout.css');
    wp_enqueue_style('feder-layout');
}
