!function($) {


	if($('.panel-icon').length > 0){

		$(".panel-icon i").toggle(
			function(){
				$(".panel-icon i").removeClass('selected');
				var icon = $(this).attr('class');
				$(this).closest('.panel-icon').find('input.icon_class').val(icon);
				$("#icon_class").val(icon);
				$(this).addClass('selected');			
			},
			function(){
				$(".panel-icon i").removeClass('selected');
				var icon = $(this).attr('class');
				$(this).closest('.panel-icon').find('input.icon_class').val('');
			}

		);


		var icon_class_value = $('.panel-icon').find('input.icon_class').val();
		if(icon_class_value.length > 0) {
			$('.panel-icon').find('i.'+icon_class_value).addClass('selected');
		}		
	}

    
}(window.jQuery);        