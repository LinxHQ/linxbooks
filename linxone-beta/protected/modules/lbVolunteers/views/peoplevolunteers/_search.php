<?php
/* @var $this PeoplevolunteersController */
/* @var $model LbPeopleVolunteers */
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
		<?php echo $form->label($model,'lb_volunteers_type'); ?>
		<?php echo $form->textField($model,'lb_volunteers_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_volunteers_position'); ?>
		<?php echo $form->textField($model,'lb_volunteers_position',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_volunteers_active'); ?>
		<?php echo $form->textField($model,'lb_volunteers_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_volunteers_start_date'); ?>
		<?php echo $form->textField($model,'lb_volunteers_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_volunteers_end_date'); ?>
		<?php echo $form->textField($model,'lb_volunteers_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_entity_id'); ?>
		<?php echo $form->textField($model,'lb_entity_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_entity_type'); ?>
		<?php echo $form->textField($model,'lb_entity_type',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->