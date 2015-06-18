<?php
    $m = $this->module->id;
    $credit_by = LbCoreEntity::model()->getCoreEntity($m,$model->lb_record_primary_key)->lb_created_by;
    $canAdd = BasicPermission::model()->checkModules($m, 'add');
    $canView = BasicPermission::model()->checkModules($m, 'view',$credit_by);
    $canList = BasicPermission::model()->checkModules($m, 'list',$credit_by);
    $canDelete = BasicPermission::model()->checkModules($m, 'delete',$credit_by);
    $canEdit = BasicPermission::model()->checkModules($m, 'update',$credit_by);
    
    $deleteTemplate=false;
    if($canDelete)
        $deleteTemplate = "{delete}";
    
    $currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
?>
<div style="margin-top: 30px">
    <?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'lb-quotation-items-form',
                        // Please note: When you enable ajax validation, make sure the corresponding
                        // controller action is handling ajax validation correctly.
                        // There is a call to performAjaxValidation() commented in generated controller code.
                        // See class documentation of CActiveForm for details on this.
                        'enableAjaxValidation'=>false,
                        'type'=>'horizontal',
        ));
    ?>
    <?php $grid_id = 'quotation-line-item-grid-'.$model->lb_record_primary_key; ?>
    <?php $this->widget('bootstrap.widgets.TbGridView',array(
                    'id'=>$grid_id,
                    'type'=>'bordered',
                    'dataProvider'=>$quotationItemModel->getquotationItems($model->lb_record_primary_key),
                    'columns'=>array(
                        array(
                            'header'=>'#',
                            'type'=>'raw',
                            'value'=>'1',
                            'htmlOptions'=>array('width'=>'10'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                        ),
                        array(
                            'class'=>'bootstrap.widgets.TbButtonColumn',
                            'template'=>$deleteTemplate,
                            'deleteButtonUrl'=>'"' . $this->createUrl("deleteBlankItem") . '" .
                                                "?id={$data->lb_record_primary_key}"',
                            'afterDelete'=>'function(link,success,response){
                                var responseJSON = jQuery.parseJSON(response);
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                                refreshTaxGrid();
                            } ',
                            'htmlOptions'=>array('width'=>'10'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                        ),
                        array(
                            'header'=>Yii::t('lang','Item'),
                            'type'=>'raw',
                            'value'=>'CHtml::activeTextArea($data,"lb_quotation_item_description",
                                              array("style"=>"width: 350px; border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                    "name"=>"lb_quotation_item_description_{$data->lb_record_primary_key}",
                                                    "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                    "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                    "class"=>"quotation-item-description lbquotation-line-items"))
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
                                    </a>"',
                            
                            'htmlOptions'=>array('width'=>'350'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header')
                            
                        ),
                        array(
                            'header'=>Yii::t('lang','Quantity'),
                            'type'=>'raw',
                            'value'=>'
                                    CHtml::activeTextField($data,"lb_quotation_item_quantity",
                                            array("style"=>"width: 50px;text-align: right; padding-right: 0px;
                                                            border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                   "class"=>"lbquotation-line-items",
                                                   "name"=>"lb_quotation_item_quantity_{$data->lb_record_primary_key}",
                                                   "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                   "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                   "line_item_field"=>"item-quantity"))
                                ',
                            'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header')
                            
                        ),
                        array(
                            'header'=>Yii::t('lang','Unit Price'),
                            'type'=>'raw',
                            'value'=>'
                                    CHtml::activeTextField($data,"lb_quotation_item_price",
                                            array("style"=>"width: 90px;text-align: right; padding-right: 0px;
                                                            border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                            "name"=>"lb_quotation_item_price_{$data->lb_record_primary_key}",
                                                            "class"=>"lbquotation-line-items",
                                                            "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                            "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                            "line_item_field"=>"item-value"))
                                ',
                            'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header')
                            
                        ),
                        array(
                            'header'=>Yii::t('lang','Total'),
                            'type'=>'raw',
                            'value'=>'
                                    CHtml::activeTextField($data,"lb_quotation_item_total",
                                            array("disabled"=>"1","style"=>"width: 90px;text-align: right; padding-right: 0px;
                                                        border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                            "name"=>"lb_quotation_item_total_{$data->lb_record_primary_key}",
                                                            "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                            "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                            "line_item_field"=>"item-total"))
                                ',
                            'htmlOptions'=>array('width'=>'100','style'=>'text-align: right;'),
                            'headerHtmlOptions'=>array('class'=>'lb-grid-header')
                            
                        ), 
                    ),
    )); ?>
 <?php
 if($canEdit)
 {
    echo CHtml::link(Yii::t('lang','Add item'), '#', array(
            'onclick'=>'
                            $.post("'.$this->createUrl('createBlankItem', 
                            array('id'=>$model->lb_record_primary_key)).'", function(response){
                                    var responseJSON = jQuery.parseJSON(response);
                                    if (responseJSON != null && responseJSON.success == 1)
                                    {
                                        lbquotation_new_line_item_added = true;
                                        $(".submit-btn-line-items-form").click();
                                        refreshLineItemsGrid();
                                    }
                            });

                            return false;'
    ));
 }

