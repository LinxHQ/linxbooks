<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'lb_record_primary_key'); ?>
		<?php echo $form->textField($model,'lb_record_primary_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_category_id'); ?>
		<?php echo $form->textField($model,'lb_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_expenses_amount'); ?>
		<?php echo $form->textField($model,'lb_expenses_amount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_expenses_date'); ?>
		<?php echo $form->textField($model,'lb_expenses_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_expenses_recurring_id'); ?>
		<?php echo $form->textField($model,'lb_expenses_recurring_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_expenses_brank_account_id'); ?>
		<?php echo $form->textField($model,'lb_expenses_brank_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_expenses_note'); ?>
		<?php echo $form->textField($model,'lb_expenses_note',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
