<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $form CActiveForm */
/* @var $invoiceItemModel LbInvoiceItem */
/* @var $invoiceDiscountModel LbInvoiceItem */
/* @var $invoiceTaxModel LbInvoiceItem */
/* @var $invoiceTotal LbInvoiceTotal */


$m = 'LbVendorInvoice';

$credit_by = LbCoreEntity::model()->getCoreEntity($m,$model->lb_record_primary_key);

$canEdit = BasicPermission::model()->checkModules($m, 'update',$credit_by);
$canDelete = BasicPermission::model()->checkModules($m, 'delete',$credit_by);
$canEdit = true;
$canDelete = true;
//$canViewProcess = BasicPermission::model()->checkModules('process_checklist', 'view',$credit_by);
//$canEditAll = BasicPermission::model()->checkModules($m, 'update all');
//$canDeletOwn = BasicPermission::model()->checkModules($m, 'delete own');
//$canDeleteAll = BasicPermission::model()->checkModules($m, 'delete all');
//LbVendorItem::model()->addLineItemVendor($model->lb_record_primary_key, 'LINE');
$currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;

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
$itemVendor = $modelItemVendor->getItemByVendorInvoice($model->lb_record_primary_key, LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE);
//echo $itemVendor->lb_vendor_id;
$itemLineVendor = LbVendorItem::model()->find('lb_vendor_invoice_id = '.$model->lb_record_primary_key.' AND lb_vendor_type = "LINE_INVOICE"');

if(count($itemLineVendor) == 0)
{
    $itemManage = new LbVendorItem();
   
    $itemManage->addLineItemVendor($model->lb_record_primary_key,LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE);
    LbVendorTotal::model()->addTotalVendor($model->lb_record_primary_key,  LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);

}

$modelTotal = LbVendorTotal::model()->getVendorTotal($model->lb_record_primary_key,  LbVendorTotal::LB_VENDOR_INVOICE_TOTAL);

$grid_id = 'invoice-line-items-grid-'.$model->lb_record_primary_key;
$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => $grid_id,
                'type'=>'bordered',
		'dataProvider' => $modelItemVendor->getItemByVendorInvoice($model->lb_record_primary_key, LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE),
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
                    'deleteButtonUrl'=>'"' . LbVendor::model()->getActionURLNormalized("ajaxDeleteItem") . '" .
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
							CHtml::activeTextArea($data,"lb_vendor_item_description",
								array("style"=>"width: 350px; border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"invoice-item-description lbinvoice-line-items",
										"name"=>"lb_vendor_item_description{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-description"))
							
                           	',
						'htmlOptions'=>array('width'=>'350','valign'=>'top'),
                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
		array(
						'header' => Yii::t('lang','Quantity'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_vendor_item_quantity",
								array("style"=>"width: 50px;text-align: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-line-items",
										"name"=>"lb_vendor_item_quantity{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                               "onchange"=>"js:onChangeLine($data->lb_record_primary_key
                                            );",
										"line_item_field"=>"item-quantity"))
						',
						'htmlOptions'=>array('width'=>'50','style'=>'text-align: right;'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
				array(
						'header' => Yii::t('lang','Unit Price'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_vendor_item_price",
								array("style"=>"width: 90px;text-align: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-line-items",
										"name"=>"lb_vendor_item_price{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                "onchange"=>"js:onChangeLine($data->lb_record_primary_key
                                            );",
										"line_item_field"=>"item-value"))
						',
						'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                        'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
				),
				array(
						'header' => Yii::t('lang','Total'),
						'type' => 'raw',
						'value' => '
							CHtml::activeTextField($data,"lb_vendor_item_amount",
								array("disabled"=>"1","style"=>"width: 90px;text-align: right; padding-right: 0px;
								            border-top: none; border-left: none; border-right: none; box-shadow: none;",
								        "class"=>"lbinvoice-line-items",
										"name"=>"lb_vendor_item_amount{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_id}",
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
			$.post("'.LbVendor::model()->getActionURLNormalized('InsertLineItem', array('id'=>$model->lb_record_primary_key)).'", 
, 
                        function(response){
                        
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
            LbVendor::model()->getActionURLNormalized('ajaxUpdateLineItems',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorItem::LB_VENDOR_INVOICE_ITEM_TYPE_LINE)), 
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
                                    
//                                    $("#invoice-subtotal-'.$model->lb_record_primary_key.'").html(jsonData.lb_vendor_subtotal);
//                                   
                                }
                            }'
                        
                    ),
                    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-line-items-form'));

}



$this->endWidget();

echo '</div>'; // end line items section

//Sub total
echo '<div class="invoice-subtotal-container">';// style="clear: both; float: right; display: block; width: 350px">';
echo "<div style='' class='invoice-total-label'>".Yii::t('lang','Sub Total')." ($currency_name):</div>";
echo "<div id='invoice-subtotal-{$model->lb_record_primary_key}' style=''  class='invoice-total-value'>";
echo "{$modelTotal->lb_vendor_subtotal}</div>";
//echo '</div>';
echo '</div>'; // end showing sub total
/********************************************************************************
 * ============================= DISCOUNTS SECTION =============================
 *******************************************************************************/

echo '<div id="container-invoice-discounts" class="invoice-discounts-container">';// style="float: right; display: block; clear: both">';

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-invoice-discounts-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
));

