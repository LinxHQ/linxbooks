<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'project_id'); ?>
		<?php echo $form->textField($model,'project_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_name'); ?>
		<?php echo $form->textField($model,'project_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_owner_id'); ?>
		<?php echo $form->textField($model,'project_owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_start_date'); ?>
		<?php echo $form->textField($model,'project_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'project_description'); ?>
		<?php echo $form->textField($model,'project_description',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->