<?php
/* @var $this PastoralcareController */
/* @var $model LbPastoralCare */
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
		<?php echo $form->label($model,'lb_people_id'); ?>
		<?php echo $form->textField($model,'lb_people_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_pastoral_care_type'); ?>
		<?php echo $form->textField($model,'lb_pastoral_care_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_pastoral_care_pastor_id'); ?>
		<?php echo $form->textField($model,'lb_pastoral_care_pastor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_pastoral_care_date'); ?>
		<?php echo $form->textField($model,'lb_pastoral_care_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_pastoral_care_remark'); ?>
		<?php echo $form->textArea($model,'lb_pastoral_care_remark',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->