<?php
/**
 * Configuration of the current theme
 */

// theme options
$ht_theme_options =  array(
    'socials',
    'general',
    'header',
    'portfolio',
    'blog',
    'styling',
    'background'
);

if( is_woocommerce_activated() ){
  $ht_theme_options[] = 'woocommerce';
}

/**
 * Setting up the page builder
 */



if (class_exists('WPBakeryVisualComposerAbstract')) {
  $dir = get_stylesheet_directory() . '/includes/vc_mods/vc_templates/';

if ( WPB_VC_VERSION < 4.3 ) {
  WPBakeryVisualComposer::$config['USER_DIR_NAME']      = 'includes/vc_mods/vc_templates';
  WPBakeryVisualComposer::$config['default_post_types'] = array('post', 'page','portfolio');  
} else {
  vc_set_shortcodes_templates_dir($dir);
  vc_set_default_editor_post_types(array('post', 'page','portfolio'));  
}
  require_once locate_template('/includes/vc_mods/vc_shortcodes.php');
}



/**
 * Enable woocommerce
 */
if(is_woocommerce_activated()){
	require_once (HT_THEME_INC_DIR     . 'woocommerce.php');
}

// post types
require_once ( HT_THEME_INC_DIR     . 'post-types/portfolio.php');


// custom meta boxes
require_once HT_THEME_INC_DIR . 'meta-boxes/index.php';


// breadcrumb
require_once HT_THEME_INC_DIR . 'lib/breadcrumb.php';

// paginattion
if (!function_exists('wp_pagenavi')) {
    require_once (HT_THEME_INC_DIR . 'lib/wp-pagenavi.php');
}