//echo '<div style="width: auto; display: block; clear: both">';// style="text-align: right; clear: both; display: block; width: 350px;">';
//echo "<div style='' class='invoice-total-label'>Discount:</div>";
echo "<div style='font-size: 9pt; float: left; width: 150px; text-align: right;'>";//  class='invoice-total-value'>";
echo CHtml::link(Yii::t('lang','Add discount'), '#', array(
    'onclick'=>'
			$.post("'.LbVendor::model()->getActionURLNormalized('createBlankDiscount',
        array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)).'", function(response){
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
    'dataProvider' => $modelDiscountVendor->getVendorDiscounts($model->lb_record_primary_key,  LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT),
    'hideHeader'=>true,
    'htmlOptions'=>array('style' =>' float: right; margin-bottom: 0px;', 'class'=>'invoice-total-grid'),
    'template'=>'{items}',
    'emptyText'=>'<div class="invoice-discount-empty-text">No discounts.</div>',
    'columns' => array(
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>"{delete}",
            'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px;'),
            'deleteButtonUrl'=>'"' . LbVendor::model()->getActionURLNormalized("ajaxDeleteItemDiscount") . '" .
                                        "?id={$data->lb_record_primary_key}"',
            'afterDelete'=>'function(link,success,data){
                if(success) {
                    refreshTotals();
                    refreshTaxesGrid();
                    refreshDiscountsGrid();
                }
            } ',
        ),
        array(
            'header' => 'Discount',
            'type' => 'raw',
            'value' => '
                CHtml::activeTextField($data,"lb_vendor_description",
								array("style"=>"width: 143px; text-align: right;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-discount",
										"name"=>"lb_vendor_description{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_invoice_id}",
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
                CHtml::activeTextField($data,"lb_vendor_value",
								array("style"=>"width: 130px; text-align: right; float: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-discount",
										"name"=>"lb_vendor_value{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-total"))

            ',
            'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px;;', 'align'=>'right'),
        )
    )
)); // end discount grid

// hidden discount submit button
echo CHtml::ajaxSubmitButton(Yii::t('lang','Save Discounts'),
 LbVendor::model()->getActionURLNormalized('ajaxUpdateDiscounts',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)),
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
                refreshTotals();
                    refreshTaxesGrid();
                    
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

