function setCookie(c_name, value, exdays) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value = encodeURIComponent(value) + ((exdays === null) ? "" : "; expires=" + exdate.toUTCString());
  document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
  var i, x, y, ARRcookies = document.cookie.split(";");
  for (i = 0; i < ARRcookies.length; i++) {
    x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
    y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
    x = x.replace(/^\s+|\s+$/g, "");
    if (x == c_name) {
      return decodeURIComponent(y);
    }
  }
}

/**
 * Helper function to transform to Title Case
 * @since 4.4
 */
function vc_toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

(function ($) {
    $.expr[':'].containsi = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };
    window.vc_get_column_size = function ($column) {
        if ($column.hasClass("vc_col-sm-12")) //full-width
            return "1/1";
        else if ($column.hasClass("vc_col-sm-11")) //three-fourth
            return "11/12";
        else if ($column.hasClass("vc_col-sm-10")) //three-fourth
            return "4/6";
        else if ($column.hasClass("vc_col-sm-9")) //three-fourth
            return "3/4";
        else if ($column.hasClass("vc_col-sm-8")) //three-fourth
            return "5/6";
        else if ($column.hasClass("vc_col-sm-8")) //two-third
            return "2/3";
        else if ($column.hasClass("vc_col-sm-7")) // 7/12
            return "7/12";
        else if ($column.hasClass("vc_col-sm-6")) //one-half
            return "1/2";
        else if ($column.hasClass("vc_col-sm-5")) //one-half
            return "5/12";
        else if ($column.hasClass("vc_col-sm-4")) // one-third
            return "1/3";
        else if ($column.hasClass("vc_col-sm-3")) // one-fourth
            return "1/4";
        else if ($column.hasClass("vc_col-sm-2")) // one-fourth
            return "1/6";
        else if ($column.hasClass("vc_col-sm-1")) // one-fourth
            return "1/12";
        else
            return false;
    };
    $('#vc_license-activation-close').click(function(e){
      e.preventDefault();
      window.setCookie('vchideactivationmsg', 1, 14);
      $(this).parent().slideUp();
    });


    /** Custom Css EDITOR
     *
     */
    window.Vc_postSettingsEditor = Backbone.View.extend({
        $editor: false,
        sel: 'wpb_csseditor',
        initialize: function(sel) {
            if(sel && sel.length > 0) {
                this.sel = sel;
            }
            this.ace_enabled = true;
        },
        setTextarea: function() {
            this.ace_enabled = false;
        },
        setAce: function() {
            this.ace_enabled = true;
        },
        aceEnabled: function() {
            return  this.ace_enabled && window.ace && window.ace.edit;
        },
        setEditor: function(value) {
            if( this.aceEnabled() ) {
                this.setEditorAce(value);
            } else {
                this.setEditorTextarea(value);
            }
            return this.$editor;
        },
        focus: function() {
            if( this.aceEnabled() ) {
                this.$editor.focus();
                var count = this.$editor.session.getLength();
                this.$editor.gotoLine(count, this.$editor.session.getLine(count - 1).length);
            } else {
                this.$editor.focus();
            }
        },
        setEditorAce: function(value) {
            if(!this.$editor) {
                this.$editor = ace.edit(this.sel);
                this.$editor.getSession().setMode("ace/mode/css");
                this.$editor.setTheme("ace/theme/chrome");
            }
            this.$editor.setValue(value);
            this.$editor.clearSelection();
            this.$editor.focus();
            var count = this.$editor.getSession().getLength();
            this.$editor.gotoLine(count, this.$editor.getSession().getLine(count-1).length);
            return this.$editor;
        },
        setEditorTextarea: function(value) {
            if(!this.$editor) {
                this.$editor = $('<textarea></textarea>').css({'width':'100%','height':'100%','minHeight':'300px'});
                $('#'+this.sel).html("").append(this.$editor).css({'overflowLeft':'hidden','width':'100%','height':'100%'});
            }
            this.$editor.val(value);
            this.$editor.focus();
            this.$editor.parent().css({'overflow':'auto'});
            return this.$editor;
        },
        setSize: function() {
            var height = $(window).height() - 380; // @fix ACE editor
            if(this.aceEnabled()) {
                $('#'+this.sel).css({'height':height,'minHeight':height});
            } else {
                this.$editor.parent().css({'height':height,'minHeight':height});
                this.$editor.css({'height':'98%','width':'98%'});
            }
        },
        getEditor: function() {
            return this.$editor;
        },
        getValue: function() {
            if( this.aceEnabled() ) {
                return this.$editor.getValue();
            } else {
                return this.$editor.val();
            }
        }
    });
})(window.jQuery);


