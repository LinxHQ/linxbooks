/* =========================================================
 * composer-storage.js 1
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer backbone/underscore Storage hidden field
 * ========================================================= */
(function ($) {
	vc.debug = false;
	/**
	 * Shortcodes mapping settings.
	 * @type {Object}
	 */
	vc.map = _.isUndefined(window.vc_mapper) ? {} : window.vc_mapper;
	/**
	 * @constructor
	 */
	vc.Storage = function () {
		this.data = {};
	};
	/**
	 * CRUD methods for content management.
	 * @type {Object}
	 */
	vc.Storage.prototype = {
		url: window.ajaxurl,
		checksum: false,
		locked: false,
		/**
		 * Create new object in storage. Require to define model name because system uses only one hidden field with
		 * serialized json object.
		 * @param model - Backbone.Model object
		 * @return {*} - Backbone.Model object
		 */
		create: function (model) {
			if (!model.id) model.id = model.attributes.id = vc_guid();
			this.data[model.id] = model.toJSON();
			// optimize root update
			this.setModelRoot(model.id);
			this.save();
			return model;
		},
		/**
		 * Optimization methods
		 */
		// {{ Methods allows lock/unlock data parsing into shortcodes and saving it in wp editor.
		lock: function () {
			this.locked = true;
		},
		unlock: function () {
			this.locked = false;
		},
		// }}
		setModelRoot: function (id) {
			var data = this.data[id];
			if (_.isString(data.parent_id) && _.isObject(this.data[data.parent_id])) {
				data.root_id = this.data[data.parent_id].root_id;
			}
			if (_.isObject(this.data[data.root_id])) this.data[data.root_id].html = false;
		},
		/**
		 * Update object in storage.
		 * @param model
		 * @return {*}
		 */
		update: function (model) {
			this.data[model.id] = model.toJSON();
			this.setModelRoot(model.id);
			this.save();
			return model;
		},
		/**
		 * Remove record from storage
		 * @param model
		 * @return {*}
		 */
		destroy: function (model) {
			if (!_.isUndefined(this.data[model.id]) && !_.isUndefined(this.data[model.id].root_id) && _.isObject(this.data[this.data[model.id].root_id])) {
				this.data[this.data[model.id].root_id].html = false;
			}
			if (!_.isUndefined(this.data[model.id])) {
				delete this.data[model.id];
			}
			this.save();
			return model;
		},
		/**
		 * Find record by id
		 * @param model_id - id of model.
		 * @return {*} - object
		 */
		find: function (model_id) {
			return this.data[model_id];
		},
		/**
		 * Find all records in storage. Used by fetch.
		 * @return {*}
		 */
		findAll: function () {
			this.fetch();
			return _.values(this.data);
		},
		/**
		 * Find all root models which are sorted by order field.
		 * @return {*}
		 */
		findAllRootSorted: function () {
			var models = _.filter(_.values(this.data), function (model) {
				return model.parent_id === false;
			});
			return _.sortBy(models, function (model) {
				return model.order;
			});
		},
		/***
		 * Escape double quotes in params value.
		 * @param value
		 * @return string
		 */
		escapeParam: function (value) {
			if (_.isString(value)) {
				return value.replace(/"/g, '``');
			} else if (!_.isUndefined(value) && !_.isNull(value) && value.toString) {
				return value.toString().replace(/"/g, '``');
			}
			return '';
		},
		/**
		 * Unescape double quotes in params valus.
		 * @param value
		 * @return {*}
		 */
		unescapeParam: function (value) {
			return value.replace(/(\`{2})/g, '"');
		},
		/**
		 * Converts model data to wordpress shortcode.
		 * @param model
		 * @return {*}
		 */
		createShortcodeString: function (model) {
			var params = _.extend({}, model.params),
				params_to_string = {};
			_.each(params, function (value, key) {
				if (key !== 'content') params_to_string[key] = this.escapeParam(value);
			}, this);
			var content = this._getShortcodeContent(model),
				is_container = _.isObject(vc.map[model.shortcode]) && _.isBoolean(vc.map[model.shortcode].is_container) && vc.map[model.shortcode].is_container === true;
			if (!is_container && _.isObject(vc.map[model.shortcode]) && !_.isEmpty(vc.map[model.shortcode].as_parent)) is_container = true;
			return wp.shortcode.string({
				tag: model.shortcode,
				attrs: params_to_string,
				content: content,
				type: !is_container && _.isUndefined(vc.getParamSettings(model.shortcode, 'content')) ? 'single' : ''
			});
		},
		/**
		 * Save data in hidden field.
		 * @return {Boolean}
		 */
		save: function () {
			if (this.locked) {
				this.locked = false;
				return false;
			}
			var content = _.reduce(this.findAllRootSorted(), function (memo, model) {
				// if(!_.isString(model.html)) {
				model.html = this.createShortcodeString(model);
				// }
				return memo + model.html;
			}, '', this);
			this.setContent(content);
			this.checksum = window.md5(content);
			return this;
		},
		/**
		 * If shortcode is container like, gets content of is shortcode in shortcodes style.
		 * @param parent - shortcode inside which content is.
		 * @return {*}
		 * @private
		 */
		_getShortcodeContent: function (parent) {
			var that = this,
				models = _.sortBy(_.filter(this.data, function (model) {
					// Filter children
					return model.parent_id === parent.id;
				}), function (model) {
					// Sort by `order` field
					return model.order;
				}),
				params = {};
			_.extend(params, parent.params);

			if (!models.length) {

				if (!_.isUndefined(window.switchEditors) && _.isString(params.content) && window.switchEditors.wpautop(params.content) === params.content) {
					params.content = window.vc_wpautop(params.content);
				}

				return _.isUndefined(params.content) ? '' : params.content;
			}
			return _.reduce(models, function (memo, model) {
				return memo + that.createShortcodeString(model);
			}, '');
		},
		/**
		 * Get content of main editor of current post. Data is used as models collection of shortcodes.
		 * @return {*}
		 */
		getContent: function () {
			if (_.isObject(window.tinymce) && tinymce.editors.content) {
				// window.switchEditors.go('content', 'html');
				tinymce.editors.content.save();
			}
			return window.vc_wpnop($('#content').val());
		},
		/**
		 * Set content of the current_post inside editor.
		 * @param content
		 * @private
		 */
		setContent: function (content) {
			var tiny = _.isObject(window.tinymce) && tinymce.editors.content && !_.isUndefined(window.switchEditors),
				editor_hidden = tiny && window.tinyMCE.get('content') && window.tinyMCE.get('content').isHidden();
			if (tiny) {
				window.switchEditors.go('content', 'html');
			}
			$('#content').val(content);
			if (tiny && !editor_hidden) {
				window.switchEditors.go('content', 'tmce');

			}
		},
		/**
		 * Parse shortcode string into objects.
		 * @param data
		 * @param content
		 * @param parent
		 * @return {*}
		 */
		parseContent: function (data, content, parent) {
			var tags = _.keys(vc.map).join('|'),
				reg = window.wp.shortcode.regexp(tags),
				matches = content.trim().match(reg);
			if (_.isNull(matches)) return data;
			_.each(matches, function (raw) {
				var sub_matches = raw.match(this.regexp(tags)),
					sub_content = sub_matches[5],
					sub_regexp = new RegExp('^[\\s]*\\[\\[?(' + _.keys(vc.map).join('|') + ')(?![\\w-])'),
					id = window.vc_guid(),
					atts_raw = window.wp.shortcode.attrs(sub_matches[3]),
					atts = {},
					shortcode,
					map_settings;
				_.each(atts_raw.named, function (value, key) {
					atts[key] = this.unescapeParam(value);
				}, this);
				shortcode = {
					id: id,
					shortcode: sub_matches[2],
					order: this.order,
					params: _.extend({}, atts),
					parent_id: (_.isObject(parent) ? parent.id : false),
					root_id: (_.isObject(parent) ? parent.root_id : id)
				};
				map_settings = vc.map[shortcode.shortcode];
				this.order += 1;
				data[id] = shortcode;
				if (id == shortcode.root_id) {
					data[id].html = raw;
				}
				if (_.isString(sub_content) && sub_content.match(sub_regexp) &&
					(
					(_.isBoolean(map_settings.is_container) && map_settings.is_container === true) ||
					(!_.isUndefined(map_settings.as_parent) && map_settings.as_parent !== false)
					)) {
					data = this.parseContent(data, sub_content, data[id]);
				} else if (_.isString(sub_content) && sub_content.length && sub_matches[2] === 'vc_row') {
					data = this.parseContent(data, '[vc_column width="1/1"][vc_column_text]' + sub_content + '[/vc_column_text][/vc_column]', data[id]);
				} else if (_.isString(sub_content) && sub_content.length && sub_matches[2] === 'vc_column') {
					data = this.parseContent(data, '[vc_column_text]' + sub_content + '[/vc_column_text]', data[id]);
				} else if (_.isString(sub_content)) {
					data[id].params.content = sub_content; // sub_content.match(/\n/) && !_.isUndefined(window.switchEditors) ? window.switchEditors.wpautop(sub_content) : sub_content;
				}
			}, this);
			return data;
		},
		/**
		 * Checks by checksum is content changed.
		 * @return {Boolean}
		 */
		isContentChanged: function () {
			return this.checksum === false || this.checksum !== window.md5(this.getContent());
		},
		/**
		 * Wrap content which is not inside vc shorcodes.
		 * @param content
		 * @return {*}
		 */
		wrapData: function (content) {
			var tags = _.keys(vc.map).join('|'),
				reg = this.regexp_split('vc_row'),
				starts_with_shortcode = new RegExp('^\\[(\\[?)' + tags, 'g'); //'^\\[(\\[?)\s*'
			var matches = _.filter(content.trim().split(reg), function (value) {
				if (!_.isEmpty(value)) return value;
			});
			content = _.reduce(matches, function (mem, value) {
				if (!value.trim().match(starts_with_shortcode)) {
					value = '[vc_row][vc_column][vc_column_text]' + value + '[/vc_column_text][/vc_column][/vc_row]';
				}
				var matches_local = value.match(vc_regexp_shortcode());
				/**
				 * Wrap existed shortcodes that is not containers (why not container too? because VC_ROW!)
				 */
				if(_.isArray(matches_local) && !_.isUndefined(matches_local[2]) && !_.isUndefined(vc.map[matches_local[2]])) {
					if(_.isUndefined(vc.map[matches_local[2]].is_container) || !vc.map[matches_local[2]].is_container) {
						value = '[vc_row][vc_column]' + value + '[/vc_column][/vc_row]';
					}
				}
				return mem + value;
			}, '');
			return content;
		},
		/**
		 * Get data from hidden field and parse it from string to objects list.
		 * @return {*}
		 */
		fetch: function () {
			if (!this.isContentChanged()) return this;
			this.order = 0;
			var content = this.getContent();
			this.checksum = window.md5(content);
			content = this.wrapData(content);
			this.data = this.parseContent({}, content);
			try {
			} catch (e) {
				this.data = {};
			}
		},
		/**
		 * Append new data to existing one.
		 * @param content - string of shortcodes.
		 */
		append: function (content) {
			this.data = {};
			this.order = 0;
			try {
				var current_content = this.getContent();
				this.setContent(current_content + "" + content);
			} catch (e) {
			}
		},
		/**
		 * Regexp used to split unwrapped data.
		 */
		regexp_split: _.memoize(function (tags) {
			return new RegExp('(\\[(\\[?)[' + tags + ']+' +
			'(?![\\w-])' +
			'[^\\]\\/]*' +
			'[\\/' +
			'(?!\\])' +
			'[^\\]\\/]*' +
			']?' +
			'(?:' +
			'\\/]' +
			'\\]|\\]' +
			'(?:' +
			'[^\\[]*' +
			'(?:\\[' +
			'(?!\\/' + tags + '\\])[^\\[]*' +
			')*' +
			'' +
			'\\[\\/' + tags + '\\]' +
			')?' +
			')' +
			'\\]?)', 'g');
		}),
		regexp: _.memoize(function (tags) {
			return new RegExp('\\[(\\[?)(' + tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)');

		})
	};
	vc.storage = new vc.Storage();

})(window.jQuery);