echo '<div id="container-invoice-taxes" style="margin-top: -20px;" class="invoice-taxes-container">';

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
    'dataProvider' => $modelTax->getTaxByVendor($model->lb_record_primary_key, LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX),
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
            'deleteButtonUrl'=>'"' . lbVendor::model()->getActionURLNormalized("ajaxDeleteItemTaxs") . '" .
                                        "?id={$data->lb_record_primary_key}"',
            'afterDelete'=>'function(link,success,data){
                if(success) {
                    refreshTotals();
                    refreshTotals();
                    refreshTaxesGrid();
                    refreshDiscountsGrid();
                }
            } ',
            'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px'),
        ),
        array(
            'header' => 'Tax',
            'type' => 'raw',
            'value' => '
                CHtml::activeDropdownList($data,"lb_tax_name",
                                array("0"=>"$data->lb_tax_name $data->lb_vendor_tax_value%")+
                                CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                        function($tax){return "$tax->lb_record_primary_key";},
                                        function($tax){return "$tax->lb_tax_name $tax->lb_tax_value%";})
                                        ,
								array("style"=>"width: 155px; text-align: right;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_tax_name{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-description",
										"options"=>array(
                                            "$data->lb_tax_name"=>array("selected"=>true),
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
                CHtml::activeTextField($data,"lb_vendor_tax_total",
								array("style"=>"width: 130px; text-align: right;float: right; padding-right: 0px;
								                border-top: none; border-left: none; border-right: none; box-shadow: none;",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_vendor_tax_total{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-total",
										"disabled"=>"true"))
				. CHtml::activeHiddenField($data,"lb_vendor_tax_value",
								array("style"=>"width: 50px; text-align: right",
										"class"=>"lbinvoice-tax",
										"name"=>"lb_vendor_tax_value{$data->lb_record_primary_key}",
										"data_invoice_id"=>"{$data->lb_vendor_invoice_id}",
										"line_item_pk"=>"{$data->lb_record_primary_key}",
										"line_item_field"=>"item-value"))
            ',
            'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px', 'align'=>'right'),
        ),
    )
)); // end tax grid

// hidden tax submit button
echo CHtml::ajaxSubmitButton('Save Taxes',
 LbVendor::model()->getActionURLNormalized('ajaxUpdateTaxes',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX)),
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
                refreshTaxesGrid();
              
                    
                disableSaveButton('.$model->lb_record_primary_key.');
			}'
    ),
    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-taxes-form'));


$this->endWidget();
// END TAX FORM
echo '</div>';// end invoice taxes
//
/// TOTAL
echo '<div class="invoice-total-container" style="margin-top: -20px">';

// total after tax
echo '<div class="invoice-total-label">'.Yii::t('lang','Total').' ('.$currency_name.'):</div>';
echo "<div id='invoice-total-{$model->lb_record_primary_key}' class='invoice-total-value'>";
echo $modelTotal->lb_vendor_last_tax;
echo '</div>';

// paid
echo '<div class="invoice-total-label">'.Yii::t('lang','Paid').' ('.$currency_name.'):</div>';
echo "<div id='invoice-paid-{$model->lb_record_primary_key}' class='invoice-total-value'>{$modelTotal->lb_vendor_last_paid}</div>";

// outstanding
echo '<div class="invoice-total-label">'.Yii::t('lang','Outstanding').' ('.$currency_name.'):</div>';
echo "<div id='invoice-outstanding-{$model->lb_record_primary_key}' class='invoice-total-value'>{$modelTotal->lb_vendor_last_outstanding}</div>";

echo '</div>';

