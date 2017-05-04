/* =========================================================
 * composer-models.js v0.2
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Visual composer backbone/underscore models for shortcodes.
 * ========================================================= */

(function ($) {
    var store = vc.storage;
    /**
     * Shortcode model.
     * Represents shortcode as an object.
     * @type {*}
     */
    vc.shortcode = Backbone.Model.extend({
        settings: false,
        defaults:function () {
            var id = window.vc_guid();
            return {
                id:id,
                shortcode:'vc_text_block',
                order:vc.shortcodes.getNextOrder(),
                params:{
                },
                parent_id:false,
                root_id:id,
                cloned:false,
                html:false,
                view: false
            };
        },
        initialize:function () {
            this.bind('remove', this.removeChildren, this);
        },
        /**
         * Synchronize data with our storage.
         * @param method
         * @param model
         * @param options
         */
        sync:function (method, model, options) {
            var resp;
            // Select action to do with data in you storage
            switch (method) {
                case "read":
                    resp = model.id ? store.find(model) : store.findAll();
                    break;
                case "create":
                    resp = store.create(model);
                    break;
                case "update":
                    resp = store.update(model);
                    break;
                case "delete":
                    resp = store.destroy(model);
                    break;
            }
            // Response
            if (resp) {
                options.success(resp);

            } else {
                options.error("Record not found");
            }
        },
        getParam: function(key) {
          return _.isObject(this.get('params')) && !_.isUndefined(this.get('params')[key]) ? this.get('params')[key] : '';
        },
        /**
         * Remove all children of model from storage.
         * Will remove children of children models too.
         * @param parent - model which is parent
         */
        removeChildren:function (parent) {
            var models = vc.shortcodes.where({parent_id:parent.id});
            _.each(models, function (model) {
                vc.storage.lock();
                model.destroy();
                this.removeChildren(model);
            }, this);
            if (models.length) vc.storage.save();
        },
        setting: function(name) {
          if(this.settings === false) this.settings = vc.getMapped(this.get('shortcode')) || {};
          return this.settings[name];
        }
    });
    /**
     * Collection of shortcodes.
     * Extended Backbone.Collection object.
     * This collection can be used for root(raw) shortcodes list and inside another shortcodes list as inner shortcodes.
     * @type {*}
     */
    var Shortcodes = vc.shortcodes_collection = Backbone.Collection.extend({
        model:vc.shortcode,
        last_index: 0,
        getNextOrder:function () {
            return this.last_index++;
        },
        comparator:function (model) {
            return model.get('order');
        },
        initialize:function () {
            // this.on('add', this.checkUpdateOrder, this);
        },
        /**
         * Updates order of other models if new one has not last order value.
         */
        checkUpdateOrder:function (model) {
            var model_order = model.get('order');
            if (model_order < this.length) {
                _.each(this.filter(function (shortcode) {
                    return model.id != shortcode.id && model.get('parent_id') === shortcode.get('parent_id') && shortcode.get('order') >= model_order;
                }), function (shortcode) {
                    shortcode.save({order:shortcode.get('order') + 1});
                });
            }
        },
        /**
         * Create new models from shortcode string.
         * @param shortcodes_string - string of shortcodes.
         * @param parent_model - parent shortcode model for parsed objects from string.
         */
        createFromString:function (shortcodes_string, parent_model) {
            var data = vc.storage.parseContent({}, shortcodes_string, _.isObject(parent_model) ? parent_model.toJSON() : false);
            _.each(_.values(data), function (model) {
                vc.shortcodes.create(model);
            }, this);
        },
        /**
         * Synchronize data with our storage.
         * @param method
         * @param model
         * @param options
         */
        sync:function (method, model, options) {
            var resp;
            // Select action to do with data in you storage
            switch (method) {
                case "read":
                    resp = model.id ? store.find(model) : store.findAll();
                    break;
                case "create":
                    resp = store.create(model);
                    break;
                case "update":
                    resp = store.update(model);
                    break;
                case "delete":
                    resp = store.destroy(model);
                    break;
            }
            // Response
            if (resp) {
                options.success(resp);

            } else {
                options.error("Record not found");
            }
        }
    });

    vc.shortcodes = new vc.shortcodes_collection();
    vc.getDefaults = function (tag) {
        var defaults = {},
            params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [];
        _.each(params, function (param) {
            if(_.isObject(param)) {
                if(!_.isUndefined(param.std)) {
                    defaults[param.param_name] = param.std;
                } else if (!_.isUndefined(param.value)) {
                    if( vc.atts[param.type] && vc.atts[param.type].defaults ) {
						defaults[param.param_name] = vc.atts[param.type].defaults(param);
                    } else if (_.isObject(param.value)) {
						defaults[param.param_name] = _.values(param.value)[0];
					} else if (_.isArray(param.value)) {
						defaults[param.param_name] = param.value[0];
					} else {
						defaults[param.param_name] = param.value;
                    }
                }
            }
        });
        return defaults;
    };
	vc.getParamSettings = _.memoize(function(tag, paramName) {
		var params = _.isObject(vc.map[tag]) && _.isArray(vc.map[tag].params) ? vc.map[tag].params : [],
			paramSettings;
		paramSettings = _.find(params, function(settings){
			return _.isObject(settings) && settings.param_name === paramName;
		}, this);
		return paramSettings;
	}, function(){
        return arguments[0]+','+arguments[1];
    });
})(window.jQuery);