function vc_convert_column_size(width) {
    var prefix = 'vc_col-sm-',
        numbers = width ? width.split('/') : [1,1],
        range = _.range(1,13),
        num = !_.isUndefined(numbers[0]) && _.indexOf(range, parseInt(numbers[0], 10)) >=0 ? parseInt(numbers[0], 10) : false,
        dev = !_.isUndefined(numbers[1]) && _.indexOf(range, parseInt(numbers[1], 10)) >=0 ? parseInt(numbers[1], 10) : false;
    if(num!==false && dev!==false) {
        return prefix + (12*num/dev);
    }
    return prefix + '12';
}
/**
 * @deprecated
 * @param width
 * @return {*}
 */
function vc_column_size(width) {
    return vc_convert_column_size(width);
}
function vc_convert_column_span_size(width) {
    width = width.replace(/^vc_/, '');
    if (width == "span12")
        return '1/1';
    else if (width == "span11")
        return '11/12';
    else if (width == "span10") //three-fourth
        return '5/6';
    else if (width == "span9") //three-fourth
        return '3/4';
    else if (width == "span8") //two-third
        return '2/3';
    else if (width == "span7")
        return '7/12';
    else if (width == "span6") //one-half
        return '1/2';
    else if (width == "span5") //one-half
        return '5/12';
    else if (width == "span4") // one-third
        return '1/3';
    else if (width == "span3") // one-fourth
        return '1/4';
    else if (width == "span2") // one-fourth
        return '1/6';
    else if(width == "span1")
        return '1/12';

    return false;
}

function vc_get_column_mask(cells) {
    var columns = cells.split('_'),
        columns_count = columns.length,
        numbers_sum = 0,
        i;

    for(i in columns) {
        if (!isNaN(parseFloat(columns[i])) && isFinite(columns[i])) {
            var sp = columns[i].match(/(\d{1,2})(\d{1,2})/);
            numbers_sum = _.reduce(sp.slice(1), function(memo, num) {
                return memo + parseInt(num, 10);
            }, numbers_sum); //TODO: jshint
        }
    }
    return columns_count + '' + numbers_sum;
}

/**
 * Create Unique id for records in storage.
 * Generate a pseudo-GUID by concatenating random hexadecimal.
 * @return {String}
 */
function vc_guid() {
    return (VCS4() + VCS4() + "-" + VCS4());
}

// Generate four random hex digits.
function VCS4() {
    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
}

/**
 * Taxonomies filter
 *
 * Show or hide taxonomies depending on selected post types
 */
