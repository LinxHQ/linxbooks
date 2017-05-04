/* =========================================================
 * params/all.js v0.0.1
 * =========================================================
 * Copyright 2012 Wpbakery
 *
 * Visual composer javascript functions to enable fields.
 * This script loads with settings form.
 * ========================================================= */

(function ($) {
	var InitGalleries = function () {
		// TODO: Backbone style for view binding
		$('.gallery_widget_attached_images_list', this.$view).unbind('click.removeImage').on('click.removeImage', 'a.icon-remove', function (e) {
			e.preventDefault();
			var $block = $(this).closest('.edit_form_line');
			$(this).parent().remove();
			var img_ids = [];
			$block.find('.added img').each(function () {
				img_ids.push($(this).attr("rel"));
			});
			$block.find('.gallery_widget_attached_images_ids').val(img_ids.join(',')).trigger('change');
		});
		$('.gallery_widget_attached_images_list').each(function (index) {
			var $img_ul = $(this);
			$img_ul.sortable({
				forcePlaceholderSize: true,
				placeholder: "widgets-placeholder-gallery",
				cursor: "move",
				items: "li",
				update: function () {
					var img_ids = [];
					$(this).find('.added img').each(function () {
						img_ids.push($(this).attr("rel"));
					});
					$img_ul.closest('.edit_form_line').find('.gallery' +
					'' +
					'_widget_attached_images_ids').val(img_ids.join(',')).trigger('change');
				}
			});
		});
	};
	new InitGalleries();

	var $tabs = $('#vc_edit-form-tabs');
	if ($tabs.length) {
        $('.wpb-edit-form').addClass('vc_with-tabs');
		$tabs.find('.vc_edit-form-tab-control').removeClass('vc_active').eq(0).addClass('vc_active');
		$tabs.find('.vc_edit-form-tab').removeClass('vc_active').eq(0).addClass('vc_active');
        $tabs.find('.vc_edit-form-link').click(function(e){
            var $this = $(this);
            e.preventDefault();
            $tabs.find('.vc_active').removeClass('vc_active');
            $this.parent().addClass('vc_active');
            $($this.attr('href')).addClass('vc_active');
        });
	}


})(window.jQuery);
