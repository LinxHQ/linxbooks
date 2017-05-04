
	<div class="edit_slide_wrapper<?php echo ($slide->isStaticSlide()) ? ' rev_static_layers' : ''; ?>">
		<?php
		
		if(!$slide->isStaticSlide()){
			?>
			<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important;">
				<h3 class="box-closed tp-accordion">
					<span class="postbox-arrow2">-</span><span><?php _e("Slider Main Image / Background",REVSLIDER_TEXTDOMAIN) ?></span>
				</h3>
				<div class="toggled-content">
					<div class="inner_wrapper p10 pb0 pt0 boxsized">
						<div class="editor_buttons_wrapper_top">
							<h3 style="cursor:default !important; background:none !important;border:none;box-shadow:none !important;font-size:12px;padding:0px;margin:10px 0px 0px;"><?php _e("Background Source:",REVSLIDER_TEXTDOMAIN)?></h3>

							<!-- IMAGE FROM MEDIAGALLERY -->
							<input style="float:left" type="radio" name="radio_bgtype" class="bgsrcchanger" data-callid="tp-bgimagewpsrc" data-imgsettings="on" data-bgtype="image" id="radio_back_image" <?php if($bgType == "image") echo 'checked="checked"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"  for="radio_back_image"><?php _e("Image BG",REVSLIDER_TEXTDOMAIN)?></label>
							<!-- THE BG IMAGE CHANGED DIV -->
							<div id="tp-bgimagewpsrc" class="bgsrcchanger-div" style="display:none;float:left;margin-top:-7px;">
								<a href="javascript:void(0)" id="button_change_image" class="button-primary revblue <?php if($bgType != "image") echo "button-disabled" ?>" style="margin-bottom:5px"><?php _e("Change Image",REVSLIDER_TEXTDOMAIN)?></a>
							</div>

							<!-- IMAGE FROM EXTERNAL -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="tp-bgimageextsrc" data-imgsettings="on" class="bgsrcchanger" data-bgtype="external" id="radio_back_external" <?php if($bgType == "external") echo 'checked="solid"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_external"><?php _e("External URL",REVSLIDER_TEXTDOMAIN)?></label>
							<!-- THE BG IMAGE FROM EXTERNAL SOURCE -->
							<div id="tp-bgimageextsrc" class="bgsrcchanger-div" style="display:none;float:left;margin-top:-7px;">
								<input type="text" name="bg_external" id="slide_bg_external" value="<?php echo $slideBGExternal?>" <?php echo ($bgType != 'external') ? ' class="disabled"' : ''; ?>>
								<a href="javascript:void(0)" id="button_change_external" class="button-primary revblue <?php if($bgType != "external") echo "button-disabled" ?>" style="margin-bottom:5px"><?php _e("Get External",REVSLIDER_TEXTDOMAIN)?></a>
							</div>

							<!-- TRANSPARENT BACKGROUND -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="" class="bgsrcchanger" data-bgtype="trans" id="radio_back_trans" <?php if($bgType == "trans") echo 'checked="checked"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_trans"><?php _e("Transparent",REVSLIDER_TEXTDOMAIN)?></label>

							<!-- COLORED BACKGROUND -->
							<input type="radio" name="radio_bgtype" style="float:left;margin-left:15px;" data-callid="tp-bgcolorsrc" class="bgsrcchanger" data-bgtype="solid" id="radio_back_solid" <?php if($bgType == "solid") echo 'checked="solid"'?>>
							<label style="float:left;margin-left:5px;margin-top:2px;"for="radio_back_solid"><?php _e("Solid Colored",REVSLIDER_TEXTDOMAIN)?></label>

							<!-- THE COLOR SELECTOR -->
							<div id="tp-bgcolorsrc"  class="bgsrcchanger-div"  style="display:none;float:left;margin-top:-5px;">
								<input type="text" name="bg_color" id="slide_bg_color" <?php echo $bgSolidPickerProps?> value="<?php echo $slideBGColor?>">
							</div>
							
							<div style="clear:both"></div>
							<!-- PREVIEW BUTTON -->
							<!-- THE BG IMAGE SETTINGS -->
							<div id="tp-bgimagesettings" class="bgsrcchanger-div" style="margin-top:10px;display:none">
								<div id="bg-setting-wrap">
									<h3 style="cursor:default !important; background:none !important;border:none;box-shadow:none !important;font-size:12px;padding:0px;margin:17px 0px 0px;"><?php _e("Background Settings:",REVSLIDER_TEXTDOMAIN)?></h3>
									<label for="slide_bg_fit"><?php _e("Background Fit:",REVSLIDER_TEXTDOMAIN)?></label>
									<select name="bg_fit" id="slide_bg_fit" style="margin-right:20px">
										<option value="cover"<?php if($bgFit == 'cover') echo ' selected="selected"'; ?>>cover</option>
										<option value="contain"<?php if($bgFit == 'contain') echo ' selected="selected"'; ?>>contain</option>
										<option value="percentage"<?php if($bgFit == 'percentage') echo ' selected="selected"'; ?>>(%, %)</option>
										<option value="normal"<?php if($bgFit == 'normal') echo ' selected="selected"'; ?>>normal</option>
									</select>
									<input type="text" name="bg_fit_x" style="<?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px" value="<?php echo $bgFitX; ?>" />
									<input type="text" name="bg_fit_y" style="<?php if($bgFit != 'percentage') echo 'display: none; '; ?> width:60px;margin-right:10px"  value="<?php echo $bgFitY; ?>" />

									<label for="slide_bg_repeat"><?php _e("Background Repeat:",REVSLIDER_TEXTDOMAIN)?></label>
									<select name="bg_repeat" id="slide_bg_repeat" style="margin-right:20px">
										<option value="no-repeat"<?php if($bgRepeat == 'no-repeat') echo ' selected="selected"'; ?>>no-repeat</option>
										<option value="repeat"<?php if($bgRepeat == 'repeat') echo ' selected="selected"'; ?>>repeat</option>
										<option value="repeat-x"<?php if($bgRepeat == 'repeat-x') echo ' selected="selected"'; ?>>repeat-x</option>
										<option value="repeat-y"<?php if($bgRepeat == 'repeat-y') echo ' selected="selected"'; ?>>repeat-y</option>
									</select>
									<label for="slide_bg_position" id="bg-position-lbl"><?php _e("Background Position:",REVSLIDER_TEXTDOMAIN)?></label>
									<div id="bg-start-position-wrapper">
										<select name="bg_position" id="slide_bg_position">
											<option value="center top"<?php if($bgPosition == 'center top') echo ' selected="selected"'; ?>>center top</option>
											<option value="center right"<?php if($bgPosition == 'center right') echo ' selected="selected"'; ?>>center right</option>
											<option value="center bottom"<?php if($bgPosition == 'center bottom') echo ' selected="selected"'; ?>>center bottom</option>
											<option value="center center"<?php if($bgPosition == 'center center') echo ' selected="selected"'; ?>>center center</option>
											<option value="left top"<?php if($bgPosition == 'left top') echo ' selected="selected"'; ?>>left top</option>
											<option value="left center"<?php if($bgPosition == 'left center') echo ' selected="selected"'; ?>>left center</option>
											<option value="left bottom"<?php if($bgPosition == 'left bottom') echo ' selected="selected"'; ?>>left bottom</option>
											<option value="right top"<?php if($bgPosition == 'right top') echo ' selected="selected"'; ?>>right top</option>
											<option value="right center"<?php if($bgPosition == 'right center') echo ' selected="selected"'; ?>>right center</option>
											<option value="right bottom"<?php if($bgPosition == 'right bottom') echo ' selected="selected"'; ?>>right bottom</option>
											<option value="percentage"<?php if($bgPosition == 'percentage') echo ' selected="selected"'; ?>>(x%, y%)</option>
										</select><input type="text" name="bg_position_x" <?php if($bgPosition != 'percentage') echo ' style="display: none;"'; ?> value="<?php echo $bgPositionX; ?>" /><input type="text" name="bg_position_y" <?php if($bgPosition != 'percentage') echo ' style="display: none;"'; ?> value="<?php echo $bgPositionY; ?>" />
									</div>
								</div>
								<div style="clear:both"></div>
								<h3 style="cursor:default !important; background:none !important;border:none;box-shadow:none !important;font-size:12px;padding:0px;margin:17px 0px 0px; float: left;"><?php _e("Ken Burns / Pan Zoom Settings:",REVSLIDER_TEXTDOMAIN)?></h3>

								<div style="margin-top: 15px; margin-left: 10px; float: left;">
									<input type="radio" name="kenburn_effect" value="on" <?php echo ($kenburn_effect == 'on') ? 'checked="checked"' : ''; ?> /> <?php _e("On",REVSLIDER_TEXTDOMAIN)?>&nbsp;&nbsp;<input type="radio" name="kenburn_effect" value="off" <?php echo ($kenburn_effect == 'off') ? 'checked="checked"' : ''; ?> /> <?php _e("Off",REVSLIDER_TEXTDOMAIN)?>
								</div>
								<div class="clear"></div>

								<table id="kenburn_wrapper" <?php echo ($kenburn_effect == 'off') ? 'style="display: none;"' : ''; ?>>
									<tr>
										<td><?php _e("Background",REVSLIDER_TEXTDOMAIN)?></td>
										<td></td>
										<td></td>
										<td style="width: 15px;">&nbsp;</td>
										<td></td>
										<td>&nbsp;<?php //_e("Start",REVSLIDER_TEXTDOMAIN)?></td>
										<td><?php //_e("End",REVSLIDER_TEXTDOMAIN)?></td>
										<td style="width: 15px;">&nbsp;</td>
										<td colspan="2"></td>
									</tr>
									<tr>
										<td><?php _e("Start Position:",REVSLIDER_TEXTDOMAIN)?></td>
										<td colspan="2" id="bg-start-position-wrapper-kb">

										</td>
										<td></td>
										<td><?php _e("Start Fit: (in %)",REVSLIDER_TEXTDOMAIN)?></td>
										<td colspan="2"><input type="text" name="kb_start_fit" value="<?php echo intval($kb_start_fit); ?>" /></td>
										<td></td>
										<td><?php _e("Easing:",REVSLIDER_TEXTDOMAIN)?></td>
										<td>
											<select name="kb_easing">
												<option <?php if($kb_easing == 'Linear.easeNone') echo ' selected="selected"'; ?> value="Linear.easeNone">Linear.easeNone</option>
												<option <?php if($kb_easing == 'Power0.easeIn') echo ' selected="selected"'; ?> value="Power0.easeIn">Power0.easeIn  (linear)</option>
												<option <?php if($kb_easing == 'Power0.easeInOut') echo ' selected="selected"'; ?> value="Power0.easeInOut">Power0.easeInOut  (linear)</option>
												<option <?php if($kb_easing == 'Power0.easeOut') echo ' selected="selected"'; ?> value="Power0.easeOut">Power0.easeOut  (linear)</option>
												<option <?php if($kb_easing == 'Power1.easeIn') echo ' selected="selected"'; ?> value="Power1.easeIn">Power1.easeIn</option>
												<option <?php if($kb_easing == 'Power1.easeInOut') echo ' selected="selected"'; ?> value="Power1.easeInOut">Power1.easeInOut</option>
												<option <?php if($kb_easing == 'Power1.easeOut') echo ' selected="selected"'; ?> value="Power1.easeOut">Power1.easeOut</option>
												<option <?php if($kb_easing == 'Power2.easeIn') echo ' selected="selected"'; ?> value="Power2.easeIn">Power2.easeIn</option>
												<option <?php if($kb_easing == 'Power2.easeInOut') echo ' selected="selected"'; ?> value="Power2.easeInOut">Power2.easeInOut</option>
												<option <?php if($kb_easing == 'Power2.easeOut') echo ' selected="selected"'; ?> value="Power2.easeOut">Power2.easeOut</option>
												<option <?php if($kb_easing == 'Power3.easeIn') echo ' selected="selected"'; ?> value="Power3.easeIn">Power3.easeIn</option>
												<option <?php if($kb_easing == 'Power3.easeInOut') echo ' selected="selected"'; ?> value="Power3.easeInOut">Power3.easeInOut</option>
												<option <?php if($kb_easing == 'Power3.easeOut') echo ' selected="selected"'; ?> value="Power3.easeOut">Power3.easeOut</option>
												<option <?php if($kb_easing == 'Power4.easeIn') echo ' selected="selected"'; ?> value="Power4.easeIn">Power4.easeIn</option>
												<option <?php if($kb_easing == 'Power4.easeInOut') echo ' selected="selected"'; ?> value="Power4.easeInOut">Power4.easeInOut</option>
												<option <?php if($kb_easing == 'Power4.easeOut') echo ' selected="selected"'; ?> value="Power4.easeOut">Power4.easeOut</option>
												<option <?php if($kb_easing == 'Back.easeIn') echo ' selected="selected"'; ?> value="Back.easeIn">Back.easeIn</option>
												<option <?php if($kb_easing == 'Back.easeInOut') echo ' selected="selected"'; ?> value="Back.easeInOut">Back.easeInOut</option>
												<option <?php if($kb_easing == 'Back.easeOut') echo ' selected="selected"'; ?> value="Back.easeOut">Back.easeOut</option>
												<option <?php if($kb_easing == 'Bounce.easeIn') echo ' selected="selected"'; ?> value="Bounce.easeIn">Bounce.easeIn</option>
												<option <?php if($kb_easing == 'Bounce.easeInOut') echo ' selected="selected"'; ?> value="Bounce.easeInOut">Bounce.easeInOut</option>
												<option <?php if($kb_easing == 'Bounce.easeOut') echo ' selected="selected"'; ?> value="Bounce.easeOut">Bounce.easeOut</option>
												<option <?php if($kb_easing == 'Circ.easeIn') echo ' selected="selected"'; ?> value="Circ.easeIn">Circ.easeIn</option>
												<option <?php if($kb_easing == 'Circ.easeInOut') echo ' selected="selected"'; ?> value="Circ.easeInOut">Circ.easeInOut</option>
												<option <?php if($kb_easing == 'Circ.easeOut') echo ' selected="selected"'; ?> value="Circ.easeOut">Circ.easeOut</option>
												<option <?php if($kb_easing == 'Elastic.easeIn') echo ' selected="selected"'; ?> value="Elastic.easeIn">Elastic.easeIn</option>
												<option <?php if($kb_easing == 'Elastic.easeInOut') echo ' selected="selected"'; ?> value="Elastic.easeInOut">Elastic.easeInOut</option>
												<option <?php if($kb_easing == 'Elastic.easeOut') echo ' selected="selected"'; ?> value="Elastic.easeOut">Elastic.easeOut</option>
												<option <?php if($kb_easing == 'Expo.easeIn') echo ' selected="selected"'; ?> value="Expo.easeIn">Expo.easeIn</option>
												<option <?php if($kb_easing == 'Expo.easeInOut') echo ' selected="selected"'; ?> value="Expo.easeInOut">Expo.easeInOut</option>
												<option <?php if($kb_easing == 'Expo.easeOut') echo ' selected="selected"'; ?> value="Expo.easeOut">Expo.easeOut</option>
												<option <?php if($kb_easing == 'Sine.easeIn') echo ' selected="selected"'; ?> value="Sine.easeIn">Sine.easeIn</option>
												<option <?php if($kb_easing == 'Sine.easeInOut') echo ' selected="selected"'; ?> value="Sine.easeInOut">Sine.easeInOut</option>
												<option <?php if($kb_easing == 'Sine.easeOut') echo ' selected="selected"'; ?> value="Sine.easeOut">Sine.easeOut</option>
												<option <?php if($kb_easing == 'SlowMo.ease') echo ' selected="selected"'; ?> value="SlowMo.ease">SlowMo.ease</option>
											</select>
										</td>
									</tr>
									<tr>
										<td><?php _e("End Position:",REVSLIDER_TEXTDOMAIN)?></td>
										<td colspan="2">
											<select name="bg_end_position" id="slide_bg_end_position">
												<option value="center top"<?php if($bgEndPosition == 'center top') echo ' selected="selected"'; ?>>center top</option>
												<option value="center right"<?php if($bgEndPosition == 'center right') echo ' selected="selected"'; ?>>center right</option>
												<option value="center bottom"<?php if($bgEndPosition == 'center bottom') echo ' selected="selected"'; ?>>center bottom</option>
												<option value="center center"<?php if($bgEndPosition == 'center center') echo ' selected="selected"'; ?>>center center</option>
												<option value="left top"<?php if($bgEndPosition == 'left top') echo ' selected="selected"'; ?>>left top</option>
												<option value="left center"<?php if($bgEndPosition == 'left center') echo ' selected="selected"'; ?>>left center</option>
												<option value="left bottom"<?php if($bgEndPosition == 'left bottom') echo ' selected="selected"'; ?>>left bottom</option>
												<option value="right top"<?php if($bgEndPosition == 'right top') echo ' selected="selected"'; ?>>right top</option>
												<option value="right center"<?php if($bgEndPosition == 'right center') echo ' selected="selected"'; ?>>right center</option>
												<option value="right bottom"<?php if($bgEndPosition == 'right bottom') echo ' selected="selected"'; ?>>right bottom</option>
												<option value="percentage"<?php if($bgEndPosition == 'percentage') echo ' selected="selected"'; ?>>(x%, y%)</option>
											</select><input type="text" name="bg_end_position_x" <?php if($bgEndPosition != 'percentage') echo ' style="display: none;"'; ?> value="<?php echo $bgEndPositionX; ?>" /><input type="text" name="bg_end_position_y" <?php if($bgEndPosition != 'percentage') echo ' style="display: none;"'; ?> value="<?php echo $bgEndPositionY; ?>" />
										</td>
										<td></td>
										<td><?php _e("End Fit: (in %)",REVSLIDER_TEXTDOMAIN)?></td>
										<td colspan="2"><input type="text" name="kb_end_fit" value="<?php echo intval($kb_end_fit); ?>" /></td>
										<?php /*<td>_e("Rotation (in °):",REVSLIDER_TEXTDOMAIN) ?></td>
										<td><input type="text" name="kb_rotation_start" value="<?php echo intval($kb_rotation_start); ?>" /></td>
										<td><input type="text" name="kb_rotation_end" value="<?php echo intval($kb_rotation_end); ?>" /></td>*/?>
										<td></td>
										<td><?php _e("Duration (in ms):",REVSLIDER_TEXTDOMAIN)?></td>
										<td><input type="text" name="kb_duration" value="<?php echo intval($kb_duration); ?>" /></td>
									</tr>

								</table>

							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>

			<div class="clear"></div>

			<div class="divide20"></div>
			
			<?php
		}
		?>
		<?php
		$slidertype = $slider->getParam("slider_type","fullwidth");
		if($slidertype == 'fullwidth'){
			$style .= ' margin: 0 auto;';
			$style_wrapper .= ' width: 100%;';
		}else{
			$style_wrapper .= $style;
		}
		?>
		<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important;">
			<h3 class="box-closed tp-accordion">
				<span><?php if($slide->isStaticSlide()){ _e("Static / Global Layers",REVSLIDER_TEXTDOMAIN); }else{ ?><?php _e("Slide",REVSLIDER_TEXTDOMAIN); }?></span>
			</h3>
			<div class="layer-editor-toolbar">
				<span class="setting_text_3"><?php _e("Helper Grid:",REVSLIDER_TEXTDOMAIN) ?></span>
				<select name="rs-grid-sizes" id="rs-grid-sizes">
					<option value="1"><?php _e("Disabled",REVSLIDER_TEXTDOMAIN) ?></option>
					<option value="5">5 x 5</option>
					<option value="10">10 x 10</option>
					<option value="25">25 x 25</option>
					<option value="50">50 x 50</option>
				</select>
				
				<span class="setting_text_3"><?php _e("Snap to:",REVSLIDER_TEXTDOMAIN) ?></span>
				<select name="rs-grid-snapto" id="rs-grid-snapto">
					<option value=""><?php _e("None",REVSLIDER_TEXTDOMAIN) ?></option>
					<option value=".helplines"><?php _e("Help Lines",REVSLIDER_TEXTDOMAIN) ?></option>
					<option value=".slide_layer"><?php _e("Layers",REVSLIDER_TEXTDOMAIN) ?></option>
				</select>
				
				<?php
				//show/hide layers of specific slides
				if($slide->isStaticSlide()){
					$all_slides = $slider->getSlides(true);
					?>
					<span class="setting_text_3"><?php _e("Show Layers from Slide:",REVSLIDER_TEXTDOMAIN) ?></span>
					<select name="rev_show_the_slides">
						<option value="none">---</option>
						<?php
						foreach($all_slides as $c_slide){
							
							$c_params = $c_slide->getParams();
							?>
							<option value="<?php echo $c_slide->getID(); ?>"><?php echo UniteFunctionsRev::getVal($c_params, "title", 'Slide').' (ID: '.$c_slide->getID().')'; ?></option>
							<?php
						}
						?>
					</select>
					<?php
				}
				?>
				
			</div>
			<div id="divLayers-wrapper" style="<?php echo $style; ?>" class="slide_wrap_layers" >
				<div id="divbgholder" style="<?php echo $style_wrapper.$divbgminwidth; ?>" class="<?php echo $class_wrapper; ?>"></div>
				<div id="divLayers" class="<?php echo $divLayersClass?>" style="<?php echo $style.$divLayersWidth; ?>"></div>
			</div>
			<div class="clear"></div>
			<div class="editor_buttons_wrapper  postbox unite-postbox" style="max-width:100% !important;">
			<div style="width:100%; border-top:1px solid #f1f1f1; margin-top:0px;"></div>
			<div class="toggled-content">
				<div class="inner_wrapper p10 pb0 pt0 boxsized">
					<?php
					//show/hide layers of specific slides
					$add_static = 'false';
					if($slide->isStaticSlide()){
						$add_static = 'true';
					}
					?>
					<div class="editor_buttons_wrapper_bottom">
						<div style="float:left">
							<a href="javascript:void(0)" id="button_add_layer" 		 data-isstatic="<?php echo $add_static; ?>" class="button-primary revblue"><i class="revicon-layers-alt"></i><?php _e("Add Layer",REVSLIDER_TEXTDOMAIN)?></a>
							<a href="javascript:void(0)" id="button_add_layer_image" data-isstatic="<?php echo $add_static; ?>" class="button-primary revblue"><i class="revicon-picture-1"></i><?php _e("Add Layer: Image",REVSLIDER_TEXTDOMAIN)?> </a>
							<a href="javascript:void(0)" id="button_add_layer_video" data-isstatic="<?php echo $add_static; ?>" class="button-primary revblue"><i class="revicon-video"></i><?php _e("Add Layer: Video",REVSLIDER_TEXTDOMAIN)?> </a>
							<a href="javascript:void(0)" id="button_duplicate_layer" class="button-primary revyellow button-disabled"><i class="revicon-picture"></i><?php _e("Duplicate Layer",REVSLIDER_TEXTDOMAIN)?></a>
						</div>
						<div style="float:right;">
							<a href="javascript:void(0)" id="button_delete_layer"    class="button-primary  revred button-disabled"><i class="revicon-trash"></i><?php _e("Delete Layer",REVSLIDER_TEXTDOMAIN)?></a>
							<a href="javascript:void(0)" id="button_delete_all"      class="button-primary  revred button-disabled"><i class="revicon-trash"></i><?php _e("Delete All Layers",REVSLIDER_TEXTDOMAIN)?> </a>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
		<div class="clear"></div>
		<div class="divide20"></div>
			<div class="layer_props_wrapper">
				<div class="edit_layers_right" style="position:relative;height:100%">
					<div class="postbox unite-postbox layer_sortbox" style="height:100%;">
						<div class="open_right_panel">
							<div class="open_right_panel_bullet"></div>
							<div class="open_right_panel_bullet bulsecond"></div>
							<div class="open_right_panel_bullet bulthird"></div>																		
						</div>							
						<h3 class="no-accordion">
							<span><?php _e("Layers Timing & Sorting",REVSLIDER_TEXTDOMAIN)?></span>																																				
						</h3>
						<div style="display:table; line-height:30px">
							<div style="display:table-cell; padding:10px 15px; min-width:45px;"><?php _e("z-Index",REVSLIDER_TEXTDOMAIN)?></div>
							<div style="display:table-cell; min-width:78px">
								<div id="button_sort_visibility" class="tipsy_enabled_top" title="<?php _e('Hide All Layers',REVSLIDER_TEXTDOMAIN)?>"><i class="eg-icon-eye"></i><i class="eg-icon-eye-off"></i></div>
								<div id="button_sort_lock" class="tipsy_enabled_top" title="<?php _e('Lock All Layers',REVSLIDER_TEXTDOMAIN)?>"><i class="eg-icon-lock-open"></i><i class="eg-icon-lock"></i></div>	
								<div id="button_sort_tillend" class="tipsy_enabled_top" title="<?php _e('Snap to Slide End / Custom End',REVSLIDER_TEXTDOMAIN)?>"><i class="eg-icon-back-in-time"></i></div>											
							</div>
							<div style="display:table-cell;padding:10px 15px 10px 0px;width:100%"><?php _e("Timing",REVSLIDER_TEXTDOMAIN)?>
								<div id="button_sort_timing" class="button-primary revblue" style="margin-left:15px !important" title="<?php _e('Show / Hide Timer Settings',REVSLIDER_TEXTDOMAIN)?>"><i class="eg-icon-equalizer"></i> <span class="onoff"> - on</span></div>
							</div>									
							<div style="display:table-cell;padding:10px 0px 10px 0px; min-width:50px;"><?php _e("Start",REVSLIDER_TEXTDOMAIN)?></div>									
							<div style="display:table-cell;padding:10px 0px 10px 0px; min-width:54px;"><?php _e("End",REVSLIDER_TEXTDOMAIN)?></div>																		
						</div>									
						
						<div class="inside" style="margin:0;">
							<ul id="sortlist" class='sortlist'></ul>
						</div>
						
						<div class="clear"></div>
					</div>
				</div>
				
						
			<!-----  Left Layers Form ------>

				<div class="edit_layers_left">

					<form name="form_layers" id="form_layers">
						<script type='text/javascript'>
							g_settingsObj['form_layers'] = {}
						</script>
						
						<?php
						$show_static = 'display: none;';

						if($slide->isStaticSlide())
							$show_static = '';
							$isTemplate = $slider->getParam("template", "false");
						?>
						<!-- THE GENERAL LAYER PARAMETERS -->
						<div class='settings_wrapper' style="<?php echo $show_static; ?>">
							<div class="postbox unite-postbox">
								<h3 class='no-accordion tp-accordion'><span class="postbox-arrow2">-</span>
									<span><?php _e("Static Options",REVSLIDER_TEXTDOMAIN)?> </span>
								</h3>
								<div class="toggled-content tp-closeifotheropen">
									<ul class="list_settings">
										<?php
										if($isTemplate == "true"){
											?>
											<li>
											<?php _e('Static Layers will be shown on every slide in template sliders', REVSLIDER_TEXTDOMAIN); ?>
											</li>
											<?php
										}
										?>
										<div id="layer_static_wrapper"<?php echo ($isTemplate == "true") ? ' style="display: none;"' : ''; ?>>
											<li>
												<div id="static_start_on_wrap" class="setting_text"><?php _e('Start on Slide', REVSLIDER_TEXTDOMAIN); ?></div>
												<select id="layer_static_start" name="static_start">
													<?php
													if(!empty($arrSlideNames)){
														$si = 1;
														end($arrSlideNames);
														//fetch key of the last element of the array.
														$lastElementKey = key($arrSlideNames);
														foreach($arrSlideNames as $sid => $sparams){
															if($lastElementKey == $sid) break; //break on the last element
															?>
															<option value="<?php echo $si; ?>"><?php echo $si; ?></option>
															<?php
															$si++;
														}
													}else{
														?>
														<option value="-1">-1</option>
														<?php
													}
													?>
												</select>
											</li>
											<div class="clear"></div>
											<li>
												<div id="static_end_on_wrap" class="setting_text"><?php _e('End on Slide', REVSLIDER_TEXTDOMAIN); ?></div>
												<select id="layer_static_end" name="static_end">
													<?php
													if(!empty($arrSlideNames)){
														$si = 1;
														foreach($arrSlideNames as $sid => $sparams){
															?>
															<option value="<?php echo $si; ?>"><?php echo $si; ?></option>
															<?php
															$si++;
														}
													}else{
														?>
														<option value="-1">-1</option>
														<?php
													}
													?>
												</select>
											</li>
										</div>
									</ul>
								</div>
							</div>
						</div>
						
						<!-- THE GENERAL LAYER PARAMETERS -->
						<div class='settings_wrapper'>
							<div class="postbox unite-postbox">
								<h3 class='no-accordion tp-accordion'><span class="postbox-arrow2">-</span>
									<span><?php _e("Layer General Parameters",REVSLIDER_TEXTDOMAIN)?> </span>
								</h3>
								<div class="toggled-content tp-closeifotheropen">
									<ul class="list_settings">
										<li id="end_layer_sap" class="attribute_title" style="margin-top:-10px;">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Layer Content",REVSLIDER_TEXTDOMAIN)?></span>
											<!--<hr>-->
										</li>
										<?php
											$s = $settingsLayerOutput;
											$s->drawSettingsByNames("layer_caption");

											//add css editor
											$s->drawCssEditor();

											//add global styles editor
											$s->drawGlobalCssEditor();

											$s->drawSettingsByNames("layer_text,button_edit_video,button_change_image_source,layer_alt");
										?>
										<li style="clear:both">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Align, Position & Styling",REVSLIDER_TEXTDOMAIN)?></span>
											<!--<hr>-->
										</li>
										<li class="align_table_wrapper">
											<table id="align_table" class="align_table table_disabled">
												<tr>
													<td><a href="javascript:void(0)" id="linkalign_left_top" data-hor="left" data-vert="top"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_center_top" data-hor="center" data-vert="top"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_right_top" data-hor="right" data-vert="top"></a></td>
												</tr>
												<tr>
													<td><a href="javascript:void(0)" id="linkalign_left_middle" data-hor="left" data-vert="middle"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_center_middle" data-hor="center" data-vert="middle"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_right_middle" data-hor="right" data-vert="middle"></a></td>
												</tr>
												<tr>
													<td><a href="javascript:void(0)" id="linkalign_left_bottom" data-hor="left" data-vert="bottom"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_center_bottom" data-hor="center" data-vert="bottom"></a></td>
													<td><a href="javascript:void(0)" id="linkalign_right_bottom" data-hor="right" data-vert="bottom"></a></td>
												</tr>
											</table>
										</li>
										<div style="float:left;width:300px;">
											<div style="clear:both">
											<?php
												$s->drawSettingsByNames("layer_left,layer_top");
											?>
											</div>
											<div style="clear:both">
											<?php
												$s->drawSettingsByNames("layer_whitespace");
											?>
											</div>

											<div style="clear:both;display:none">
											<?php
												$s->drawSettingsByNames("layer_align_hor,layer_align_vert");
											?>
											</div>
											<div style="clear:both"></div>
											<div>
											<?php
												$s->drawSettingsByNames("layer_max_width,layer_max_height");
											?>
											</div>
										</div>
										
										<li id="layer_scale_title_row" style="clear:both;">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Image Scale (dimensions in pixel)",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<a id="reset-scale" class="revred button-primary" href="javascript:void(0);"><?php echo _e("Reset Size",REVSLIDER_TEXTDOMAIN)?></a>
										<?php
											$s->drawSettingsByNames("layer_scaleX,layer_scaleY");
											$s->drawSettingsByNames("layer_proportional_scale");

										$show_parallax = 'display: none;';

										if(UniteFunctionsRev::getVal($sliderParams, "use_parallax","off") == 'on')
											$show_parallax = '';

										?>
										
										<li id="layer_2d_title_row" style="clear:both;">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Final Rotation",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<div style="clear: both;">
											<?php
												$s->drawSettingsByNames("layer_2d_rotation");
												$s->drawSettingsByNames("layer_2d_origin_x");
												$s->drawSettingsByNames("layer_2d_origin_y");
											?>
										</div>
										
										<div id="parallax_wrapper_div" style="<?php echo $show_parallax; ?>">
											<li id="parallax_title_row" style="clear:both;">
												<span class="setting_text_2 text-disabled" original-title=""><?php _e("Parallax Setting",REVSLIDER_TEXTDOMAIN)?></span>
											</li>
											<?php
												$s->drawSettingsByNames("parallax_level");
											?>
										</div>
									</ul>
									<div class="clear"></div>
								</div>
							</div>
						</div>

						<!-- THE ANIMATION PARAMETERS -->
						<div class='settings_wrapper'>
							<div class="postbox unite-postbox">
								<h3 class='no-accordion tp-accordion tpa-closed'><span class="postbox-arrow2">+</span>
									<span><?php _e("Layer Animation",REVSLIDER_TEXTDOMAIN)?> </span>
								</h3>
								<div class="toggled-content tp-closedatstart tp-closeifotheropen">
									<ul class="list_settings">

										<!--LAYER START ANIMATION -->
										<li id="end_layer_sap" class="attribute_title" style="margin-top:-10px;">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Preview Transition (Star end Endtime is Ignored during Demo)",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<div id="preview_caption_transition">

											<div class="preview_caption_wrapper">
												<div id="preview_caption_animateme">LAYER EXAMPLE</div>
											</div>

											<div id="preview_looper"><i class="revicon-arrows-ccw"></i><span class="replyinfo">ON</span></div>
										</div>

										<div class="divide10"></div>

										<!--LAYER START ANIMATION -->
										<li id="end_layer_sap" class="attribute_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Start Transition",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<div class="layer-animations">
											<div style="float:left;margin-right:10px;"><?php
												$s->drawSettingsByNames("layer_animation");
											?></div>

											<a href="javascript:void(0)" id="add_customanimation_in" 	class="button-primary revblue"><i class="revicon-equalizer"></i><?php _e("Custom Animation",REVSLIDER_TEXTDOMAIN)?></a>
											<div class="clear"></div>
											<?php
												$s->drawSettingsByNames("layer_easing,layer_speed,layer_split,layer_splitdelay");
											?>
										</div>
										<!--LAYER END ANIMATION -->
										<li id="end_layer_sap" class="attribute_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("End Transition (optional)",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<div class="layer-animations">
										<div style="float:left;margin-right:10px;"><?php
												$s->drawSettingsByNames("layer_endanimation");
											?></div>

											<a href="javascript:void(0)" id="add_customanimation_out" 	class="button-primary revblue"><i class="revicon-equalizer"></i><?php _e("Custom Animation",REVSLIDER_TEXTDOMAIN)?></a>
											<div class="clear"></div>
											<?php
												$s->drawSettingsByNames("layer_endeasing,layer_endspeed,layer_endtime,layer_endsplit,layer_endsplitdelay");
											?>

										</div>

										<!--LAYER LOOP ANIMATION -->
										<li id="loop_layer_sap" class="attribute_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Loop Animation",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<?php
											$s->drawSettingsByNames("layer_loop_animation");
										?>
										<div id="layer_speed_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_speed");
											?>
										</div>
										<div id="layer_easing_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_easing");
											?>
										</div>
										<div id="layer_degree_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_startdeg,layer_loop_enddeg");
											?>
										<div style="clear: both"></div>
										</div>

										<div id="layer_origin_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_xorigin,layer_loop_yorigin");
											?>
										<div style="clear: both"></div>
										</div>
										<div id="layer_x_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_xstart,layer_loop_xend");
											?>
											<div style="clear: both"></div>
										</div>
										<div id="layer_y_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_ystart,layer_loop_yend");
											?>
											<div style="clear: both"></div>
										</div>
										<div id="layer_zoom_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_zoomstart,layer_loop_zoomend");
											?>
											<div style="clear: both"></div>
										</div>
										<div id="layer_angle_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_angle");
											?>
										</div>
										<div id="layer_radius_wrapper" style="display: none;">
											<?php
												$s->drawSettingsByNames("layer_loop_radius");
											?>
										</div>
									</ul>
									<div class="clear"></div>
								</div>
							</div>
						</div><!-- END OF ANIMATION PARAMETERS -->


						<!-- LAYER ANIMATION EDITOR  (DISPLAY NONE !!)-->
						<div id="layeranimeditor_wrap" title="Layer Animation Editor" style="display:none;margin-bottom:0px; padding-bottom:0px;">
							<div class="tp-present-wrapper-parent">
								<div class="tp-present-wrapper">
									<div class="tp-present-caption">
										<div id="caption_custon_anim_preview" class="">LAYER EXAMPLE</div>
									</div>
								</div>
							</div>

							<div class="divide20"></div>
							<div class="settings_wrapper">
								<div class="postbox unite-postbox">
									<h3 class="no-accordion tp-accordion">
										<span style="font-size:13px;padding-left:4px;"><i class="revicon-equalizer"></i><?php _e("Layer Animation Settings Panel",REVSLIDER_TEXTDOMAIN)?></span>
										<span style="float: right;"><a href="javascript:void(0);" style="margin-top:-7px;border: none;font-weight: 400;box-shadow: none;-webkit-box-shadow: none;-moz-box-shadow: none;" id="set-random-animation" class="button-primary revgreen"><i class="eg-icon-shuffle"></i><?php _e("Randomize",REVSLIDER_TEXTDOMAIN)?></a></span>
									</h3>

									<table style="border-spacing:0px">

										<!-- TRANSITION -->
										<tr class="css-edit-title graybasicbg" ><td colspan="6" style="padding:10px"><?php _e("Transition",REVSLIDER_TEXTDOMAIN)?></td></tr>

										<tr class="graybasicbg">
											<td><?php _e("X:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-movex-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="movex" type="text" value="0" />px
											</td>

											<td><?php _e("Y:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-movey-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="movey" type="text" value="0" />px
											</td>

											<td><?php _e("Z:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-movez-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="movez" type="text" value="0" />px
											</td>

										</tr>

										<!-- ROTATION -->

										<tr class="css-edit-title"><td colspan="6" style="padding:10px"><?php _e("Rotation",REVSLIDER_TEXTDOMAIN) ?></td></tr>
										<tr>
											<td><?php _e("X:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-rotationx-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="rotationx" type="text" value="0" />°
											</td>

											<td><?php _e("Y:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-rotationy-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="rotationy" type="text" value="0" />°
											</td>

											<td><?php _e("Z:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="padding-bottom:15px">
												<div id='caption-rotationz-slider' class="rotationsliders"></div>
												<input class="css_edit_novice tpshortinput" name="rotationz" type="text" value="0" />°
											</td>

										</tr>

									</table>
									<table style="border-spacing:0px">
										<!-- SCALE && SKEW-->

										<tr class="css-edit-title graybasicbg">
											<td colspan="4" style="padding:10px"><?php _e("Scale",REVSLIDER_TEXTDOMAIN) ?></td>
											<td colspan="4" style="padding:10px;padding-left:20px"><?php _e("Skew",REVSLIDER_TEXTDOMAIN) ?></td>
										</tr>

										<tr class="graybasicbg">
											<!-- SCALE X -->
											<td style="width:30px"><?php _e("X:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-scalex-slider' class="rotationsliders"  style="width:100px !important;"></div>
												<input class="css_edit_novice tpshortinput" name="scalex" type="text" value="0" />%
											</td>
											<!-- SCALE Y -->
											<td style="width:30px;"><?php _e("Y:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-scaley-slider' class="rotationsliders"  style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="scaley" type="text" value="0" />%
											</td>
											<td style="width:30px;"><?php _e("X:",REVSLIDER_TEXTDOMAIN) ?></td>
											<!-- SKEW X -->
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-skewx-slider' class="rotationsliders" style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="skewx" type="text" value="0" />°
											</td>

											<td style="width:30px"><?php _e("Y:",REVSLIDER_TEXTDOMAIN) ?></td>
											<!-- SKEW Y -->
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-skewy-slider' class="rotationsliders" style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="skewy" type="text" value="0" />°
											</td>

										</tr>

									</table>

									<table style="border-spacing:0px padding-bottom:10px">
										<!-- OPACITY -->

										<tr class="css-edit-title">
											<td colspan="2" style="padding:10px"><?php _e("Opacity",REVSLIDER_TEXTDOMAIN)?></td>
											<td colspan="2" style="padding:10px;padding-left:20px"><?php _e("Perspective",REVSLIDER_TEXTDOMAIN)?></td>
											<td colspan="2" style="padding:10px;padding-left:20px"><?php _e("Origin",REVSLIDER_TEXTDOMAIN)?></td>
										</tr>

										<tr class="">
										<!-- OPACITY -->
											<td style="width:30px"></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-opacity-slider' class="rotationsliders"  style="width:100px !important;"></div>
												<input class="css_edit_novice tpshortinput" name="captionopacity" type="text" value="0" />%
											</td>
										<!-- PERSPECTIVE -->
											<td style="width:30px;"></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-perspective-slider' class="rotationsliders"  style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="captionperspective" type="text" value="0" />px
											</td>
										<!-- ORIGINX -->
											<td style="width:30px;"><?php _e("X:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-originx-slider' class="rotationsliders" style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="originx" type="text" value="0" />%
											</td>
										<!-- ORIGINY -->
											<td style="width:30px"><?php _e("Y:",REVSLIDER_TEXTDOMAIN) ?></td>
											<td style="width:100px; padding-bottom:15px; ">
												<div id='caption-originy-slider' class="rotationsliders" style="width:100px;"></div>
												<input class="css_edit_novice tpshortinput" name="originy" type="text" value="0" />%
											</td>

										</tr>

									</table>
								</div>
							</div>


							<div class="settings_wrapper">
								<div class="postbox unite-postbox">
									<h3 class="no-accordion tp-accordion">
										<span style="font-size:13px;padding-left:4px;"><i class="eg-icon-tools"></i><?php _e("Test Parameters",REVSLIDER_TEXTDOMAIN)?></span>
										<span style="font-size: 9px;text-align: right;font-weight: 300;font-style: italic;white-space: nowrap;"><?php _e("*These Settings are only for Customizer. Settings can be set per Start and End Animation.",REVSLIDER_TEXTDOMAIN)?></span>
									</h3>

										<table>
											<tr>
												<td>Speed:</td>
												<td style="vertical-align: middle; line-height: 25px;"><input class="css_edit_novice tpshortinput" style="margin-top:3px;margin-right:5px;" name="captionspeed" type="text" value="600" />ms</td>
												<td>Easing:</td>
												<td>
													<select id="caption-easing-demo" name="caption-easing-demo" class="">
														<option value="Linear.easeNone">Linear.easeNone</option>
														<option value="Power0.easeIn">Power0.easeIn  (linear)</option>
														<option value="Power0.easeInOut">Power0.easeInOut  (linear)</option>
														<option value="Power0.easeOut">Power0.easeOut  (linear)</option>
														<option value="Power1.easeIn">Power1.easeIn</option>
														<option value="Power1.easeInOut">Power1.easeInOut</option>
														<option value="Power1.easeOut">Power1.easeOut</option>
														<option value="Power2.easeIn">Power2.easeIn</option>
														<option value="Power2.easeInOut">Power2.easeInOut</option>
														<option value="Power2.easeOut">Power2.easeOut</option>
														<option value="Power3.easeIn">Power3.easeIn</option>
														<option value="Power3.easeInOut">Power3.easeInOut</option>
														<option value="Power3.easeOut">Power3.easeOut</option>
														<option value="Power4.easeIn">Power4.easeIn</option>
														<option value="Power4.easeInOut">Power4.easeInOut</option>
														<option value="Power4.easeOut">Power4.easeOut</option>
														<option value="Back.easeIn">Back.easeIn</option>
														<option value="Back.easeInOut">Back.easeInOut</option>
														<option value="Back.easeOut">Back.easeOut</option>
														<option value="Bounce.easeIn">Bounce.easeIn</option>
														<option value="Bounce.easeInOut">Bounce.easeInOut</option>
														<option value="Bounce.easeOut">Bounce.easeOut</option>
														<option value="Circ.easeIn">Circ.easeIn</option>
														<option value="Circ.easeInOut">Circ.easeInOut</option>
														<option value="Circ.easeOut">Circ.easeOut</option>
														<option value="Elastic.easeIn">Elastic.easeIn</option>
														<option value="Elastic.easeInOut">Elastic.easeInOut</option>
														<option value="Elastic.easeOut">Elastic.easeOut</option>
														<option value="Expo.easeIn">Expo.easeIn</option>
														<option value="Expo.easeInOut">Expo.easeInOut</option>
														<option value="Expo.easeOut">Expo.easeOut</option>
														<option value="Sine.easeIn">Sine.easeIn</option>
														<option value="Sine.easeInOut">Sine.easeInOut</option>
														<option value="Sine.easeOut">Sine.easeOut</option>
														<option value="SlowMo.ease">SlowMo.ease</option>
													</select>
												</td>
											</tr>
											<tr>
												<td>Animate per:</td>
												<td>
													<select id="caption-split-demo" name="caption-split-demo" class="">
														<option value="full">None</option>
														<option value="chars">Chars</option>
														<option value="words">Words</option>
														<option value="lines">Lines</option>
													</select>
												</td>
												<!-- DELAYS -->
												<td>Delays:</td>
												<td style="vertical-align: middle; line-height: 25px;"><input class="css_edit_novice tpshortinput" style="margin-top:3px;margin-right:5px;" name="captionsplitdelay" type="text" value="10" />ms</td>
											</tr>
										</table>

										<div id="caption-inout-controll" class="caption-inout-controll">
											<i id="revshowmetheinanim" class="revicon-login reviconinaction"></i><i id="revshowmetheoutanim" class="revicon-logout"></i><?php _e("Transition Direction",REVSLIDER_TEXTDOMAIN)?>
										</div>



										<div class="clear"></div>

								</div>
							</div>
						</div>

						<div id="dialog-change-layeranimation" title="Save Layer Animation" style="display:none;">
							<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 50px 0;"></span><?php
							_e('Overwrite the current selected Animation ',REVSLIDER_TEXTDOMAIN);
							echo '"<span id="current-layer-handle"></span>"';
							_e(' or save as a new Animation?',REVSLIDER_TEXTDOMAIN)?></p>
						</div>

						<div id="dialog-change-layeranimation-save-as" title="Save as" style="display:none;">
							<p>
								<?php _e('Save as Animation:',REVSLIDER_TEXTDOMAIN)?><br />
								<input type="text" name="layeranimation_save_as" value="" />
							</p>
						</div>
						<!-- END OF CUSTOM ANIMATION LAYER EDITOR -->


						<!-- THE ADVANCED LAYER PARAMETERS -->
						<div class='settings_wrapper'>
							<div class="postbox unite-postbox">
								<h3 class='no-accordion tp-accordion tpa-closed'><span class="postbox-arrow2">+</span>
									<span><?php _e("Layer Links & Advanced Params",REVSLIDER_TEXTDOMAIN)?> </span>
								</h3>
								<div class="toggled-content tp-closedatstart tp-closeifotheropen">

									<ul class="list_settings">
										<li class="custom attributes_title" style="margin-top:-10px;">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Links (optional)",REVSLIDER_TEXTDOMAIN)?></span>
											<!--<hr>-->
										</li>
										<div class="layer-links">
											<?php
												$s = $settingsLayerOutput;
												$s->drawSettingsByNames("layer_image_link,layer_link_open_in,layer_slide_link,layer_scrolloffset,layer_link_id,layer_link_class,layer_link_title,layer_link_rel");
											?>
										</div><div style="clear: both;"></div>

										<li id="" class="custom attributes_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Caption Sharp Corners (optional only with BG color)",REVSLIDER_TEXTDOMAIN)?></span>
											<!--<hr>-->
										</li>
										<div class="layer-links">
											<?php
												$s = $settingsLayerOutput;
												$s->drawSettingsByNames("layer_cornerleft,layer_cornerright");
											?>
										</div>

										<li id="" class="custom attributes_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Advanced Responsive Settings",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<div class="layer-links">
											<?php
												$s = $settingsLayerOutput;
												$s->drawSettingsByNames("layer_resizeme,layer_hidden");
											?>
										</div>


										<li id="custom_attributes" class="custom attributes_title" style="">
											<span class="setting_text_2 text-disabled" original-title=""><?php _e("Attributes (optional)",REVSLIDER_TEXTDOMAIN)?></span>
										</li>
										<?php
											$s = $settingsLayerOutput;
											$s->drawSettingsByNames("layer_id,layer_classes,layer_title,layer_rel");
										?>

									</ul>
									<div class="clear"></div>
								</div>
							</div>
						</div>

					</form>
				</div>

				<!----- End Left Layers Form ------>
				<div class="clear"></div>

			</div>
		</div>


	<div id="dialog_insert_button" class="dialog_insert_button" title="Insert Button" style="display:none;">
		<p>
			<ul class="list-buttons">
			<?php foreach($arrButtonClasses as $class=>$text): ?>
					<li>
						<a href="javascript:UniteLayersRev.insertButton('<?php echo $class?>','<?php echo $text?>')" class="tp-button <?php echo $class?> small"><?php echo $text?></a>
					</li>
			<?php endforeach;?>
			</ul>
		</p>
	</div>

	<div id="dialog_template_insert" class="dialog_template_help" title="<?php _e("Template Insertions",REVSLIDER_TEXTDOMAIN) ?>" style="display:none;">
		<b><?php _e("Post Replace Placeholders:",REVSLIDER_TEXTDOMAIN) ?></b>
		<table class="table_template_help">
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('meta:somemegatag')">%meta:somemegatag%</a></td><td><?php _e("Any custom meta tag",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('title')">%title%</a></td><td><?php _e("Post Title",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('excerpt')">%excerpt%</a></td><td><?php _e("Post Excerpt",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('alias')">%alias%</a></td><td><?php _e("Post Alias",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('content')">%content%</a></td><td><?php _e("Post content",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('link')">%link%</a></td><td><?php _e("The link to the post",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('date')">%date%</a></td><td><?php _e("Date created",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('date_modified')">%date_modified%</a></td><td><?php _e("Date modified",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('author_name')">%author_name%</a></td><td><?php _e("Author name",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('num_comments')">%num_comments%</a></td><td><?php _e("Number of comments",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('catlist')">%catlist%</a></td><td><?php _e("List of categories with links",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('taglist')">%taglist%</a></td><td><?php _e("List of tags with links",REVSLIDER_TEXTDOMAIN) ?></td></tr>
		</table>
		<?php if(UniteEmRev::isEventsExists()):?>

		<br><br>

		<b><?php _e("Events Placeholders:",REVSLIDER_TEXTDOMAIN) ?></b>
		<table class="table_template_help">
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_start_date')">%event_start_date%</a></td><td><?php _e("Event start date",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_end_date)">'%event_end_date%</a></td><td><?php _e("Event end date",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_start_time')">%event_start_time%</a></td><td><?php _e("Event start time",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_end_time)">'%event_end_time%</a></td><td><?php _e("Event end time",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_event_id')">%event_event_id%</a></td><td><?php _e("Event ID",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_name')">%event_location_name%</a></td><td><?php _e("Event location name",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_slug%')">%event_location_slug%</a></td><td><?php _e("Event location slug",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_address)">%event_location_address%</a></td><td><?php _e("Event location address",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_town')">%event_location_town%</a></td><td><?php _e("Event location town",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_state')">%event_location_state%</a></td><td><?php _e("Event location state",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_postcode')">%event_location_postcode%</a></td><td><?php _e("Event location postcode",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_region')">%event_location_region%</a></td><td><?php _e("Event location region",REVSLIDER_TEXTDOMAIN) ?></td></tr>
			<tr><td><a href="javascript:UniteLayersRev.insertTemplate('event_location_country')">%event_location_country%</a></td><td><?php _e("Event location country",REVSLIDER_TEXTDOMAIN) ?></td></tr>
		</table>

		<?php endif?>
	</div>

	<!-- FIXED POSITIONED TOOLBOX -->
		<div class="" style="position:fixed;right:-10px;top:100px;z-index:100;">
			<?php
			if(!$slide->isStaticSlide()){
				?>
				<a href="javascript:void(0)" id="button_preview_slide-tb" class="button-primary button-fixed revbluedark"><div style="font-size:16px; padding:10px 5px;" class="revicon-search-1"></div></a>
				<?php
			}else{
				?>
				<a href="javascript:void(0)" id="button_preview_slider-tb" class="button-primary button-fixed revbluedark"><div style="font-size:16px; padding:10px 5px;" class="revicon-search-1"></div></a>
				<?php
			}
			?>
		</div>

	<script type="text/javascript">

		jQuery(document).ready(function() {
			<?php if(!empty($jsonLayers)):?>
				//set init layers object
				UniteLayersRev.setInitLayersJson(<?php echo $jsonLayers?>);
			<?php endif?>
			
			<?php if($slide->isStaticSlide()){
				$arrayDemoLayers = array();
				$arrayDemoSettings = array();
				if(!empty($all_slides)){
					foreach($all_slides as $cSlide){
						$arrayDemoLayers[$cSlide->getID()] = $cSlide->getLayers();
						$arrayDemoSettings[$cSlide->getID()] = $cSlide->getParams();
					}
				}
				$jsonDemoLayers = UniteFunctionsRev::jsonEncodeForClientSide($arrayDemoLayers);
				$jsonDemoSettings = UniteFunctionsRev::jsonEncodeForClientSide($arrayDemoSettings);
				?>
				//set init demo layers object
				UniteLayersRev.setInitDemoLayersJson(<?php echo $jsonDemoLayers?>);
				UniteLayersRev.setInitDemoSettingsJson(<?php echo $jsonDemoSettings?>);
			<?php } ?>
			
			<?php if(!empty($jsonCaptions)):?>
			UniteLayersRev.setInitCaptionClasses(<?php echo $jsonCaptions?>);
			<?php endif?>

			<?php if(!empty($arrCustomAnim)):?>
			UniteLayersRev.setInitLayerAnim(<?php echo $arrCustomAnim?>);
			<?php endif?>

			<?php if(!empty($jsonFontFamilys)):?>
			UniteLayersRev.setInitFontTypes(<?php echo $jsonFontFamilys?>);
			<?php endif?>

			<?php if(!empty($arrCssStyles)):?>
			UniteCssEditorRev.setInitCssStyles(<?php echo $arrCssStyles?>);
			<?php endif?>

			UniteCssEditorRev.setCssCaptionsUrl('<?php echo $urlCaptionsCSS?>');

			UniteLayersRev.init("<?php echo $slideDelay?>");
			UniteCssEditorRev.init();

			RevSliderAdmin.initGlobalStyles();
			
			RevSliderAdmin.initLayerPreview();

			RevSliderAdmin.setStaticCssCaptionsUrl('<?php echo GlobalsRevSlider::$urlStaticCaptionsCSS; ?>');

/*			var reproduce;
			jQuery(window).resize(function() {
				clearTimeout(reproduce);
				reproduce = setTimeout(function() {
					UniteLayersRev.refreshGridSize();
				},100);
			});*/

			<?php if($kenburn_effect == 'on'){ ?>
			jQuery('input[name="kenburn_effect"]:checked').change();
			<?php } ?>
		});

	</script>
