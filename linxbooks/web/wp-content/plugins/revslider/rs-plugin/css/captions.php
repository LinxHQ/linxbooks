<?php
header("Content-Type: text/css; charset=utf-8");

$absolute_path = str_replace('\\', '/', __FILE__);
$path_to_file = explode( '/revslider/rs-plugin/', $absolute_path );

$path_to_wp = $path_to_file[0].'/../..';
require_once( $path_to_wp.'/wp-load.php' );

$currentFolder = dirname($absolute_path);

//include framework files
require_once $currentFolder . '/../../inc_php/framework/include_framework.php';

$db = new UniteDBRev();

$styles = $db->fetch(GlobalsRevSlider::$table_css);

echo UniteCssParserRev::parseDbArrayToCss($styles, "\n");

?>