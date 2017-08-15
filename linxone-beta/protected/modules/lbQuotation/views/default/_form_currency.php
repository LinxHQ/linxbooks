<?php

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-genera-form',
    
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    
));

echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
echo '<div id="tax_error"></div>';
echo $form->textFieldRow($GeneraModel,'lb_genera_currency_symbol');
echo $form->textFieldRow($GeneraModel,'lb_thousand_separator');
echo $form->textFieldRow($GeneraModel,'lb_decimal_symbol');

LBApplicationUI::submitButton('Save', array(
    'url'=> LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateCurrency",
        array('ajax'=>1,'quotation_id'=>$model->lb_record_primary_key)),
    'buttonType'=>'ajaxSubmit',
    'ajaxOptions'=>array(
        'id' => 'ajax-quick-create-currency-' . uniqid(),
//        'beforeSend' => 'function(data){
//				if ($("#LbCustomerAddress_lb_customer_address_line_1").val() == "")
//				{
//				    alert("Please fill in the required fields.");
//                    return false;
//				}
//
//				return true;
//			} ',
        'success' => 'function(data, status, obj) {
            if (data != null)
            {
                var dataJSON = jQuery.parseJSON(data);
                 var attention_editable = $("#LbQuotation_quotation_genera_id_"+'.$model->lb_record_primary_key.');
                     attention_editable.html(dataJSON.lb_genera_currency_symbol);
                 lbAppUIHideModal('.$model->lb_record_primary_key.');
                
            }
		}'
    ),
    'htmlOptions'=>array(
        'style'=>'margin-left: auto; margin-right: auto',
        'id'=>'ajax-btn-quick-create-address',
        'live'=>false,
    ),
));
$this->endWidget(); // and form


