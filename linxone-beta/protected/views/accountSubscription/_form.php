<?php
/* @var $this AccountSubscriptionController */
/* @var $model AccountSubscription */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'add-subscription-form',
		'htmlOptions' => array('class'=>'well'),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),

));
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

<fieldset>
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->textFieldRow($model,'subscription_name'); ?>
</fieldset>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->