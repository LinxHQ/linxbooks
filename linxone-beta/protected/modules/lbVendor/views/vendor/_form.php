<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $form CActiveForm */

/**
 * ===== SUPPLIER SECTION =====
 */

        
 
echo '<div id="container-invoice-supplier-section">';

// logo
echo '<div id="container-supplier-logo" style="max-width: 200px;">';
echo '</div>';

echo '</div>';
// ===== END SUPPLIER SECTION =============================================


/**
 * ===== CUSTOMER SECTION =====
 */
echo '<div id="container-invoice-customer-info" style="padding-top: 20px;clear: both;">';

// customer name
echo '<div id="container-invoice-customer-name">';
echo '<div class="field-label-left">'.Yii::t('lang','To').':</div>';
echo '<div class="field-value-left lb_info_bill">';
$this->widget('editable.EditableField', array(
        'type'      => 'select',
        'model'     => $model,
        'attribute' => 'lb_vendor_supplier_id',
		'emptytext' => 'Choose customer',
        'url'       => $model->getActionURLNormalized('ajaxUpdateCustomer'), 
        'source'    => $this->createUrl('/lbCustomer/default/dropdownJSON',array('allow_add'=>0)), 
        //you can also use js function returning string url
        //'source'    => 'js: function() { return "?r=site/getStatusList"; }',
        'placement' => 'right',
        'validate' => 'function(value){
            if (value < 0) return "Please select a valid customer";
        }',
		'success' => 'js: function(response, newValue) {
			var jsonResponse = jQuery.parseJSON(response);		 
		    updateInvoiceAddressLines(jsonResponse);
		    updateAttentionUI('.$model->lb_record_primary_key.',0,"Choose contact");
                    lbInvoice_choose_customer = true;
		
			// put customer id into hidden field
			$("#hidden-invoice-customer-id").val(newValue);
		}',
		'display' => 'js: function(value, sourceData) {
			var el = $(this);
			$.each(sourceData, function(index) {
				if (sourceData[index].value == value) {
					el.html(sourceData[index].text);
				}
			});
		}',
        'options'	=> array(
            'sourceCache'=> false,
        ),
        'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeCustomerDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
        'htmlOptions'=>array(
            'id'=>'LbInvoice_invoice_customer_id_'.$model->lb_record_primary_key,
        ),
    ));
echo '</div>'; // end div for customer name's txt
echo CHtml::hiddenField('hidden-invoice-customer-id', $model->lb_vendor_supplier_id, 
		array('id'=>'hidden-invoice-customer-id'));
echo '</div>'; // end customer name
// customer address
echo '<div id="container-invoice-customer-address">';
echo '<div class="field-label-left">'.Yii::t('lang','Billing Address').':</div>';
echo '<div class="field-value-left lb_info_bill">';
$this->widget('editable.EditableField', array(
		'type'      => 'select',
		'model'     => $model,
		'attribute' => 'lb_vendor_supplier_address',
		'emptytext' => 'Choose billing address',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'source'    => $this->createUrl('/lbCustomerAddress/default/dropdownJSON',
				array('allow_add'=>2, 'vendor_id'=>$model->lb_record_primary_key)),
		'placement' => 'right',
		/**
		'success' => 'js: function(response, newValue) {
			if(!response.success) return response.msg;
		}',**/
		'display' => 'js: function(value, sourceData) {
			var el = $(this);
			$.get("'.LbCustomerAddress::model()->getActionURLNormalized('addressLinesJSON').'?id="+value,function(response){
				var jsonResponse = jQuery.parseJSON(response);
				updateInvoiceAddressLines(jsonResponse);
			});
		}',
        'validate' => 'function(value){
            if (value < 0) return "Please select a valid address";
        }',
		'options'	=> array(
			'sourceCache'=> false,
		),
        'htmlOptions'=>array(
            'id'=>'LbInvoice_invoice_customer_address_id_'.$model->lb_record_primary_key,
        ),
        'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeAddressDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
    ));
echo '</div>';
echo '</div>'; // end customer address

