<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joseph
 * Date: 10/28/13
 * Time: 10:19 PM
 * To change this template use File | Settings | File Templates.
 */

/* @var $model LbInvoice */
/* @var $customerModel LbCustomer */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-quick-create-customer-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    //'htmlOptions'=>array('class'=>'well'),
));

echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
echo $form->errorSummary($customerModel);
echo $form->textFieldRow($customerModel,'lb_customer_name',array('class'=>'span4','maxlength'=>255));
echo $form->error($customerModel,'lb_customer_name');
echo $form->textFieldRow($customerModel,'lb_customer_website_url',array('class'=>'span4',));
echo $form->error($customerModel,'lb_customer_website_url');
echo $form->hiddenField($customerModel, 'lb_customer_is_own_company',
    array('value'=>$customerModel::LB_CUSTOMER_IS_NOT_OWN_COMPANY));

LBApplicationUI::submitButton('Save', array(
    'url'=> $model->getActionURLNormalized('ajaxQuickCreateCustomer',
        array('ajax'=>1,'id'=>$model->lb_record_primary_key)),
    'buttonType'=>'ajaxSubmit',
    'ajaxOptions'=>array(
        'id' => 'ajax-quick-create-customer-' . uniqid(),
        'beforeSend' => 'function(data){
				if ($("#LbCustomer_lb_customer_name").val() == "")
				{
				    alert("Please fill in the required fields.");
                    return false;
				}

				return true;
			} ',
        'success' => 'function(data, status, obj) {
            if (data != null)
            {
                
                var dataJSON = jQuery.parseJSON(data);
                
                var customer_editable = $("#LbInvoice_invoice_customer_id_'.$model->lb_record_primary_key.'");
                var address_editable = $("#LbInvoice_invoice_customer_address_id_'.$model->lb_record_primary_key.'");
                var attention_editable = $("#LbInvoice_invoice_attention_contact_id_'.$model->lb_record_primary_key.'");
                customer_editable.attr("data-value",dataJSON.lb_record_primary_key);
                customer_editable.html(dataJSON.lb_customer_name);
                customer_editable.editable("setValue", dataJSON.lb_record_primary_key);

                address_editable.html("Choose billing address");
                attention_editable.html("Choose attention");
                lbInvoice_choose_customer = true;
                lbAppUIHideModal('.$model->lb_record_primary_key.');
            }
		}'
    ),
    'htmlOptions'=>array(
        'style'=>'margin-left: auto; margin-right: auto',
        'id'=>'ajax-btn-quick-create-customer',
        'live'=>false,
    ),
));

$this->endWidget(); // end form
