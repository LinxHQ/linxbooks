<?php

/**
 * Highthemes Sub Navigation
 */

class ht_submenu extends WP_Widget {

	public function __construct() {
		global  $theme_name;
		$widget_ops = array('classname' => 'ht_sub_navigation',
							'description' => __( 'Showing subpages on sidebar','highthemes') );
		parent::__construct(
			'ht_submenu', 
			'Highthemes - ' . __('Sub Pages','highthemes'), 
			 $widget_ops // Args
		);
	}	
	
	
	// display the widget in the theme
	function widget( $args, $instance ) {
		global $wpdb, $post;
		extract($args);
		
	 	if ( !is_page() ) return false;

    	if ($post->post_parent != 0)
    	$parent = get_post($post->post_parent);
    	else
    	$parent = false;
	  
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;


 		// Default Args for selecting sub pages
    	$page_args = array( 'title_li' => '',
                        'child_of' => $post->ID,
                        'depth'    => 1,
                        'echo'     => false );

      	// Read the subpages again
     	$page_listing = wp_list_pages($page_args);
	    //if ( !$page_listing ) return false;


        echo  '<ul>';
        echo $page_listing;
     	echo '</ul>';
		echo $after_widget;
		
		//end
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array( 'title' => __('Sub Pages','highthemes') ) );
	$title = strip_tags($instance['title']);
	
	
	// print the form fields
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">
	<?php _e('Title:','highthemes'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
		esc_attr($title); ?>" /></p>
    

	<?php
	}
	}