echo '<div id="container-invoice-customer-attention">';
echo '<div class="field-label-left">'.Yii::t('lang','Attention').':</div>';
echo '<div class="field-value-left lb_info_bill">';
$this->widget('editable.EditableField', array(
    'type'      => 'select',
    'model'     => $model,
    'attribute' => 'lb_vendor_supplier_attention_id',
    'emptytext' => 'Choose contact',
    'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
    'source'    =>LbCustomerContact::model()->getActionURLNormalized('dropdownJSON',
        array('allow_add'=>2, 'vendor_id'=>$model->lb_record_primary_key)),
    'placement' => 'right',
    /**
    'success' => 'js: function(response, newValue) {
    if(!response.success) return response.msg;
    }',**/
    'options'	=> array(
        'sourceCache'=> false,
    ),
    'htmlOptions'=>array(
        'id'=>'LbInvoice_invoice_attention_contact_id_'.$model->lb_record_primary_key,
    ),
    'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeAttentionDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
));
echo '</div>';
echo '</div>'; // end attention

echo '</div>'; 
?>
<br>
<?php 

echo '<div id="container-invoice-customer-attention">';
echo '<div class="field-label-left">'.Yii::t('lang','Category').':</div>';
        $this->widget('editable.EditableField', array(
            'type'      => 'select',
            'model'     => $model,
            'attribute' => 'lb_vendor_category',
            'emptytext' => 'Choose contact',
            'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
            'source'    =>  LbVendor::model()->getActionURLNormalized('dropdownJSONCategory',
                array('allow_add'=>0, 'vendor_id'=>$model->lb_record_primary_key)),
            'placement' => 'right',
            /**
            'success' => 'js: function(response, newValue) {
            if(!response.success) return response.msg;
            }',**/
            'options'	=> array(
                'sourceCache'=> false,
            ),
            'htmlOptions'=>array(
                'id'=>'LbInvoice_invoice_attention_contact_id_'.$model->lb_record_primary_key,
                'class'=>'editable editable-click editable-empty lb_info_bill'
            ),
            'onShown' => 'js: function() {
                    var $tip = $(this).data("editableContainer").tip();
                    var dropdown = $tip.find("select");
                    $(dropdown).bind("change", function(e){
                        onChangeAttentionDropdown(e,'.$model->lb_record_primary_key.');
                    });
                }',
        ));
        
echo '</div>'; // end attention



echo '<br />';
//echo Yii::t('lang','Category');echo '&nbsp;&nbsp;&nbsp;';
//        $category_arr = SystemList::model()->getItemsForListCode('expenses_category');
//             echo CHtml::dropDownList('lb_category_id', '', array(''=>'All')+CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'), array('style'=>'width:150px;'));echo '&nbsp;&nbsp;&nbsp;';
?>

<?php  $category_arr = SystemList::model()->getItemsForListCode('expenses_category');
//            echo dropDownListRow($model, 'lb_category_id', CHtml::listData($category_arr, 'system_list_item_id', 'system_list_item_name'));?>
<div id="container-invoice-customer-subject">
    <h4><?php echo Yii::t('lang','Subject'); ?>:</h4>
    <?php
        $this->widget('editable.EditableField', array(
            'type'        => 'textarea',
            'inputclass'  => 'input-large-textarea',
            'emptytext'   => 'Enter invoice subject',
            'model'       => $model,
            'attribute'   => 'lb_vendor_subject',
            'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement'   => 'right',
            //'showbuttons' => 'bottom',
            'htmlOptions' => array('class'=>'lb_edit_table'),
            'options'	=> array(
            ),
        ));
        $lb_invoice_customer_id = $model->lb_record_primary_key;
        $manage = LbVendor::model()->findByPk($lb_invoice_customer_id);
    ?>
</div>
<script language="javascript">
    var lb_invoice_customer_id = "<?php echo $lb_invoice_customer_id; ?>";
    var lb_invoice_status = "<?php echo $manage->lb_vendor_status; ?>";
//    
    var lbInvoice_choose_customer = false;
    var lbInvoice_status_draft = false;
    if(lb_invoice_customer_id!="")
    {
        lbInvoice_choose_customer = true;
    }
    if(lb_invoice_status=="<?php echo LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT ?>")
    {
        lbInvoice_status_draft = true
    }
    function onChangeCustomerDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == 0)
        {
            lbAppUILoadModal(invoice_id, 'New Customer','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateCustomer",
                    array("ajax"=>1, "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

    function onChangeAddressDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(invoice_id, 'New Address','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateAddress",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

    function onChangeAttentionDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(invoice_id, 'New Contact','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateContact",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }
</script>
