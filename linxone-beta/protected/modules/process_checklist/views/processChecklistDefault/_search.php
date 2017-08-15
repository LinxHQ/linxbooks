<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $model ProcessChecklistDefault */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pcdi_id'); ?>
		<?php echo $form->textField($model,'pcdi_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_id'); ?>
		<?php echo $form->textField($model,'pc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcdi_name'); ?>
		<?php echo $form->textField($model,'pcdi_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcdi_order'); ?>
		<?php echo $form->textField($model,'pcdi_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->