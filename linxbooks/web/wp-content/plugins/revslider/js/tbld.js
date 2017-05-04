(function() {
	tinymce.create('tinymce.plugins.revslider', {
 
		init : function(ed, url) {
		},
		createControl : function(n, cm) {
 
            if(n=='revslider'){
                var mlb = cm.createListBox('revslider', {
                     title: 'Revolution Slider',
                     onselect : function(v) {
                     	if(tinyMCE.activeEditor.selection.getContent() == ''){
                            tinyMCE.activeEditor.selection.setContent( v )
                        }
                     }
                });
 
                for(var i in revslider_shortcodes)
                	mlb.add(revslider_shortcodes[i],revslider_shortcodes[i]);
 
                return mlb;
            }
            return null;
        }
 
 
	});
	tinymce.PluginManager.add('revslider', tinymce.plugins.revslider);
	
	setTimeout(function() {
		jQuery('.mce-widget.mce-btn').each(function() {
			var btn = jQuery(this);
			if (btn.attr('aria-label')=="Revolution Slider")
				btn.find('span').css({padding:"10px 20px 10px 10px"});
		});
	},1000);
	
})();