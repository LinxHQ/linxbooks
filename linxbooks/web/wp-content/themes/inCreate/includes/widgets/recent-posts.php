<?php

/**
 * HighThemes Recent Posts Widget
 */

class ht_recent_posts extends WP_Widget {

	public function __construct() {
			global  $theme_name;
			$widget_ops = array('classname' => 'ht_recent_posts',
							'description' => __( 'The most recent posts with thumbnails','highthemes') );
			parent::__construct(
				'ht_recent_posts', 
				'Highthemes - ' . __('Recent Posts','highthemes'), 
				 $widget_ops // Args
			);
	}
		
	// display the widget in the theme
	function widget( $args, $instance ) {
		global $wpdb;
		extract($args);

		$posts_number  = (int) $instance['posts_number'];
		$category  = $instance['category'];

		if($category =='all') {
			$posts = get_posts("post_type=post&numberposts=$posts_number&offset=0");

		} else {
			$posts = get_posts("post_type=post&cat=$category&numberposts=$posts_number&offset=0");

		}

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
				<?php } else { ?>
	            <a class="post-thumbnail" href="<?php echo $permalink; ?>" title="<?php echo $post_title; ?>">
	                <img width="60" height="60" class="frame" src="<?php echo $thumb_url;?>" alt="<?php echo $post_title;?>" />
	            </a>
	            <?php }?>
	            <h3><a href="<?php echo $permalink; ?>"><?php echo $post_title; ?></a></h3>
	            <div class="post-meta"><span><?php echo $post_date; ?></span></div>
            </li>

		<?php $post_format = ''; }?>
        </ul>
        <?php
            }
		echo $after_widget;
		
		
		//end
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		// replace old with new
		$instance['posts_number'] = (int) strip_tags($new_instance['posts_number']);
		$instance['title'] =  strip_tags($new_instance['title']);
		$instance['style'] =  $new_instance['style'];
		$instance['category'] =  $new_instance['category'];

		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {

	$of_categories = array('all' => 'All');
    $of_categories_obj = get_categories('hide_empty=0');
    foreach ($of_categories_obj as $of_cat) {
        $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
    }

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array( 'posts_number' => 3, 'title'=> __('Recent Posts','highthemes'), 'style' =>'' ) );
	$posts_number = (int) strip_tags($instance['posts_number']);
	$title =  strip_tags($instance['title']);
	$style = $instance['style'];
	$category = $instance['category'];

	// print the form fields
?>
	
	<p><label for="<?php echo $this->get_field_id('title'); ?>">
	<?php _e('Title:','highthemes'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
		esc_attr($title); ?>" /></p>   

	<p>
	<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
		<?php foreach ($of_categories as $key => $value) {
			$selected = ($category == $key) ? 'selected="selected"' : '';
			echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
		}
		?>
	</select>
	</p>	 
        
    <p><label for="<?php echo $this->get_field_id('posts_number'); ?>">
	<?php _e('Number of Posts:','highthemes'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('posts_number'); ?>" name="<?php echo $this->get_field_name('posts_number'); ?>" type="text" value="<?php echo
		esc_attr($posts_number); ?>" /></p>

	<?php
	}
	}