// hidden line item submit button
if($canAdd)
{
    echo CHtml::ajaxSubmitButton(Yii::t('lang','Save'),
                    $model->getActionURLNormalized('AjaxUpdateLineItems',array('id'=>$model->lb_record_primary_key)), 
                    array(
                            'id' => 'ajax-submit-form-items-' . uniqid(), 
                            'beforeSend' => 'function(data){ 
                                    // code...
                            } ',
                            'success' => 'function(response) {
                                var responseJSON = jQuery.parseJSON(response);
                                if(lbquotation_new_line_item_added)
                                {
                                    lbquotation_new_line_item_added =false;
                                }
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                                refreshTaxGrid()
                            }'
                    ),
                    array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-line-items-form'));
}
?>
    <!--    Get Total Item-->
    <div class="invoice-subtotal-container">
        <div class="invoice-total-label"><?php echo Yii::t('lang','Sub Total');?> (<?php echo $currency_name ?>):</div>
        <div id='quotation-subtotal' class="invoice-total-value"><?php echo $quotationTotalModel->lb_quotation_subtotal; ?></div>
    </div><!--  End  Get Total Item-->
<?php $this->endWidget(); ?>
    <!--  DISCOUNT DESTION -->
    
<?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'lb-quotation-discounts-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
    ));
