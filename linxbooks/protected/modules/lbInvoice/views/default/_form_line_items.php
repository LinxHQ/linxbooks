<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $form CActiveForm */
/* @var $invoiceItemModel LbInvoiceItem */
/* @var $invoiceDiscountModel LbInvoiceItem */
/* @var $invoiceTaxModel LbInvoiceItem */
/* @var $invoiceTotal LbInvoiceTotal */

$m = $this->module->id;
$credit_by = LbCoreEntity::model()->getCoreEntity($m,$model->lb_record_primary_key)->lb_created_by;
$canEdit = BasicPermission::model()->checkModules($m, 'update',$credit_by);
$canDelete = BasicPermission::model()->checkModules($m, 'delete',$credit_by);

$canViewProcess = BasicPermission::model()->checkModules('process_checklist', 'view',$credit_by);
//$canEditAll = BasicPermission::model()->checkModules($m, 'update all');
//$canDeletOwn = BasicPermission::model()->checkModules($m, 'delete own');
//$canDeleteAll = BasicPermission::model()->checkModules($m, 'delete all');

$currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
$lb_thousand_separator = LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$lb_decimal_symbol = LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;


/********************************************************************************
 * ============================= LINE ITEMS SECTION =============================
 *******************************************************************************/

echo '<div id="container-invoice-line-items-section" style="margin-top: 30px">';

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'lb-invoice-items-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
));

/**
LineItem Grid's $data is LbInvoiceItem
Each line item's fields (description, quantity, unit price and total) 
are marked by the line item's primary key.
 */
$grid_id = 'invoice-line-items-grid-'.$model->lb_record_primary_key;
$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => $grid_id,
        'type'=>'bordered',
		'dataProvider' => $invoiceItemModel->getInvoiceItems($model->lb_record_primary_key),
		'columns' => array(
				array(
						'header' => '#',
						'type' => 'raw',
						'value' => '1',
						'htmlOptions'=>array('style'=>'width: 10px; '),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>"{delete}",
                    'deleteButtonUrl'=>'"' . $model->getActionURLNormalized("ajaxDeleteItem") . '" .
                                        "?id={$data->lb_record_primary_key}"',
                    'afterDelete'=>'function(link,success,data){
                        if(success) {
                            refreshTotals();
                        }
                    } ',
                    'htmlOptions'=>array('style'=>'width: 10px'),
                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                ),
				array(
						'header' => Yii::t('lang','Item'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextArea($data,"lb_invoice_item_description",
								array("style"=>"width: 350px; border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"invoice-item-description lbinvoice-line-items",
										"name"=>"lb_invoice_item_description_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-description"))
							. "<a href=\'#\' onclick=\'showTemplateModal({$data->lb_record_primary_key}); return false;\'
							        class=\'lb-tooltip-top\'
                                    data-toggle=\'tooltip\'
                                    style=\'vertical-align: top\'
                                    title=\'Add item from template\'><i class=\'icon-list-alt\'></i>
                            </a>"
                            . "<a href=\"#\" onclick=\"saveItemAsTemplate(" . $data->lb_record_primary_key . "); return false;\"
                                    class=\"lb-tooltip-top\"
                                    data-toggle=\"tooltip\"
                                    style=\"vertical-align: top\"
                                    title=\"Save item as template\"><i class=\"icon-hdd\"></i>
                            </a>"
						',
						'htmlOptions'=>array('width'=>'350','valign'=>'top'),
                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
				array(
						'header' => Yii::t('lang','Quantity'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_invoice_item_quantity",
								array("style"=>"width: 50px;text-align: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-line-items",
										"name"=>"lb_invoice_item_quantity_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-quantity"))
						',
						'htmlOptions'=>array('width'=>'50','style'=>'text-align: right;'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
				array(
						'header' => Yii::t('lang','Unit Price'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_invoice_item_value",
								array("style"=>"width: 90px;text-align: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-line-items",
										"name"=>"lb_invoice_item_value_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-value"))
						',
						'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
				array(
						'header' => Yii::t('lang','Total'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_invoice_item_total",
								array("disabled"=>"1","style"=>"width: 90px;text-align: right; padding-right: 0px;
								            border-top: none; border-left: none; border-right: none; box-shadow: none;",
								        "class"=>"lbinvoice-line-items",
										"name"=>"lb_invoice_item_total_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-total"))
						',
						'htmlOptions'=>array('width'=>'90','style'=>'text-align: right;'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
		),
));

echo CHtml::link(Yii::t('lang','Add item'), '#', array(
	'onclick'=>'
			$.post("'.$model->getActionURLNormalized('createBlankItem', 
			array('id'=>$model->lb_record_primary_key)).'", function(response){
				var responseJSON = jQuery.parseJSON(response);
				if (responseJSON != null && responseJSON.success == 1)
				{
    				lbinvoice_new_line_item_added = true;
					submitLineItemsAjaxForm();
				}
			});
					
			return false;'
));

// hidden line item submit button
if($canEdit)
{
    echo CHtml::ajaxSubmitButton(Yii::t('lang','Save'),
                    $model->getActionURLNormalized('ajaxUpdateLineItems',array('id'=>$model->lb_record_primary_key)), 
                    array(
                            'id' => 'ajax-submit-form-items-' . uniqid(), 
                            'beforeSend' => 'function(data){ 
                                    // code...
                            } ',
                            'success' => 'function(data, status, obj) {
                                if (lbinvoice_new_line_item_added)
                                {
                                    refreshLineItemsGrid();
                                    lbinvoice_new_line_item_added = false;
                                }
                                if (lbinvoice_discounts_updated)
                                    submitDiscountsAjaxForm();
                                else
                                    submitTaxesAjaxForm();

                                if (data != null) {
                                    //$("#invoice-subtotal-'.$model->lb_record_primary_key.'").html(jsonData.lb_invoice_subtotal);
                                }
                            }'
                    ),
                    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-line-items-form'));

}
    $this->endWidget();

echo '</div>'; // end line items section

// END LINE ITEMS FORM

echo '<div id="container-total" >';
// print sub total
echo '<div class="invoice-subtotal-container" style="border:solid 1px #dddddd;border-bottom:none;">';// style="clear: both; float: right; display: block; width: 350px">';
echo "<div style='margin-left:236px;' class='invoice-total-label'>".Yii::t('lang','Sub Total')." ($currency_name):</div>";
echo "<div id='invoice-subtotal-{$model->lb_record_primary_key}' style=''  class='invoice-total-value'>";
echo number_format($invoiceTotal->lb_invoice_subtotal,2,$lb_decimal_symbol,$lb_thousand_separator)."</div>";
echo '</div>'; // end showing sub total

/********************************************************************************
 * ============================= DISCOUNTS SECTION =============================
 *******************************************************************************/

echo '<div style="border-left:solid 1px #dddddd; border-right:solid 1px #dddddd;" id="container-invoice-discounts" class="invoice-discounts-container">';// style="float: right; display: block; clear: both">';

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-invoice-discounts-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
));