var wpb_grid_post_types_for_taxonomies_handler = function () {
    var $labels = this.$content.find('.wpb_el_type_taxonomies label[data-post-type]'),
        $ = jQuery;
    $labels.hide();
    $('.grid_posttypes:checkbox', this.$content).change(function () {
        if ($(this).is(':checked')) {
            $labels.filter('[data-post-type=' + $(this).val() + ']').show();
        } else {
            $labels.filter('[data-post-type=' + $(this).val() + ']').hide();
        }
    }).each(function () {
            if ($(this).is(':checked')) $labels.filter('[data-post-type=' + $(this).val() + ']').show();
        });
};
var wpb_single_image_img_link_dependency_callback = function () {
    var $img_link_large = this.$content.find('#img_link_large-yes'),
        $ = jQuery,
        $img_link_target = this.$content.find('[name=img_link_target]').parents('.vc_shortcode-param:first'),
        params = this.model.get('params'),
        old_param_value = '',
        $link_field = $('.wpb-edit-form [name=link]');
    this.$content.find('#img_link_large-yes').change(function () {
        var checked = $(this).is(':checked');
        if (checked) {
            $img_link_target.show();
        } else {
            if ($link_field.val().length > 0 && $link_field.val() !== 'http://') {
                $img_link_target.show();
            } else {
                $img_link_target.hide();
            }
        }
    });
    var key_up_callback = _.debounce(function () {
        var val = $(this).val();
        if (val.length > 0 && val !== 'http://' && val !== 'https://') {
            $img_link_target.show();
        } else {
            $img_link_target.hide();
        }
    }, 300);
    $link_field.keyup(key_up_callback).trigger('keyup');
    if (this.$content.find('#img_link_large-yes').is(':checked')) {
        $img_link_target.show();
    } else {
        if ($link_field.length && $link_field.val().length > 0) {
            $img_link_target.show();
        } else {
            $img_link_target.hide();
        }
    }
    if (params.img_link && params.img_link.length && !params.link) {
        old_param_value = params.img_link;
        if (!old_param_value.match(/^https?\:\/\//)) old_param_value = 'http://' + old_param_value;
        $link_field.val(old_param_value);
    }
    vc.edit_form_callbacks.push(function () {
        if (this.params.img_link) this.params.img_link = '';
    });
};

var vc_button_param_target_callback = function () {
    var $ = jQuery,
        $link_target = this.$content.find('[name=target]').parents('.vc_shortcode-param:first'),
        $link_field = $('.wpb-edit-form [name=href]');
    var key_up_callback =  _.debounce(function () {
        var val = $(this).val();
        if (val.length > 0 && val !== 'http://' && val !== 'https://' ) {
            $link_target.show();
        } else {
            $link_target.hide();
        }
    }, 300);
    $link_field.keyup(key_up_callback).trigger('keyup');
};

var vc_cta_button_param_target_callback = function () {
    var $ = jQuery,
        $link_target = this.$content.find('[name=target]').parents('.vc_shortcode-param:first'),
        $link_field = $('.wpb-edit-form [name=href]');
    var key_up_callback =  _.debounce(function () {
        var val = $(this).val();
        if (val.length > 0 && val !== 'http://' && val !== 'https://' ) {
            $link_target.show();
        } else {
            $link_target.hide();
        }
    }, 300);
    $link_field.keyup(key_up_callback).trigger('keyup');
};
/*
var vc_grid_include_dependency_callback = function () {
	var $ = jQuery;
	var include_el = $('.wpb_vc_param_value[name=include]',this.$content);
	// include_el.parents('.wpb_el_type_autocomplete.vc_shortcode-param').removeClass('vc_dependent-hidden');
	var include_obj = include_el.data('object');
	var post_type_object = $('select.wpb_vc_param_value[name="post_type"]',this.$content);
	var val = post_type_object.val();
	include_obj.source_data = function (request, response) {
		return {query: {query:val,term:request.term}};
	};
    include_obj.source_data_val = val;
	post_type_object.change(function(e){
		val = $(this).val();
        if(include_obj.source_data_val != val) {
            include_obj.source_data = function (request, response) {
                return {query: {query:val,term:request.term}};
            };
        
            include_obj.$el.data('uiAutocomplete').destroy();
            include_obj.$sortable_wrapper.find('.vc_data').remove(); // remove all appended items
            include_obj.render(); // re-render data

            include_obj.source_data_val = val;
            // include_el.parents('.wpb_el_type_autocomplete.vc_shortcode-param').removeClass('vc_dependent-hidden');
        }
	});
};
*/
var vc_grid_exclude_dependency_callback = function () {
	var $ = jQuery;
	var exclude_el = $('.wpb_vc_param_value[name=exclude]',this.$content);
	// exclude_el.parents('.wpb_el_type_autocomplete.vc_shortcode-param').removeClass('vc_dependent-hidden');
	var exclude_obj = exclude_el.data('object');
	var post_type_object = $('select.wpb_vc_param_value[name="post_type"]',this.$content);
	var val = post_type_object.val();
	exclude_obj.source_data = function (request, response) {
		return {query: {query:val,term:request.term}};
	};
    exclude_obj.source_data_val = val;
	post_type_object.change(function(){
		val = $(this).val();
        if(exclude_obj.source_data_val != val) {
            exclude_obj.source_data = function (request, response) {
                return {query: {query:val,term:request.term}};
            };
            exclude_obj.$el.data('uiAutocomplete').destroy();
            exclude_obj.$sortable_wrapper.find('.vc_data').remove(); // remove all appended items
            exclude_obj.render(); // re-render data
            exclude_obj.source_data_val = val;
		    // exclude_el.parents('.wpb_el_type_autocomplete.vc_shortcode-param').removeClass('vc_dependent-hidden');
        }
	});
};
var vcGriFilfterExcludeValuesList = [];
var vcGridFilterExcludeCallBack = function() {
    var $ = jQuery, $filterBy, $exclude, autocomplete, currentFilterValue;
    $filterBy = $('.wpb_vc_param_value[name=filter_source]',this.$content);
    currentFilterValue = $filterBy.val();
    $exclude = $('.wpb_vc_param_value[name=exclude_filter]',this.$content);
    autocomplete = $exclude.data('object');
    vcGriFilfterExcludeValuesList = autocomplete.options && autocomplete.options.values
        ? _.extend([], autocomplete.options.values) : [];
    $filterBy.change(function(){
        var filterValue = $(this).val();
        autocomplete.options.values = _.filter(vcGriFilfterExcludeValuesList, function(value){
            return value.group_id == filterValue;
        });
        filterValue != currentFilterValue && autocomplete.clearValue();
        currentFilterValue = filterValue;
    }).trigger('change');
};

/*
var vc_grid_custom_query_dependency = function() {
    var $ = jQuery,
        $post_type = $('select.wpb_vc_param_value[name="post_type"]',this.$content);
    $post_type.change(function(){
       var val = $(this).val();
       if(val === 'custom') {
           $(this).parents('.vc_shortcode-param').parent().addClass('vc_grid-custom-source');
       } else {
           $(this).parents('.vc_shortcode-param').parent().removeClass('vc_grid-custom-source');
       }
    });
}
*/
var vc_wpnop = function(content) {
    var blocklist1, blocklist2, preserve_linebreaks = false, preserve_br = false;

    // Protect pre|script tags
    if ( content.indexOf('<pre') != -1 || content.indexOf('<script') != -1 ) {
        preserve_linebreaks = true;
        content = content.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
            a = a.replace(/<br ?\/?>(\r\n|\n)?/g, '<wp-temp-lb>');
            return a.replace(/<\/?p( [^>]*)?>(\r\n|\n)?/g, '<wp-temp-lb>');
        });
    }

    // keep <br> tags inside captions and remove line breaks
    if ( content.indexOf('[caption') != -1 ) {
        preserve_br = true;
        content = content.replace(/\[caption[\s\S]+?\[\/caption\]/g, function(a) {
            return a.replace(/<br([^>]*)>/g, '<wp-temp-br$1>').replace(/[\r\n\t]+/, '');
        });
    }

    // Pretty it up for the source editor
    blocklist1 = 'blockquote|ul|ol|li|table|thead|tbody|tfoot|tr|th|td|div|h[1-6]|p|fieldset';
    content = content.replace(new RegExp('\\s*</('+blocklist1+')>\\s*', 'g'), '</$1>\n');
    content = content.replace(new RegExp('\\s*<((?:'+blocklist1+')(?: [^>]*)?)>', 'g'), '\n<$1>');

    // Mark </p> if it has any attributes.
    content = content.replace(/(<p [^>]+>.*?)<\/p>/g, '$1</p#>');

    // Sepatate <div> containing <p>
    content = content.replace(/<div( [^>]*)?>\s*<p>/gi, '<div$1>\n\n');

    // Remove <p> and <br />
    content = content.replace(/\s*<p>/gi, '');
    content = content.replace(/\s*<\/p>\s*/gi, '\n\n');
    content = content.replace(/\n[\s\u00a0]+\n/g, '\n\n');
    content = content.replace(/\s*<br ?\/?>\s*/gi, '\n');

    // Fix some block element newline issues
    content = content.replace(/\s*<div/g, '\n<div');
    content = content.replace(/<\/div>\s*/g, '</div>\n');
    content = content.replace(/\s*\[caption([^\[]+)\[\/caption\]\s*/gi, '\n\n[caption$1[/caption]\n\n');
    content = content.replace(/caption\]\n\n+\[caption/g, 'caption]\n\n[caption');

    blocklist2 = 'blockquote|ul|ol|li|table|thead|tbody|tfoot|tr|th|td|h[1-6]|pre|fieldset';
    content = content.replace(new RegExp('\\s*<((?:'+blocklist2+')(?: [^>]*)?)\\s*>', 'g'), '\n<$1>');
    content = content.replace(new RegExp('\\s*</('+blocklist2+')>\\s*', 'g'), '</$1>\n');
    content = content.replace(/<li([^>]*)>/g, '\t<li$1>');

    if ( content.indexOf('<hr') != -1 ) {
        content = content.replace(/\s*<hr( [^>]*)?>\s*/g, '\n\n<hr$1>\n\n');
    }

    if ( content.indexOf('<object') != -1 ) {
        content = content.replace(/<object[\s\S]+?<\/object>/g, function(a){
            return a.replace(/[\r\n]+/g, '');
        });
    }

    // Unmark special paragraph closing tags
    content = content.replace(/<\/p#>/g, '</p>\n');
    content = content.replace(/\s*(<p [^>]+>[\s\S]*?<\/p>)/g, '\n$1');

    // Trim whitespace
    content = content.replace(/^\s+/, '');
    content = content.replace(/[\s\u00a0]+$/, '');

    // put back the line breaks in pre|script
    if ( preserve_linebreaks )
        content = content.replace(/<wp-temp-lb>/g, '\n');

    // and the <br> tags in captions
    if ( preserve_br )
        content = content.replace(/<wp-temp-br([^>]*)>/g, '<br$1>');

    return content;
};

var vc_wpautop = function(pee) {
    var preserve_linebreaks = false, preserve_br = false,
        blocklist = 'table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|noscript|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary';

    if ( pee.indexOf('<object') != -1 ) {
        pee = pee.replace(/<object[\s\S]+?<\/object>/g, function(a){
            return a.replace(/[\r\n]+/g, '');
        });
    }

    pee = pee.replace(/<[^<>]+>/g, function(a){
        return a.replace(/[\r\n]+/g, ' ');
    });

    // Protect pre|script tags
    if ( pee.indexOf('<pre') != -1 || pee.indexOf('<script') != -1 ) {
        preserve_linebreaks = true;
        pee = pee.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
            return a.replace(/(\r\n|\n)/g, '<wp-temp-lb>');
        });
    }

    // keep <br> tags inside captions and convert line breaks
    if ( pee.indexOf('[caption') != -1 ) {
        preserve_br = true;
        pee = pee.replace(/\[caption[\s\S]+?\[\/caption\]/g, function(a) {
            // keep existing <br>
            a = a.replace(/<br([^>]*)>/g, '<wp-temp-br$1>');
            // no line breaks inside HTML tags
            a = a.replace(/<[a-zA-Z0-9]+( [^<>]+)?>/g, function(b){
                return b.replace(/[\r\n\t]+/, ' ');
            });
            // convert remaining line breaks to <br>
            return a.replace(/\s*\n\s*/g, '<wp-temp-br />');
        });
    }

    pee = pee + '\n\n';
    pee = pee.replace(/<br \/>\s*<br \/>/gi, '\n\n');
    pee = pee.replace(new RegExp('(<(?:'+blocklist+')(?: [^>]*)?>)', 'gi'), '\n$1');
    pee = pee.replace(new RegExp('(</(?:'+blocklist+')>)', 'gi'), '$1\n\n');
    pee = pee.replace(/<hr( [^>]*)?>/gi, '<hr$1>\n\n'); // hr is self closing block element
    pee = pee.replace(/\r\n|\r/g, '\n');
    pee = pee.replace(/\n\s*\n+/g, '\n\n');
    pee = pee.replace(/([\s\S]+?)\n\n/g, '<p>$1</p>\n');
    pee = pee.replace(/<p>\s*?<\/p>/gi, '');
    pee = pee.replace(new RegExp('<p>\\s*(</?(?:'+blocklist+')(?: [^>]*)?>)\\s*</p>', 'gi'), "$1");
    pee = pee.replace(/<p>(<li.+?)<\/p>/gi, '$1');
    pee = pee.replace(/<p>\s*<blockquote([^>]*)>/gi, '<blockquote$1><p>');
    pee = pee.replace(/<\/blockquote>\s*<\/p>/gi, '</p></blockquote>');
    pee = pee.replace(new RegExp('<p>\\s*(</?(?:'+blocklist+')(?: [^>]*)?>)', 'gi'), "$1");
    pee = pee.replace(new RegExp('(</?(?:'+blocklist+')(?: [^>]*)?>)\\s*</p>', 'gi'), "$1");
    pee = pee.replace(/\s*\n/gi, '<br />\n');
    pee = pee.replace(new RegExp('(</?(?:'+blocklist+')[^>]*>)\\s*<br />', 'gi'), "$1");
    pee = pee.replace(/<br \/>(\s*<\/?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)>)/gi, '$1');
    pee = pee.replace(/(?:<p>|<br ?\/?>)*\s*\[caption([^\[]+)\[\/caption\]\s*(?:<\/p>|<br ?\/?>)*/gi, '[caption$1[/caption]');

    pee = pee.replace(/(<(?:div|th|td|form|fieldset|dd)[^>]*>)(.*?)<\/p>/g, function(a, b, c) {
        if ( c.match(/<p( [^>]*)?>/) )
            return a;

        return b + '<p>' + c + '</p>';
    });

    // put back the line breaks in pre|script
    if ( preserve_linebreaks )
        pee = pee.replace(/<wp-temp-lb>/g, '\n');

    if ( preserve_br )
        pee = pee.replace(/<wp-temp-br([^>]*)>/g, '<br$1>');
    return pee;
};


var vc_regexp_shortcode = _.memoize(function() {
    return new RegExp( '\\[(\\[?)(\\S[^\\]]+)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)' );
});