?>
    <div id="container-quotation-discounts" class="invoice-discounts-container">
        <div style='font-size: 9pt; float: left; width: 150px; text-align: right;'>
            <?php
                echo CHtml::link(Yii::t('lang','Add discount'),'#', array(
                    'onclick'=>'
                            $.post("'.$this->createUrl("ajaxCreateBlankDiscount",
                                    array('id'=>$model->lb_record_primary_key)).'",
                                   function(response){
                                        var responseJSON = jQuery.parseJSON(response);
                                        lbquotation_new_discount_added = true;
                                        refreshDiscountGrid();
                                        lbquotation_discounts_updated = false;
                                        lbquotation_new_discount_added = false;
                                   });
                           return false;'
                ))
            ?>
        </div>
        <?php
            $discount_grid_id = 'quotation-discount-grid-'.$model->lb_record_primary_key;
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>$discount_grid_id,
                'dataProvider'=>$quotationDiscountModel->getQuotationDiscounts($model->lb_record_primary_key),
                'hideHeader'=>true,
                'htmlOptions'=>array('style' =>' float: right; margin-bottom: 0px;', 'class'=>'invoice-total-grid'),
                'template'=>'{items}',
                'emptyText'=>'<div class="invoice-discount-empty-text">No discounts.</div>',
                'columns'=>array(
                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>$deleteTemplate,
                        'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px;'),
                        'deleteButtonUrl'=>'"' . $this->createUrl("ajaxDeleteBlankDiscount") . '" .
                                                    "?id={$data->lb_record_primary_key}"',
                        'afterDelete'=>'function(link,success,response){
                                var responseJSON = jQuery.parseJSON(response);
                                refreshTaxGrid();
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                        } ',
                    ),
                    array(
                        'header' => Yii::t('lang','Discount'),
                        'type' => 'raw',
                        'value' => '
                            CHtml::activeTextField($data,"lb_quotation_discount_description",
                                                                            array("style"=>"width: 143px; text-align: right;
                                                                                            border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                            "class"=>"lbquotation-discount",
                                                                                            "name"=>"lb_quotation_item_description_{$data->lb_record_primary_key}",
                                                                                            "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                                                            "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                            "line_item_field"=>"item-description"))
                                            ."&nbsp;('.$currency_name.'):"
                        ',
                        'htmlOptions'=>array('style'=>'width: 200px; border-top: none; padding-top: 0px;'),
                    ),
                    array(
                        'header' => Yii::t('lang','Amount'),
                        'type' => 'raw',
                        'value' => '
                            CHtml::activeTextField($data,"lb_quotation_discount_total",
                                                                            array("style"=>"width: 130px; text-align: right; float: right; padding-right: 0px;
                                                                                            border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                            "class"=>"lbquotation-discount",
                                                                                            "name"=>"lb_quotation_item_total_{$data->lb_record_primary_key}",
                                                                                            "data_quotation_id"=>"{$data->lb_quotation_id}",
                                                                                            "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                            "line_item_field"=>"item-total"))

                        ',
                        'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px;;', 'align'=>'right'),
                    ),
                )
            ));
            
        // hidden discount submit button
        if($canAdd)
        {
            echo CHtml::ajaxSubmitButton(Yii::t('lang','Save Discounts'),
                $model->getActionURLNormalized('ajaxUpdateDiscount',array('id'=>$model->lb_record_primary_key)),
                array(
                    'id' => 'ajax-submit-form-discounts-' . uniqid(),
                    'beforeSend' => 'function(data){
                                            // code...
                                    } ',
                    'success' => 'function(response) {
                                var responseJSON = jQuery.parseJSON(response);
                                if(lbquotation_new_discount_added)
                                {
                                    lbquotation_new_discount_added = false;
                                    refreshDiscountGrid();

                                }
                                refreshTaxGrid();
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                            }'
                ),
                array('live' => false, 'style'=>'display: none;', 'class'=>'submit-btn-discounts-form'));
        }

    ?>
    </div>
    
<?php $this->endWidget(); ?>
    
<!--
/********************************************************************************
 * =============================== TAXES SECTION ================================
 *******************************************************************************/ 
