/* =========================================================
 * composer-atts.js v0.2.1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer backbone/underscore shortcodes attributes
 * form field and parsing controls
 * ========================================================= */
var vc = {
	filters: {templates: []}, addTemplateFilter: function (callback) {
		if (_.isFunction(callback)) this.filters.templates.push(callback);
	}
};
(function ($) {

	var wpb_change_tab_title, wpb_change_accordion_tab_title, vc_activeMce;

	wpb_change_tab_title = function ($element, field) {
		$('.tabs_controls a[href=#tab-' + $(field).val() + ']').text($('.wpb-edit-form [name=title].wpb_vc_param_value').val());
	};
	wpb_change_accordion_tab_title = function ($element, field) {
		var $section_title = $element.prev();
		$section_title.find('a').text($(field).val());
	};

	window.init_textarea_html = function ($element) {

		/*
		 Simple version without all this buttons from Wordpress
		 tinyMCE.init({
		 mode : "textareas",
		 theme: 'advanced',
		 editor_selector: $element.attr('name') + '_tinymce'
		 });
		 */
		var $wp_link = $('#wp-link')
		if ($wp_link.parent().hasClass('wp-dialog')) $wp_link.wpdialog('destroy');
		var qt, textfield_id = $element.attr("id"),
			$form_line = $element.closest('.edit_form_line'),
			$content_holder = $form_line.find('.vc_textarea_html_content'),
			content = $content_holder.val();
		// Init Quicktag
		if (_.isUndefined(tinyMCEPreInit.qtInit[textfield_id])) {
			window.tinyMCEPreInit.qtInit[textfield_id] = _.extend({}, window.tinyMCEPreInit.qtInit[window.wpActiveEditor], {id: textfield_id})
		}
		// Init tinymce
		if (window.tinyMCEPreInit && window.tinyMCEPreInit.mceInit[window.wpActiveEditor]) {
			window.tinyMCEPreInit.mceInit[textfield_id] = _.extend({}, window.tinyMCEPreInit.mceInit[window.wpActiveEditor], {
				resize: 'vertical',
				height: 200,
				id: textfield_id,
				setup: function (ed) {
					if (typeof(ed.on) != 'undefined') {
						ed.on('init', function (ed) {
							ed.target.focus();
							window.wpActiveEditor = textfield_id;
						});
					} else {
						ed.onInit.add(function (ed) {
							ed.focus();
							window.wpActiveEditor = textfield_id;
						});
					}
				}
			});
			window.tinyMCEPreInit.mceInit[textfield_id].plugins = window.tinyMCEPreInit.mceInit[textfield_id].plugins.replace(/,?wpfullscreen/, '');
		}
		$element.val($content_holder.val());
		qt = quicktags(window.tinyMCEPreInit.qtInit[textfield_id]);
		QTags._buttonsInit();
		if (window.tinymce) {
			window.switchEditors && window.switchEditors.go(textfield_id, 'tmce');
			if (tinymce.majorVersion === "4") tinymce.execCommand('mceAddEditor', true, textfield_id);
		}
		vc_activeMce = textfield_id;
		window.wpActiveEditor = textfield_id;
	};
	function init_textarea_html_old($element) {
		var textfield_id = $element.attr("id"),
			$form_line = $element.closest('.edit_form_line'),
			$content_holder = $form_line.find('.vc_textarea_html_content');
		$('#' + textfield_id + '-html').trigger('click');
		var $tmce = $('.switch-tmce');
		$tmce.trigger('click');
		$form_line.find('.wp-switch-editor').removeAttr("onclick");
		$tmce.trigger('click');
		$element.closest('.edit_form_line').find('.switch-tmce').click(function () {
			window.tinyMCE.execCommand("mceAddControl", true, textfield_id);
			window.switchEditors.go(textfield_id, 'tmce');
			$element.closest('.edit_form_line').find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
			var val = window.switchEditors.wpautop($(this).closest('.edit_form_line').find("textarea.visual_composer_tinymce").val());
			$("textarea.visual_composer_tinymce").val(val);
			// Add tinymce
			window.tinyMCE.execCommand("mceAddControl", true, textfield_id);
		});
		$element.closest('.edit_form_line').find('.switch-html').click(function () {
			$element.closest('.edit_form_line').find('.wp-editor-wrap').removeClass('tmce-active').addClass('html-active');
			window.tinyMCE.execCommand("mceRemoveControl", true, textfield_id);
		});
		$('#wpb_tinymce_content-html').trigger('click');
		$('#wpb_tinymce_content-tmce').trigger('click'); // Fix hidden toolbar
	}

	// TODO: unsecure. Think about it
	Color.prototype.toString = function () {
		if (this._alpha < 1) {
			return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
		}
		var hex = parseInt(this._color, 10).toString(16);
		if (this.error)
			return '';
		// maybe left pad it
		if (hex.length < 6) {
			for (var i = 6 - hex.length - 1; i >= 0; i--) {
				hex = '0' + hex;
			}
		}
		return '#' + hex;
	};

	var template_options = {
		evaluate: /<#([\s\S]+?)#>/g,
		interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
		escape: /\{\{([^\}]+?)\}\}(?!\})/g
	};

	/**
	 * Loop param for shortcode with magic query posts constructor.
	 * ====================================
	 */
	vc.loop_partial = function (template_name, key, loop, settings) {
		var data = _.isObject(loop) && !_.isUndefined(loop[key]) ? loop[key] : '';
		return _.template($('#_vcl-' + template_name).html(), {
			name: key,
			data: data,
			settings: settings
		}, template_options);
	};
	vc.loop_field_not_hidden = function (key, loop) {
		return !(_.isObject(loop[key]) && _.isBoolean(loop[key].hidden) && loop[key].hidden === true);
	};
	vc.is_locked = function (data) {
		return _.isObject(data) && _.isBoolean(data.locked) && data.locked === true;
	};

	var Suggester = function (element, options) {
		this.el = element;
		this.$el = $(this.el);
		this.$el_wrap = '';
		this.$block = '';
		this.suggester = '';
		this.selected_items = [];
		this.options = _.isObject(options) ? options : {};
		_.defaults(this.options, {
			css_class: 'vc_suggester',
			limit: false,
			source: {},
			predefined: [],
			locked: false,
			select_callback: function (label, data) {
			},
			remove_callback: function (label, data) {
			},
			update_callback: function (label, data) {
			},
			check_locked_callback: function (el, data) {
				return false;
			}
		});
		this.init();
	};

	Suggester.prototype = {
		constructor: Suggester,
		init: function () {
			_.bindAll(this, 'buildSource', 'itemSelected', 'labelClick', 'setFocus', 'resize');
			var that = this;
			this.$el.wrap('<ul class="' + this.options.css_class + '"><li class="input"/></ul>');

			this.$el_wrap = this.$el.parent();
			this.$block = this.$el_wrap.closest('ul').append($('<li class="clear"/>'));
			this.$el.focus(this.resize).blur(function () {
				$(this).parent().width(170);
				$(this).val('');
			});
			this.$block.click(this.setFocus);
			this.suggester = this.$el.data('suggest'); // Remove form here
			this.$el.autocomplete({
				source: this.buildSource,
				select: this.itemSelected,
				minLength: 2,
				focus: function (event, ui) {
					return false;
				}
			}).data("ui-autocomplete")._renderItem = function (ul, item) {
				return $('<li data-value="' + item.value + '">')
					.append("<a>" + item.name + "</a>")
					.appendTo(ul);
			};
			this.$el.autocomplete("widget").addClass('vc_ui-front')
			if (_.isArray(this.options.predefined)) {
				_.each(this.options.predefined, function (item) {
					this.create(item);
				}, this);
			}
		},
		resize: function () {
			var position = this.$el_wrap.position(),
				block_position = this.$block.position();
			this.$el_wrap.width(parseFloat(this.$block.width()) - (parseFloat(position.left) - parseFloat(block_position.left) + 4));
		},
		setFocus: function (e) {
			e.preventDefault();
			var $target = $(e.target);
			if ($target.hasClass(this.options.css_class)) {
				this.$el.trigger('focus');
			}
		},
		itemSelected: function (event, ui) {
			this.$el.blur();
			this.create(ui.item);
			this.$el.focus();
			return false;
		},
		create: function (item) {
			var index = (this.selected_items.push(item) - 1),
				remove = this.options.check_locked_callback(this.$el, item) === true ? '' : ' <a class="remove">&times;</a>',
				$label,
				exclude_css = '';
			if (_.isUndefined(this.selected_items[index].action)) this.selected_items[index].action = '+';
			exclude_css = this.selected_items[index].action === '-' ? ' exclude' : ' include';
			$label = $('<li class="vc_suggest-label' + exclude_css + '" data-index="' + index + '" data-value="' + item.value + '"><span class="label">' + item.name + '</span>' + remove + '</li>');
			$label.insertBefore(this.$el_wrap);
			if (!_.isEmpty(remove)) $label.click(this.labelClick);
			this.options.select_callback($label, this.selected_items);
		},
		labelClick: function (e) {
			e.preventDefault();
			var $label = $(e.currentTarget),
				index = parseInt($label.data('index'), 10),
				$target = $(e.target);
			if ($target.is('.remove')) {
				delete this.selected_items[index];
				this.options.remove_callback($label, this.selected_items);
				$label.remove();
				return false;
			}
			this.selected_items[index].action = this.selected_items[index].action === '+' ? '-' : '+';
			if (this.selected_items[index].action == '+') {
				$label.removeClass('exclude').addClass('include');
			} else {
				$label.removeClass('include').addClass('exclude');
			}
			this.options.update_callback($label, this.selected_items);
		},
		buildSource: function (request, response) {
			var exclude = _.map(this.selected_items, function (item) {
				return item.value;
			}).join(',');
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: window.ajaxurl,
				data: {
					action: 'wpb_get_loop_suggestion',
					field: this.suggester,
					exclude: exclude,
					query: request.term
				}
			}).done(function (data) {
				response(data);
			});
		}
	};
	$.fn.suggester = function (option) {
		return this.each(function () {
			var $this = $(this),
				data = $this.data('suggester'),
				options = _.isObject(option) ? option : {};
			if (!data) $this.data('suggester', (data = new Suggester(this, option)));
			if (typeof option == 'string') data[option]();
		});
	};

	var VcLoopEditorView = Backbone.View.extend({
		className: 'loop_params_holder',
		events: {
			'click input, select': 'save',
			'change input, select': 'save',
			'change :checkbox[data-input]': 'updateCheckbox'
		},
		query_options: {

		},
		return_array: {},
		controller: '',
		initialize: function () {
			_.bindAll(this, 'save', 'updateSuggestion', 'suggestionLocked');
		},
		render: function (controller) {
			var that = this,
				template = _.template($('#vcl-loop-frame').html(), this.model, _.extend({}, template_options, {variable: 'loop'}));
			this.controller = controller;
			this.$el.html(template);
			this.controller.$el.append(this.$el);
			_.each($('[data-suggest]'), function (object) {
				var $field = $(object),
					current_value = window.decodeURIComponent($('[data-suggest-prefill=' + $field.data('suggest') + ']').val());
				$field.suggester({
					predefined: $.parseJSON(current_value),
					select_callback: this.updateSuggestion,
					update_callback: this.updateSuggestion,
					remove_callback: this.updateSuggestion,
					check_locked_callback: this.suggestionLocked
				});
			}, this);
			return this;
		},
		show: function () {
			this.$el.slideDown();
		},
		save: function (e) {
			this.return_array = {};
			_.each(this.model, function (value, key) {
				var value = this.getValue(key, value);
				if (_.isString(value) && !_.isEmpty(value)) this.return_array[key] = value;
			}, this);
			this.controller.setInputValue(this.return_array);
		},
		getValue: function (key, default_value) {
			var value = $('[name=' + key + ']', this.$el).val();
			return value;
		},
		hide: function () {
			this.$el.slideUp();
		},
		toggle: function () {
			if (!this.$el.is(':animated')) this.$el.slideToggle();
		},
		updateCheckbox: function (e) {
			var $checkbox = $(e.currentTarget),
				input_name = $checkbox.data('input'),
				$input = $('[data-name=' + input_name + ']', this.$el),
				value = [];
			$('[data-input=' + input_name + ']:checked').each(function () {
				value.push($(this).val());
			});
			$input.val(value);
			this.save();
		},
		updateSuggestion: function ($elem, data) {
			var value,
				$suggestion_block = $elem.closest('[data-block=suggestion]');
			value = _.reduce(data, function (memo, label) {
				if (!_.isEmpty(label)) {
					return memo + (_.isEmpty(memo) ? '' : ',') + (label.action === '-' ? '-' : '') + label.value;
				}
			}, '');
			$suggestion_block.find('[data-suggest-value]').val(value).trigger('change');
		},
		suggestionLocked: function ($elem, data) {
			var value = data.value,
				field = $elem.closest('[data-block=suggestion]').find('[data-suggest-value]').data('suggest-value');

			return this.controller.settings[field]
			&& _.isBoolean(this.controller.settings[field].locked)
			&& this.controller.settings[field].locked == true
			&& _.isString(this.controller.settings[field].value)
			&& _.indexOf(this.controller.settings[field].value.replace('-', '').split(/\,/), '' + value) >= 0;
		}
	});
	var VcLoop = Backbone.View.extend({
		events: {
			'click .vc_loop-build': 'showEditor'
		},
		initialize: function () {
			_.bindAll(this, 'createEditor');
			this.$input = $('.wpb_vc_param_value', this.$el);
			this.$button = this.$el.find('.vc_loop-build');
			this.data = this.$input.val();
			this.settings = $.parseJSON(window.decodeURIComponent(this.$button.data('settings')));
		},
		render: function () {
			return this;
		},
		showEditor: function (e) {
			e.preventDefault();
			if (_.isObject(this.loop_editor_view)) {
				this.loop_editor_view.toggle();
				return false;
			}
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: window.ajaxurl,
				data: {
					action: 'wpb_get_loop_settings',
					value: this.data,
					settings: this.settings,
					post_id: vc.post_id
				}
			}).done(this.createEditor);
		},
		createEditor: function (data) {
			this.loop_editor_view = new VcLoopEditorView({model: !_.isEmpty(data) ? data : {}});
			this.loop_editor_view.render(this).show();
		},
		setInputValue: function (value) {
			this.$input.val(_.map(value, function (value, key) {
				return key + ':' + value;
			}).join('|'));
		}
	});
	var VcOptionsField = Backbone.View.extend({
		events: {
			'click .vc_options-edit': 'showEditor',
			'click .vc_close-button': 'showEditor',
			'click input, select': 'save',
			'change input, select': 'save',
			'keyup input': 'save'
		},
		data: {},
		fields: {},
		initialize: function () {
			this.$button = this.$el.find('.vc_options-edit');
			this.$form = this.$el.find('.vc_options-fields');
			this.$input = this.$el.find('.wpb_vc_param_value');
			this.settings = this.$form.data('settings');
			this.parseData();
			this.render();
		},
		render: function () {
			var html = '';
			_.each(this.settings, function (field) {
				if (!_.isUndefined(this.data[field.name])) {
					field.value = this.data[field.name];
				} else if (!_.isUndefined(field.value)) {
					field.value = field.value.toString().split(',');
					this.data[field.name] = field.value;
				}
				this.fields[field.name] = field;
				var $field = $('#vcl-options-field-' + field.type);
				if ($field.is('script')) {
					html += _.template(
						$field.html(),
						$.extend({
							name: '',
							label: '',
							value: [],
							options: '',
							description: ''
						}, field),
						_.extend({}, template_options)
					);
				}
			}, this);
			this.$form.html(html + this.$form.html());
			return this;
		},
		parseData: function () {
			_.each(this.$input.val().split("|"), function (data) {
				if (data.match(/\:/)) {
					var split = data.split(':'),
						name = split[0],
						value = split[1];
					this.data[name] = _.map(value.split(','), function (v) {
						return window.decodeURIComponent(v);
					});
				}
			}, this);
		},
		saveData: function () {
			var data_string = _.map(this.data, function (value, key) {
				return key + ':' + _.map(value, function (v) {
					return window.encodeURIComponent(v);
				}).join(',');
			}).join('|');
			this.$input.val(data_string);
		},
		showEditor: function () {
			this.$form.slideToggle();
		},
		save: function (e) {
			var $field = $(e.currentTarget)
			if ($field.is(':checkbox')) {
				var value = [];
				this.$el.find('input[name=' + $field.attr('name') + ']').each(function () {
					if ($(this).is(':checked')) {
						value.push($(this).val());
					}
				});
				this.data[$field.attr('name')] = value;
			} else {
				this.data[$field.attr('name')] = [$field.val()];
			}
			this.saveData();
		}
	});

	/**
	 * VC_link power code.
	 */

	var VcSortedList = function (element, settings) {
		this.el = element;
		this.$el = $(this.el);
		this.$data_field = this.$el.find('.wpb_vc_param_value');
		this.$toolbar = this.$el.find('.vc_sorted-list-toolbar');
		this.$current_control = this.$el.find('.vc_sorted-list-container');
		_.defaults(this.options, {});
		this.init();
	};
	VcSortedList.prototype = {
		constructor: VcSortedList,
		init: function () {
			var that = this;
			_.bindAll(this, 'controlEvent', 'save');
			this.$toolbar.on('change', 'input', this.controlEvent);
			var selected_data = this.$data_field.val().split(',');
			for (var i in selected_data) {
				var control_settings = selected_data[i].split('|'),
					$control = control_settings.length ? this.$toolbar.find('[data-element=' + decodeURIComponent(control_settings[0]) + ']') : false;
				if ($control !== false && $control.is('input')) {
					$control.prop('checked', true);
					this.createControl({
						value: $control.val(),
						label: $control.parent().text(),
						sub: $control.data('subcontrol'),
						sub_value: _.map(control_settings.slice(1), function (item) {
							return window.decodeURIComponent(item)
						})
					});
				}
			}
			this.$current_control.sortable({
				stop: this.save
			}).on('change', 'select', this.save);
		},
		createControl: function (data) {
			var sub_control = '',
				selected_sub_value = _.isUndefined(data.sub_value) ? [] : data.sub_value;
			if (_.isArray(data.sub)) {
				_.each(data.sub, function (sub, index) {
					sub_control += ' <select>';
					_.each(sub, function (item) {
						sub_control += '<option value="' + item[0] + '"' + (_.isString(selected_sub_value[index]) && selected_sub_value[index] === item[0] ? ' selected="true"' : '') + '>' + item[1] + '</option>';
					});
					sub_control += '</select>';
				}, this);

			}
			this.$current_control.append('<li class="vc_control-' + data.value + '" data-name="' + data.value + '">' + data.label + sub_control + '</li>');

		},
		controlEvent: function (e) {
			var $control = $(e.currentTarget);
			if ($control.is(':checked')) {
				this.createControl({
					value: $control.val(),
					label: $control.parent().text(),
					sub: $control.data('subcontrol')
				});

			} else {
				this.$current_control.find('.vc_control-' + $control.val()).remove();
			}
			this.save();
		},
		save: function () {
			var value = _.map(this.$current_control.find('[data-name]'), function (element) {
				var return_string = encodeURIComponent($(element).data('name'));
				$(element).find('select').each(function () {
					var $sub_control = $(this);
					if ($sub_control.is('select') && $sub_control.val() !== '') {
						return_string += '|' + encodeURIComponent($sub_control.val());
					}
				});
				return return_string;
			}).join(',');
			this.$data_field.val(value);
		}
	};
	$.fn.VcSortedList = function (option) {
		return this.each(function () {
			var $this = $(this),
				data = $this.data('vc_sorted_list'),
				options = _.isObject(option) ? option : {};
			if (!data) $this.data('vc_sorted_list', (data = new VcSortedList(this, option)));
			if (typeof option == 'string') data[option]();
		});
	};

	/**
	 * Google fonts element methods
	 */
	var GoogleFonts = Backbone.View.extend({
		preview_el: ".vc_google_fonts_form_field-preview-container > span",
		font_family_dropdown_el: ".vc_google_fonts_form_field-font_family-container > select",
		font_style_dropdown_el: ".vc_google_fonts_form_field-font_style-container > select",
		font_style_dropdown_el_container: ".vc_google_fonts_form_field-font_style-container",
		status_el: ".vc_google_fonts_form_field-status-container > span",
		events: {
			'change .vc_google_fonts_form_field-font_family-container > select': 'fontFamilyDropdownChange',
			'change .vc_google_fonts_form_field-font_style-container > select': 'fontStyleDropdownChange'
		},
		initialize: function (attr) {
			_.bindAll(this, 'previewElementInactive', 'previewElementActive', 'previewElementLoading');
			this.$preview_el = $(this.preview_el, this.$el);
			this.$font_family_dropdown_el = $(this.font_family_dropdown_el, this.$el);
			this.$font_style_dropdown_el = $(this.font_style_dropdown_el, this.$el);
			this.$font_style_dropdown_el_container = $(this.font_style_dropdown_el_container, this.$el);
			this.$status_el = $(this.status_el, this.$el);
			this.fontFamilyDropdownRender();
		},
		render: function () {
			return this;
		},
		previewElementRender: function () {
			this.$preview_el.css({
				"font-family": this.font_family,
				"font-style": this.font_style,
				"font-weight": this.font_weight
			});
			return this;
		},
		previewElementInactive: function () {
			this.$status_el.text(window.i18nLocale.gfonts_loading_google_font_failed || "Loading google font failed.").css('color', '#FF0000');
		},
		previewElementActive: function () {
			this.$preview_el.text("Grumpy wizards make toxic brew for the evil Queen and Jack.").css('color', 'inherit');
			this.fontStyleDropdownRender();
		},
		previewElementLoading: function () {
			this.$preview_el.text(window.i18nLocale.gfonts_loading_google_font || "Loading Font...");
		},
		fontFamilyDropdownRender: function () {
			this.fontFamilyDropdownChange();
			return this;
		},
		fontFamilyDropdownChange: function () {
			var $font_family_selected = this.$font_family_dropdown_el.find(':selected');
			this.font_family_url = $font_family_selected.val();
			this.font_family = $font_family_selected.attr('data[font_family]');
			this.font_types = $font_family_selected.attr('data[font_types]');
			this.$font_style_dropdown_el_container.parent().hide();

			if (this.font_family_url && this.font_family_url.length > 0) {
				WebFont.load({
					google: {
						families: [this.font_family_url]
					},
					inactive: this.previewElementInactive,
					active: this.previewElementActive,
					loading: this.previewElementLoading
				});
			}
			return this;
		},
		fontStyleDropdownRender: function () {
			var str = this.font_types;
			var str_arr = str.split(',');
			var oel = '';
			var default_f_style = this.$font_family_dropdown_el.attr('default[font_style]');
			for (var str_inner in str_arr) {
				var str_arr_inner = str_arr[str_inner].split(':');
				var sel = "";
				if (_.isString(default_f_style) && default_f_style.length > 0 && str_arr[str_inner] == default_f_style) {
					sel = 'selected="selected"';
				}
				oel = oel + '<option ' + sel + ' value="' + str_arr[str_inner] + '" data[font_weight]="' + str_arr_inner[1] + '" data[font_style]="' + str_arr_inner[2] + '" class="' + str_arr_inner[2] + '_' + str_arr_inner[1] + '" >' + str_arr_inner[0] + '</option>';

			}
			this.$font_style_dropdown_el.html(oel);
			this.$font_style_dropdown_el_container.parent().show();
			this.fontStyleDropdownChange();
			return this;
		},
		fontStyleDropdownChange: function () {
			var $font_style_selected = this.$font_style_dropdown_el.find(':selected');
			this.font_weight = $font_style_selected.attr('data[font_weight]');
			this.font_style = $font_style_selected.attr('data[font_style]');
			this.previewElementRender();
			return this;
		}
	});

	/**
	 * Auto Complete PARAMETER
	 *
	 */
	var VC_AutoComplete = Backbone.View.extend({
		min_length: 2,
		delay: 500,
		auto_focus: true,
		ajax_url: window.ajaxurl,
		source_data: function () {
			return {};
		},
		replace_values_on_select: false,
		initialize: function (params) {
			_.bindAll(this, 'sortableChange', 'resize', 'labelRemoveHook', 'updateItems', 'sortableCreate', 'sortableUpdate', 'source', 'select', 'labelRemoveClick', 'createBox', 'focus', 'response', 'change', 'close', 'open', 'create', 'search', '_renderItem', '_renderMenu', '_renderItemData', '_resizeMenu');
			params = $.extend({
				min_length: this.min_length,
				delay: this.delay,
				auto_focus: this.auto_focus,
				replace_values_on_select : this.replace_values_on_select
			},params);
			this.options = params;
			this.param_name = this.options.param_name;
			this.$el = this.options.$el;
			this.$el_wrap = this.$el.parent();
			this.$sortable_wrapper = this.$el_wrap.parent();
			this.$input_param = this.options.$param_input;
			this.selected_items = [];
			this.isMultiple = false;

			this.render();
		},
		resize: function () {
			var position = this.$el_wrap.position(),
				block_position = this.$block.position();
			var widget = this.$el.autocomplete("widget");
			widget.width(parseFloat(this.$block.width()) - (parseFloat(position.left) - parseFloat(block_position.left) + 4 ) + 11);
		},
		enableMultiple: function () {
			this.isMultiple = true;
			this.$el.show();
			this.$el.focus();
		},
		enableSortable: function () {
			this.sortable = this.$sortable_wrapper.sortable({
				items: ".vc_data",
				axis: 'y',
				change: this.sortableChange,
				create: this.sortableCreate,
				update: this.sortableUpdate
			});

		},
		updateItems: function () {
			if (this.selected_items.length) {
				this.$input_param.val(this.getSelectedItems().join(", "));
			} else {
				this.$input_param.val("");
			}
		},
		sortableChange: function (event, ui) {
		},
		itemsCreate: function() {
			var sel_items = [];
			this.$block.find('.vc_data').each(function(key,item){
				sel_items.push( { label:item.dataset.label, value:item.dataset.value } );
			});
			this.selected_items = sel_items;
		},
		sortableCreate: function (event, ui) {
		},
		sortableUpdate: function (event, ui) {
			var elems = this.$sortable_wrapper.sortable('toArray', {attribute: 'data-index'});
			var items = [];
			_.each(elems, function (index) {
				items.push(this.selected_items[index]);
			}, this);
			var index = 0;
			$('li.vc_data',this.$sortable_wrapper).each(function () {
				$(this).attr('data-index', index++);
			});
			this.selected_items = items;
			this.updateItems();
		},
		getWidget: function () {
			return this.$el.autocomplete('widget');
		},
		render: function () {
			this.$el.focus(this.resize);
			this.data = this.$el.autocomplete({
				source: this.source,
				minLength: this.options.min_length,
				delay: this.options.delay,
				autoFocus: this.options.auto_focus,
				select: this.select,
				focus: this.focus,
				response: this.response,
				change: this.change,
				close: this.close,
				open: this.open,
				create: this.create,
				search: this.search
			});
			this.data.data("ui-autocomplete")._renderItem = this._renderItem;
			this.data.data("ui-autocomplete")._renderMenu = this._renderMenu;
			this.data.data("ui-autocomplete")._resizeMenu = this._resizeMenu;
			if (this.$input_param.val().length > 0) {
				if (!this.isMultiple) {
					this.$el.hide();
				} else {
					this.$el.focus();
				}
				var that = this;
				$('.vc_autocomplete-label.vc_data', this.$sortable_wrapper).each(function () {
					that.labelRemoveHook($(this));
				});

			}
			this.getWidget().addClass('vc_ui-front').addClass('vc_ui-auotocomplete');
			this.$block = this.$el_wrap.closest('ul').append($('<li class="clear"/>'));
			this.itemsCreate();
			return this;
		},
		close: function (event, ui) {
			if(this.selected && this.options.no_hide) {
				this.getWidget().show();
				this.selected++;
				if(this.selected > 2 ) { this.selected = undefined; }
			}
		},
		open: function (event, ui) {
			var widget = this.getWidget().menu();
			var widget_position = widget.position();
			widget.css('left', widget_position.left - 6);
			widget.css('top', widget_position.top + 2);
		},
		focus: function (event, ui) {
			if(!this.options.replace_values_on_select) {
				event.preventDefault();
				return false;
			}
		},
		create: function (event, ui) {
		},
		change: function (event, ui) {
		},
		response: function (event, ui) {
		},
		search: function (event, ui) {
		},
		select: function (event, ui) {
			this.selected=1;
			if(ui.item) {
				if (this.options.unique_values) {
					var $li_el = this.getWidget().data('uiMenu').active;
					if (this.options.groups) {
						var $prev_el = $li_el.prev();
						var $next_el = $li_el.next();
						if ($prev_el.hasClass('vc_autocomplete-group') && !$next_el.hasClass('vc_autocomplete-item')) {
							$prev_el.remove();
						}
					}
					$li_el.remove();

					var that = this;
					if (!$('li.ui-menu-item', this.getWidget()).length) {
						that.selected = undefined;
					}
				}
				this.createBox(ui.item);
				if (!this.isMultiple) {
					this.$el.hide();
				} else {
					this.$el.focus();
				}
			}
			return false;
		},
		createBox: function (item) {
			var index = (this.selected_items.push(item) - 1),
				remove = '<a class="vc_autocomplete-remove">&times;</a>',
				$label;
			this.updateItems();
			$label = $('<li class="vc_autocomplete-label vc_data" data-index="' + index + '" data-value="' + item.value + '" data-label="' + item.label + '"><span class="vc_autocomplete-label"><a>' + item.label + '</a></span>' + remove + '</li>');
			$label.insertBefore(this.$el_wrap);
			this.labelRemoveHook($label);
		},
		labelRemoveHook: function ($label) {
			this.$el.blur();
			this.$el.val('');
			$label.click(this.labelRemoveClick);
		},
		labelRemoveClick: function (e, ui) {
			e.preventDefault();
			var $label = $(e.currentTarget),
				index = parseInt($label.data('index'), 10),
				$target = $(e.target);
			if ($target.is('.vc_autocomplete-remove')) {
				delete this.selected_items[index];
				$label.remove();
				this.updateItems();
				this.$el.show();
				return false;
			}
		},
		getSelectedItems: function () {
			if (this.selected_items.length) {
				var results = [];
				_.each(this.selected_items, function (item) {
					results.push(item['value']);
				});
				return results;
			}
			return false;
		},
		_renderMenu: function (ul, items) {
			var that = this;
			var group = null;
			if(this.options.groups) {
				items.sort(function (a, b) {
					return a.group > b.group;
				});
			}
			$.each(items, function (index, item) {
				if(that.options.groups) {
					if(item.group != group) {
						group = item.group;
						ul.append("<li class='ui-autocomplete-group vc_autocomplete-group' aria-label='" + group + "'>" + group + "</li>");
					}
				}
				that._renderItemData(ul, item);
			});
		},
		_renderItem: function (ul, item) {
			return $('<li data-value="' + item.value + '" class="vc_autocomplete-item">')
				.append('<a>'+item.label+'</a>')
				.appendTo(ul);
		},
		_renderItemData: function (ul, item) {
			return this._renderItem(ul, item).data("ui-autocomplete-item", item);
		},
		_resizeMenu: function () {
		},
		/**
		 * Used to remove all data in the list.
		 */
		clearValue: function() {
			this.selected_items = [];
			this.updateItems();
			$('.vc_autocomplete-label.vc_data', this.$sortable_wrapper).remove();
		},
		source: function (request, response) {
			var that = this;
			if(this.options.values && this.options.values.length > 0) {
				if(this.options.unique_values) {
					response($.ui.autocomplete.filter(
						_.difference(this.options.values,this.selected_items),
						request.term
					));
				} else {
					response($.ui.autocomplete.filter(
						this.options.values, request.term
					));
				}
			} else {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: this.ajax_url,
					data: $.extend({
						action: 'vc_get_autocomplete_suggestion',
						shortcode: vc.active_panel.model.get('shortcode'), // get current shortcode?
						param: this.param_name,
						query: request.term
					}, this.source_data(request,response))
				}).done(function (data) {
					if(that.options.unique_values) {
						response(
							_.filter(data, function(obj){ return !_.findWhere( that.selected_items, obj); })
						);
					} else {
						response(data);
					}
				});
			}
		}
	});

	/**
	 * Param initializer
	 *
	 */
	var Vc_ParamInitializer = Backbone.View.extend({
		$content: {},
		initialize: function () {
			_.bindAll(this, 'content');
			this.$content = this.$el;
			this.model = vc.active_panel.model;
		},
		content: function () {
			return this.$content;
		},
		render: function () {
			var that = this;
			$('.vc_shortcode-param', this.content()).each(function () {
				var param = {};
				param.type = $(this).data('param_type');
				param.param_name = $(this).data('param_name');
				var $field = $(this);
				vc.atts.init.call(that, param, $field);
			});
			return this;
		}
	});

	/**
	 * Param group
	 */
	var VC_ParamGroup = Backbone.View.extend({
		max_items: 0,
		items: 0,
		initializer: false,
		events: {
			'click > .edit_form_line > .vc_param_group-list > .vc_param_group-add_content': 'addNew'
		},
		initialize: function () {
			this.$ul = this.$el.find('> .edit_form_line > .vc_param_group-list');
			var $el_param = $('> .wpb_vc_row', this.$ul);
			this.initializer = new Vc_ParamInitializer({el:this.$el});
			this.model = vc.active_panel.model;
			var data_settings = this.$ul.data('settings');
			if(data_settings && data_settings['settings'] && data_settings['settings']['max_items']) {
				this.max_items = data_settings['settings']['max_items'];
			}
			this.items = 0;
			var that = this;
			if ($el_param.length) {
				$el_param.each(function () {
					var pg = new VC_ParamGroup_Param({
						el: $(this),
						parent: that
					});
					that.items++;
					that.afterAdd();
				});
			}

			this.$ul.sortable({
				handle: '.vc_control.column_move',
				items: '> .wpb_vc_row:not(vc_param_group-add_content-wrapper)'
			});
		},
		addNew: function (ev) {
			ev.preventDefault();
			if (this.addAllowed()) {
				var $new_el = $(JSON.parse(this.$ul.next('.vc_param_group-template').html()));
				$new_el.removeClass('vc_param_group-add_content-wrapper');
				$new_el.insertBefore(ev.currentTarget);
				$new_el.show();
				this.initializer.$content = $('> .wpb_element_wrapper', $new_el);
				this.initializer.render();
				this.items++;
				new VC_ParamGroup_Param({el: $new_el, parent: this});
				this.afterAdd();
			}
		},
		addAllowed: function () {
			return (this.max_items > 0 && this.items + 1 <= this.max_items) || this.max_items <= 0;
		},
		afterAdd: function () {
			if (!this.addAllowed()) {
				this.$ul.find('> .wpb_vc_row > .controls > .vc_row_edit_clone_delete > .vc_control.column_clone').hide();
				this.$ul.find('> .vc_param_group-add_content').hide();
			}
		},
		afterDelete: function () {
			if (this.addAllowed()) {
				this.$ul.find('> .wpb_vc_row > .controls > .vc_row_edit_clone_delete > .vc_control.column_clone').show();
				this.$ul.find('> .vc_param_group-add_content').show();
			}
		}
	});
	var VC_ParamGroup_Param = Backbone.View.extend({
		events: {
			'click > .controls > .vc_row_edit_clone_delete > .vc_control.column_toggle': 'toggle',
			'click > .controls > .vc_row_edit_clone_delete > .vc_control.column_delete': 'delete',
			'click > .controls > .vc_row_edit_clone_delete > .vc_control.column_clone': 'clone'
		},
		initialize: function (options) {
			this.options = options;
			this.$content = this.options.parent.$ul;
			this.model = vc.active_panel.model;
		},
		delete: function (ev) {
			_.isObject(ev) && ev.preventDefault && ev.preventDefault();
			var answer = confirm(i18n.press_ok_to_delete_section);
			if (answer === true) {
				this.options.parent.items--;
				this.options.parent.afterDelete();
				this.$el.remove();

				//todo check memleaks everywhere
				this.unbind(); // Unbind all local event bindings
				this.remove(); // Remove view from DOM
			}
		},
		content: function () {
			return this.$content;
		},
		clone: function (ev) {
			ev.preventDefault();
			if (this.options.parent.addAllowed()) {
				var param = this.options.parent.$ul.data('settings');
				var $content = this.$content;
				this.$content = this.$el;
				var value = vc.atts.param_group.parseOne.call(this, param);
				var $new_el;
				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'vc_param_group_clone',
						param: encodeURIComponent(JSON.stringify(param)),
						shortcode: vc.active_panel.model.get('shortcode'),
						value: value,
						vc_inline: true
					},
					dataType: 'html',
					context: this
				}).done(function (html) {
					$new_el = $(html);
					$new_el.insertAfter(this.$el);
					this.$content = $content;
					this.options.parent.initializer.$content = $('> .wpb_element_wrapper', $new_el);
					this.options.parent.initializer.render();
					new VC_ParamGroup_Param({
						el: $new_el,
						parent: this.options.parent
					});
					this.options.parent.items++;
					this.options.parent.afterAdd();
				});

			}
		},
		toggle: function (ev) {
			ev.preventDefault();
			var $elem = this.$el.find('> .wpb_element_wrapper');
			$elem.slideToggle();
			$elem.parent().toggleClass('vc_param_group-collapsed');
		}
	});

	var i18n = window.i18nLocale;
	vc.edit_form_callbacks = [];
	vc.atts = {
		parse: function (param) {
			var value;
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			if (!_.isUndefined(vc.atts[param.type]) && !_.isUndefined(vc.atts[param.type].parse)) {
				value = vc.atts[param.type].parse.call(this, param);
			} else {
				value = $field.length ? $field.val() : null;
			}
			if ($field.data('js-function') !== undefined && typeof(window[$field.data('js-function')]) !== 'undefined') {
				var fn = window[$field.data('js-function')];
				fn(this.$el, this, param);
			}
			return value;
		},
		parseFrame: function (param) {
			var value;
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			if (!_.isUndefined(vc.atts[param.type]) && !_.isUndefined(vc.atts[param.type].parse)) {
				value = vc.atts[param.type].parse.call(this, param);
			} else {
				value = $field.length ? $field.val() : null;
			}
			if ($field.data('js-function') !== undefined && typeof(window[$field.data('js-function')]) !== 'undefined') {
				var fn = window[$field.data('js-function')];
				fn(this.$el, this, param);
			}
			return value;
		},
		init: function (param, $field) {
			if (!_.isUndefined(vc.atts[param.type]) && !_.isUndefined(vc.atts[param.type].init)) {
				vc.atts[param.type].init.call(this, param, $field);
			}
		}
	};

	// Default atts
	vc.atts.textarea_html = {
		parse: function (param) {
			var _window = this.window();
				$field = this.content().find('.textarea_html.' + param.param_name + '');
			if(_window.tinyMCE && _.isArray(_window.tinyMCE.editors)) {
				_.each(_window.tinyMCE.editors, function(_editor){
					if('wpb_tinymce_content' === _editor.id) {
						_editor.save();
					}
				});
			}
			return $field.val();
		},
		render: function (param, value) {
			return _.isUndefined(value) ? value : vc_wpautop(value);
		}
	};

	vc.atts.textarea_safe = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']'),
				new_value = $field.val();
			return new_value.match(/"/) ? '#E-8_' + base64_encode(rawurlencode(new_value)) : new_value;
		},
		render: function (param, value) {
			return value && value.match(/^#E\-8_/) ? $("<div/>").text(rawurldecode(base64_decode(value.replace(/^#E\-8_/, '')))).html() : value;
		}
	};

	vc.atts.checkbox = {
		parse: function (param) {
			var arr = [],
				new_value = "";
			if(_.isUndefined(param.save_always)) {
				param.save_always = true; // fix #1239
			}
			$('input[name=' + param.param_name + ']', this.content()).each(function () {
				var self = $(this);
				if (self.is(':checked')) {
					arr.push(self.attr("value"));
				}
			});
			if (arr.length > 0) {
				new_value = arr.join(',');
			}
			return new_value;
		},
		defaults: function(param) {
			return '';
		}
	};

	vc.atts.posttypes = {
		parse: function (param) {
			var posstypes_arr = [],
				new_value = '';
			$('input[name=' + param.param_name + ']', this.content()).each(function () {
				var self = $(this);
				if (self.is(':checked')) {
					posstypes_arr.push(self.attr("value"));
				}
			});
			if (posstypes_arr.length > 0) {
				new_value = posstypes_arr.join(',');
			}
			return new_value;
		}
	};

	vc.atts.taxonomies = {
		parse: function (param) {
			var posstypes_arr = [],
				new_value = '';
			$('input[name=' + param.param_name + ']', this.content()).each(function () {
				var self = $(this);
				if (self.is(':checked')) {
					posstypes_arr.push(self.attr("value"));
				}
			});
			if (posstypes_arr.length > 0) {
				new_value = posstypes_arr.join(',');
			}
			return new_value;
		}
	};

	vc.atts.exploded_textarea = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			return $field.val().replace(/\n/g, ",");
		}
	};

	vc.atts.textarea_raw_html = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']'),
				new_value = $field.val();
			return base64_encode(rawurlencode(new_value));
		},
		render: function (param, value) {
			return $("<div/>").text(rawurldecode(base64_decode(value))).html();
		}
	};

	vc.atts.dropdown = {
		render: function (param, value) {
			return value;
		},
		init: function (param, $field) {
			$('.wpb_vc_param_value.dropdown', $field).change(function () {
				var $this = $(this),
					$options = $this.find(':selected'),
					prev_option_class = $this.data('option'),
					option_class = $options.length ? $options.attr('class').replace(/\s/g, '_') : '';
				prev_option_class != undefined && $this.removeClass(prev_option_class);
				option_class != undefined && $this.data('option', option_class) && $this.addClass(option_class);
			});
		},
        defaults: function(param) {
			var values;
			if ( !_.isArray(param.value) && !_.isString(param.value) ) {
				values = _.values(param.value)[0];
				return values.label ? values.value : values;
			} else if ( _.isArray(param.value) ) {
				values = param.value[0];
				return _.isArray(values) && values.length ? values[0] : values;
			}
			return '';
        }
	};

	vc.atts.attach_images = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']'),
				thumbnails_html = '';
			// TODO: Check image search with Wordpress
			$field.parent().find('li.added').each(function () {
				thumbnails_html += '<li><img src="' + $(this).find('img').attr('src') + '" alt=""></li>';
			});
			$('[data-model-id=' + this.model.id + ']').data('field-' + param.param_name + '-attach-images', thumbnails_html);
			return $field.length ? $field.val() : null;
		},
		render: function (param, value) {
			var $thumbnails = this.$el.find('.attachment-thumbnails[data-name=' + param.param_name + ']'),
				thumbnails_html = this.$el.data('field-' + param.param_name + '-attach-images');
			if (_.isUndefined(thumbnails_html) && !_.isEmpty(value)) {
				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wpb_gallery_html',
						content: value
					},
					dataType: 'html',
					context: this
				}).done(function (html) {
					vc.atts.attach_images.updateImages($thumbnails, html);
				});
			} else if (!_.isUndefined(thumbnails_html)) {
				this.$el.removeData('field-' + param.param_name + '-attach-images');
				vc.atts.attach_images.updateImages($thumbnails, thumbnails_html);
			}
			return value;
		},
		updateImages: function ($thumbnails, thumbnails_html) {
			$thumbnails.html(thumbnails_html);
			if (thumbnails_html.length) {
				$thumbnails.removeClass('image-exists').next().addClass('image-exists');
			} else {
				$thumbnails.addClass('image-exists').next().removeClass('image-exists');
			}
		}
	};

	vc.atts.href = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']'),
				val = '';
			if ($field.length && $field.val() != 'http://') val = $field.val();
			return val;
		}
	};

	vc.atts.attach_image = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']'),
				image_src = '';
			if ($field.parent().find('li.added').length) {
				image_src = $field.parent().find('li.added img').attr('src');
			}
			$('[data-model-id=' + this.model.id + ']').data('field-' + param.param_name + '-attach-image', image_src);
			return $field.length ? $field.val() : null;
		},
		render: function (param, value) {
			var $model = $('[data-model-id=' + this.model.id + ']');
			var image_src = $model.data('field-' + param.param_name + '-attach-image');
			var $thumbnail = this.$el.find('.attachment-thumbnail[data-name=' + param.param_name + ']');
			if (_.isUndefined(image_src) && !_.isEmpty(value)) {
				$.ajax({
					type: 'POST',
					url: window.ajaxurl,
					data: {
						action: 'wpb_single_image_src',
						content: value
					},
					dataType: 'html',
					context: this
				}).done(function (src) {
					vc.atts['attach_image'].updateImage($thumbnail, src);
				});
			} else if (!_.isUndefined(image_src)) {
				$model.removeData('field-' + param.param_name + '-attach-image');
				vc.atts['attach_image'].updateImage($thumbnail, image_src);
			}

			return value;
		},
		updateImage: function ($thumbnail, image_src) {
			if (_.isEmpty(image_src)) {
				$thumbnail.attr('src', '').hide();
				$thumbnail.next().removeClass('image-exists').next().removeClass('image-exists');
			} else {
				$thumbnail.attr('src', image_src).show();
				$thumbnail.next().addClass('image-exists').next().addClass('image-exists');
			}
		}
	};

	vc.atts.google_fonts = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			var $block = $field.parent();
			var options = {},
				string_pieces,
				string;
			options.font_family = $block.find('.vc_google_fonts_form_field-font_family-select > option:selected').val();
			options.font_style = $block.find('.vc_google_fonts_form_field-font_style-select > option:selected').val();
			string_pieces = _.map(options, function (value, key) {
				if (_.isString(value) && value.length > 0) {
					return key + ':' + encodeURIComponent(value);
				}
			});
			string = $.grep(string_pieces, function (value) {
				return _.isString(value) && value.length > 0;
			}).join('|');
			return string;
		},
		init: function (param, $field) {
			var $g_fonts = $field;
			if ($g_fonts.length) {
				if (typeof WebFont != "undefined") {
					new GoogleFonts({el: $g_fonts});
				} else {
					$g_fonts.find('> .edit_form_line').html(window.i18nLocale.gfonts_unable_to_load_google_fonts || "Unable to load Google Fonts");
				}
			}
		}
	};

	vc.atts.font_container = {
		parse: function (param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			var $block = $field.parent();
			var options = {},
				string_pieces,
				string;
			options.tag = $block.find('.vc_font_container_form_field-tag-select > option:selected').val();
			options.font_size = $block.find('.vc_font_container_form_field-font_size-input').val();
			options.text_align = $block.find('.vc_font_container_form_field-text_align-select > option:selected').val();
			options.font_family = $block.find('.vc_font_container_form_field-font_family-select > option:selected').val();
			options.color = $block.find('.vc_font_container_form_field-color-input').val();
			options.line_height = $block.find('.vc_font_container_form_field-line_height-input').val();
			options.font_style_italic = $block.find('.vc_font_container_form_field-font_style-checkbox.italic').is(':checked') ? "1" : "";
			options.font_style_bold = $block.find('.vc_font_container_form_field-font_style-checkbox.bold').is(':checked') ? "1" : "";
			string_pieces = _.map(options, function (value, key) {
				if (_.isString(value) && value.length > 0) {
					return key + ':' + encodeURIComponent(value);
				}
			});
			string = $.grep(string_pieces, function (value) {
				return _.isString(value) && value.length > 0;
			}).join('|');
			return string;
		},
		init: function(param, $field) {
			vc.atts.colorpicker.init.call(this, param, $field);
		}
	};

	vc.atts.param_group = {
		parse: function (param) {
			var $content = this.content();
			var $this_content = this.$content;
			var $block = $content.find('.wpb_el_type_param_group.vc_shortcode-param[data-param_name="' + param['param_name'] + '"]');
			var $list = $block.find('> .edit_form_line > .vc_param_group-list');
			var data = [];
			var that = this;
			$('>.wpb_vc_row:not(".vc_param_group-add_content-wrapper")', $list).each(function () {
				var inner_data = {};
				that.$content = $(this);
				_.each(param['params'], function (par) {
					var para = $.extend({}, par);
					var param_data = {};
					param_data['param_name'] = para['param_name'];
					param_data['type'] = para['type'];
					para['param_name'] = param['param_name'] + '_' + para['param_name'];
					param_data['value'] = vc.atts.parse.call(that, para);
					inner_data[para['param_name']] = param_data;
				});
				data.push(inner_data);
			});
			this.$content = $this_content;
			return encodeURIComponent(JSON.stringify(data));
		},
		parseOne: function (param) {
			var $content = this.content();
			var $this_content = this.$content;
			var data = [];
			var that = this;
			$content.each(function () {
				var inner_data = {};
				that.$content = $(this);
				_.each(param['params'], function (par) {
					var para = $.extend({}, par);
					var param_data = {};
					param_data['param_name'] = para['param_name'];
					param_data['type'] = para['type'];
					para['param_name'] = param['param_name'] + '_' + para['param_name'];
					param_data['value'] = vc.atts.parse.call(that, para);
					inner_data[para['param_name']] = param_data;
				});
				data.push(inner_data);
			});
			this.$content = $this_content;
			return encodeURIComponent(JSON.stringify(data));
		},
		init: function (param, $field) {
			new VC_ParamGroup({el: $field});
		}
	};
	vc.atts.colorpicker = {
		init: function (param, $field) {
			var $content = $field;
			$('.vc_color-control', $content).each(function () {
				var $control = $(this),
					value = $control.val().replace(/\s+/g, ''),
					alpha_val = 100,
					$alpha, $alpha_output;
				if (value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
					alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1]) * 100;
				}
				$control.wpColorPicker({
					clear: function (event, ui) {
						$alpha.val(100);
						$alpha_output.val(100 + '%');
					}
				});
				$('<div class="vc_alpha-container">'
				+ '<label>Alpha: <output class="rangevalue">' + alpha_val + '%</output></label>'
				+ '<input type="range" min="1" max="100" value="' + alpha_val + '" name="alpha" class="vc_alpha-field">'
				+ '</div>').appendTo($control.parents('.wp-picker-container:first').addClass('vc_color-picker').find('.iris-picker'));
				$alpha = $control.parents('.wp-picker-container:first').find('.vc_alpha-field');
				$alpha_output = $control.parents('.wp-picker-container:first').find('.vc_alpha-container output')
				$alpha.bind('change keyup', function () {
					var alpha_val = parseFloat($alpha.val()),
						iris = $control.data('a8c-iris'),
						color_picker = $control.data('wp-wpColorPicker');
					$alpha_output.val($alpha.val() + '%');
					iris._color._alpha = alpha_val / 100.0;
					$control.val(iris._color.toString());
					color_picker.toggler.css({backgroundColor: $control.val()});
				}).val(alpha_val).trigger('change');
			});
		}
	};

	vc.atts.autocomplete = {
		init: function (param, $field) {
			var $el_type_autocomplete = $field;
			if ($el_type_autocomplete.length) {
				$el_type_autocomplete.each(function () {
					var $param = $('.wpb_vc_param_value', this);
					var param_name = $param.attr('name');
					var $el = $('.vc_auto_complete_param', this);
					var options = {};
					options = $.extend(
						{
							$param_input: $param,
							$el: $el,
							param_name: param_name
						},
						$param.data('settings')
					);
					var ac = new VC_AutoComplete( options );
					if (options.multiple) {
						ac.enableMultiple();
					}
					if (options.sortable) {
						ac.enableSortable();
					}
					$param.data('object',ac);
				});

			}
		}
	};

	vc.atts.loop = {
		init: function (param, $field) {
			new VcLoop({el: $field});
		}
	};

	vc.atts.vc_link = {
		init: function (param, $field) {
			$('.vc_link-build', $field).click(function (e) {
				e.preventDefault();
				var $self = $(this),
					$block = $(this).closest('.vc_link'),
					$input = $block.find('.wpb_vc_param_value'),
					$url_label = $block.find('.url-label'),
					$title_label = $block.find('.title-label'),
					value_object = $input.data('json'),
					$link_submit = $('#wp-link-submit'),
					$vc_link_submit = $('<input type="submit" name="vc_link-submit" id="vc_link-submit" class="button-primary" value="Set Link">'),
					dialog;
				$link_submit.hide();
				$("#vc_link-submit").remove();
				$vc_link_submit.insertBefore($link_submit);
				if ($.fn.wpdialog && $('#wp-link').length) {
					dialog = {
						$link: false,
						open: function () {
							this.$link = $('#wp-link').wpdialog({
								title: wpLinkL10n.title,
								width: 480,
								height: 'auto',
								modal: true,
								dialogClass: 'wp-dialog',
								zIndex: 300000
							});
						},
						close: function () {
							this.$link.wpdialog('close');
						}
					};
				} else {
					dialog = window.wpLink;
				}
				dialog.open(vc_activeMce);
				window.wpLink.textarea = $self;
				if (_.isString(value_object.url)) $('#url-field').val(value_object.url);
				if (_.isString(value_object.title)) $('#link-title-field').val(value_object.title);
				$('#link-target-checkbox').prop('checked', !_.isEmpty(value_object.target));

				$vc_link_submit.unbind('click.vcLink').bind('click.vcLink', function (e) {
					e.preventDefault();
					e.stopImmediatePropagation();
					var options = {},
						string = '';
					options.url = $('#url-field').val();
					options.title = $('#link-title-field').val();
					var $checkbox = $('#link-target-checkbox');
					options.target = $checkbox.is(':checked') ? ' _blank' : '';
					string = _.map(options, function (value, key) {
						if (_.isString(value) && value.length > 0) {
							return key + ':' + encodeURIComponent(value);
						}
					}).join('|');
					$input.val(string);
					$input.data('json', options);
					$url_label.html(options.url + options.target);
					$title_label.html(options.title);

					// $dialog.wpdialog('close');
					dialog.close();
					$link_submit.show();
					$vc_link_submit.unbind('click.vcLink');
					$vc_link_submit.remove();
					// remove vc_link hooks for wpLink
					$('#wp-link-cancel').unbind('click.vcLink');
					window.wpLink.textarea = '';
					$checkbox.attr('checked', false);
					return false;
				});
				$('#wp-link-cancel').unbind('click.vcLink').bind('click.vcLink', function (e) {
					e.preventDefault();
					dialog.close();
					// remove vc_link hooks for wpLink
					$vc_link_submit.unbind('click.vcLink');
					$vc_link_submit.remove();
					// remove vc_link hooks for wpLink
					$('#wp-link-cancel').unbind('click.vcLink');
					window.wpLink.textarea = '';
				});
			});
		}
	};

	vc.atts.sorted_list = {
		init: function (param, $field) {
			$('.vc_sorted-list', $field).VcSortedList();
		}
	};
	vc.atts.options = {
		init: function (param, $field) {
			new VcOptionsField({el: $field});
		}
	};

	vc.atts.iconpicker = {
		change: function(param, $field) {
			var $select = $field.find('.vc-iconpicker');
			$select.val(this.value);
			$select.data('vc-no-check',true);
			$select.find('[value="'+this.value+'"]').attr('selected','selected');
			$select.data('vcFontIconPicker').loadIcons(); // this methods actualy reload "active icon" and triggers event change
		},
		parse: function(param) {
			var $field = this.content().find('.wpb_vc_param_value[name=' + param.param_name + ']');
			var $block = $field.parent();
			var val = $block.find('.vc-iconpicker').val();

			return val;
		},
		init: function (param, $field) {
			var $el = $field.find('.wpb_vc_param_value');

			var settings = $.extend({
				iconsPerPage: 100, // default icons per page for iconpicker
				iconDownClass: 'fa fa-arrow-down',
				iconUpClass: 'fa fa-arrow-up',
				iconLeftClass: 'fa fa-arrow-left',
				iconRightClass: 'fa fa-arrow-right',
				iconSearchClass: 'fa fa-search',
				iconCancelClass: 'fa fa-remove',
				iconBlockClass: 'fa fa-minus-circle'
			}, $el.data('settings'));

			$field.find('.vc-iconpicker').vcFontIconPicker(settings).on('change',function(e){
				var $select = $(this);
				if(!$select.data('vc-no-check')) {
					//event.extra_type = true;
					$el.data('vc-no-check', true).val(this.value).trigger('change');
				}
				$select.data('vc-no-check',false);

			});
			$el.on('change',function(e){
				if(!$el.data('vc-no-check')) {
					vc.atts.iconpicker.change.call(this, param, $field);
				}
				$el.data('vc-no-check',false);
			});
		}
	};

	vc.atts.animation_style = {
		init: function (param, $field) {
			var content = $field;
			var $field_input = $('.wpb_vc_param_value[name=' + param.param_name + ']', content);
			$('option[value="' + $field_input.val() + '"]', content).attr('selected', true);
			var animation_style_test = function (el, x) {
				$(el).removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
					$(this).removeClass().addClass('vc_param-animation-style-preview');
				});
			};

			$('.vc_param-animation-style-trigger', content).click(function (e) {
				e.preventDefault();
				var animation = $('.vc_param-animation-style', content).val();
				if (animation != 'none') {
					animation_style_test(this.parentNode, 'vc_param-animation-style-preview ' + animation);
				}
			});

			$('.vc_param-animation-style', content).change(function () {
				var animation = $(this).val();
				$field_input.val(animation);
				if (animation != 'none') {
					var el = $('.vc_param-animation-style-preview', content);
					animation_style_test(el, 'vc_param-animation-style-preview ' + animation);
				}
			});
		}
	};

	vc.getMapped = function (tag) {
		return vc.map[tag] || {};
	}
})(window.jQuery);