//echo '<div style="width: auto; display: block; clear: both">';// style="text-align: right; clear: both; display: block; width: 350px;">';
//echo "<div style='' class='invoice-total-label'>Discount:</div>";
echo "<div style='font-size: 9pt; float: left; width: 150px; text-align: right; '>";//  class='invoice-total-value'>";
echo CHtml::link(Yii::t('lang','Add discount'), '#', array(
    'onclick'=>'
			$.post("'.$model->getActionURLNormalized('createBlankDiscount',
        array('id'=>$model->lb_record_primary_key)).'", function(response){
				var responseJSON = jQuery.parseJSON(response);
				if (responseJSON != null && responseJSON.success == 1)
				{
				    lbinvoice_new_discount_added = true;
					submitDiscountsAjaxForm();
				}
			});

			return false;'
));
echo '</div>';
//echo '</div>';

// discount grid
$discount_grid_id = 'invoice-discounts-grid-'.$model->lb_record_primary_key;
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => $discount_grid_id,
    'dataProvider' => $invoiceDiscountModel->getInvoiceDiscounts($model->lb_record_primary_key),
    'hideHeader'=>true,
    'htmlOptions'=>array('style' =>' float: right; margin-bottom: 0px;', 'class'=>'invoice-total-grid'),
    'template'=>'{items}',
    'emptyText'=>'<div class="invoice-discount-empty-text">No discounts.</div>',
    'columns' => array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>"{delete}",
            'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px;'),
            'deleteButtonUrl'=>'"' . $model->getActionURLNormalized("ajaxDeleteItem") . '" .
                                        "?id={$data->lb_record_primary_key}"',
            'afterDelete'=>'function(link,success,data){
                if(success) {
                    refreshTotals();
                }
            } ',
        ),
        array(
            'header' => 'Discount',
            'type' => 'raw',
            'value' => '
                CHtml::activeTextField($data,"lb_invoice_item_description",
								array("style"=>"width: 143px; text-align: right;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-discount",
										"name"=>"lb_invoice_item_description_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-description"))
				."&nbsp;('.$currency_name.'):"
            ',
            'htmlOptions'=>array('style'=>'width: 200px; border-top: none; padding-top: 0px;;'),
        ),
        array(
            'header' => 'Amount',
            'type' => 'raw',
            'value' => '
                CHtml::activeTextField($data,"lb_invoice_item_total",
								array("style"=>"width: 130px; text-align: right; float: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-discount",
										"name"=>"lb_invoice_item_total_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-total"))

            ',
            'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px;;', 'align'=>'right'),
        )
    )
)); // end discount grid

// hidden discount submit button
echo CHtml::ajaxSubmitButton(Yii::t('lang','Save Discounts'),
    $model->getActionURLNormalized('ajaxUpdateDiscounts',array('id'=>$model->lb_record_primary_key)),
    array(
        'id' => 'ajax-submit-form-discounts-' . uniqid(),
        'beforeSend' => 'function(data){
				// code...
			} ',
        'success' => 'function(data, status, obj) {
            if (lbinvoice_new_discount_added)
            {
                refreshDiscountsGrid();
                lbinvoice_new_discount_added = false;
            }
            submitTaxesAjaxForm();
		}'
    ),
    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-discounts-form'));


