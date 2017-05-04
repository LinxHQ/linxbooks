<?php
 
class RevSlider_TinyBox {
	
    public function __construct(){
		add_action('admin_head', array('RevSlider_TinyBox', 'my_print_shortcodes_in_js'));
		add_action('admin_head', array('RevSlider_TinyBox', 'my_add_tinymce'));
    }
	
	public static function my_print_shortcodes_in_js(){
		$sld = new RevSlider();
		$sliders = $sld->getArrSliders();
		$shortcodes = '';
		if(!empty($sliders)){
			$first = true;
			foreach($sliders as $slider){
				$shortcode = $slider->getParam('shortcode','false');
				if($shortcode != 'false'){
					if(!$first) $shortcodes .= ',';
					
					$shortcodes.="'".$shortcode."'";
					$first = false;
				}
			}
		}
		?>
		<script type="text/javascript">
			var revslider_shortcodes = [<?php echo $shortcodes; ?>];
		</script>
		<?php
	}
	
	public static function my_add_tinymce() {
		add_filter('mce_external_plugins', array('RevSlider_TinyBox', 'my_add_tinymce_plugin'));
		add_filter('mce_buttons', array('RevSlider_TinyBox', 'my_add_tinymce_button'));
	}
	 
	public static function my_add_tinymce_plugin($plugin_array) {
		$version = get_bloginfo('version'); 
		if($version<3.9)
			$plugin_array['revslider'] = plugins_url('../js/tbld.js',__FILE__);
		else
			$plugin_array['revslider'] = plugins_url('../js/tbld-3.9.js',__FILE__);
			
		return $plugin_array;
	}
	 
	public static function my_add_tinymce_button($buttons) {
		array_push($buttons, 'revslider');
		return $buttons;
	}

}


?>