<?php
class ht_socials extends WP_Widget {

	public function __construct() {
			global  $theme_name;
			$widget_ops = array('classname' => 'ht_socials_widget clearfix',
							'description' => __( 'Display social icons','highthemes') );
			parent::__construct(
				'ht_socials', 
				'Highthemes - ' . __('Social Icons','highthemes'), 
				 $widget_ops // Args
			);
	}


	// list of available socials
	public $social_list = array(
			"rss_id"       => "RSS",
			"twitter_id"   => "Twitter",
			"facebook_id"  => "Facebook",
			"gplus_id"     => "Google Plus",
			"flickr_id"    => "Flickr",
			"linkedin_id"  => "LinkedIn",
			"dribbble_id"   => "Dribbble",
			"github_id"    => "Github",
			"tumblr_id"    => "Tumblr",
			"skype_id"     => "Skype",
			"dropbox_id"   => "Dropbox",
			"instagram_id" => "Instagram",
			"youtube_id"   => "Youtube",
			"pinterest_id" => "Pinterest",
			"email_id"     => "Email"

		);	


	public $social_icon_names = array(
			"rss_id"       => "fa-rss",
			"twitter_id"   => "fa-twitter",
			"facebook_id"  => "fa-facebook",
			"gplus_id"     => "fa-google-plus",
			"flickr_id"    => "fa-flickr",
			"linkedin_id"  => "fa-linkedin",
			"dribbble_id"  => "fa-dribbble",
			"github_id"    => "fa-github",
			"tumblr_id"    => "fa-tumblr",
			"skype_id"     => "fa-skype",
			"dropbox_id"   => "fa-dropbox",
			"instagram_id" => "fa-instagram",
			"youtube_id"   => "fa-youtube",
			"pinterest_id" => "fa-pinterest",
			"email_id"     => "fa-envelope"

		);		

	
	// display the widget in the theme
	function widget( $args, $instance ) {
		global $ht_options;

		extract( $args );
		// getting the checked socials
		$social_values = array();
		foreach($this->social_list as $index=>$value) {
			$social_values[$index] = $instance[$index];
		}


		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);		

		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;

		// list of final socials
		$socials = array();

        /* Display a containing div */
        echo '<div class="social social_head">';
		global $ht_options;

		$target = ($ht_options['social_menu_target'] == 1) ? '_blank' : '_self' ;
        foreach($social_values as $key=>$social_status){
        	if( $social_values[$key]){
        		if($key =='email_id') {
        			$socials[] = '<a target="'. $target.'" class="toptip" title="'. $this->social_list[$key].'" href="mailto:' . $ht_options[$key] . '"><i class="'.$this->social_icon_names[$key].'"></i></a>';

        		} else {
        			$socials[] = '<a target="'. $target.'" class="toptip" title="'. $this->social_list[$key].'" href="' . $ht_options[$key] . '"><i class="'.$this->social_icon_names[$key].'"></i></a>';
        		}
			
        	}
        }
		
		foreach($socials as $social){
			echo $social;
		}
		
		echo '</div>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		

		foreach($this->social_list as $key=>$value) {
			$instance[$key] = $new_instance[$key];
		}
				
		return $instance;
	}
		
	function form( $instance ) {
		global $ht_options;
	
		/* Set up some default widget settings. */
			$title =  strip_tags($instance['title']);

		foreach($this->social_list as $key=>$value) {
			$defaults[$key] = '';
		}
	
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:','highthemes'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
			esc_attr($title); ?>" /></p>    
        
		<?php 

		foreach($this->social_list as $key=>$value) {
		?>
		<p>
			<?php if ($instance[$key]){ ?>
				<input type="checkbox" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" checked="checked" />
			<?php } else { ?>
				<input type="checkbox" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>"  />
			<?php } ?>
 		<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label>

		</p>
		<?php
		}

	}
}