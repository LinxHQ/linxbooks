<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-expenses_new_customer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	//'htmlOptions'=>array('class'=>'well'),
)); ?>

<fieldset>
	<p class="note"><?php echo Yii::t('lang','Fields with * are required'); ?>.</p>

	<?php echo $form->errorSummary($expensesModel); 
	
		echo '<div class="accordion" id="accordion2">';
		/**
		 * ============= BASIC INFORMATION
		 */
		
		// accordion group starts
		echo '<div class="accordion-group">';
		
		// heading
		echo '<div class="accordion-heading">';
		echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form-new-customer-basic-info-collapse">';
        echo YII::t('lang','Basic Information');
	    echo  '</a></div>'; // end heading
		
	    // body
	    echo '<div id="form-new-customer-basic-info-collapse" class="accordion-body collapse in">
      			<div class="accordion-inner">';
		echo $form->textFieldRow($customerModel,'lb_customer_name',array('class'=>'span4','maxlength'=>255));
                echo $form->error($customerModel,'lb_customer_name');
		echo $form->textFieldRow($customerModel,'lb_customer_website_url',array('class'=>'span4',)); 
		echo $form->error($customerModel,'lb_customer_website_url'); 
		echo $form->textFieldRow($customerModel,'lb_customer_registration',array()); 
		echo $form->error($customerModel,'lb_customer_registration');
                if($own)
                    echo $form->checkBoxRow($customerModel,'lb_customer_is_own_company',array("checked"=>"checked"));
                else
                    echo $form->checkBoxRow($customerModel,'lb_customer_is_own_company');
		echo $form->error($customerModel,'lb_customer_is_own_company');
		
		echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END BASIC INFORMATION **/
		
		/**
		 * ============= ADDRESS SECTION
		 */
		// accordion group starts
		echo '<div class="accordion-group">';
		
		// heading
		echo '<div class="accordion-heading">';
		echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form-new-customer-address-collapse">';
		echo Yii::t('lang','Address').' ('.Yii::t('lang','Optional').')';
		echo  '</a></div>'; // end heading
		
		// body
		echo '<div id="form-new-customer-address-collapse" class="accordion-body collapse">
      			<div class="accordion-inner">';
		echo $form->checkBoxRow($addressModel, 'lb_customer_address_is_billing', array('checked'=>'1'));
		echo $form->textFieldRow($addressModel, 'lb_customer_address_line_1',array('class'=>'span4'));
		echo $form->textFieldRow($addressModel, 'lb_customer_address_line_2',array('class'=>'span4'));
		echo $form->textFieldRow($addressModel, 'lb_customer_address_city');
		echo $form->textFieldRow($addressModel, 'lb_customer_address_state');
		echo $form->dropDownListRow($addressModel, 'lb_customer_address_country', LBApplicationUI::countriesDropdownData());
		echo $form->textFieldRow($addressModel, 'lb_customer_address_postal_code',array('class'=>'span2'));
		echo $form->hiddenField($addressModel, 'lb_customer_address_is_active', array('value'=>$addressModel::LB_CUSTOMER_ADDRESS_IS_ACTIVE));
		
		echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END ADDRESS **/
		
		/**
		 * ============= CONTACT SECTION
		 */
		// accordion group starts
		echo '<div class="accordion-group">';
		
		// heading
		echo '<div class="accordion-heading">';
		echo '<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#form-new-customer-contact-collapse">';
		echo Yii::t('lang','Contact Person').' ('.Yii::t('lang','Optional').')';
		echo  '</a></div>'; // end heading
		
		// body
		echo '<div id="form-new-customer-contact-collapse" class="accordion-body collapse">
      			<div class="accordion-inner">';
		echo $form->textFieldRow($contactModel,'lb_customer_contact_first_name');
		echo $form->textFieldRow($contactModel,'lb_customer_contact_last_name');
		echo $form->textFieldRow($contactModel,'lb_customer_contact_email_1');
		echo $form->textFieldRow($contactModel,'lb_customer_contact_office_phone');
		echo $form->textFieldRow($contactModel,'lb_customer_contact_mobile');
		echo $form->hiddenField($contactModel, 'lb_customer_contact_is_active', array('value'=>$contactModel::LB_CUSTOMER_CONTACT_IS_ACTIVE));
		
		echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END CONTACT **/
		?>
</fieldset>

		<?php
             //   $expenses_id = $expensesModel->lb_record_primary_key;
		LBApplicationUI::submitButton('Save',array(
                    'url'=>LbExpenses::model()->getActionURLNormalized('ExpensesNewCustomer',
                                    array('ajax'=>1,'form_type'=>'ajax','expenses_id'=>$expensesModel->lb_record_primary_key)),
                    'buttonType'=>'ajaxSubmit',
                    'ajaxOptions'=>array(
                         'id' => 'ajax-expenses-new-customer-' . uniqid(),
                         'beforeSend' => 'function(data){
				if ($("#LbCustomer_lb_customer_name").val() == "")
				{
				    
                                    $("#customer_error").html("<div class=\'alert alert-block alert-error\'>Please fill in the required fields.</div>");
                                    return false;
				}

				return true;
                            } ',
                        'success'=>'function(data){      
                            refreshCustomerName();
                            $("#modal-customer-form").modal("hide");
                        }'
                    ),
                    'htmlOptions'=>array(
                         'style'=>'margin-left: auto; margin-right: auto',
                        'id'=>'ajax-btn-new-customer',
                        'live'=>false,
                     ),
                ));
        
        
		?>
&nbsp;&nbsp;
                <?php
		LBApplicationUI::submitButton('Close',array(
                    'htmlOptions'=>array('data-dismiss'=>'modal'),
                ));
		?>
<?php $this->endWidget(); ?>