$this->endWidget();
// END DISCOUNT FORM
echo '</div>';// end invoice discount div


/********************************************************************************
 * =============================== TAXES SECTION ================================
 *******************************************************************************/

echo '<div id="container-invoice-taxes" style="margin-top: -20px;border-left:solid 1px #dddddd;border-right:solid 1px #dddddd;" class="invoice-taxes-container" >';

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-invoice-taxes-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
));

echo "<div style='font-size: 9pt; float: left; width: 150px; text-align: right;'>";
echo CHtml::link(Yii::t('lang','Add tax'), '#', array(
    'onclick'=>'addTaxClick(); return false;'
));
echo '</div>';

// taxes grid
$taxes_grid_id = 'invoice-taxes-grid-'.$model->lb_record_primary_key;
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => $taxes_grid_id,
    'dataProvider' => $invoiceTaxModel->getInvoiceTaxes($model->lb_record_primary_key),
    'hideHeader'=>true,
    'htmlOptions'=>array('class'=>'invoice-total-grid', 'style'=>'float: right'),
    'template'=>'{items}',
    /**'emptyText'=>'<div style="float: right">'.CHtml::link('Add tax', '#', array(
            'onclick'=>'addTaxClick(); return false;'
        )).'</div>',**/
    'emptyText'=>'<div class="invoice-tax-empty-text">No taxes.</div>',
    'columns' => array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>"{delete}",
            'deleteButtonUrl'=>'"' . $model->getActionURLNormalized("ajaxDeleteItem") . '" .
                                        "?id={$data->lb_record_primary_key}"',
            'afterDelete'=>'function(link,success,data){
                if(success) {
                    refreshTotals();
                }
            } ',
            'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px'),
        ),
        array(
            'header' => 'Tax',
            'type' => 'raw',
            'value' => '
                CHtml::activeDropdownList($data,"lb_invoice_item_description",
                                array("0"=>"")+
                                CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                        function($tax){return "$tax->lb_record_primary_key";},
                                        function($tax){return "$tax->lb_tax_name $tax->lb_tax_value%";})
                                        + array("-1"=>"-- Add new tax --"),
								array("style"=>"width: 155px; text-align: right;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_invoice_item_description_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-description",
										"options"=>array(
                                            "$data->lb_invoice_item_description"=>array("selected"=>true),
                                        ),
                                        "onchange"=>"js:onChangeTaxDropdown($(this).attr(\"line_item_pk\"),
                                            $(this).val());"
                                )
                )
                . "&nbsp;('.$currency_name.'):"
            ',
            'htmlOptions'=>array('style'=>'width: 200px; border-top: none; padding-top: 0px'),
        ),
        array(
            'header' => 'Amount',
            'type' => 'raw',
            'value' => '
                CHtml::activeTextField($data,"lb_invoice_item_total",
								array("style"=>"width: 130px; text-align: right;float: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_invoice_item_total_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-total",
										"disabled"=>"true"))
				. CHtml::activeHiddenField($data,"lb_invoice_item_value",
								array("style"=>"width: 50px; text-align: right",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_invoice_item_value_{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-value"))
            ',
            'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px', 'align'=>'right'),
        ),
    )
)); // end tax grid

// hidden tax submit button
echo CHtml::ajaxSubmitButton('Save Taxes',
    $model->getActionURLNormalized('ajaxUpdateTaxes',array('id'=>$model->lb_record_primary_key)),
    array(
        'id' => 'ajax-submit-form-taxes-' . uniqid(),
        'beforeSend' => 'function(data){
				// code...
			} ',
        'success' => 'function(data, status, obj) {
                if(lbinvoice_new_tax_added)
                {
                    lbinvoice_new_tax_added = false;
					refreshTaxesGrid();
                }
                refreshTotals();
                disableSaveButton('.$model->lb_record_primary_key.');
			}'
    ),
    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-taxes-form'));


$this->endWidget();
// END TAX FORM
echo '</div>';// end invoice taxes

/// TOTAL

echo '<div class="invoice-total-container" style="margin-top: -20px ;margin-bottom:30px;border-left:solid 1px #dddddd;border-right:solid 1px #dddddd; border-bottom:solid 1px #dddddd;border-right:solid 1px #dddddd;" >';

// total after tax
echo '<div class="invoice-total-label" style="margin-left:236px;">'.Yii::t('lang','Total').' ('.$currency_name.'):</div>';
echo "<div id='invoice-total-{$model->lb_record_primary_key}' class='invoice-total-value'>";
echo number_format($invoiceTotal->lb_invoice_total_after_taxes,2,$lb_decimal_symbol,$lb_thousand_separator);
echo '</div>';

