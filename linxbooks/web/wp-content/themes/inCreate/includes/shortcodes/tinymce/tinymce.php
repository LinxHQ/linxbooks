<?php

//////////////////////////////////////////////////////////////////
// Add buttons to tinyMCE
//////////////////////////////////////////////////////////////////
add_action('init', 'add_button');

function add_button() {
    if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
    {
        add_filter('mce_external_plugins', 'add_plugin');
        add_filter('mce_buttons_3', 'register_button');
    }
}

function register_button($buttons) {
    array_push($buttons, "one_half", "one_third", "one_fourth", "one_fifth", "one_sixth", "two_third", "two_fifth", "three_fourth", "three_fifth", "four_fifth", "five_sixth");
    return $buttons;
}

function add_plugin($plugin_array) {
	$plugin_array['one_half']     = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['one_third']    = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['one_fourth']   = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['one_fifth']    = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['one_sixth']    = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['two_third']    = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['two_fifth']    = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['three_fourth'] = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['three_fifth']  = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['four_fifth']   = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';
	$plugin_array['five_sixth']   = HT_THEME_INC_URL.'shortcodes/tinymce/customcodes.js';

    return $plugin_array;
}

class add_shortcodes_button {
	
	var $pluginname = 'highthemes_shortcode';
	var $path = '';
	var $internalVersion = 100;
	
	function add_shortcodes_button()  {
		
		// Set path to editor_plugin.js
		$this->path = HT_THEME_INC_URL.'shortcodes/tinymce/';	
		
		// Modify the version when tinyMCE plugins are changed.
		add_filter('tiny_mce_version', array (&$this, '1.0') );

		// init process for button control
		add_action('init', array (&$this, 'addbuttons') );
	}
	
	
	
	
	function addbuttons() {
		global $page_handle;
	
		// Don't bother doing this stuff if the current user lacks permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) 
			return;
		
		$svr_uri = $_SERVER['REQUEST_URI'];

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
		 
		if ( strstr($svr_uri, 'post.php') || strstr($svr_uri, 'post-new.php') || strstr($svr_uri, 'page.php') || strstr($svr_uri, 'page-new.php') ) {
				add_filter("mce_external_plugins", array (&$this, 'add_tinymce_plugin' ), 5);
				add_filter('mce_buttons', array (&$this, 'register_button' ), 5);
				
			}
		}
	}
	
	function register_button($buttons) {
	
		array_push($buttons, 'separator', $this->pluginname );
	
		return $buttons;
	}
	
	function add_tinymce_plugin(){
	    global $typenow, $pagenow;

	    if ( empty( $typenow ) && !empty( $_GET['post'] ) ) {
	        $post = get_post( $_GET['post'] );
	        $typenow = $post->post_type;
	    }

	    $curpage = $pagenow . 'post-new.php?post_type=' . $typenow;

	    if( 'portfolio' == $typenow || 'post-new.php?post-type=portfolio' == $curpage  ||
	    	'post' == $typenow || 'post-new.php?post-type=post' == $curpage ||
	    	'page' == $typenow || 'post-new.php?post-type=page' == $curpage 

	    	) {

	        if( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) )
	           return;

			$plugin_array[$this->pluginname] =  $this->path . 'editor_plugin_post.js';
			return $plugin_array;			

	    }

	}

	

	function change_tinymce_version($version) {
			$version = $version + $this->internalVersion;
		return $version;
	}
	
}

$tinymce_button = new add_shortcodes_button ();

?>