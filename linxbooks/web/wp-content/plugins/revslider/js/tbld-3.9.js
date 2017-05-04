(function() {
"use strict";   
	
	var rs_val = [];
	
	for(var i in revslider_shortcodes){
		rs_val[i] = {text: revslider_shortcodes[i], onclick : function() {
			//tinymce.execCommand('mceInsertContent', false, revslider_shortcodes[i]);
		}};
	}
	
	tinymce.PluginManager.add( 'revslider', function( editor, url ) {

		editor.addButton( 'revslider', {
			type: 'listbox',
			title: 'Revolution Slider',			
			text: 'RevSlider',
			icon: false,
			onselect: function(e) {
				tinymce.execCommand('mceInsertContent', false, e.control['_text']);
			}, 
			values: rs_val
 
		});
	});
	
	setTimeout(function() {
		jQuery('.mce-widget.mce-btn').each(function() {
			var btn = jQuery(this);
			if (btn.attr('aria-label')=="Revolution Slider")
				btn.find('span').css({padding:"10px 20px 10px 10px"});
		});
	},1000);
 
})();