// paid
echo '<div class="invoice-total-label" style="margin-left:236px;">'.Yii::t('lang','Paid').' ('.$currency_name.'):</div>';
echo "<div id='invoice-paid-{$model->lb_record_primary_key}' class='invoice-total-value'>".number_format($invoiceTotal->calculateInvoicetotalPaid($model->lb_record_primary_key),2,$lb_decimal_symbol,$lb_thousand_separator)."</div>";

// outstanding
echo '<div style="margin-left:236px;" class="invoice-total-label">'.Yii::t('lang','Outstanding').' ('.$currency_name.'):</div>';
echo "<div id='invoice-outstanding-{$model->lb_record_primary_key}' class='invoice-total-value'>".number_format($invoiceTotal->calculateInvoiceTotalOutstanding(),2,$lb_decimal_symbol,$lb_thousand_separator)."</div>";

echo '</div>';

echo '</div>';


//Payment




echo '<div id="container-invoice-line-items-section" style="margin-top: 30px;clear:both;">';

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'lb-invoice-items-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
));

/**
LineItem Grid's $data is LbInvoiceItem
Each line item's fields (description, quantity, unit price and total) 
are marked by the line item's primary key.
 */
//$modelPayment = LBPayment::model()->getPaymentById($PaymentInvoice);
//$this->widget('ext.rezvan.RDatePicker',array(
//    'name'=>'message[messageDate]',
//    'value'=>$modelPayment->lb_payment_date,
//    'options' => array(
//        'format' => 'yyyy/mm/dd',
//        'viewformat' => 'yyyy/mm/dd',
//        'placement' => 'right',
//        'todayBtn'=>true,
//    )
//));
 

echo '<div id="container-payment-invoice"></div>';

// hidden line item submit button
if($canEdit)
{
    echo CHtml::ajaxSubmitButton(Yii::t('lang','Save'),
                    $model->getActionURLNormalized('ajaxUpdateLineItems',array('id'=>$model->lb_record_primary_key)), 
                    array(
                            'id' => 'ajax-submit-form-items-' . uniqid(), 
                            'beforeSend' => 'function(data){ 
                                    // code...
                            } ',
                            'success' => 'function(data, status, obj) {
                                if (lbinvoice_new_line_item_added)
                                {
                                    refreshLineItemsGrid();
                                    lbinvoice_new_line_item_added = false;
                                }
                                if (lbinvoice_discounts_updated)
                                    submitDiscountsAjaxForm();
                                else
                                    submitTaxesAjaxForm();

                                if (data != null) {
                                    //$("#invoice-subtotal-'.$model->lb_record_primary_key.'").html(jsonData.lb_invoice_subtotal);
                                }
                            }'
                    ),
                    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-line-payment-form'));

}
    $this->endWidget();
    

echo '</div>'; // end line items section

/********************************************************************************
 * =============================== NOTE SECTION ================================
 *******************************************************************************/
echo '<div id="container-invoice-note-'.$model->lb_record_primary_key.'"
    style="display: flex; clear: both; padding-top: 40px; width: 100%;" class="">';
echo '<table class="items table table-bordered" style="width:100%;">'
. ' <thead>
    <tr>
		<th class="lb-grid-header" style="font-size:18px;">'.Yii::t('lang','Note').'</th>
		</tr>
	</thead><tbody>';
       
echo '<tr><td>';
$this->widget('editable.EditableField', array(
    'type'        => 'textarea',
    'inputclass'  => 'input-large-textarea',
    'emptytext'   => 'Enter invoice note',
    'model'       => $model,
    'attribute'   => 'lb_invoice_note',
    'value'=>"123",
    'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
    'placement'   => 'right',
    //'showbuttons' => 'bottom',
    'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
    'options'	=> array(
    ),
    'onShown'=> 'js:function(){
        var tip = $(this).data("editableContainer").tip();
        var editable_left = $(tip).css("left").replace("px","");
        //console.log(tip,tip.attr("style"));
        //if (editable_left < 0)
            $(tip).css("left", 50);
    }'
));
echo '</td></tr></tbody></table>';

//echo '<table class="items table table-bordered" style="width:40%;float:right;margin-left:200px;">'
//.' <thead>
//    <tr>
//		<th class="lb-grid-header" style="font-size:18px;">'.Yii::t('lang','Internal Note').'</th>
//		</tr>
//	</thead><tbody>';
//echo '<tr><td>';
//$this->widget('editable.EditableField', array(
//    'type'        => 'textarea',
//    'inputclass'  => 'input-large-textarea',
//    'emptytext'   => 'Enter internal note',
//    'model'       => $model,
//    'attribute'   => 'lb_invoice_internal_note',
//    'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
//    'placement'   => 'right',
//    //'showbuttons' => 'bottom',
//    'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
//    'options'	=> array(
//    ),
//    'onShown'=> 'js:function(){
//        var tip = $(this).data("editableContainer").tip();
//        var editable_left = $(tip).css("left").replace("px","");
//        //console.log(tip,tip.attr("style"));
//        //if (editable_left < 0)
//            $(tip).css("left", 50);
//    }'
//));
//echo '</td></tr></tbody></table>';
echo '</div>';// end note div



