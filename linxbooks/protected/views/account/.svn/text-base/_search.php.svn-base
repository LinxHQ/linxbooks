<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'account_id'); ?>
		<?php echo $form->textField($model,'account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_email'); ?>
		<?php echo $form->textField($model,'account_email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_master_account_id'); ?>
		<?php echo $form->textField($model,'account_master_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_created_date'); ?>
		<?php echo $form->textField($model,'account_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_timezone'); ?>
		<?php echo $form->textField($model,'account_timezone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_language'); ?>
		<?php echo $form->textField($model,'account_language',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_status'); ?>
		<?php echo $form->textField($model,'account_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->