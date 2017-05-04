jQuery(document).on('acf/setup_fields', function(e, el){
	// Redeclare active editor.
	setTimeout(function(){
		jQuery('#content-html').trigger('click');
	}, 10);
});