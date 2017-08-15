<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joseph
 * Date: 10/29/13
 * Time: 5:00 PM
 * To change this template use File | Settings | File Templates.
 */

/* @var $model LbQuotation */
/* @var $customerModel LbCustomer */
/* @var $customerAddressModel LbCustomerAddress */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-quick-create-customer-address-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    //'htmlOptions'=>array('class'=>'well'),
));

echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
echo $form->hiddenField($customerAddressModel, 'lb_customer_address_is_billing',
    array('value'=>'1'));
echo $form->hiddenField($customerAddressModel, 'lb_customer_address_is_active',
    array('value'=>$customerAddressModel::LB_CUSTOMER_ADDRESS_IS_ACTIVE));

echo $form->textFieldRow($customerAddressModel, 'lb_customer_address_line_1',array('class'=>'span4'));
echo $form->textFieldRow($customerAddressModel, 'lb_customer_address_line_2',array('class'=>'span4'));
echo $form->textFieldRow($customerAddressModel, 'lb_customer_address_city');
echo $form->textFieldRow($customerAddressModel, 'lb_customer_address_state');
echo $form->dropDownListRow($customerAddressModel, 'lb_customer_address_country',
    LBApplicationUI::countriesDropdownData());
echo $form->textFieldRow($customerAddressModel, 'lb_customer_address_postal_code',array('class'=>'span2'));

LBApplicationUI::submitButton('Save', array(
    'url'=> $model->getActionURLNormalized('ajaxQuickCreateAddress',
        array('ajax'=>1,'id'=>$model->lb_record_primary_key)),
    'buttonType'=>'ajaxSubmit',
    'ajaxOptions'=>array(
        'id' => 'ajax-quick-create-address-' . uniqid(),
        'beforeSend' => 'function(data){
				if ($("#LbCustomerAddress_lb_customer_address_line_1").val() == "")
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
                var address_editable = $("#LbInvoice_quotation_address_id_'.$model->lb_record_primary_key.'");
                address_editable.attr("data-value",dataJSON.lb_record_primary_key);
                address_editable.editable("setValue", dataJSON.lb_record_primary_key);
                updateInvoiceAddressLines(dataJSON);
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
