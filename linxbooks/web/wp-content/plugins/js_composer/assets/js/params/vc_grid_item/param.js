/* =========================================================
 * vc_grid_element.js v1.0
 * =========================================================
 * Copyright 2014 WPBakery
 *
 * Shortcodes params grid element attribute for edit form
 * ========================================================= */
// Safety first
if (_.isUndefined(window.vc)) var vc = {atts:{}};
(function ($) {
	"use strict";
	vc.atts.vc_grid_item = {
		init:function (param, $field) {
			this.content().find('[data-param_name="' + param.param_name + '"] [data-vc-grid-element="value"]')
				.change(function(){
					var value = $(this).val(),
						url = $(this).find('[value=' + value +']').data('vcLink');
					if(value) {
						$(this).parents('[data-param_name="' + param.param_name + '"]:first')
							.find('[data-vc-grid-item="edit_link"]').attr('href', url);
					}
			}).trigger('change');
			/*
			// Iterate through all params_preset selects and build backbone view
			$('[data-vc-grid-element="container"]', $field).each(function () {
				var $this = $(this);
				_.isUndefined($this.data('vcFieldManager')) && $this.data('vcFieldManager',
					new vc.VcGridElementView({el:this}).render());
			});
			*/
		},
		parse: function(param) {
			var $field = this.content().find('[data-param_name="' + param.param_name + '"] [data-vc-grid-element="value"]');
			/*
				fieldManager = $param_container.find('[data-vc-grid-element="container"]').data('vcFieldManager');
			return fieldManager ? fieldManager.save() : '';
			*/
			return $field.length ? $field.val() : '';
		}
	};

})(window.jQuery);