/********************************************************************************
 * =============================== INTERANL NOTE SECTION ================================
 *******************************************************************************/
echo '<div id="container-invoice-internal-note-'.$model->lb_record_primary_key.'"
    style="display: block; clear: both; padding-top: -9px; width: 100%;" class="">';
echo '<table class="items table table-bordered" style="width:100%;">'
.' <thead>
    <tr>
		<th class="lb-grid-header" style="font-size:18px;">'.Yii::t('lang','Internal Note').'</th>
		</tr>
	</thead><tbody>';
echo '<tr><td>';
$this->widget('editable.EditableField', array(
    'type'        => 'textarea',
    'inputclass'  => 'input-large-textarea',
    'emptytext'   => 'Enter internal note',
    'model'       => $model,
    'attribute'   => 'lb_invoice_internal_note',
    'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
    'placement'   => 'right',
    //'showbuttons' => 'bottom',
    'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
    'options'	=> array(
    ),
    'onShown'=> 'js:function(){
        var tip = $(this).data("editableContainer").tip();
        var editable_left = $(tip).css("left").replace("px","");
        //console.log(tip,tip.attr("style"));
        //if (editable_left < 0)
            $(tip).css("left", 50);
    }'
));
echo '</td></tr></tbody></table>';
echo '</div>';// end note div


echo '<div style="display: block; clear: both; text-align: center; padding-top: 40px;" class="">';

if($canEdit)
{
    //// SAVE BUTTON
    LBApplicationUI::submitButton('Save', array(
        'htmlOptions'=>array(
            'onclick'=>'saveInvoice('.$model->lb_record_primary_key.'); return false;',
            'style'=>'margin-left: auto; margin-right: auto',
            'id'=>'btn-invoice-save-all-'.$model->lb_record_primary_key,
        ),
    ));

    //// SHOW CONFIRM BUTTON IF INVOICE IS A DRAFT
    if ($model->lb_invoice_status_code == $model::LB_INVOICE_STATUS_CODE_DRAFT)
    {
        echo '&nbsp;';
        LBApplicationUI::ajaxButton(Yii::t('lang','Confirm Invoice'),
            $model->getActionURLNormalized('ajaxConfirmInvoice',
                array('id'=>$model->lb_record_primary_key)),
            array(
                'id' => 'ajax-submit-confirm-invoice-' . uniqid(),
                'beforeSend' => 'function(data){
                                    if(!lbInvoice_choose_customer)
                                    {
                                        alert("Customer name cannot be blank.");
                                        return false;
                                    }
                            } ',
                'success' => 'function(data, status, obj) {
                    if(data != null)
                    {
                        var dataJSON = jQuery.parseJSON(data);
                        $("#lb_invocie_status").html(dataJSON.lb_invoice_status_code);
                        onConfirmInvoiceSuccessful(dataJSON);
                        loadPaymentInvoice(dataJSON.lb_invoice_status_code);
                    }
                            }'
            ),//end ajax options
            array(
                'id'=> 'btn-confirm-invoice-'.$model->lb_record_primary_key,
            ) // end html options
        );
    }

    // Buttom Write Off
    if ($model->lb_invoice_status_code != $model::LB_INVOICE_STATUS_CODE_WRITTEN_OFF && $model->lb_invoice_status_code != $model::LB_INVOICE_STATUS_CODE_PAID)
    {
        echo '&nbsp;';
        LBApplicationUI::ajaxButton(Yii::t('lang','Write off'),
            $model->getActionURLNormalized('ajaxUpdateStatus',
                array('id'=>$model->lb_record_primary_key,'status'=>  LbInvoice::LB_INVOICE_STATUS_CODE_WRITTEN_OFF)),
            array(
                
            ),//end ajax options
            array(
                'id'=> 'btn-write-off-invoice-'.$model->lb_record_primary_key,
            ) // end html options
        );
    }
}
if($canDelete)
{
    // Buttom DELETE
    if ($model->lb_invoice_status_code == $model::LB_INVOICE_STATUS_CODE_DRAFT)
    {
        echo '&nbsp;';
        LBApplicationUI::button(Yii::t('lang','Delete'),array(
            'url'=>$this->createUrl('delete',array('id'=>$model->lb_record_primary_key)),
            'htmlOptions'=>array(
                    'onclick'=>'return confirm("Are you sure you want to delete this item?");',
                    'id'=>'btn-delete-invoice-'.$model->lb_record_primary_key,
                ),
        ));
    }
}

echo '</div>';

/***************************** HIDDEN STUFF *************************************/

////// GENERIC MODAL HOLDER
////// We can use this to load anything into a modal,
////// through ajax as well
$this->beginWidget('bootstrap.widgets.TbModal',
    array('id'=>'modal-holder-'.$model->lb_record_primary_key));
