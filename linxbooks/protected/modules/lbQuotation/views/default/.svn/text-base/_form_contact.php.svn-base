<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joseph
 * Date: 10/29/13
 * Time: 10:25 PM
 * To change this template use File | Settings | File Templates.
 */

/* @var $model LbInvoice */
/* @var $customerModel LbCustomer */
/* @var $customerContactModel LbCustomerContact */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-quick-create-customer-contact-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    //'htmlOptions'=>array('class'=>'well'),
));

echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
echo $form->textFieldRow($customerContactModel,'lb_customer_contact_first_name');
echo $form->textFieldRow($customerContactModel,'lb_customer_contact_last_name');
echo $form->textFieldRow($customerContactModel,'lb_customer_contact_email_1');
echo $form->textFieldRow($customerContactModel,'lb_customer_contact_office_phone');
echo $form->textFieldRow($customerContactModel,'lb_customer_contact_mobile');
echo $form->hiddenField($customerContactModel, 'lb_customer_contact_is_active',
    array('value'=>$customerContactModel::LB_CUSTOMER_CONTACT_IS_ACTIVE));

LBApplicationUI::submitButton('Save', array(
    'url'=> $model->getActionURLNormalized('ajaxQuickCreateContact',
        array('ajax'=>1,'id'=>$model->lb_record_primary_key)),
    'buttonType'=>'ajaxSubmit',
    'ajaxOptions'=>array(
        'id' => 'ajax-quick-create-contact-' . uniqid(),
        'beforeSend' => 'function(data){
				if ($("#LbCustomerContact_lb_customer_contact_first_name").val() == ""
				    || $("#LbCustomerContact_lb_customer_contact_last_name").val() == "")
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
                
                var attention_editable = $("#LbInvoice_quotation_contact_id_'.$model->lb_record_primary_key.'");
                attention_editable.attr("data-value",dataJSON.lb_record_primary_key);
                attention_editable.editable("setValue", dataJSON.lb_record_primary_key);
                attention_editable.attr("class","editable editable-click");
                attention_editable.html(dataJSON.lb_customer_contact_first_name
                                                    + " " + dataJSON.lb_customer_contact_last_name);
                                                    
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

$this->endWidget();