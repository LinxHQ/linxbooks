<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */

LBApplication::renderPartial($this, '_page_header', array(
	'model'=>$model,
));

$this->renderPartial('_form', array(
		'model'=>$model,)); 
