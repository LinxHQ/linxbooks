<?php
/* @var $this AccountPasswordResetController */
/* @var $model AccountPasswordReset */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-password-reset-form',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<p class="note">Please enter the email associated with your account.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'account_email', array('style'=>'width: 300px;')); ?>
</fieldset>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->