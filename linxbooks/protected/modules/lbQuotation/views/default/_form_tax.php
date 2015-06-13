<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joseph
 * Company: Lion and Lamb Soft Lte Ptd
 * Date: 10/25/13
 * Time: 2:59 PM
 * To change this template use File | Settings | File Templates.
 */

/* @var $this DefaultController */
/* @var $model LbTax */
/* @var $invoiceModel LbQuotation */
/* @var $form CActiveForm */
/* @var $submission_details array("type"=>"ajax|default", "ajaxCallback"=>"callbackscript...")*/

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'lb-tax-form',
    //'action'=>$model->getActionURLNormalized('createTax'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    //'htmlOptions'=>array('class'=>'well'),
));

echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
echo '<div id="tax_error"></div>';
echo $form->textFieldRow($model,'lb_tax_name');
echo $form->textFieldRow($model, 'lb_tax_value');
echo $form->checkBoxRow($model,'lb_tax_is_default');

if (isset($submission_details) && $submission_details["type"] == 'ajax')
{
    LBApplicationUI::submitButton('Save', array(
        'url'=> LbQuotation::model()->getActionURLNormalized('ajaxQuickCreateTax',
            array('ajax'=>1,'form_type'=>'ajax', 'auto_add'=>'1', "id"=>$quotationModel->lb_record_primary_key)),
        'buttonType'=>'ajaxSubmit',
        'ajaxOptions'=>array(
            'id' => 'ajax-submit-form-new-tax-' . uniqid(),
            'beforeSend' => 'function(data){
				if ($("#LbTax_lb_tax_name").val() == "" ||
				    $("#LbTax_lb_tax_value").val() == "")
				{
				    $("#tax_error").html("<div class=\'alert alert-block alert-error\'>Please fill in the required fields.</div>");
                                    return false;
				}

				return true;
			} ',
            'success' => 'function(data, status, obj) {
                var responseJSON = jQuery.parseJSON(data);
                if(responseJSON.error!=undefined)
                    $("#tax_error").html("<div class=\'alert alert-block alert-error\'>"+responseJSON.error+"</div>");
                else
                {
                    
                    lbAppUIHideModal('.$quotationModel->lb_record_primary_key.');
                    refreshTaxGrid();
                }
            }'
        ),
        'htmlOptions'=>array(
            'style'=>'margin-left: auto; margin-right: auto',
            'id'=>'ajax-btn-new-tax',
            'live'=>false,
        ),
    ));
} else {
    LBApplicationUI::submitButton('Save');
}

$this->endWidget(); // and form
