<?php
/* @var $this DefaultController */
/* @var $model LbTax */
/* @var $form CActiveForm */

echo "<h1>Update Tax</h1>";
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
if($error!="")
{
    echo '<div class="alert alert-block alert-error">';
        echo $error;
    echo '</div>';
}
echo $form->textFieldRow($model,'lb_tax_name');
echo $form->textFieldRow($model, 'lb_tax_value',array('value'=>  number_format($model->lb_tax_value,0)));
echo $form->checkBoxRow($model,'lb_tax_is_default');

    LBApplicationUI::submitButton('Save', array(
        'url'=> $this->createUrl('updateTax',array('id'=>$model->lb_record_primary_key)),
        'ajaxOptions'=>array(
            'id' => 'ajax-submit-form-new-tax-' . uniqid(),
            'beforeSend' => 'function(data){
				if ($("#LbTax_lb_tax_name").val() == "" ||
				    $("#LbTax_lb_tax_value").val() == "")
				{
				    alert("Please fill in the required fields.");
                    return false;
				}

				return true;
			} ',
        ),
        'htmlOptions'=>array(
            'style'=>'margin-left: auto; margin-right: auto',
            'id'=>'ajax-btn-new-tax',
            'live'=>false,
        ),
    ));

$this->endWidget(); // and form
?>
