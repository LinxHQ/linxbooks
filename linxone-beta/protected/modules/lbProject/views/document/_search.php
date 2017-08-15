<?php
/* @var $this DocumentController */
/* @var $model Documents */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'document_id'); ?>
		<?php echo $form->textField($model,'document_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_real_name'); ?>
		<?php echo $form->textField($model,'document_real_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_encoded_name'); ?>
		<?php echo $form->textField($model,'document_encoded_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_description'); ?>
		<?php echo $form->textField($model,'document_description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_date'); ?>
		<?php echo $form->textField($model,'document_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_revision'); ?>
		<?php echo $form->textField($model,'document_revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_root_revision_id'); ?>
		<?php echo $form->textField($model,'document_root_revision_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_owner_id'); ?>
		<?php echo $form->textField($model,'document_owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_parent_id'); ?>
		<?php echo $form->textField($model,'document_parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'document_parent_type'); ?>
		<?php echo $form->textField($model,'document_parent_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->