-->
    <div id="container-invoice-taxes" style="margin-top: -20px;" class="invoice-taxes-container">
    <?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'lb-invoice-taxes-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
        ));
    ?>
        <div style='font-size: 9pt; float: left; width: 150px; text-align: right;'>
            <?php 
                echo CHtml::link(Yii::t('lang','Add tax'), '#', array(
                    'onclick'=>'
                        $.post("'.$this->createUrl("ajaxCreateBlankTax",array("id"=>$model->lb_record_primary_key)).'",
                            function(response){
                                var responseJSON = jQuery.parseJSON(response);
                                refreshTaxGrid();
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                            }
                        );
                        return false;'
                )); ?>
        </div>
        <div>
            <?php
                // taxes grid
                $taxes_grid_id = 'invoice-taxes-grid-'.$model->lb_record_primary_key;
                $this->widget('bootstrap.widgets.TbGridView', array(
                    'id' => $taxes_grid_id,
                    'dataProvider' => $quotaitonTaxModel->getTaxQuotation($model->lb_record_primary_key),
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
                            'template'=>"$deleteTemplate",
                            'deleteButtonUrl'=>'"' . $model->getActionURLNormalized("ajaxDeleteBlankTax") . '" .
                                                        "?id={$data->lb_record_primary_key}"',
                            'afterDelete'=>'function(link,success,response){
                                var responseJSON = jQuery.parseJSON(response);
                                refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                            } ',
                            'htmlOptions'=>array('style'=>'width: 10px; border-top: none; padding-top: 0px'),
                        ),
                        array(
                            'header' => Yii::t('lang','Tax'),
                            'type' => 'raw',
                            'value' => '
                                CHtml::activeDropdownList($data,"lb_quotation_tax_id",
                                                array("0"=>"")+
                                                CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                                        function($tax){return "$tax->lb_record_primary_key";},
                                                        function($tax){return "$tax->lb_tax_name $tax->lb_tax_value%";})
                                                        + array("-1"=>"-- Add new tax --"),
                                                                                array("style"=>"width: 155px; text-align: right;
                                                                                                border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                                "class"=>"lbinvoice-tax",
                                                                                                "name"=>"lb_quotation_tax_id_{$data->lb_record_primary_key}",
                                                                                                "data_invoice_id"=>"{$data->lb_quotation_id}",
                                                                                                "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                                "line_item_field"=>"item-description",
                                                                                                "options"=>array(
                                                            "$data->lb_quotation_tax_id"=>array("selected"=>true),
                                                        ),
                                                        "onchange"=>"js:onChangeTax($(this).val());"
                                                )
                                )
                                . "&nbsp;('.$currency_name.'):"
                            ',
                            'htmlOptions'=>array('style'=>'width: 200px; border-top: none; padding-top: 0px'),
                        ),
                        array(
                            'header' => Yii::t('lang','Amount'),
                            'type' => 'raw',
                            'value' => '
                                CHtml::activeTextField($data,"lb_quotation_tax_total",
                                                                                array("style"=>"width: 130px; text-align: right;float: right; padding-right: 0px;
                                                                                                border-top: none; border-left: none; border-right: none; box-shadow: none;",
                                                                                                "class"=>"lbinvoice-tax",
                                                                                                "name"=>"lb_quotation_total_{$data->lb_record_primary_key}",
                                                                                                "data_invoice_id"=>"{$data->lb_quotation_id}",
                                                                                                "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                                "line_item_field"=>"item-total",
                                                                                                "disabled"=>"true"))
                                                . CHtml::activeHiddenField($data,"lb_quotation_tax_value",
                                                                                array("style"=>"width: 50px; text-align: right",
                                                                                                "class"=>"lbinvoice-tax",
                                                                                                "name"=>"lb_quotation_item_value_{$data->lb_record_primary_key}",
                                                                                                "data_invoice_id"=>"{$data->lb_quotation_id}",
                                                                                                "line_item_pk"=>"{$data->lb_record_primary_key}",
                                                                                                "line_item_field"=>"item-value"))
                            ',
                            'htmlOptions'=>array('style'=>'width: 148px; border-top: none; padding-top: 0px', 'align'=>'right'),
                        ),
                    )
                 ));
            ?>
        </div>
        <br>
        <?php
            // hidden tax submit button
            echo CHtml::ajaxSubmitButton(Yii::t('lang','Save Taxes'),
                $model->getActionURLNormalized('ajaxUpdateTaxs',array('id'=>$model->lb_record_primary_key)),
                array(
                    'id' => 'ajax-submit-form-taxes-' . uniqid(),
                    'beforeSend' => 'function(data){
                                            // code...
                                    } ',
                    'success' => 'function(response) {
                                    var responseJSON = jQuery.parseJSON(response);
                                    refreshTotal(responseJSON.lb_quotation_subtotal,responseJSON.lb_quotation_total_after_total);
                                    refreshTaxGrid();
                                }'
                ),
                array('live' => false, 'style'=>'display:none;', 'class'=>'submit-btn-taxes-form'));
        ?>
    <?php $this->endWidget(); ?>
    </div>

<!-- /// TOTAL -->
<div class="invoice-total-container" style="margin-top: -20px">
    <div class="invoice-total-label"><?php echo Yii::t('lang','Total');?> (<?php echo $currency_name ?>):</div>
    <div id="quotation-total" class="invoice-total-value">
        <?php echo $quotationTotalModel->lb_quotation_total_after_total; ?>
    </div>
