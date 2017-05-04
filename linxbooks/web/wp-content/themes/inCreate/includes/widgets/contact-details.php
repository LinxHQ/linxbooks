<?php
/**
 * Highthemes Contact Details
 */

class ht_contact_details extends WP_Widget {

	public function __construct() {
		global  $theme_name;
		$widget_ops = array('classname' => 'ht_contact_details',
							'description' => __( 'Contact Details for Sidebar','highthemes') );

		parent::__construct(
			'ht_contact_details', 
			'Highthemes - ' . __('Contact Details','highthemes'), 
			 $widget_ops // Args
		);
	}	

	// display the widget in the theme
	function widget( $args, $instance ) {
		extract($args);

		if(isset($instance['contact_text'])) $instance['contact_text'] = stripslashes($instance['contact_text']);
		if(isset($instance['contact_details'])) $instance['contact_details'] = stripslashes($instance['contact_details']);

		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		
		echo $before_widget;
				


?>
<div class="contact-details"> 
            <?php if ( $title ) echo $before_title . $title . $after_title; ?>
            <p><?php echo stripslashes($instance['contact_text']); ;?> </p>
            <ul>
              <?php echo stripslashes($instance['contact_details']);?>
            </ul>
          </div>

<?php
		echo $after_widget;
		
		//end
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['contact_text'] = $new_instance['contact_text'];
		$instance['contact_details'] = $new_instance['contact_details'];

		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array('title'=>'Contact Details', 'contact_text'=>'lorem ipsum dolor sit amet', 'contact_details'=>'<li><i class="fa-home"></i>1736 Nutters Barn Lane Clarion, LA 50525</li><li><i class="fa-phone"></i> 111-5252-8568</li><li><i class="fa-print"></i> 111-9858-858</li><li><i class="fa-envelope"></i>email@gmail.com</li><li><i class="fa-globe"></i>www.site.com</li>' ) );
	$contact_text = $instance['contact_text'];
	$contact_details = $instance['contact_details'];
	$title =  strip_tags($instance['title']);

	
	
	// print the form fields
?>

    <div class="contact-details">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','highthemes') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo
		esc_attr($title); ?>" />
		</p>

        <p><label for="<?php echo $this->get_field_id('contact_text'); ?>">
        <?php _e('Text:','highthemes'); ?></label>
            <textarea cols="36" rows="5" name="<?php echo $this->get_field_name('contact_text'); ?>" id="<?php echo $this->get_field_id('contact_text'); ?>"><?php echo
            esc_attr($contact_text); ?></textarea>
        </p>
        <p><label for="<?php echo $this->get_field_id('contact_details'); ?>">
        <?php _e('Contact Details:','highthemes'); ?></label>
            <textarea cols="36" rows="15" name="<?php echo $this->get_field_name('contact_details'); ?>" id="<?php echo $this->get_field_id('contact_details'); ?>"><?php echo
            esc_attr($contact_details); ?></textarea>
            </p>

    </div>
	<?php
	}
	}
