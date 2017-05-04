var vcPointerId = 0;
jQuery(document).ready(function ($) {
	var pointersList = vcPointer.pointers[0] && vcPointer.pointers[0].messages || [],
		mainPointerId = vcPointer.pointers[0].pointer_id;
	function vcOpenPointer(i) {
		var pointer = pointersList[i],
			$pointer;
		vc.app.disableFixedNav = true;
		options = $.extend(pointer.options, {
			opened: function(a, b) {
				var offset = b.pointer.offset();
				offset && offset.top && $('body').scrollTop(offset.top > 80 ? offset.top - 80 : 0);
			},
			buttons: function (event, t) {
				var $closeBtn = $('<a class="close" href="#">' + vcPointer.texts.finish + '</a>'),

					$nextBtn = $('<button class="button button-primary button-large vc_wp-pointers-next">'
					+ vcPointer.texts.next + '<i class="vc_pointer-icon"></i></button>'),

					$prevBtn = $('<button class="button button-primary button-large vc_wp-pointers-prev">'
					+ '<i class="vc_pointer-icon"></i>'
					+ vcPointer.texts.prev + '</button> ');

				$closeBtn.bind('click.vcPointer', function (e) {
					e.preventDefault();
					t.element.pointer('close');
					vc.app.disableFixedNav = false;
					$.post(ajaxurl, {
						pointer: mainPointerId,
						action: 'dismiss-wp-pointer'
					});
				});
				$buttons = $('<div class="vc_wp-pointer-controls" />').append($closeBtn);
				if (vcPointerId > 0) {
					$prevBtn.bind('click.vcPointer', function (e) {
						e.preventDefault();
						vcPointerId--;
						$pointer.pointer('close');
						vcOpenPointer(vcPointerId);
					});
					$buttons.addClass('vc_wp-pointer-controls-prev').append($prevBtn);
				}
				if (vcPointerId + 1 < pointersList.length) {
					$nextBtn.bind('click.vcPointer', function (e) {
						e.preventDefault();
						vcPointerId++;
						$pointer.pointer('close');
						vcOpenPointer(vcPointerId);
					});
					$buttons.addClass('vc_wp-pointer-controls-next').append($nextBtn);
				}

				return $buttons;
			}
		});
		$pointer = $(pointer.target);
		$pointer.pointer(options).pointer('open');
	};
	$(document).ready(function () {
		vcOpenPointer(vcPointerId);
	});
});