echo '<div id="container-invoice-note-'.$model->lb_record_primary_key.'"
    style="display: block; clear: both;padding-top: 40px; width: 100%;" class="invoice-total-container">';
    echo '<h4>'.Yii::t('lang','Note').':</h4>';
    $this->widget('editable.EditableField', array(
        'type'        => 'textarea',
        'inputclass'  => 'input-large-textarea',
        'emptytext'   => 'Enter invoice note',
        'model'       => $model,
        'attribute'   => 'lb_vd_invoice_notes',
        'url'         => LbVendor::model()->getActionURLNormalized('ajaxUpdateNoteVI'),
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
   
    echo '</div>';// end note div
    
echo '</div>';

echo '<div style="text-align: center; width:100%;" class="invoice-total-container">';
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
    if ($model->lb_vd_invoice_status == $model::LB_VD_STATUS_CODE_DRAFT)
    {
        echo '&nbsp;';
        LBApplicationUI::ajaxButton(Yii::t('lang','Confirm Invoice'),
            lbVendor::model()->getActionURLNormalized('AjaxConfirmVenDorInvoice',
                array('id'=>$model->lb_record_primary_key)),
            array(
                'id' => 'ajax-submit-confirm-invoice-' . uniqid(),
                'beforeSend' => 'function(data){
                                    var invoice_vendor_id = $("#po-number-container").text();
                                 
                                    if(invoice_vendor_id=="Draft")
                                    {
                                   
                                        alert("Please enter Bill invoice");
                                        return false;
                                        }
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
                        $("#lb_invocie_status").html(dataJSON.lb_vd_invoice_status);
                        $("#po-number-container").html(dataJSON.lb_vd_invoice_no);
                        onConfirmInvoiceSuccessful(dataJSON);
                    }
                            }'
            ),//end ajax options
            array(
                'id'=> 'btn-confirm-invoice-'.$model->lb_record_primary_key,
            ) // end html options
        );
    }

    // Buttom Write Off
    if ($model->lb_vd_invoice_status != $model::LB_VD_CODE_WRITTEN_OFF)
    {
        echo '&nbsp;';
        LBApplicationUI::ajaxButton(Yii::t('lang','Write off'),
        LbVendor::model()->getActionURLNormalized('UpdateStatusVIWriteOff',
                array('id'=>$model->lb_record_primary_key,'status'=> LbVendor::LB_VENDOR_STATUS_CODE_WRITTEN_OFF)),
            array(
                'success' => 'function(data, status, obj) {
                    if(data != null)
                    {
                        var dataJSON = jQuery.parseJSON(data);
                        onConfirmInvoiceSuccessful(dataJSON);
                        $("#invoice-header-container .ribbon-green").html(dataJSON.lb_vendor_status);
                        $("#lb_invocie_status").html(dataJSON.lb_vendor_status);
                        $("#btn-write-off-invoice-"+dataJSON.lb_record_primary_key).remove();
                    }
                            }'
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
    if ($model->lb_vd_invoice_status == $model::LB_VD_STATUS_CODE_DRAFT)
    {
        echo '&nbsp;';
        LBApplicationUI::button(Yii::t('lang','Delete'),array(
            'url'=>LbVendor::model()->getActionURLNormalized('deleteVDInvoice',array('id'=>$model->lb_record_primary_key)),
            'htmlOptions'=>array(
                    'onclick'=>'return confirm("Are you sure you want to delete this item?");',
                    'id'=>'btn-delete-invoice-'.$model->lb_record_primary_key,
                ),
        ));
    }
}
echo '</div>';

echo '</div></div>';



?>
<script language="javascript">
   $(document).ready(function(){
    $('.invoice-item-description').autosize({append: "\n"}); 
    bindLineItemsForChanges("<?php echo $grid_id; ?>");
    bindDiscountsForChanges("<?php echo $discount_grid_id; ?>");


});
function addTaxClick()
{
    $.post("<?php echo LbVendor::model()->getActionURLNormalized('createBlankTax', array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX));?>",
        function(response){
            
            var responseJSON = jQuery.parseJSON(response);
           
            if (responseJSON != null && responseJSON.success == 1)
            {
                lbinvoice_new_tax_added = true;
                submitTaxesAjaxForm();
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
function refreshTotals()
{
    $.get("<?php echo LbVendor::model()->getActionURLNormalized('ajaxGetTotals',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX)); ?>",
        {},
        function(response)
        {
            if (response != null)
            {
                var responseJSON = jQuery.parseJSON(response);
                getInvoiceTotals(responseJSON);
                updateInvoiceTotalsUI(<?php echo $model->lb_record_primary_key;?>);
               
            }
        }
    )
}

function totalAfterdeleteDiscount()
{
    $.get("<?php echo LbVendor::model()->getActionURLNormalized('AjaxUpdateDiscounts',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorDiscount::LB_VENDOR_INVOICE_ITEM_TYPE_DISCOUNT)); ?>",
        {},
        function(response)
        {
//            window.location.reload();
        }
    )
}
function refreshTax(id,value,line_item_pk)
{
   
    $.get("<?php echo LbVendor::model()->getActionURLNormalized('ajaxGetTotals',array('id'=>$model->lb_record_primary_key,'type'=>  LbVendorTax::LB_VENDOR_INVOICE_ITEM_TYPE_TAX)); ?>",
        {},
        function(response)
        {
            if (response != null)
            {
                var responseJSON = jQuery.parseJSON(response);
                getInvoiceTotals(responseJSON);
                updateInvoiceTotalsUI(<?php echo $model->lb_record_primary_key;?>);
                var discount = responseJSON.lb_vendor_total_last_discount;
               
                var tax = (discount*value)/100;
               
                $('#lb_vendor_tax_total'+line_item_pk).val(tax);
                
            }
        }
    )
}
function getInvoiceTotals(responseJSON)
{
    invoice_sub_total = responseJSON.lb_vendor_subtotal;
    invoice_total_after_discounts = responseJSON.lb_vendor_total_last_discount;
    invoice_total_after_taxes = responseJSON.lb_vendor_last_tax;
    invoice_total_paid = responseJSON.lb_vendor_last_paid;
    invoice_total_outstanding = responseJSON.lb_vendor_last_outstanding;
    //console.log(invoice_sub_total, invoice_total_after_taxes);
}
function updateInvoiceTotalsUI(invoice_id)
{
    $("#invoice-subtotal-"+invoice_id).html(parseFloat(invoice_sub_total).toFixed(2));
    $("#invoice-total-"+invoice_id).html(parseFloat(invoice_total_after_taxes).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_paid).toFixed(2));
    if ($("#"+invoice_id) != null)
        $("#"+invoice_id).html(parseFloat(invoice_total_outstanding).toFixed(2));
    $('#invoice-outstanding-'+invoice_id).html(parseFloat(invoice_total_outstanding).toFixed(2));
}

function bindDiscountsForChanges(grid_id)
{
    $('#' + grid_id +' .lbinvoice-discount').each(function() {
        var elem = $(this);

        console.log('binding discount...'+$(this));

        // Save current value of element
        elem.data('oldVal', elem.val());

        // Look for changes in the value
        elem.unbind("propertychange keyup input paste", discountChangeHandler);
        elem.bind("propertychange keyup input paste", discountChangeHandler);
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

function bindLineItemsForChanges(grid_id)
{
    
	$('#' + grid_id +' .lbinvoice-line-items').each(function() {
		var elem = $(this);
		console.log('binding...'+$(this));

		// Save current value of element
		elem.data('oldVal', elem.val());

		// Look for changes in the value
		elem.unbind("propertychange keyup input paste", lineItemsChangeHandler);
		elem.bind("propertychange keyup input paste", lineItemsChangeHandler);
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
        $.post("<?php echo LbVendor::model()->getActionURLNormalized('ajaxGetTax',array('id'=>$model->lb_record_primary_key)); ?>",
            {line_item_pk: line_item_pk, tax_id: tax_id},
            function(response)
            {
               
                if (response != null)
                {
                    
                    var responseJSON = jQuery.parseJSON(response);
//                   refreshTotals();
                    refreshTax(responseJSON.lb_record_primary_key,responseJSON.lb_tax_value,line_item_pk);
                    refreshTotals();
                    refreshTaxesGrid();
                    
                    // refill tax value
                    $("#lb_invoice_item_value_"+line_item_pk).val(responseJSON.lb_tax_value);

                    // recalculate totals on client-side
                    calculateInvoiceTotals(<?php echo $model->lb_record_primary_key; ?>);
                    updateInvoiceTotalsUI(<?php echo $model->lb_record_primary_key; ?>);
                }
            }
        );
    } // end else
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


function  onChangeLine(id)
{
   var lb_vendor_item_quantity = $('#lb_vendor_item_quantity'+id).val();
   var lb_vendor_item_price = $('#lb_vendor_item_price'+id).val();
   var amount = lb_vendor_item_quantity*lb_vendor_item_price;

   $('#lb_vendor_item_amount'+id).val(amount);
}

</script>