echo '<div class="modal-header">';//
echo '<a class="close" data-dismiss="modal">&times;</a>';
echo '<h4 id="modal-header"></h4>';
echo '</div>'; // end modal header
// modal body
echo '<div id="modal-body" class="modal-body">';
echo '</div>'; // end modal body
echo '<div id="modal-footer" class="modal-footer" style="display: none">';
$this->widget('bootstrap.widgets.TbButton', array(
    'id'=>'btn-modal-close',
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
));
echo '</div>';
$this->endWidget(); // end modal widget
////// END GENERIC MODAL HOLDER

// form add tax on the fly
$this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-new-tax-form'));
echo '<div class="modal-header">';
echo '<a class="close" data-dismiss="modal">&times;</a>';
echo '<h4>'.Yii::t('lang','Add Tax').'</h4>';
echo '</div>'; // end modal header
// modal body -tax form
echo '<div class="modal-body" id="modal-new-tax-form-body-'.$model->lb_record_primary_key.'">';
echo '</div>'; // end modal body - tax form
echo '<div class="modal-footer" style="display: none">';
$this->widget('bootstrap.widgets.TbButton', array(
    'id'=>'modal-new-tax-form-btn-close',
    'label'=>'Close',
    'url'=>'#',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
));
echo '</div>';
$this->endWidget(); // end modal widget

$this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Add new tax',
    'type'=>'',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#modal-new-tax-form',
        'style'=>'display: none;',
        'id'=>'btn-add-new-tax',
    ),
));
//// end add tax on the fly


// form Email on the  fly
$this->beginWidget('bootstrap.widgets.TbModal',array('id'=>'modal-email-form'));
// modal Header
echo '<div class="modal-header">';
echo '<a class="close" data-dismiss="modal">&times;</a>';
echo '<h4>Send Email</h4>';
echo '</div>';
////End Modal Header
// modal Body
echo '<div class="modal-body" style="max-height:500px;" id="modal-send-email-body-'.$model->lb_record_primary_key.'">';
echo '</div>';
echo '<div class="modal-footer">';
echo '</div>';
$this->endWidget();
$this->widget('bootstrap.widget.TbButton', array(
    'label'=>'Send mail',
    'type'=>'',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#modal-email-form',
        'style'=>'display:none',
        'id'=>'btn-send-mail',
    ),
));

////end Email on the fly

// form Get Public PDF on the  fly
$this->beginWidget('bootstrap.widgets.TbModal',array('id'=>'modal-get-public-pdf-form'));
// modal Header
echo '<div class="modal-header">';
echo '<a class="close" data-dismiss="modal">&times;</a>';
echo '<h4>Share PDF</h4>';
echo '</div>';
////End Modal Header
// modal Body
echo '<div class="modal-body" style="max-height:900px;" id="modal-get-public-pdf-body-'.$model->lb_record_primary_key.'">';
echo '</div>';
echo '<div class="modal-footer">';
echo '</div>';
$this->endWidget();
$this->widget('bootstrap.widget.TbButton', array(
    'label'=>'Send mail',
    'type'=>'',
    'htmlOptions'=>array(
        'data-toggle'=>'modal',
        'data-target'=>'#modal-get-public-pdf-form',
        'style'=>'display:none',
        'id'=>'btn-get-public-pdf',
    ),
));

////end Get Public PDF on the fly

if($canViewProcess)
{
//    echo '<div id="process-checklist">';
//
//    echo '</div>';
}
 

        
?>


<script language="javascript">
var item=1;

$(document).ready(function(){

     	
        var from_date = $(".lbinvoice-line-payment_date").datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
 
    $('.invoice-item-description').autosize({append: "\n"}); 
    bindLineItemsForChanges("<?php echo $grid_id; ?>");
    bindDiscountsForChanges("<?php echo $discount_grid_id; ?>");

    invoice_sub_total = <?php echo $invoiceTotal->lb_invoice_subtotal; ?>;
    invoice_total_after_discounts = <?php echo $invoiceTotal->lb_invoice_total_after_discounts?>;
    invoice_total_after_taxes = <?php echo $invoiceTotal->lb_invoice_total_after_taxes; ?>;
    invoice_total_paid = <?php echo $invoiceTotal->lb_invoice_total_paid ?>;
    invoice_total_outstanding = <?php echo $invoiceTotal->lb_invoice_total_outstanding; ?>;
    
    loadPaymentInvoice()
});

function refreshLineItemsGrid()
{
	$.fn.yiiGridView.update("<?php echo $grid_id; ?>",{
        complete: function(jqXHR, status) {
            if (status=='success'){
            	bindLineItemsForChanges("<?php echo $grid_id; ?>");
            }
        }
	});	
}

function refreshDiscountsGrid()
{
    $.fn.yiiGridView.update("<?php echo $discount_grid_id; ?>",{
        complete: function(jqXHR, status) {
            if (status=='success'){
                bindDiscountsForChanges("<?php echo $discount_grid_id; ?>");
            }
        }
    });
}

function refreshTaxesGrid()
{
    $.fn.yiiGridView.update("<?php echo $taxes_grid_id; ?>",{
        complete: function(jqXHR, status) {
            if (status=='success'){
            }
        }
    });
}

