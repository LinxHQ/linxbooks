<?php
/* @var $this ProcessChecklistController */
/* @var $model ProcessChecklist */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pc_id'); ?>
		<?php echo $form->textField($model,'pc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subcription_id'); ?>
		<?php echo $form->textField($model,'subcription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_name'); ?>
		<?php echo $form->textField($model,'pc_name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_create_date'); ?>
		<?php echo $form->textField($model,'pc_create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_last_update_by'); ?>
		<?php echo $form->textField($model,'pc_last_update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_last_update'); ?>
		<?php echo $form->textField($model,'pc_last_update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->