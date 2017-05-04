
<!-- //Youtube dialog: -->
<div id="dialog_video" class="dialog-video" title="<?php _e("Add Video Layout",REVSLIDER_TEXTDOMAIN)?>" style="display:none">
	
	<!-- Type chooser -->
		
		<div id="video_type_chooser" class="video-type-chooser">
			<div class="choose-video-type" style="float:left">
				<?php _e("Choose video type",REVSLIDER_TEXTDOMAIN)?>
			</div>
			<div style="float:left; height:35px;line-height:15px;margin-top:20px;margin-left:30px">
				<label for="video_radio_youtube"><?php _e("Youtube",REVSLIDER_TEXTDOMAIN)?></label>
				<input type="radio" checked id="video_radio_youtube" name="video_select">
				
				<label for="video_radio_vimeo"><?php _e("Vimeo",REVSLIDER_TEXTDOMAIN)?></label>
				<input type="radio" id="video_radio_vimeo" name="video_select">
				
				<label for="video_radio_html5"><?php _e("HTML5",REVSLIDER_TEXTDOMAIN)?></label>
				<input type="radio" id="video_radio_html5" name="video_select">			
			</div>
			<div style="clear:both"></div>			
			
			<hr>
			<div style="width:100%;height:15px;"></div>
		</div>

		
	<div class="video_left" id="video-dialog-wrap">
		
		
		
		<!-- Vimeo block -->
		
		<div id="video_block_vimeo" class="video-select-block" style="display:none;" >
			
			<div class="video-title" >
				<?php _e("Enter Vimeo ID or URL",REVSLIDER_TEXTDOMAIN)?>
			</div>
			
			<input type="text" id="vimeo_id" value=""></input>
			&nbsp;
			<input type="button" id="button_vimeo_search" class="button-regular" value="search">
			
			<img id="vimeo_loader" src="<?php echo self::$url_plugin?>/images/loader.gif" style="display:none">
			
			<div class="video_example">
				<?php _e("example:  30300114",REVSLIDER_TEXTDOMAIN)?>
			</div>
		
		</div>
		
		<!-- Youtube block -->
		
		<div id="video_block_youtube" class="video-select-block">
		
			<div class="video-title">
				<?php _e("Enter Youtube ID or URL",REVSLIDER_TEXTDOMAIN)?>:
			</div>
			
			<input type="text" id="youtube_id" value=""></input>
			&nbsp;
			<input type="button" id="button_youtube_search" class="button-regular" value="search">
			
			<img id="youtube_loader" src="<?php echo self::$url_plugin?>/images/loader.gif" style="display:none">
			
			<div class="video_example">
				<?php _e("example",REVSLIDER_TEXTDOMAIN)?>:  <?php echo GlobalsRevSlider::YOUTUBE_EXAMPLE_ID?>
			</div>
			
		</div>
		
		<!-- Html 5 block -->
		
		<div id="video_block_html5" class="video-select-block" style="display:none;">
			
			<ul>
				<li style="width:45%;float:left;">
					<div class="video-title">
					<?php _e("Poster Image Url", REVSLIDER_TEXTDOMAIN)?>:
					</div>
					<input type="text" id="html5_url_poster" value=""></input>
					<span class="video_example"><?php _e("Example",REVSLIDER_TEXTDOMAIN)?>: http://video-js.zencoder.com/oceans-clip.png</span>
				</li>
				<li style="width:45%;float:left;margin-left:4%;">
					<div class="video-title">				
					<?php _e("Video MP4 Url", REVSLIDER_TEXTDOMAIN)?>:
					</div>
					<input type="text" id="html5_url_mp4" value=""></input>
					<span class="video_example"><?php _e("Example",REVSLIDER_TEXTDOMAIN)?>: http://video-js.zencoder.com/oceans-clip.mp4</span>
				</li>
				<li style="clear:both;width:45%;float:left;margin-top:20px;">
					<div class="video-title">								
					<?php _e("Video WEBM Url", REVSLIDER_TEXTDOMAIN)?>:
					</div>
					<input type="text" id="html5_url_webm" value=""></input>
					<span class="video_example"><?php _e("Example",REVSLIDER_TEXTDOMAIN)?>: http://video-js.zencoder.com/oceans-clip.webm</span>					
				</li>
				<li style="width:45%;float:left;margin-left:4%;margin-top:20px;">
					<div class="video-title">
					<?php _e("Video OGV Url", REVSLIDER_TEXTDOMAIN)?>:
					</div>			
					<input type="text" id="html5_url_ogv" value=""></input>
					<span class="video_example"><?php _e("Example",REVSLIDER_TEXTDOMAIN)?>: http://video-js.zencoder.com/oceans-clip.ogv</span>	
				</li>
				
			</ul>
			
		</div>
		<div style="clear:both"></div>
		
		<!-- Video controls -->
		
		<div id="video_hidden_controls" style="display:none; margin-top:20px;">
			<hr>
			<div class="video-title">
				<?php _e("Video Size",REVSLIDER_TEXTDOMAIN)?>:
			</div>
					
			<div id="video_size_wrapper" class="youtube-inputs-wrapper">
			
				<label for="input_video_fullwidth" class=" float_left mtop_10">
					<?php _e("Full Screen:",REVSLIDER_TEXTDOMAIN)?>
				</label>								
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13 " id="input_video_fullwidth" ></input>
				
				<div class="float_left mleft_20 mtop_10" id="input_video_width_lbl"><?php _e("Width",REVSLIDER_TEXTDOMAIN)?>:</div>
				<input type="text" id="input_video_width" style="margin-top:5px;" class="video-input-small float_left" value="320">
				
				<div class="float_left mleft_20 mtop_10" id="input_video_height_lbl"><?php _e("Height",REVSLIDER_TEXTDOMAIN)?>:</div>
				<input type="text" id="input_video_height" style="margin-top:5px;" class="video-input-small float_left" value="240">
				
				<div style="clear:both"></div>
				
				<div class="mtop_10">
					<label for="input_video_cover" class="float_left">
						<?php _e("Force Cover:",REVSLIDER_TEXTDOMAIN)?>
					</label>				
					<input type="checkbox" class="checkbox_video_dialog float_left " id="input_video_cover" ></input>
				</div>
				
				<div style="clear:both"></div>
				
				<div id="fullscreenvideofun1" class="mtop_20">
					<label for="input_video_dotted_overlay" class="float_left" id="input_video_dotted_overlay_lbl">
						<?php _e("Dotted Overlay:",REVSLIDER_TEXTDOMAIN)?>
					</label>				
					<select id="input_video_dotted_overlay" style="float: left; margin-top:-5px">
						<option value="none"><?php _e('none',REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="twoxtwo"><?php _e('2 x 2 Black',REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="twoxtwowhite"><?php _e('2 x 2 White',REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="threexthree"><?php _e('3 x 3 Black',REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="threexthreewhite"><?php _e('3 x 3 White',REVSLIDER_TEXTDOMAIN); ?></option>
					</select>
					
					<div style="clear: both;"></div>
					
					<label for="input_video_ratio" class="float_left mtop_10" id="input_video_ratio_lbl">
						<?php _e("Aspect Ratio:",REVSLIDER_TEXTDOMAIN)?>
					</label>				
					<select id="input_video_ratio" style="margin-top:5px">
						<option value="16:9"><?php _e('16:9',REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="4:3"><?php _e('4:3',REVSLIDER_TEXTDOMAIN); ?></option>
					</select>
					
				</div>
				<div style="clear:both"></div>
				
			</div>
			
			<div class="mtop_20">
				<hr>
				<div class="video-title">
					<?php _e("Video Settings",REVSLIDER_TEXTDOMAIN)?>:
				</div>
				
				
				<label for="input_video_autoplay" class="float_left mtop_10 ">
					<?php _e("Autoplay:",REVSLIDER_TEXTDOMAIN)?>
				</label>
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_autoplay" ></input>
				
				<div id="rev-video-loop-wrap" class="float_left" style="display: none;">
					<label for="input_video_loop" class=" float_left mleft_20 mtop_10">
						<?php _e("Loop Video:",REVSLIDER_TEXTDOMAIN)?>
					</label>				
					<?php /* <input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_loop" ></input> */ ?>
					<select id="input_video_loop" style="width: 200px;">
						<option value="none"><?php _e('Disable', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="loop"><?php _e('Loop', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="loopandnoslidestop"><?php _e('Loop, Slide does not stop', REVSLIDER_TEXTDOMAIN); ?></option>
					</select>
				</div>
				
				<div id="showautoplayfirsttime" class="float_left">
					<label for="input_video_autoplay_first_time" class="float_left mtop_10 mleft_20">
						<?php _e("Only 1st Time:",REVSLIDER_TEXTDOMAIN)?>
					</label>
					<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_autoplay_first_time" ></input>
				</div>
				
				<div style="clear:both"></div>	
				
				<label for="input_video_nextslide" class="float_left mtop_10">
					<?php _e("Next Slide On End:",REVSLIDER_TEXTDOMAIN)?>
				</label>
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_nextslide" ></input>
			
				<label for="input_video_force_rewind" class="float_left mtop_10 mleft_20">
					<?php _e("Force Rewind:",REVSLIDER_TEXTDOMAIN)?>
				</label>
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_force_rewind" ></input>
			
			
				<div style="clear:both"></div>	
				<label for="input_video_control" class="float_left mtop_10">
					<?php _e("Hide Controls:",REVSLIDER_TEXTDOMAIN)?>
				</label>				
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_control" ></input>
				
				<label for="input_video_mute" class="float_left mleft_20 mtop_10">
					<?php _e("Mute:",REVSLIDER_TEXTDOMAIN)?>
				</label>				
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_video_mute" ></input>
				
				<label for="input_disable_on_mobile" class="float_left mleft_20 mtop_10">
					<?php _e("Disable Mobile:",REVSLIDER_TEXTDOMAIN)?>
				</label>
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_disable_on_mobile" ></input>
				<div class="clear"></div>
				<div id="rev-youtube-options">
					<label for="input_video_speed" class="float_left mtop_10">
						<?php _e("Video Speed:",REVSLIDER_TEXTDOMAIN)?>
					</label>
					<select id="input_video_speed" style="margin-top: 5px;">
						<option value="0.25"><?php _e('0.25', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="0.50"><?php _e('0.50', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="1"><?php _e('1', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="1.5"><?php _e('1.5', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="2"><?php _e('2', REVSLIDER_TEXTDOMAIN); ?></option>
					</select>
				</div>
				<div id="rev-html5-options" style="display: none;">
					<label for="input_video_preload" class="float_left mtop_10">
						<?php _e("Video Preload:",REVSLIDER_TEXTDOMAIN)?>
					</label>
					<select id="input_video_preload" style="margin-top: 5px;">
						<option value="auto"><?php _e('Auto', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="none"><?php _e('Disable', REVSLIDER_TEXTDOMAIN); ?></option>
						<option value="metadata"><?php _e('Metadata', REVSLIDER_TEXTDOMAIN); ?></option>
					</select>
				</div>
				<div class="clear"></div>
			</div>

			<div class="video-title mtop_20" id="preview-image-video-wrap">
				<hr>
				<div class="video-title">
					<?php _e("Preview Image",REVSLIDER_TEXTDOMAIN)?>:
				</div>

				<input type="button" id="" class="button-image-select-video button-primary revblue" value="<?php _e("Set",REVSLIDER_TEXTDOMAIN)?>">
				<input type="button" id="" class="button-image-remove-video button-primary revblue" value="<?php _e("Remove",REVSLIDER_TEXTDOMAIN)?>">
				<input type="hidden" class="checkbox_video_dialog float_left" id="input_video_preview">
				<div class="clear"></div>
				<label for="input_use_poster_on_mobile" class="float_left mtop_10" style="font-weight: 400 !important;">
					<?php _e("Disable Video on Mobile and use Preview Image:",REVSLIDER_TEXTDOMAIN)?>
				</label>
				<input type="checkbox" class="checkbox_video_dialog float_left mtop_13" id="input_use_poster_on_mobile" ></input>
				<div class="clear"></div>
				
				<div style="width:100%;height:10px"></div>
			</div>
			<div class="clear"></div>
			<hr>
			<div class="video-title mtop_20">
				<?php _e("Arguments:",REVSLIDER_TEXTDOMAIN)?>
			</div>
					
			<input type="text" id="input_video_arguments" style="width:100%;" value="" data-youtube="<?php echo GlobalsRevSlider::DEFAULT_YOUTUBE_ARGUMENTS?>" data-vimeo="<?php echo GlobalsRevSlider::DEFAULT_VIMEO_ARGUMENTS?>" ></input>
			
			<div class="mtop_20">
				
				
			</div>
			
			<div class="clear"></div>
			<div class="add-button-wrapper">
				<a href="javascript:void(0)" class="button-primary revblue" id="button-video-add" data-textadd="<?php _e("Add This Video",REVSLIDER_TEXTDOMAIN)?>" data-textupdate="<?php _e("Update Video",REVSLIDER_TEXTDOMAIN)?>" ><?php _e("Add This Video",REVSLIDER_TEXTDOMAIN)?></a>
			</div>
			
		</div>
		
	</div>
	
	<div id="video_content" class="video_right" style="display:none"></div>		
	
</div>
