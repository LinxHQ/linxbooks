<?php

/**
 * HighThemes Popular Posts
 */

class ht_popular_posts extends WP_Widget {
	
	public function __construct() {
		global  $theme_name;
		$widget_ops = array('classname' => 'ht_popular_posts',
						'description' => __( 'The most popular posts with thumbnails','highthemes') );
		parent::__construct(
			'ht_popular_posts', 
			'Highthemes - ' . __('Popular Posts','highthemes'), 
			 $widget_ops // Args
		);
	}
	
	// display the widget in the theme
	function widget( $args, $instance ) {
		global $wpdb;
		extract($args);
		
	$pop_posts =  (int) strip_tags($instance['posts_number']);
	
	if (empty($pop_posts) || $pop_posts < 1) $pop_posts = 3;
	$now = gmdate("Y-m-d H:i:s",time());
	$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
	$popularposts = "SELECT ID, post_title,post_type,  post_date, COUNT($wpdb->comments.comment_post_ID) AS
					'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND post_type='post'
					AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'  
					AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT ".$pop_posts;
	
	$posts = $wpdb->get_results($popularposts);
	$popular = '';
		
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		

		if($posts){ ?>
		<ul class="thumb-list">
		<?php
            $post_format = '';
            foreach($posts as $post){

                $post_title = stripslashes($post->post_title);
                $post_date = $post->post_date;
                $post_date = mysql2date('F j, Y', $post_date, false);
                $permalink = get_permalink($post->ID);

                if ( post_type_supports( $post->post_type, 'post-formats' ) ){
                    $_format = get_the_terms( $post->ID, 'post_format' );
                    if ( !empty( $_format ) ){
                        $format = array_shift( $_format );
                        $post_format = str_replace('post-format-', '', $format->slug );
                    }
                }
	      
		        $image_id = get_post_meta($post->ID, "_thumbnail_id", true);
		        $image = wp_get_attachment_image_src($image_id,'small-thumb');			
		        $thumb_url = $image[0];
	        	$icon = '';

            	?>

				<li class="clearfix">
				<?php if($post_format =='video'   ||
					  $post_format =='link'   || 
					  $post_format =='quote'  || 
					  $post_format =='audio'  					  
					)  
				{
				?>
	            <a class="fl post-format-icons" href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>">
	                <i class="fa-<?php echo ht_post_format_icon($post_format);?>"></i>
	            </a>
				<?php } else if (!$thumb_url) {	?>
	            <a class="fl post-format-icons" href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>">
	                <i class="fa-list"></i>
	            </a>
				<?php } else {?>
	            <a class="post-thumbnail" href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>">
	                <img width="60" height="60" class="frame" src="<?php echo $thumb_url;?>" alt="<?php echo $post_title;?>" />
	            </a>
	            <?php }?>
	            <h3><a href="<?php echo $permalink; ?>"><?php echo $post_title; ?></a></h3>
	            <div class="post-meta"><span><?php echo $post_date; ?></span></div>
            </li>
                <?php $post_format = ''; }?>
		</ul>
		<?php }
		echo $after_widget;
		
		
		//end
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		// replace old with new
		$instance['posts_number'] = (int) strip_tags($new_instance['posts_number']);
		$instance['title'] =  strip_tags($new_instance['title']);
		
		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array( 'posts_number' => 3, 'title' => __('Popular Posts','highthemes') ) );
	$posts_number = (int) strip_tags($instance['posts_number']);
	$title =  strip_tags($instance['title']);
	
	// print the form fields
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">
	<?php _e('Title: ','highthemes'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
		esc_attr($title); ?>" /></p>
        
	<p><label for="<?php echo $this->get_field_id('posts_number'); ?>">
	<?php _e('Number of Posts:','highthemes'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('posts_number'); ?>" name="<?php echo $this->get_field_name('posts_number'); ?>" type="text" value="<?php echo
		esc_attr($posts_number); ?>" /></p>
	<?php
	}
	}	

