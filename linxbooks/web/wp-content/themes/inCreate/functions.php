<?php
/*
HighThemes.com
Twitter: theHighThemes

*/
/*
 * change the default.po file with poedit to create .mo file
 * The .mo file must be named based on the locale exactly.
 */
load_theme_textdomain('highthemes', get_template_directory() .'/languages');

/**
 * Including the admin framework
 */
require_once ('framework/init.php');

/**
 * Theme Functions
 */
require_once (HT_THEME_INC_DIR .'functions.php');

/**
 * Redirect the uesr to admin options
 */
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
      // Now redirect to portfolio
    wp_redirect(admin_url("admin.php?page=optionsframework"));
}


?>