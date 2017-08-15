<?php
/* @var $this TaskController */
/* @var $model Task */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'task_id'); ?>
		<?php echo $form->textField($model,'task_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_id'); ?>
		<?php echo $form->textField($model,'project_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_name'); ?>
		<?php echo $form->textField($model,'task_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_start_date'); ?>
		<?php echo $form->textField($model,'task_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_end_date'); ?>
		<?php echo $form->textField($model,'task_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_owner_id'); ?>
		<?php echo $form->textField($model,'task_owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_created_date'); ?>
		<?php echo $form->textField($model,'task_created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_public_viewable'); ?>
		<?php echo $form->textField($model,'task_public_viewable'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'task_status'); ?>
		<?php echo $form->textField($model,'task_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->