function onChangeTaxDropdown(line_item_pk, tax_id)
{
    if (tax_id == -1)
    {
        // show pop up form to create new tax item
        $("#modal-new-tax-form-body-"+<?php echo $model->lb_record_primary_key; ?>).html(getLoadingIconHTML(false));
        $("#modal-new-tax-form-body-"+<?php echo $model->lb_record_primary_key; ?>).load("<?php echo $model->getActionURLNormalized('createTax',array('form_type'=>'ajax','ajax'=>1,'invoice_id'=>$model->lb_record_primary_key)); ?>");
        $("#btn-add-new-tax").click();
    } else {
        // submit selected tax to server
        $.post("<?php echo $model->getActionURLNormalized('ajaxGetTax',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, tax_id: tax_id},
            function(response)
            {
                if (response != null)
                {
                    
                    var responseJSON = jQuery.parseJSON(response);
                    // refill tax value
                    $("#lb_invoice_item_value_"+line_item_pk).val(responseJSON.lb_tax_value);

                    // recalculate totals on client-side
                    calculateInvoiceTotals(<?php echo $model->lb_record_primary_key; ?>);
                    updateInvoiceTotalsUI(<?php echo $model->lb_record_primary_key; ?>);
                    submitTaxesAjaxForm();
                }
            }
        );
    } // end else
}

function refreshTotals()
{
    $.get("<?php echo $model->getActionURLNormalized('ajaxGetTotals',array('id'=>$model->lb_record_primary_key)); ?>",
        {},
        function(response)
        {
            
            if (response != null)
            {
                var responseJSON = jQuery.parseJSON(response);
                getInvoiceTotals(responseJSON);
                $("#invoice-outstanding-<?php echo $model->lb_record_primary_key?>").text(responseJSON.lb_invoice_total_outstanding);
                updateInvoiceTotalsUI(<?php echo $model->lb_record_primary_key;?>);
            }
        }
    )
}

function addTaxClick()
{
    $.post("<?php echo $model->getActionURLNormalized('createBlankTax', array('id'=>$model->lb_record_primary_key));?>",
        function(response){
            var responseJSON = jQuery.parseJSON(response);
            if (responseJSON != null && responseJSON.success == 1)
            {
                lbinvoice_new_tax_added = true;
                submitTaxesAjaxForm();
            }
        });
}

function showTemplateModal(item_id)
{
    lbAppUILoadModal(<?php echo $model->lb_record_primary_key?>, 'Item Templates',
        "<?php echo $model->getActionURLNormalized('chooseItemTemplate',
            array(
                'id'=>$model->lb_record_primary_key,
                'ajax'=>1));?>&item_id="+item_id
    );
}

function saveItemAsTemplate(invoice_item_id)
{
    var item_description = $("#lb_invoice_item_description_"+invoice_item_id).val();
    var item_unit_price = $("#lb_invoice_item_value_"+invoice_item_id).val();
    $.post("<?php echo $model->getActionURLNormalized('saveItemAsTemplate', array('id'=>$model->lb_record_primary_key))?>",
        {item_description: item_description, item_unit_price: item_unit_price},
        function(response){
            if (response == 'success')
            {
                var td_container = $("#lb_invoice_item_description_"+invoice_item_id).parent();
                td_container.append('<div class="alert fade in">Template saved.<a class="close" data-dismiss="alert" href="#">&times;</a></div>').alert();
            } else {

            }
        }
    );
}
function onclickFormEmail(){
    $('#btn-send-mail').click();
    senEmail();
}
function senEmail(){
    $('#modal-send-email-body-'+<?php echo $model->lb_record_primary_key ?>).html(getLoadingIconHTML(false));
    $('#modal-send-email-body-'+<?php echo $model->lb_record_primary_key ?>).load("<?php echo $model->getActionURLNormalized('SenEmail', array('form_type'=>'ajax','ajax'=>1,'id'=>$model->lb_record_primary_key)) ?>");
}

function onclickFormGetPublicPDF(){
    $('#btn-get-public-pdf').click();
    senGetPublicPDF();
}
function senGetPublicPDF(){
    $('#modal-get-public-pdf-body-'+<?php echo $model->lb_record_primary_key ?>).html(getLoadingIconHTML(false));
    $('#modal-get-public-pdf-body-'+<?php echo $model->lb_record_primary_key ?>).load("<?php echo $model->getActionURLNormalized('PublicPDF', array('form_type'=>'ajax','ajax'=>1,'p'=>"$model->lb_invoice_encode")) ?>");
}
function calculateInvoiceTotals(invoice_id)
{
    var line_items_grid_id = 'invoice-line-items-grid-'+invoice_id;
    var discounts_grid_id = 'invoice-discounts-grid-'+invoice_id;
    var taxes_grid_id = 'invoice-taxes-grid-'+invoice_id;

    calculateInvoiceSubTotal(line_items_grid_id);
    calculateInvoiceTotalDiscount(discounts_grid_id);
    calculateInvoiceTotalAfterDiscounts();
    calculateInvoiceTotalTax(taxes_grid_id);
    calculateInvoiceTotalAfterTaxes();
    calculateInvoiceTotalOutstanding();
}

