<?php
/**
 * Widgets
 * 
 * Main file for manage widget.     
 */
 
define( 'HT_WIDGETS_FOLDER', HT_THEME_INC_DIR . 'widgets/' );  

$ht_widgets = ht_get_widgets();

foreach ( $ht_widgets as $index => $widget ) {
	    	include_once HT_WIDGETS_FOLDER . $widget . '.php';   
}
  
add_action( 'widgets_init', 'ht_register_widgets' );  

/**
 * Retrieve all widgets that are in the theme
 * @return array An array with all widgets name 
 */
function ht_get_widgets() {
	$widgets = array();  
	
	$file_widgets = ht_list_files_into( HT_WIDGETS_FOLDER );
	foreach ( $file_widgets as $file ) {
		$name = preg_replace( '/(.*).php/', '$1', $file );
		$widgets[] = $name;
	}
	
	return $widgets;			
}

/**
 * register all widgets of the theme
 * 
 * @since 1.0  
 */
function ht_register_widgets() 
{
    global $ht_widgets;
	foreach ( $ht_widgets as $widget ){
		$widget = str_replace('-', '_', $widget);
		$widget = 'ht_' . $widget;
        register_widget( $widget );
	}	
}                       


?>