</div>

<!--
/********************************************************************************
 * =============================== NOTE SECTION ================================
 *******************************************************************************/
-->

    <?php
        echo '<div id="container-quotation-note-'.$model->lb_record_primary_key.'"
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
            'emptytext'   => 'Enter quotation note',
            'model'       => $model,
            'attribute'   => 'lb_quotation_note',
            'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement'   => 'right',
            //'showbuttons' => 'bottom',
            'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
            'options'	=> array(
            ),
        ));
        echo '</td></tr></tbody></table></div>';
    ?>


<!--
/********************************************************************************
 * =============================== INTERNAL NOTE ================================
 *******************************************************************************/
-->
<?php echo '<div id="container-quotation-internal-note-'.$model->lb_record_primary_key.'"
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
            'attribute'   => 'lb_quotation_internal_note',
            'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement'   => 'right',
            //'showbuttons' => 'bottom',
            'htmlOptions' => array('style'=>'text-decoration: none; border-bottom: none; color: #777'),
            'options'	=> array(
            ),
        ));
        echo '</td></tr></tbody></table>';
echo '</div>';// end note div
    ?>


<!-- //// SAVE BUTTON -->
<div style="display: block; clear: both; text-align: center; padding-top: 40px;" class="">
    <?php 
    if($canAdd)
    {
        LBApplicationUI::submitButton(Yii::t('lang','Save'), array(
            'htmlOptions'=>array(
                'onclick'=>'saveQuotation('.$model->lb_record_primary_key.'); return false;',
                'style'=>'margin-left: auto; margin-right: auto',
                'id'=>'btn-quotation-save-all-'.$model->lb_record_primary_key,
            ),
        ));
        
        //// SHOW CONFIRM BUTTON IF QUOTATION IS A DRAFT
        if ($model->lb_quotation_status == $model::LB_QUOTATION_STATUS_CODE_DRAFT)
        {
            echo '&nbsp;';
            LBApplicationUI::ajaxButton(Yii::t('lang','Confirm quotation'),
                $model->getActionURLNormalized('ajaxtConfirm',
                    array('id'=>$model->lb_record_primary_key)),
                array(
                    'id' => 'ajax-submit-confirm-invoice-' . uniqid(),
                    'beforeSend' => 'function(data){
                                       if(!lbQuotation_choose_customer)
                                       {
                                            alert("Customer name cannot be blank.");
                                            return false;
                                       }
                                       
                                } ',
                    'success' => 'function(data, status, obj) {
                        if(data != null)
                        {
                            var dataJSON = jQuery.parseJSON(data);
                            onConfirmQuotationSuccessful(dataJSON);
                        }
                                }'
                ),//end ajax options
                array(
                    'id'=> 'btn-confirm-quotation-'.$model->lb_record_primary_key,
                ) // end html options
            );
        }
    }
 
// Buttom DELETE
if ($model->lb_quotation_status == $model::LB_QUOTATION_STATUS_CODE_DRAFT && $canDelete)
{
    echo '&nbsp;';
    LBApplicationUI::button(Yii::t('lang','Delete'),array(
        'url'=>$this->createUrl('delete',
                        array('id'=>$model->lb_record_primary_key)
            ),
        'htmlOptions'=>array(
                'onclick'=>'return confirm("Are you sure you want to delete this item?");',
                'id'=>'btn-delete-quotation-'.$model->lb_record_primary_key,
            ),
    ));
}


?>
</div>
<?php      
/***************************** HIDDEN STUFF *************************************/

////// GENERIC MODAL HOLDER
////// We can use this to load anything into a modal,
////// through ajax as well
$this->beginWidget('bootstrap.widgets.TbModal',
    array('id'=>'modal-holder-'.$model->lb_record_primary_key));
