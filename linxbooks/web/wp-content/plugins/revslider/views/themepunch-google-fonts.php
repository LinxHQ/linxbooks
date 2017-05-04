<?php
/**
 * @package   Revolution Slider
 * @author    ThemePunch <info@themepunch.com>
 * @link      http://www.themepunch.com/revolution/
 * @copyright 2014 ThemePunch
 */
 
 
 
 ?>
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>

	<div id="eg-grid-google-font-wrapper">
		<?php
		$fonts = new ThemePunch_Fonts();
		$custom_fonts = $fonts->get_all_fonts();
		
		if(!empty($custom_fonts)){
			foreach($custom_fonts as $font){
				$cur_font = $font['url'];
				$cur_font = explode('+', $cur_font);
				$cur_font = implode(' ', $cur_font);
				$cur_font = explode(':', $cur_font);
				
				$title = $cur_font['0'];
				
				?>
				<div class="postbox eg-postbox" style="width:100%;min-width:500px">
					<h3 class="box-closed"><span style="font-weight:400"><?php _e('Font Family:', REVSLIDER_TEXTDOMAIN); ?></span><span style="text-transform:uppercase;"><?php echo $title; ?> </span><div class="postbox-arrow"></div></h3>
					<div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;background:#ebebeb">
						<div class="tp-googlefont-row">
							<div class="eg-cus-row-l"><label><?php _e('Handle:', REVSLIDER_TEXTDOMAIN); ?></label> tp-<input type="text" name="esg-font-handle[]" value="<?php echo @$font['handle']; ?>" readonly="readonly"></div>
							<div class="eg-cus-row-l"><label><?php _e('Parameter:', REVSLIDER_TEXTDOMAIN); ?></label><input type="text" name="esg-font-url[]" value="<?php echo @$font['url']; ?>"></div>
						</div>
						<div class="tp-googlefont-save-wrap-settings">
							<a class="button-primary revblue eg-font-edit" href="javascript:void(0);"><?php _e('Edit', REVSLIDER_TEXTDOMAIN); ?></a>
							<a class="button-primary revred eg-font-delete" href="javascript:void(0);"><?php _e('Remove', REVSLIDER_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		<div>
			<i style="font-size:10px;color:#777"><?php _e('Copy the Google Font Family from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a> like: <strong>Open+Sans:400,700,600</strong>', REVSLIDER_TEXTDOMAIN); ?></i>
		</div>
	</div>

	<a class="button-primary revblue" id="eg-font-add" href="javascript:void(0);"><?php _e('Add New Font', REVSLIDER_TEXTDOMAIN); ?></a>
	
	<div id="font-dialog-wrap" class="essential-dialog-wrap" title="<?php _e('Add Font', REVSLIDER_TEXTDOMAIN); ?>"  style="display: none; padding:20px !important;">
		
		<div class="tp-googlefont-cus-row-l"><label><?php _e('Handle:', REVSLIDER_TEXTDOMAIN); ?></label><span style="margin-left:-20px;margin-right:2px;"><strong>tp-</strong></span><input type="text" name="eg-font-handle" value="" /></div>
		<div style="margin-top:0px; padding-left:100px; margin-bottom:20px;">
			<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Unique WordPress handle (Internal use only)', REVSLIDER_TEXTDOMAIN); ?></i>
		</div>
		<div class="tp-googlefont-cus-row-l"><label><?php _e('Parameter:', REVSLIDER_TEXTDOMAIN); ?></label><input type="text" name="eg-font-url" value="" /></div>
		<div style="padding-left:100px;">
			<i style="font-size:12px;color:#777; line-height:20px;"><?php _e('Copy the Google Font Family from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a><br/>i.e.:<strong>Open+Sans:400,600,700</strong>', REVSLIDER_TEXTDOMAIN); ?></i>
		</div>
		
	</div>
	
	
	<script type="text/javascript">
		jQuery(function(){
			UniteAdminRev.initGoogleFonts();
			UniteAdminRev.initAccordion();
		});
	</script>