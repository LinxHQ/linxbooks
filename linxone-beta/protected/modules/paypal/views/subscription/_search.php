<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'subscription_id'); ?>
		<?php echo $form->textField($model,'subscription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscription_name'); ?>
		<?php echo $form->textField($model,'subscription_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscription_cycle'); ?>
		<?php echo $form->textField($model,'subscription_cycle'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subscription_value'); ?>
		<?php echo $form->textField($model,'subscription_value',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->