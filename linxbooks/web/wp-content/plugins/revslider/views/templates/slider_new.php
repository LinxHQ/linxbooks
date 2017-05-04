	<div class="wrap settings_wrap">
		<div class="clear_both"></div>
			<div class="title_line">
				<div id="icon-options-general" class="icon32"></div>
				<?php
				if($sliderTemplate){
					?>
					<div class="view_title"><i class="revicon-pencil-1"></i><?php _e("New Slider Template",REVSLIDER_TEXTDOMAIN)?></div>
					<?php
					$template_value = 'true';
				}else{
					?>
					<div class="view_title"><i class="revicon-pencil-1"></i><?php _e("New Slider",REVSLIDER_TEXTDOMAIN)?></div>
					<?php
					$template_value = 'false';
				}
				?>
				<input type="hidden" id="revslider_template" value="<?php echo $template_value; ?>"></input>

				<a href="<?php echo GlobalsRevSlider::LINK_HELP_SLIDER?>" class="button-secondary float_right mtop_10 mleft_10" target="_blank"><?php _e("Help",REVSLIDER_TEXTDOMAIN)?></a>

			</div>
			<div class="settings_panel">
				<div class="settings_panel_left">
					<div id="main_dlier_settings_wrapper" class="postbox unite-postbox ">
					  <h3 class="box-closed"><span><?php _e("Main Slider Settings",REVSLIDER_TEXTDOMAIN) ?></span></h3>
					  <div class="p10">
							<?php $settingsSliderMain->draw("form_slider_main",true)?>

							<div id="layout-preshow">
								<strong>Layout Example</strong><?php _e("(Can be different based on Theme Style)",REVSLIDER_TEXTDOMAIN)?>
								<div class="divide20"></div>
								<div id="layout-preshow-page">
									<div class="layout-preshow-text">BROWSER</div>
									<div id="layout-preshow-theme">
											<div class="layout-preshow-text">PAGE</div>
									</div>
									<div id="layout-preshow-slider">
											<div class="layout-preshow-text">SLIDER</div>
									</div>
									<div id="layout-preshow-grid">
											<div class="layout-preshow-text">LAYERS GRID</div>										
									</div>
								</div>
							</div>
							
							<div class="divide20"></div>
							<a id="button_save_slider" class='button-primary revgreen' href='javascript:void(0)' ><i class="revicon-cog"></i><span id="create_slider_text"><?php _e("Create Slider",REVSLIDER_TEXTDOMAIN)?></span></a>

							<span class="hor_sap"></span>
							<a id="button_cancel_save_slider" class='button-primary revred' href='<?php echo self::getViewUrl("sliders") ?>' ><i class="revicon-cancel"></i><?php _e("Close",REVSLIDER_TEXTDOMAIN)?> </a>
					  </div>
					</div>
				</div>
				<div class="settings_panel_right">
					<?php $settingsSliderParams->draw("form_slider_params",true); ?>
				</div>
				<div class="clear"></div>
			</div>
	</div>

	<script type="text/javascript">
		var g_jsonTaxWithCats = <?php echo $jsonTaxWithCats?>;

		jQuery(document).ready(function(){

			RevSliderAdmin.initAddSliderView();
			
			<?php if($sliderTemplate){ ?>
			RevSliderAdmin.initSliderViewTemplate();
			<?php } ?>
		});
	</script>

