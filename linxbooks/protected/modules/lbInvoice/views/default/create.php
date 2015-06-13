<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $invoiceItemModel LbInvoiceItem */
/* @var $invoiceDiscountModel LbInvoiceItem */
/* @var $invoiceTaxModel LbInvoiceItem */
/* @var $invoiceTotal LbInvoiceTotal */

LBApplication::renderPartial($this, '_page_header', array(
	'model'=>$model,
));

$this->renderPartial('_form', array(
		'model'=>$model)); 

$this->renderPartial('_form_line_items', array(
		'model'=>$model,
		'invoiceItemModel'=>$invoiceItemModel,
    'invoiceDiscountModel'=>$invoiceDiscountModel,
    'invoiceTaxModel'=>$invoiceTaxModel,
    'invoiceTotal'=>$invoiceTotal,
));