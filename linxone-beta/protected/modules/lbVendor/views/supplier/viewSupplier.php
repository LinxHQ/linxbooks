<?php
/* @var $this VendorController */
/* @var $model LbVendor */

LBApplication::renderPartial($this, '_page_header', array(
	'model'=>$model,
));

$canAddInvoice = BasicPermission::model()->checkModules(LbVendorInvoice::model()->getEntityType(), 'add');
$this->renderPartial('_form', array(
		'model'=>$model)); 
//
$this->renderPartial('_form_line_items', array(
		'model'=>$model,
		'modelItemVendor'=>$modelItemVendor,
                'modelDiscountVendor'=>$modelDiscountVendor,
                'modelTax'=>$modelTax,
                'modelTotal'=>$modelTotal,
));
echo '<div style="float: right; z-index: 9999; top: 150px; position: absolute; width: 60px; height: 300px; margin-left: 1030px;
 border-bottom-right-radius: 5px; border-top-right-radius: 5px;
 padding: 10px;">';

//if($canAddInvoice)
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_invoice.png', 'Create invoice', array('class'=>'lb-side-icon')),'#', array('data-toggle'=>"tooltip",'onclick'=>'onclickCopyQuotationToInvoice();', 'title'=>"Create invoice", 'class'=>'lb-side-link-invoice'));


echo '</div></div>'; ?>
