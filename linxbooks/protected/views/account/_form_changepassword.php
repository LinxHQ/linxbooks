<?php
/* @var $this AccountController */
/* @var $model Account */
?>

<h3><?php 
echo CHtml::link(
	'View Account ' . AccountProfile::model()->getShortFullName($model->account_id),
	array('account/view', 'id' => $model->account_id) // Yii URL
); ?></h3>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-form',
	'enableAjaxValidation'=>false,
)); ?>

<fieldset>
	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->passwordFieldRow($model,'account_current_password',
			array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); ?>
	<?php echo $form->passwordFieldRow($model,'account_new_password',
			array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); ?>
	<?php echo $form->passwordFieldRow($model,'account_new_password_retype',
			array('size'=>60,'maxlength'=>255) + (isset($_GET['ajax']) ? $iframe_input_style : array())); ?>
</fieldset>
		<?php echo CHtml::submitButton('Change Password'); ?>

<?php $this->endWidget(); ?>
</div>