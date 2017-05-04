/* =========================================================
 * css_editor.js v1.0.1
 * =========================================================
 * Copyright 2014 Wpbakery
 *
 * Shortcodes css editor for edit form backbone/underscore version
 * ========================================================= */
// Safety first
/** global window.i18nLocale */
if (_.isUndefined(window.vc)) var vc = {atts: {}};
(function ($) {
	var preloaderUrl = ajaxurl.replace(/admin\-ajax\.php/, 'images/wpspin_light.gif'),
		template_options = {
			evaluate: /<#([\s\S]+?)#>/g,
			interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
			escape: /\{\{([^\}]+?)\}\}(?!\})/g
		},
		removeOldDesignOptions;
	wp.media.controller.VcCssSingleImage = wp.media.controller.VcSingleImage.extend({
		setCssEditor: function (view) {
			if (view) this._css_editor = view;
			return this;
		},
		updateSelection: function () {
			var selection = this.get('selection'),
				id = this._css_editor.getBackgroundImage(),
				attachment;
			if (id) {
				attachment = wp.media.model.Attachment.get(id);
				attachment.fetch();
			}
			selection.reset(attachment ? [attachment] : []);
		}
	});
	/**
	 * Css editor view.
	 * @type {*}
	 */
	var VcCssEditor;
	VcCssEditor = vc.CssEditor = Backbone.View.extend({
		attrs: {},
		layouts: ['margin', 'border-width', 'padding'],
		positions: ['top', 'right', 'bottom', 'left'],
		$field: false,
		simplify: false,
		$simplify: false,
		events: {
			'click .icon-remove': 'removeImage',
			'click .vc_add-image': 'addBackgroundImage',
			'change .vc_simplify': 'changeSimplify'
		},
		initialize: function () {
			// _.bindAll(wp.media.vc_css_editor, 'open');
			_.bindAll(this, 'setSimplify')
		},
		render: function (value) {
			this.attrs = {};
			this.$simplify = this.$el.find('.vc_simplify');
			_.isString(value) && this.parse(value);
			// wp.media.vc_css_editor.init(this);
			return this;
		},
		parse: function (value) {
			var data_split = value.split(/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/g);
			data_split[2] && this.parseAtts(data_split[2].replace(/\s+!important/g, ''));
		},
		addBackgroundImage: function (e) {
			e.preventDefault();
			if (this.image_media)
				return this.image_media.open('vc_editor');
			this.image_media = wp.media({
				state: 'vc_single-image',
				states: [new wp.media.controller.VcCssSingleImage().setCssEditor(this)]
			});
			this.image_media.on('toolbar:create:vc_single-image', function (toolbar) {
				this.createSelectToolbar(toolbar, {
					text: window.i18nLocale.set_image
				});
			}, this.image_media);
			this.image_media.state('vc_single-image').on('select', this.setBgImage);
			this.image_media.open('vc_editor');
		},
		setBgImage: function () {
			var selection = this.get('selection').single();
			selection && this._css_editor.$el.find('.vc_background-image .vc_image').html(_.template($('#vc_css-editor-image-block').html(), selection.attributes, _.extend({variable: 'img'}, template_options)));
		},
		setCurrentBgImage: function (value) {
			var image_regexp = /([^\?]+)(\?id=\d+){0,1}/, url = '', id = '', image_split;
			if (value.match(/^\d+$/)) {
				this.$el.find('.vc_background-image .vc_image').html(_.template($('#vc_css-editor-image-block').html(), {
					url: preloaderUrl,
					id: value,
					css_class: 'vc_preview'
				}, _.extend({variable: 'img'}, template_options)));
				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wpb_single_image_src',
						content: value,
						size: 'full'
					},
					dataType: 'html',
					context: this
				}).done(function (url) {
					this.$el.find('.vc_ce-image').attr('src', url + '?id=' + value).removeClass('vc_preview');
				});
			} else if (value.match(image_regexp)) {
				image_split = value.split(image_regexp);
				url = image_split[1];
				if (image_split[2]) id = image_split[2].replace(/[^\d]+/, '');
				this.$el.find('.vc_background-image .vc_image').html(_.template($('#vc_css-editor-image-block').html(), {
					url: url,
					id: id
				}, _.extend({variable: 'img'}, template_options)));
			}
		},
		changeSimplify: function () {
			var f = _.debounce(this.setSimplify, 100);
			f && f();
		},
		setSimplify: function () {
			this.simplifiedMode(this.$simplify.is(':checked'));

		},
		simplifiedMode: function (enable) {
			if (enable) {
				this.simplify = true;
				this.$el.addClass('vc_simplified');
			} else {
				this.simplify = false;
				this.$el.removeClass('vc_simplified');
				_.each(this.layouts, function (attr) {
					if (attr === 'border-width') attr = 'border';
					var $control = $('[data-attribute=' + attr + '].vc_top');
					this.$el.find('[data-attribute=' + attr + ']:not(.vc_top)').val($control.val());
				}, this);
			}
		},
		removeImage: function (e) {
			var $control = $(e.currentTarget);
			e.preventDefault();
			$control.parent().remove();
		},
		getBackgroundImage: function () {
			return this.$el.find('.vc_ce-image').data('imageId');
		},
		parseAtts: function (string) {
			var border_regex, background_regex, background_size;
			border_regex = /(\d+\S*)\s+(\w+)\s+([\d\w#\(,]+)/;
			background_regex = /^([^\s]+)\s+url\(([^\)]+)\)([\d\w]+\s+[\d\w]+)?$/;
			background_size = false;
			_.map(string.split(';'), function (val) {
				var val_s = val.split(/:\s/), val_pos, border_split, background_split,
					value = val_s[1] || '',
					name = val_s[0] || '';
				if (value) value = value.trim();
				if (name.match(new RegExp('^(' + this.layouts.join('|').replace('-', '\\-') + ')$')) && value) {
					val_pos = value.split(/\s+/g);
					if (val_pos.length == 1) {
						val_pos = [val_pos[0], val_pos[0], val_pos[0], val_pos[0]];
					} else if (val_pos.length === 2) {
						val_pos[2] = val_pos[0];
						val_pos[3] = val_pos[1];
					} else if (val_pos.length === 3) {
						val_pos[3] = val_pos[1];
					}
					_.each(this.positions, function (pos, key) {
						this.$el.find('[data-name=' + name + '-' + pos + ']').val(val_pos[key]);
					}, this);
				} else if (name === 'background-size') {
					background_size = value;
					this.$el.find('[name=background_style]').val(value);
				} else if (name === 'background-repeat' && !background_size) {
					this.$el.find('[name=background_style]').val(value);
				} else if (name === 'background-image') {
					this.setCurrentBgImage(value.replace(/url\(([^\)]+)\)/, '$1'));
				} else if (name === 'background' && value) {
					background_split = value.split(background_regex);
					background_split[1] && this.$el.find('[name=' + name + '_color]').val(background_split[1]);
					background_split[2] && this.setCurrentBgImage(background_split[2]);
				} else if (name == 'border' && value && value.match(border_regex)) {
					border_split = value.split(border_regex);
					val_pos = [border_split[1], border_split[1], border_split[1], border_split[1]];
					_.each(this.positions, function (pos, key) {
						this.$el.find('[name=' + name + '_' + pos + '_width]').val(val_pos[key]);
					}, this);
					this.$el.find('[name=border_style]').val(border_split[2]);
					this.$el.find('[name=border_color]').val(border_split[3]).trigger('change');
				} else if (name.indexOf('border') != -1 && value) {
					if (name.indexOf('style') != -1) {
						this.$el.find('[name=border_style]').val(value);
					} else if (name.indexOf('color') != -1) {
						this.$el.find('[name=border_color]').val(value).trigger('change');
					} else if (name.match(/^[\w\-\d]+$/)) {
						this.$el.find('[name=' + name.replace(/\-+/g, '_') + ']').val(value);
					}
				} else if (name.match(/^[\w\-\d]+$/) && value) {
					this.$el.find('[name=' + name.replace(/\-+/g, '_') + ']').val(value);
				}
			}, this);
		},
		save: function () {
			var string = '';
			this.attrs = {};
			_.each(this.layouts, function (type) {
				this.getFields(type)
			}, this);
			this.getBackground();
			this.getBorder();
			if (!_.isEmpty(this.attrs)) {
				string = '.vc_custom_' + (+new Date) + '{' + _.reduce(this.attrs, function (memo, value, key) {
					return value ? memo + key + ': ' + value + ' !important;' : memo;
				}, '', this) + '}';
			}
			string && vc.frame_window && vc.frame_window.vc_iframe.setCustomShortcodeCss(string);
			return string;
		},
		getBackgroundImageSrc: function () {
			return this.$el.find('.vc_background-image img').attr('src');
		},
		getBackgroundColor: function () {
			return this.$el.find('[name=background_color]').val();
		},
		getBackgroundStyle: function () {
			return this.$el.find('[name=background_style]').val();
		},
		getBackground: function () {
			var color = this.getBackgroundColor(),
				image = this.getBackgroundImageSrc(),
				style = this.getBackgroundStyle();
			if (color && image) {
				this.attrs['background'] = color + ' ' + 'url(' + image + ')';
			} else if (color) {
				this.attrs['background-color'] = color;
			} else if (image) {
				this.attrs['background-image'] = 'url(' + image + ')';
			}
			if (style.match(/repeat/)) {
				this.attrs['background-position'] = '0 0';
				this.attrs['background-repeat'] = style;
			} else if (style.match(/cover|contain/)) {
				this.attrs['background-position'] = 'center';
				this.attrs['background-repeat'] = 'no-repeat';
				this.attrs['background-size'] = style;
			}
			if (color.match(/^rgba/)) {
				this.attrs['*background-color'] = color.replace(/\s+/, '').replace(/(rgb)a\((\d+)\,(\d+),(\d+),[^\)]+\)/, '$1($2,$3,$4)');
			}
		},
		getBorder: function () {
			var style = this.$el.find('[name=border_style]').val(),
				color = this.$el.find('[name=border_color]').val();
			var sides = ['left', 'right', 'top', 'bottom'];
			if (style && color && this.attrs['border-width'] && this.attrs['border-width'].match(/^\d+\S+$/)) {
				this.attrs.border = this.attrs['border-width'] + ' ' + style + ' ' + color;
				this.attrs['border-width'] = undefined;
			} else {
				_.each(sides, function (side) {
					if (this.attrs['border-' + side + '-width']) {
						if (color) this.attrs['border-' + side + '-color'] = color;
						if (style) this.attrs['border-' + side + '-style'] = style;
					}
				}, this);
			}
		},
		getFields: function (type) {
			var data = [];
			if (this.simplify) return this.getSimplifiedField(type);
			_.each(this.positions, function (pos) {
				var val = this.$el.find('[data-name=' + type + '-' + pos + ']').val().replace(/\s+/, '');
				if (!val.match(/^\d*(\.\d?){0,1}(%|in|cm|mm|em|rem|ex|pt|pc|px|vw|vh|vmin|vmax)$/)) {
					val = (isNaN(parseFloat(val)) ? '' : '' + parseFloat(val) + 'px');
				}
				val.length && data.push({name: pos, val: val});
			}, this);
			_.each(data, function (attr) {
				var attr_name = type == 'border-width' ? 'border-' + attr.name + '-width' : type + '-' + attr.name;
				this.attrs[attr_name] = attr.val;
			}, this);
		},
		getSimplifiedField: function (type) {
			var pos = 'top',
				val = this.$el.find('[data-name=' + type + '-' + pos + ']').val().replace(/\s+/, '');
			if (!val.match(/^\d*(\.\d?){0,1}(%|in|cm|mm|em|rem|ex|pt|pc|px|vw|vh|vmin|vmax)$/)) {
				val = (isNaN(parseFloat(val)) ? '' : '' + parseFloat(val) + 'px');
			}
			if (val.length) this.attrs[type] = val;
		}
	});
	/**
	 * Add new param to atts types list for vc
	 * @type {Object}
	 */
	vc.atts.css_editor = {
		parse: function (param) {
			var $field, css_editor, result;
			$field = this.content().find('input.wpb_vc_param_value[name="' + param.param_name + '"]' );
			css_editor = $field.data('vcFieldManager');
			result = css_editor.save();

			if (result) vc.edit_form_callbacks.push(removeOldDesignOptions);
			return result;
		},
		init: function (param, $field) {
			/**
			 * Find all fields with css_editor type and initialize.
			 */
			$('[data-css-editor=true]', this.content()).each(function () {
				var $editor = $(this),
					$param = $editor.find('input.wpb_vc_param_value[name="' + param.param_name +'"]' ),
					value = $param.val();
				if (!value) value = parseOldDesignOptions();
				$param.data('vcFieldManager', new VcCssEditor({el: $editor}).render(value));
			});
			vc.atts.colorpicker.init.call(this, param, $field);
		}
	};
	/**
	 * Backward capability for old css attributes
	 * @return {String} - Css settings with class name and css attributes settings.
	 */
	var parseOldDesignOptions = function () {
		var keys = {
				'bg_color': 'background-color',
				'padding': 'padding',
				'margin_bottom': 'margin-bottom',
				'bg_image': 'background-image'
			},
			params = vc.edit_element_block_view.model.get('params'),
			cssString = _.reduce(keys, function (memo, css_name, attr_name) {
			var value = params[attr_name];
			if (_.isUndefined(value) || !value.length) return memo;
			if (attr_name === 'bg_image')  value = 'url(' + value + ')';
			return memo + css_name + ': ' + value + ';';
		}, '', this);
		return cssString ? '.tmp_class{' + cssString + '}' : '';
	};
	removeOldDesignOptions = function () {
		this.params = _.omit(this.params, 'bg_color', 'padding', 'margin_bottom', 'bg_image');
	};

})(window.jQuery);