<?php 
/* @var $model AccountPasswordReset */

?>

<h3>Reset Password</h3>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-password-reset-form-2',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<p class="note">Please enter your new password below (2 times). 
	Your password should have at least 8 characters, and include digits, letters, and special characters (such as &, *, $, [, ], etc.
	</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->passwordFieldRow($model,'account_new_password', array('style'=>'width: 300px;')); ?>
	<?php echo $form->passwordFieldRow($model,'account_new_password_retype', array('style'=>'width: 300px;')); ?>
	<?php echo $form->hiddenField($model, 'account_email');?>
	<?php echo $form->hiddenField($model, 'account_password_reset_rand_key');?>
</fieldset>

<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->