echo '<div class="modal-header">';
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
echo '</div></div>';
$this->endWidget(); // end modal widget
////// END GENERIC MODAL HOLDER
?>
<?php
## Next,Previous,Last,First ##########
$quotation_next = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,'next');
$quotation_previous = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"previous");
$quotation_last = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"last");
$quotation_first = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"first");

$url_first = ($quotation_first) ? $model->getViewURLByIdNormalized($quotation_first[0],$quotation_first[1]) : '#';
$url_previous = ($quotation_previous) ? $model->getViewURLByIdNormalized($quotation_previous[0],$quotation_previous[1]) : '#';
$url_next = ($quotation_next) ? $model->getViewURLByIdNormalized($quotation_next[0],$quotation_next[1]) : '#';
$url_last = ($quotation_last) ? $model->getViewURLByIdNormalized($quotation_last[0],$quotation_last[1]) : '#';
?>
<div id="lb-container-footer">
    <a href="<?php echo $url_first;  ?>" ><i class="icon-fast-backward"></i></a>&nbsp;
    <a href="<?php echo $url_previous; ?>"><i class="icon-backward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo $url_next ?>"><i class="icon-forward">&nbsp;</i></a>
    <a href="<?php echo $url_last; ?>"><i class="icon-fast-forward"></i></a>
</div>

