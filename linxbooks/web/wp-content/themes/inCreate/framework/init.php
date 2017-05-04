<?php
/**
 * Initialize the framework
 * 
 * Main includes for all framework.     
 * 
 */
// metaboxes prefix
$prefix = '_ht_';


define( 'HT_FRAMEWORK_VERSION', '1.0.0' );
define( 'HT_FRAMEWORK_PATH', dirname(__FILE__) . '/' );
define( 'HT_FRAMEWORK_URL', get_template_directory_uri() . '/framework/' );

/**
 *  The theme main directories path
 */
define( 'HT_THEME_STYLES_DIR', 	get_template_directory() . '/styles/' );
define( 'HT_THEME_JS_DIR', 		get_template_directory() . '/scripts/' );
define( 'HT_THEME_IMG_DIR', 	get_template_directory() . '/images/' );
define( 'HT_THEME_I18N_DIR', 	get_template_directory() . '/languages/' );
define( 'HT_THEME_INC_DIR', 	get_template_directory() . '/includes/' );

/**
 * The theme main folders uri
 */
define( 'HT_THEME_STYLES_URL', 	get_template_directory_uri() . '/styles/' );
define( 'HT_THEME_JS_URL', 		get_template_directory_uri() . '/scripts/' );
define( 'HT_THEME_IMG_URL', 	get_template_directory_uri() . '/images/' );
define( 'HT_THEME_I18N_URL', 	get_template_directory_uri() . '/languages/' );
define( 'HT_THEME_INC_URL', 	get_template_directory_uri() . '/includes/' );



// google fonts
require_once ( HT_FRAMEWORK_PATH 	. 'assets/php/googlefonts.php');

// core functions
require_once ( HT_FRAMEWORK_PATH 	. 'functions/functions.php' );

// custom sidebars
require_once (HT_FRAMEWORK_PATH     . 'functions/multiple-sidebars.php');

require_once HT_FRAMEWORK_PATH . 'functions/functions-metaboxes.php';

// theme config
require_once ( HT_THEME_INC_DIR	. 'config.php');

// widgets
require_once ( HT_FRAMEWORK_PATH     . 'widgets.php');

// theme options
require_once ( HT_FRAMEWORK_PATH    . 'theme-options/index.php');

// install plugins
require_once ( HT_THEME_INC_DIR	. 'lib/install-plugins.php');

// shortcodes
require_once ( HT_THEME_INC_DIR	. 'shortcodes/shortcodes.php');
require_once ( HT_THEME_INC_DIR	. 'shortcodes/tinymce/tinymce.php');

// html5 audio
require_once (HT_THEME_INC_DIR    . 'lib/oEmbed-html5-audio.php');

// mobile detection
require_once( HT_THEME_INC_DIR . 'lib/mobile-detect.php' );

