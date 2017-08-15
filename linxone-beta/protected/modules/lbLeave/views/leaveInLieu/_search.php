<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'leave_in_lieu_id'); ?>
		<?php echo $form->textField($model,'leave_in_lieu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_in_lieu_name'); ?>
		<?php echo $form->textField($model,'leave_in_lieu_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_in_lieu_day'); ?>
		<?php echo $form->textField($model,'leave_in_lieu_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'leave_in_lieu_totaldays'); ?>
		<?php echo $form->textField($model,'leave_in_lieu_totaldays'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'account_create_id'); ?>
		<?php echo $form->textField($model,'account_create_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->