function updateInvoiceTotalsUI(invoice_id)
{
    $("#invoice-subtotal-"+invoice_id).html(parseFloat(invoice_sub_total).toFixed(2));
    $("#invoice-total-"+invoice_id).html(parseFloat(invoice_total_after_taxes).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_paid).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_outstanding).toFixed(2));
}

function calculateInvoiceTotalTax(grid_id)
{
    invoice_total_tax = 0;
    $('#' + grid_id +' .lbinvoice-tax').each(function() {
        var el_field_name = $(this).attr("line_item_field");
        var line_item_pk = $(this).attr("line_item_pk");

        // if this is total field, add
        if (el_field_name == 'item-total') {
            var this_tax_total = ($("#lb_invoice_item_value_"+line_item_pk).val()/100)*invoice_total_after_discounts;
            $(this).val(parseFloat(this_tax_total).toFixed(2));
            invoice_total_tax += parseFloat(this_tax_total);
        }
    });
}

function onChangeMethodDropdown(line_item_pk, method_id)
{
    if (method_id == -1)
    {
        // show pop up form to create new tax item
        $("#modal-new-tax-form-body-"+<?php echo $model->lb_record_primary_key; ?>).html(getLoadingIconHTML(false));
        $("#modal-new-tax-form-body-"+<?php echo $model->lb_record_primary_key; ?>).load("<?php echo $model->getActionURLNormalized('createTax',array('form_type'=>'ajax','ajax'=>1,'invoice_id'=>$model->lb_record_primary_key)); ?>");
        $("#btn-add-new-tax").click();
    } else {
        // submit selected tax to server
//        $('#content').block();
        $.post("<?php echo $model->getActionURLNormalized('ajaxgetMethod',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, method_id: method_id}, 
//               $('#container-invoice-line-items-section').block();
            function(response)
            {
                if (response != null)
                {
                    var responseJSON = jQuery.parseJSON(response);
                    // refill tax value
                    
//                    $('#content').unblock();
                }
            }
        );
    } // end else
}
function changeAmount(line_item_pk, method_id)
{
   
        // submit selected tax to server
        $('#content').block();
        $.post("<?php echo $model->getActionURLNormalized('ajaxgetAmount',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, method_id: method_id,invoice_id:<?php echo $model->lb_record_primary_key;?>},
            function(response)
            {
                
                    var responseJSON = $.parseJSON(response);
                    
                    var status = responseJSON.status;
                    if(status == "I_PAID")
                    {
                        $('#lb_invocie_status').text("Paid");
                    }
                    else
                        $('#lb_invocie_status').text("Open");
                    // refill tax value
                    $('#invoice-outstanding-'+<?php echo $model->lb_record_primary_key;?>).text(responseJSON.outstanding);
                    $('#invoice-paid-'+<?php echo $model->lb_record_primary_key;?>).text(responseJSON.paid);
                    
                    $('#content').block({
                        message:"<div style='padding:20px'><?php echo "Successfully: ".date('d/m/Y H:i:s'); ?></div>",
                    });
                    setTimeout(function(){
                            $('#content').unblock()
                        }, 2000);
            
                    
                   
            }
        );
    
}
function changeNote(line_item_pk, method_id)
{
   
        // submit selected tax to server
        $.post("<?php echo $model->getActionURLNormalized('ajaxgetNote',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, method_id: method_id},
            function(response)
            {
                if (response != null)
                {
                    var responseJSON = jQuery.parseJSON(response);
                    // refill tax value
                   
                }
            }
        );
    
}
function changeDate(line_item_pk, method_id)
{
   
        // submit selected tax to server
        $.post("<?php echo $model->getActionURLNormalized('ajaxgetDate',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, method_id: method_id},
            function(response)
            {
                if (response != null)
                {
                    var responseJSON = jQuery.parseJSON(response);
                    // refill tax value
                   
                }
            }
        );
    
}
function datePicker(line_item_pk, method_id)
{
//   alert(line_item_pk);
//   alert(method_id);
    var from_date = $("#lb_invoice_item_payment_"+line_item_pk+"").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
       
    
}

function loadPaymentInvoice(invoice_status){
    if(invoice_status==undefined);
        invoice_status = 'invoice_status=<?php echo $model->lb_invoice_status_code; ?>';
    $('#container-payment-invoice').html('<img src="'+BASE_URL+'/images/loading.gif"/>');
    $('#container-payment-invoice').load('<?php echo $this->createUrl('LoadPaymentInvoice'); ?>?invoice_id=<?php echo $model->lb_record_primary_key; ?>&invoice_status='+invoice_status);
}

</script>

<style>
    .invoice-total-label {
    display: inline-block;
    float: left;
    font-weight: bold;
    text-align: right;
    width: 150px;
  
}

    </style>