<script type="text/javascript">
   
    var lbquotation_line_items_updated = false;
    var lbquotation_discounts_updated =false;
    var lbquotation_new_line_item_added = false;
    var lbquotation_new_discount_added = false;
    
    $(document).ready(function(){
        $('.quotation-item-description').autosize({append: "\n"}); 
        bindLineItemsForChanges("<?php echo $grid_id; ?>");
        bindDiscountsForChanges("<?php echo $discount_grid_id; ?>");
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
    function refreshDiscountGrid()
    {
        $.fn.yiiGridView.update("<?php echo $discount_grid_id; ?>",{
            complete: function(jqXHR, status) {
                if (status=='success'){
                    bindDiscountsForChanges("<?php echo $discount_grid_id; ?>");
                }
            }
	});
    }
    function refreshTaxGrid()
    {
        $.fn.yiiGridView.update("<?php echo $taxes_grid_id; ?>");
    }
    function refreshTotal(subtotal,total)
    {
        $('#quotation-subtotal').html(subtotal);
        $('#quotation-total').html(total);
        disableSaveQuotation(<?php echo $model->lb_record_primary_key; ?>);
    }
    
    function onChangeTax(value)
    {
        if(value!=-1)
        {
            $(".submit-btn-taxes-form").click();
            enableSaveQuotation(<?php echo $model->lb_record_primary_key; ?>);
        }
        else
       {
            lbAppUILoadModal(<?php echo $model->lb_record_primary_key; ?>, 'New Tax','<?php
                echo LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateTax",
                    array("ajax"=>1,
                        'form_type'=>'ajax',
                        "id"=>$model->lb_record_primary_key)); ?>');
       }
        
    }
    
    function bindLineItemsForChanges(grid_id)
    {
            $('#' + grid_id +' .lbquotation-line-items').each(function() {
                    var elem = $(this);
                    console.log('binding...'+$(this));

                    // Save current value of element
                    elem.data('oldVal', elem.val());

                    // Look for changes in the value
                    elem.unbind("propertychange keyup input paste", lineItemsChangeHandler);
                    elem.bind("propertychange keyup input paste", lineItemsChangeHandler);
            });
    }
    
    function lineItemsChangeHandler(event) 
    {
       lbquotation_line_items_updated = true;
       
       	var el = event.target;
	var el_field_name = $(el).attr("line_item_field");
	var line_item_pk = $(el).attr("line_item_pk");
        if (el_field_name == "item-value" || el_field_name == "item-quantity")
            {
                    var el_total_fld = $("#lb_quotation_item_total_"+line_item_pk);
                    var el_quantity_fld = $("#lb_quotation_item_quantity_"+line_item_pk);
                    var el_value_fld = $("#lb_quotation_item_price_"+line_item_pk);
                    var total = parseFloat(el_quantity_fld.val()) * parseFloat(el_value_fld.val());
                    var item_total = total.toFixed(2);
                    el_total_fld.val(item_total);
            }
       
        enableSaveQuotation(<?php echo $model->lb_record_primary_key; ?>);
    }
    
    /**
     * bind discounts to events that might have caused by
     * changes done by user
     */
    function bindDiscountsForChanges(grid_id)
    {
        $('#' + grid_id +' .lbquotation-discount').each(function() {
            var elem = $(this);

            console.log('binding discount...'+$(this));

            // Save current value of element
            elem.data('oldVal', elem.val());

            // Look for changes in the value
            elem.unbind("propertychange keyup input paste", discountChangeHandler);
            elem.bind("propertychange keyup input paste", discountChangeHandler);
        });
    }
    
    function discountChangeHandler(event)
    {
        lbquotation_discounts_updated = true;
        enableSaveQuotation(<?php echo $model->lb_record_primary_key; ?>);
    }
    
    function saveQuotation()
    {
        if(lbquotation_line_items_updated)
        {
            $(".submit-btn-line-items-form").click();
            lbquotation_line_items_updated = false;
        }
        else if(lbquotation_discounts_updated)
        {
            $(".submit-btn-discounts-form").click();
            lbquotation_discounts_updated = false;
        }
        else
        {
            $(".submit-btn-taxes-form").click();
        }
        disableSaveQuotation(<?php echo $model->lb_record_primary_key; ?>);
                
    }
    function disableSaveQuotation(quotation_id)
    {
        $('#btn-quotation-save-all-'+quotation_id).html('Alrealy Saved');
        $('#btn-quotation-save-all-'+quotation_id).attr("disabled","disabled");
    }
    function enableSaveQuotation(quotation_id)
    {
        $('#btn-quotation-save-all-'+quotation_id).html('<i class=\"icon-ok icon-white\"></i> Save');
        $('#btn-quotation-save-all-'+quotation_id).removeAttr("disabled"); 
    }
    function onConfirmQuotationSuccessful(quotationJSON){
        $('#quotation-number-container').html(quotationJSON.lb_quotation_no);
        $('#quotation_status_container').html(quotationJSON.lb_quotation_status_display);
        $('#quotation_status .editable').html(quotationJSON.lb_quotation_status);
        $('#quotation_status .editable').attr("data-value",quotationJSON.lb_quotation_status);
        $('#quotation_status .editable').editable("setValue",quotationJSON.lb_quotation_status);
        quotation_status_draft =false;
        $('#btn-confirm-quotation-<?php echo $model->lb_record_primary_key; ?>').remove();
        $("#btn-delete-quotation-<?php echo $model->lb_record_primary_key; ?>").remove();
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
    function saveItemAsTemplate(quotation_item_id)
    {
        var item_description = $("#lb_quotation_item_description_"+quotation_item_id).val();
        var item_unit_price = $("#lb_quotation_item_price_"+quotation_item_id).val();
        $.post("<?php echo $model->getActionURLNormalized('saveItemAsTemplate', array('id'=>$model->lb_record_primary_key))?>",
            {item_description: item_description, item_unit_price: item_unit_price},
            function(response){
                if (response == 'success')
                {
                    var td_container = $("#lb_quotation_item_description_"+quotation_item_id).parent();
                    td_container.append('<div class="alert fade in">Template saved.<a class="close" data-dismiss="alert" href="#">&times;</a></div>').alert();
                } else {

                }
            }
        );
    }

window.setInterval(function(){
	if (lbquotation_line_items_updated) {
		lbquotation_line_items_updated = false;
		$(".submit-btn-line-items-form").click();
                lbquotation_line_items_updated = false;
		console.log('line items form auto-submitted: '+lbquotation_line_items_updated);
	}

    if (lbquotation_discounts_updated) {
        lbquotation_discounts_updated = false;
        $(".submit-btn-discounts-form").click();
        lbquotation_discounts_updated = false;
        console.log('discounts form auto-submitted.');
    }
		
}, 1000*5);
</script>
