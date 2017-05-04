/* =========================================================
 * param_preset.js v1.0
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Shortcodes params preset attribute for edit form
 * ========================================================= */
// Safety first
if (_.isUndefined(window.vc)) var vc = {atts: {}};
(function ($) {
	/**
	 * Backbone view for params preset
	 * @type {*}
	 */
	var ParamsPresetView = Backbone.View.extend({
		events: {
			'change': 'setParams'
		},
		/**
		 * Sets params for defined fields
		 */
		setParams: function () {
			var val = this.save(),
				$option = this.$el.find('[value="' + val + '"]'),
				data,
				$edit_form = vc.edit_element_block_view.content(),
				$params_preset = this.$el;
			if ($option.length) {
				data = $option.data('params');
				var fields = [];
				_.each(data, function (value, key, list) {
					var $field = $edit_form.find('[name=' + key + '].wpb_vc_param_value'),
						fieldManager;
					if ($field.length) {
						$field.unbind('change.vcParamsPreset');
						fieldManager = $field.data('vcFieldManager');
						fieldManager && fieldManager.render && fieldManager.render(value);
						fields.push($field);
						$field.val(value).trigger('change');
					}
				});
				_.each(fields, function (value, key ) {
					value.bind('change.vcParamsPreset', function (e) {
						if(_.isUndefined(e.extra_type)) {
							$params_preset.val('');
						}
					});
				});
			}
		},
		// Render value
		render: function () {
			this.setParams();
			return this;
		},
		// Return select value;
		save: function () {
			return this.$el.val();
		}
	});

	vc.atts.params_preset = {
		parse: function(param) {
			var $el = $('select[name=' + param.param_name + ']', this.content());
			if($el && $el.data('fieldManager')) {
				return $el.data('fieldManager').save();
			}
			return "";
		},
		init: function (param, $field) {
			// Iterate through all params_preset selects and build backbone view
			$('.vc_params-preset-select', $field).each(function () {
				var $this = $(this);
				_.isUndefined($this.data('fieldManager')) && $this.data('fieldManager',
					new ParamsPresetView({el: $this}).render());
			});
		}
	};

})(window.jQuery);