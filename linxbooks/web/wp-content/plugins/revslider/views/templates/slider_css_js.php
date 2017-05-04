<?php
$custom_css = '';
$custom_js = '';
if(!empty($sliderID)){
	$custom_css = @stripslashes($arrFieldsParams['custom_css']);
	$custom_js = @stripslashes($arrFieldsParams['custom_javascript']);
}
?>
	<div id="toolbox_wrapper" class="toolbox_wrapper postbox unite-postbox rs-cm-refresh">
		<h3 class="box_closed tp-accordion tpa-closed"><div class="postbox-arrow"></div><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-magic"></i><span><?php _e("CSS / JavaScript",REVSLIDER_TEXTDOMAIN) ?></span></h3>
		<div class="toggled-content tp-closedatstart p20">
			
			<div class="api-caption"><?php _e("Custom CSS",REVSLIDER_TEXTDOMAIN)?>:</div>
			<div class="divide5"></div>
			<textarea name="custom_css" id="rs_custom_css"><?php echo $custom_css; ?></textarea>
			<div class="divide20"></div>
			
			<div class="api-caption"><?php _e("Custom JavaScript",REVSLIDER_TEXTDOMAIN)?>:</div>
			<div class="divide5"></div>
			<textarea name="custom_javascript" id="rs_custom_javascript"><?php echo $custom_js; ?></textarea>
			<div class="divide20"></div>
			
		</div>
	</div>
	
	<script type="text/javascript">
		rev_cm_custom_css = null;
		rev_cm_custom_js = null;
		
		jQuery(document).ready(function(){
			rev_cm_custom_css = CodeMirror.fromTextArea(document.getElementById("rs_custom_css"), {
				onChange: function(){ },
				lineNumbers: true
			});
			
			rev_cm_custom_js = CodeMirror.fromTextArea(document.getElementById("rs_custom_javascript"), {
				onChange: function(){ },
				lineNumbers: true
			});
			
			
			jQuery('.rs-cm-refresh').click(function(){
				rev_cm_custom_css.refresh();
				rev_cm_custom_js.refresh();
			});
		});
	</script>
	

