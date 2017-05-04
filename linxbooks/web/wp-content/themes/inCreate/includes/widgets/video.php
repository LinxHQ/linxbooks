<?php

/**
 * Highthemes Video
 */

class ht_video extends WP_Widget {

	public function __construct() {
		global  $theme_name;
        $widget_ops = array('classname' => 'ht_video',
            'description' => __( 'Embed a Video','highthemes') );

		parent::__construct(
			'ht_video', 
			'Highthemes - ' . __('Embed Video','highthemes'), 
			 $widget_ops // Args
		);
	}	

    // display the widget in the theme
    function widget( $args, $instance ) {
        extract($args);

        $instance['v_title']  = strip_tags(stripslashes($instance['v_title']));
        $instance['v_splash'] = strip_tags($instance['v_splash']);
        $instance['v_url']    = strip_tags($instance['v_url']);
        $instance['v_mp4']    = strip_tags($instance['v_mp4']);
        $instance['v_webm']   = strip_tags($instance['v_webm']);
        $instance['v_ogv']    = strip_tags($instance['v_ogv']);
        $instance['v_flv']    = strip_tags($instance['v_flv']);

        $title = apply_filters('widget_title', $instance['v_title'], $instance, $this->id_base);

        echo $before_widget;
        echo '<h3 class="col-title">'. $title .'</h3>';
        echo embed_video($instance['v_url'], 190, 145,$instance['v_mp4'], $instance['v_webm'], $instance['v_flv'], $instance['v_ogv'], $instance['v_splash']);

        echo $after_widget;

        //end
    }

    // update the widget when new options have been entered
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

		$instance['v_title']  = strip_tags($new_instance['v_title']);
        $instance['v_url']    = $new_instance['v_url'];
        $instance['v_splash'] = $new_instance['v_splash'];
        $instance['v_mp4']    = $new_instance['v_mp4'];
        $instance['v_webm']   = $new_instance['v_webm'];
        $instance['v_ogv']    = $new_instance['v_ogv'];
        $instance['v_flv']    = $new_instance['v_flv'];

        return $instance;
    }

    // print the widget option form on the widget management screen
    function form( $instance ) {

        // combine provided fields with defaults
		$instance = wp_parse_args( (array) $instance, array( 'v_title' => __('Video','highthemes') ));
        $v_title  = $instance['v_title'];
        $v_url    = $instance['v_url'];
        $v_splash = $instance['v_splash'];
        $v_mp4    = $instance['v_mp4'];
        $v_webm   = $instance['v_webm'];
        $v_ogv    = $instance['v_ogv'];
        $v_flv    = $instance['v_flv'];

        // print the form fields
        ?>

    <div class="video-widget">
        <p><label for="<?php echo $this->get_field_id('v_title'); ?>">
            <?php _e('Title:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_title'); ?>" name="<?php echo $this->get_field_name('v_title'); ?>" type="text" value="<?php echo
            esc_attr($v_title); ?>" /></p>

        <p>
        	<label for="<?php echo $this->get_field_id('v_splash'); ?>">
            <?php _e('Splash Preview Image:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_splash'); ?>" name="<?php echo $this->get_field_name('v_splash'); ?>" type="text" value="<?php echo
            esc_attr($v_splash); ?>" />
        </p> 

        <p>
        	<label for="<?php echo $this->get_field_id('v_url'); ?>">
            <?php _e('Youtube, Vimeo, Dailymotion or Hosted MP4:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_url'); ?>" name="<?php echo $this->get_field_name('v_url'); ?>" type="text" value="<?php echo
            esc_attr($v_url); ?>" />
        </p>

         <p>
            <label for="<?php echo $this->get_field_id('v_mp4'); ?>">
            <?php _e('MP4:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_mp4'); ?>" name="<?php echo $this->get_field_name('v_mp4'); ?>" type="text" value="<?php echo
            esc_attr($v_mp4); ?>" />
        </p> 

         <p>
        	<label for="<?php echo $this->get_field_id('v_webm'); ?>">
            <?php _e('WebM:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_webm'); ?>" name="<?php echo $this->get_field_name('v_webm'); ?>" type="text" value="<?php echo
            esc_attr($v_webm); ?>" />
        </p> 


        <p>
        	<label for="<?php echo $this->get_field_id('v_ogv'); ?>">
            <?php _e('OGG:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_ogv'); ?>" name="<?php echo $this->get_field_name('v_ogv'); ?>" type="text" value="<?php echo
            esc_attr($v_ogv); ?>" />
        </p> 

        <p>
        	<label for="<?php echo $this->get_field_id('v_flv'); ?>">
            <?php _e('FLV:','highthemes'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('v_flv'); ?>" name="<?php echo $this->get_field_name('v_flv'); ?>" type="text" value="<?php echo
            esc_attr($v_flv); ?>" />
        </p>      

    </div>
    <?php
    }
}

