<?php

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-genera-form',
    
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    
));

//echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
//echo '<div id="tax_error"></div>';
echo $form->textFieldRow($GeneraModel,'lb_genera_currency_symbol');
echo $form->textFieldRow($GeneraModel,'lb_thousand_separator');
echo $form->textFieldRow($GeneraModel,'lb_decimal_symbol');

LBApplicationUI::submitButton('Save', array(
    'url'=> LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateCurrency",
        array('ajax'=>1,'invoice_id'=>$model->lb_record_primary_key)),
    'buttonType'=>'ajaxSubmit',
    'ajaxOptions'=>array(
        'id' => 'ajax-quick-create-currency-' . uniqid(),
        'success' => 'function(data) {
            if (data != null)
            {   
                var dataJSON = jQuery.parseJSON(data);
                
                 var attention_editable = $("#LbInvoice_invoice_genera_id_"+'.$model->lb_record_primary_key.');
                  attention_editable.html(dataJSON.lb_genera_currency_symbol);
                   //alert(dataJSON);
                 lbAppUIHideModal('.$model->lb_record_primary_key.');
                
            }
        }',
    ),
    'htmlOptions'=>array(
        'style'=>'margin-left: auto; margin-right: auto',
        'id'=>'ajax-btn-quick-create-address',
        'live'=>false,
    ),
));
$this->endWidget(); // and form

