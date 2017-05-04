var vc_woocommerce_product_attribute_filter_dependency_callback = function () {
	(function ($, that) {
		var $filter_dropdown = $('.vc_shortcode-param.vc_dependent-hidden', that.$content);
		$filter_dropdown.removeClass('vc_dependent-hidden');
		var $empty = $('#filter-empty', $filter_dropdown);
		if ($empty.length) {
			$empty.parent().remove();
			$('.edit_form_line', $filter_dropdown).prepend($("<div class='vc_checkbox-label'><span>No values found</span></div>"));
		}
		$('select[name="attribute"]', that.$content).change(function () {
			$('.vc_checkbox-label', $filter_dropdown).remove();
			$filter_dropdown.removeClass('vc_dependent-hidden');

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: window.ajaxurl,
				data: {
					action: 'vc_woocommerce_get_attribute_terms',
					attribute: this.value
				}
			}).done(function (data) {
				if (data.length > 0) {
					$('.edit_form_line', $filter_dropdown).prepend($(data));
				} else {
					$('.edit_form_line', $filter_dropdown).prepend($("<div class='vc_checkbox-label'><span>No values found</span></div>"));
				}
			});
		});
	})(window.jQuery, this);
};
