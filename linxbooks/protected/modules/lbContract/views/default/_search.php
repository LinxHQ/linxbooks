<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
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
		<?php echo $form->label($model,'lb_customer_id'); ?>
		<?php echo $form->textField($model,'lb_customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_address_id'); ?>
		<?php echo $form->textField($model,'lb_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contact_id'); ?>
		<?php echo $form->textField($model,'lb_contact_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_no'); ?>
		<?php echo $form->textField($model,'lb_contract_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_notes'); ?>
		<?php echo $form->textField($model,'lb_contract_notes',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_date_start'); ?>
		<?php echo $form->textField($model,'lb_contract_date_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_date_end'); ?>
		<?php echo $form->textField($model,'lb_contract_date_end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_type'); ?>
		<?php echo $form->textField($model,'lb_contract_type',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_amount'); ?>
		<?php echo $form->textField($model,'lb_contract_amount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_parent'); ?>
		<?php echo $form->textField($model,'lb_contract_parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lb_contract_status'); ?>
		<?php echo $form->textField($model,'lb_contract_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->