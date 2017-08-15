<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $model ProcessChecklistItemRel */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pcir_id'); ?>
		<?php echo $form->textField($model,'pcir_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pc_id'); ?>
		<?php echo $form->textField($model,'pc_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_name'); ?>
		<?php echo $form->textField($model,'pcir_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_order'); ?>
		<?php echo $form->textField($model,'pcir_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_entity_type'); ?>
		<?php echo $form->textField($model,'pcir_entity_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_entity_id'); ?>
		<?php echo $form->textField($model,'pcir_entity_id',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_status'); ?>
		<?php echo $form->textField($model,'pcir_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pcir_status_update_by'); ?>
		<?php echo $form->textField($model,'pcir_status_update_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->