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
echo '<div id="container-invoice-customer-info" class="lb_customer_info">';

// customer name
echo '<div id="container-invoice-customer-name">';
echo '<div class="field-label-left"><h4>'.Yii::t('lang','To').':</h4></div>';
echo '<div class="field-value-left">';
echo '<h4>';
$this->widget('editable.EditableField', array(
        'type'      => 'select',
        'model'     => $model,
        'attribute' => 'lb_invoice_customer_id',
		'emptytext' => 'Choose customer',
        'url'       => $model->getActionURLNormalized('ajaxUpdateCustomer'), 
        'source'    => $this->createUrl('/lbCustomer/default/dropdownJSON',array('allow_add'=>YES)), 
        //you can also use js function returning string url
        //'source'    => 'js: function() { return "?r=site/getStatusList"; }',
        'placement' => 'right',
        'validate' => 'function(value){
            if (value < 0) return "Please select a valid customer";
        }',
		'success' => 'js: function(response, newValue) {
                    var jsonResponse = jQuery.parseJSON(response);
                    if(jsonResponse.customer >0){
                                    var cutomer_id=jsonResponse.customer;
                                    var customer_name=jsonResponse.customer_name;
                                    $("#user").attr("href", "'.$this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/lbCustomer/"+cutomer_id+"-"+customer_name+"').'");
                                }

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
 



$custoemr_id=0;
$custoemr_name="";
if($model->lb_invoice_customer_id){
        $custoemr_id=$model->lb_invoice_customer_id;
        $custoemr_name = str_replace( ' ', '-',$model->customer->lb_customer_name);

        }
        if($custoemr_id>0){
            echo '&nbsp;&nbsp;<a id="user" href="'.$this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/lbCustomer/'.$model->lb_invoice_customer_id.'-'.$custoemr_name).'"><i class="icon-search"></i></a>';
        }
        else
            echo '&nbsp;&nbsp;<a id="user"><i class="icon-search"></i></a>';
echo '</h4>';
echo '</div>'; // end div for customer name's txt
echo CHtml::hiddenField('hidden-invoice-customer-id', $model->lb_invoice_customer_id, 
		array('id'=>'hidden-invoice-customer-id'));

echo '</div>'; // end customer name

// customer address
echo '<div id="container-invoice-customer-address">';
//echo '<div class="field-label-left">'.Yii::t('lang','Billing Address').':</div>';
echo '<div class="field-value-left">';
$this->widget('editable.EditableField', array(
		'type'      => 'select',
		'model'     => $model,
		'attribute' => 'lb_invoice_customer_address_id',
		'emptytext' => 'Choose billing address',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'source'    => $this->createUrl('/lbCustomerAddress/default/dropdownJSON',
				array('allow_add'=>YES, 'invoice_id'=>$model->lb_record_primary_key)),
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
//echo '<div class="field-label-left">'.Yii::t('lang','Attention').':</div>';
echo '<div class="field-value-left">';
$this->widget('editable.EditableField', array(
    'type'      => 'select',
    'model'     => $model,
    'attribute' => 'lb_invoice_attention_contact_id',
    'emptytext' => 'Choose contact',
    'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
    'source'    => LbCustomerContact::model()->getActionURLNormalized('dropdownJSON',
        array('allow_add'=>YES, 'invoice_id'=>$model->lb_record_primary_key)),
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

// ===== END CUSTOMER SECTION =====
($model->lb_invoice_status_code) ? $lb_invoice_status = $model->lb_invoice_status_code : $lb_invoice_status="";
($model->lb_invoice_customer_id) ? $lb_invoice_customer_id = $model->lb_invoice_customer_id : $lb_invoice_customer_id="";
?>

<br>
<div id="container-invoice-customer-subject" class="lb_subject_invoice">
    <h4><?php echo Yii::t('lang','Subject'); ?>:</h4>
    <?php
        $this->widget('editable.EditableField', array(
            'type'        => 'textarea',
            'inputclass'  => 'input-large-textarea',
            'emptytext'   => 'Enter invoice subject',
            'model'       => $model,
            'attribute'   => 'lb_invoice_subject',
            'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement'   => 'right',
            //'showbuttons' => 'bottom',
            'htmlOptions' => array('class'=>'lb_edit_table'),
            'options'	=> array(
            ),
        ));
    ?>
</div>

<script language="javascript">
    var lb_invoice_customer_id = "<?php echo $lb_invoice_customer_id; ?>";
    var lb_invoice_status = "<?php echo $lb_invoice_status; ?>";
    
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
