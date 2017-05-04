<?php
	$orders = false;
	$orderst = false;
	//order=asc&ot=name&type=reg
	if(isset($_GET['ot']) && isset($_GET['order']) && isset($_GET['type'])){
		$order = array();
		switch($_GET['ot']){
			case 'alias':
				$order['alias'] = ($_GET['order'] == 'asc') ? 'ASC' : 'DESC';
			break;
			case 'name':
			default:
				$order['title'] = ($_GET['order'] == 'asc') ? 'ASC' : 'DESC';
			break;
		}
		
		if($_GET['type'] != 'reg')
			$orderst = $order;
		else
			$orders = $order;
	}
	
	
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSliders(false, $orders);
	$arrSlidersTemplates = $slider->getArrSliders(true, $orderst);
	
	$addNewLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER);
	$addNewTemplateLink = self::getViewUrl(RevSliderAdmin::VIEW_SLIDER_TEMPLATE);

	
	require self::getPathTemplate("sliders");
	
	
?>


	