(function($) {

	if (typeof _wpcf7 == 'undefined' || _wpcf7 === null) {
		_wpcf7 = {};
	}

	_wpcf7.taggen = {};

	$(function() {
		$('form.tag-generator-panel').each(function() {
			_wpcf7.taggen.update($(this));
		});
	});

	$('form.tag-generator-panel').submit(function(event) {
		return false;
	});

	$('form.tag-generator-panel .control-box :input').change(function(event) {
		var form = $(this).closest('form.tag-generator-panel');
		_wpcf7.taggen.normalize($(this));
		_wpcf7.taggen.update(form);
	});

	$('input.insert-tag').click(function(event) {
		var form = $(this).closest('form.tag-generator-panel');
		var tag = form.find('input.tag').val();
		_wpcf7.taggen.insert(tag);
		tb_remove(); // close thickbox
		return false;
	});

	_wpcf7.taggen.update = function($form) {
		var id = $form.attr('data-id');
		var name = '';
		var name_fields = $form.find('input[name="name"]');

		if (name_fields.length) {
			name = name_fields.val();

			if ('' == name) {
				name = id + '-' + Math.floor(Math.random() * 1000);
				name_fields.val(name);
			}
		}

		if ($.isFunction(_wpcf7.taggen.update[id])) {
			return _wpcf7.taggen.update[id].call(this, $form);
		}

		$form.find('input.tag').each(function() {
			var tag_type = $(this).attr('name');

			if ($form.find(':input[name="tagtype"]').length) {
				tag_type = $form.find(':input[name="tagtype"]').val();
			}

			if ($form.find(':input[name="required"]').is(':checked')) {
				tag_type += '*';
			}

			components = _wpcf7.taggen.compose(tag_type, $form);
			$(this).val(components);
		});

		$form.find('span.mail-tag').text('[' + name + ']');

		$form.find('input.mail-tag').each(function() {
			$(this).val('[' + name + ']');
		});

	};

	_wpcf7.taggen.update.captcha = function($form) {
		var captchac = _wpcf7.taggen.compose('captchac', $form);
		var captchar = _wpcf7.taggen.compose('captchar', $form);

		$form.find('input.tag').val(captchac + ' ' + captchar);
	};

	_wpcf7.taggen.compose = function(tagType, $form) {
		var name = $form.find('input[name="name"]').val();
		var scope = $form.find('.scope.' + tagType);

		if (! scope.length) {
			scope = $form;
		}

		var options = [];

		var size = scope.find(':input[name="size"]').val() || '';
		var maxlength = scope.find(':input[name="maxlength"]').val() || '';
		var cols = scope.find(':input[name="cols"]').val() || '';
		var rows = scope.find(':input[name="rows"]').val() || '';

		if ((cols || rows) && maxlength) {
			options.push(cols + 'x' + rows + '/' + maxlength);
		} else if (cols || rows) {
			options.push(cols + 'x' + rows);
		} else if (size || maxlength) {
			options.push(size + '/' + maxlength);
		}

		scope.find('input.option').not(':checkbox,:radio').each(function(i) {
			var excluded = ['size', 'maxlength', 'cols', 'rows'];

			if (-1 < $.inArray($(this).attr('name'), excluded)) {
				return;
			}

			var val = $(this).val();

			if (! val) {
				return;
			}

			if ($(this).hasClass('filetype')) {
				val = val.split(/[,|\s]+/).join('|');
			}

			if ($(this).hasClass('color')) {
				val = '#' + val;
			}

			if ('class' == $(this).attr('name')) {
				$.each(val.split(' '), function(i, n) { options.push('class:' + n) });
			} else {
				options.push($(this).attr('name') + ':' + val);
			}
		});

		scope.find('input:checkbox.option').each(function(i) {
			if ($(this).is(':checked')) {
				options.push($(this).attr('name'));
			}
		});

		options = (options.length > 0) ? options.join(' ') : '';

		var value = '';

		if (scope.find(':input[name="values"]').val()) {
			$.each(scope.find(':input[name="values"]').val().split("\n"), function(i, n) {
				value += ' "' + n.replace(/["]/g, '&quot;') + '"';
			});
		}

		var components = [];

		$.each([tagType, name, options, value], function(i, v) {
			v = $.trim(v);

			if ('' != v) {
				components.push(v);
			}
		});

		components = $.trim(components.join(' '));
		return '[' + components + ']';
	}

	_wpcf7.taggen.normalize = function($input) {
		var val = $input.val();

		if ($input.is('input[name="name"]')) {
			val = val.replace(/[^0-9a-zA-Z:._-]/g, '').replace(/^[^a-zA-Z]+/, '');
		}

		if ($input.is('.numeric')) {
			val = val.replace(/[^0-9.-]/g, '');
		}

		if ($input.is('.idvalue')) {
			val = val.replace(/[^-0-9a-zA-Z_]/g, '');
		}

		if ($input.is('.classvalue')) {
			val = $.map(val.split(' '), function(n) {
				return n.replace(/[^-0-9a-zA-Z_]/g, '');
			}).join(' ');

			val = $.trim(val.replace(/\s+/g, ' '));
		}

		if ($input.is('.color')) {
			val = val.replace(/[^0-9a-fA-F]/g, '');
		}

		if ($input.is('.filesize')) {
			val = val.replace(/[^0-9kKmMbB]/g, '');
		}

		if ($input.is('.filetype')) {
			val = val.replace(/[^0-9a-zA-Z.,|\s]/g, '');
		}

		if ($input.is('.date')) {
			if (! val.match(/^\d{4}-\d{2}-\d{2}$/)) { // 'yyyy-mm-dd' ISO 8601 format
				val = '';
			}
		}

		if ($input.is(':input[name="values"]')) {
			val = $.trim(val);
		}

		$input.val(val);

		if ($input.is(':checkbox.exclusive')) {
			_wpcf7.taggen.exclusiveCheckbox($input);
		}
	}

	_wpcf7.taggen.exclusiveCheckbox = function($cb) {
		if ($cb.is(':checked')) {
			$cb.siblings(':checkbox.exclusive').prop('checked', false);
		}
	};

	_wpcf7.taggen.insert = function(content) {
		$('textarea#wpcf7-form').each(function() {
			this.focus();

			if (document.selection) { // IE
				var selection = document.selection.createRange();
				selection.text = content;
			} else if (this.selectionEnd || 0 === this.selectionEnd) {
				var val = $(this).val();
				var end = this.selectionEnd;
				$(this).val(val.substring(0, end) + content + val.substring(end, val.length));
				this.selectionStart = end + content.length;
				this.selectionEnd = end + content.length;
			} else {
				$(this).val($(this).val() + content);
			}

			this.focus();
		});
	};

})(jQuery);
