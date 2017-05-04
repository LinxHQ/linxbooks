<?php 

//$generalSettings = self::getSettings("general");
//$settingsOutput = new UniteSettingsRevProductRev();
//$settingsOutput->init($generalSettings);

$generalSettings = self::getSettings("general");
$role = $generalSettings->getSettingValue("role",UniteBaseAdminClassRev::ROLE_ADMIN);
$includes_globally = $generalSettings->getSettingValue("includes_globally",'on');
$pages_for_includes = $generalSettings->getSettingValue("pages_for_includes",'');
$js_to_footer = $generalSettings->getSettingValue("js_to_footer",'off');
$show_dev_export = $generalSettings->getSettingValue("show_dev_export",'off');

$enable_logs = $generalSettings->getSettingValue("enable_logs",'off');
?>

<div id="dialog_general_settings" title="<?php _e("General Settings",REVSLIDER_TEXTDOMAIN)?>" style="display:none;">

	<div class="settings_wrapper unite_settings_wide">
		<form name="form_general_settings" id="form_general_settings">
				<script type="text/javascript">
					g_settingsObj['form_general_settings'] = {}					
				</script>
				<table class="form-table">				
					<tbody>
						<tr id="role_row" valign="top">
							<th scope="row">
								<?php _e("View Plugin Permission:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<select id="role" name="role">
									<option <?php selected($role, 'admin'); ?>value="admin"><?php _e("To Admin",REVSLIDER_TEXTDOMAIN); ?></option>
									<option <?php selected($role, 'editor'); ?>value="editor"><?php _e("To Editor, Admin",REVSLIDER_TEXTDOMAIN); ?></option>
									<option <?php selected($role, 'author'); ?>value="author"><?php _e("Author, Editor, Admin",REVSLIDER_TEXTDOMAIN); ?></option>
								</select>
							
								<div class="description_container">
									<span class="description"><?php _e("The role of user that can view and edit the plugin",REVSLIDER_TEXTDOMAIN)?></span>					
								</div>
							</td>
						</tr>								
						<tr id="includes_globally_row" valign="top">
							<th scope="row">
								<?php _e("Include RevSlider libraries globally:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<span id="includes_globally_wrapper" class="radio_settings_wrapper">
								<div class="radio_inner_wrapper">
									<input type="radio" id="includes_globally_1" value="on" name="includes_globally" <?php checked($includes_globally, 'on'); ?>>
									<label for="includes_globally_1" style="cursor:pointer;"><?php _e("On",REVSLIDER_TEXTDOMAIN); ?></label>
								</div>
					
								<div class="radio_inner_wrapper">
									<input type="radio" id="includes_globally_2" value="off" name="includes_globally" <?php checked($includes_globally, 'off'); ?>>
									<label for="includes_globally_2" style="cursor:pointer;"><?php _e("Off",REVSLIDER_TEXTDOMAIN); ?></label>
								</div>					
								</span>
					
								<div class="description_container">
									<span class="description"><?php _e("ON - Add CSS and JS Files to all pages. </br>Off - CSS and JS Files will be only loaded on Pages where any rev_slider shortcode exists.",REVSLIDER_TEXTDOMAIN)?></span>					
								</div>
							</td>
						</tr>								
						<tr id="pages_for_includes_row" valign="top">
							<th scope="row">
								<?php _e("Pages to include RevSlider libraries:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<input type="text" class="regular-text" id="pages_for_includes" name="pages_for_includes" value="<?php echo $pages_for_includes; ?>">			
								<div class="description_container">
									<span class="description"><?php _e("Specify the page id's that the front end includes will be included in. Example: 2,3,5 also: homepage,3,4",REVSLIDER_TEXTDOMAIN)?></span>
				
								</div>
							</td>
						</tr>								
						<tr id="js_to_footer_row" valign="top">
							<th scope="row">
								<?php _e("Insert JavaSscript Into Footer:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<span id="js_to_footer_wrapper" class="radio_settings_wrapper">
									<div class="radio_inner_wrapper">
										<input type="radio" id="js_to_footer_1" value="on" name="js_to_footer" <?php checked($js_to_footer, 'on'); ?>>
										<label for="js_to_footer_1" style="cursor:pointer;"><?php _e("On",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>
					
									<div class="radio_inner_wrapper">
										<input type="radio" id="js_to_footer_2" value="off" name="js_to_footer" <?php checked($js_to_footer, 'off'); ?>>
										<label for="js_to_footer_2" style="cursor:pointer;"><?php _e("Off",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>					
								</span>					
								<div class="description_container">
									<span class="description"><?php _e("Putting the js to footer (instead of the head) is good for fixing some javascript conflicts.",REVSLIDER_TEXTDOMAIN)?></span>				
								</div>
							</td>
						</tr>									
						<tr id="show_dev_export_row" valign="top">
							<th scope="row">
								<?php _e("Enable Markup Export option:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<span id="js_to_footer_wrapper" class="radio_settings_wrapper">
									<div class="radio_inner_wrapper">
										<input type="radio" id="show_dev_export_1" value="on" name="show_dev_export" <?php checked($show_dev_export, 'on'); ?>>
										<label for="show_dev_export_1" style="cursor:pointer;"><?php _e("On",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>
					
									<div class="radio_inner_wrapper">
										<input type="radio" id="show_dev_export_2" value="off" name="show_dev_export" <?php checked($show_dev_export, 'off'); ?>>
										<label for="show_dev_export_2" style="cursor:pointer;"><?php _e("Off",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>					
								</span>					
								<div class="description_container">
									<span class="description"><?php _e("This will enable the option to export the Slider Markups to copy/paste it directly into websites.",REVSLIDER_TEXTDOMAIN)?></span>				
								</div>
							</td>
						</tr>
						
						<tr id="use_hammer_js_row" valign="top">
							<th scope="row">
								<?php _e("Enable Logs:",REVSLIDER_TEXTDOMAIN); ?>
							</th>
							<td>
								<span id="enable_logs_wrapper" class="radio_settings_wrapper">
									<div class="radio_inner_wrapper">
										<input type="radio" id="enable_logs_1" value="on" name="enable_logs" <?php checked($enable_logs, 'on'); ?>>
										<label for="enable_logs_1" style="cursor:pointer;"><?php _e("On",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>
					
									<div class="radio_inner_wrapper">
										<input type="radio" id="use_hammer_js_2" value="off" name="enable_logs" <?php checked($enable_logs, 'off'); ?>>
										<label for="use_hammer_js_2" style="cursor:pointer;"><?php _e("Off",REVSLIDER_TEXTDOMAIN); ?></label>
									</div>
								</span>
								<div class="description_container">
									<span class="description"><?php _e("Enable console logs for debugging.",REVSLIDER_TEXTDOMAIN)?></span>				
								</div>
							</td>
						</tr>								
				</tbody>
			</table>				
		</form>
	</div>
<br>

<a id="button_save_general_settings" class="button-primary" original-title=""><?php _e("Update",REVSLIDER_TEXTDOMAIN); ?></a>
<span id="loader_general_settings" class="loader_round mleft_10" style="display: none;"></span>

<!-- 
&nbsp;
<a class="button-primary">Close</a>
-->

</div>
