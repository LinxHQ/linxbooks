<?php
/* @var $this CategoryController */
/* @var $model LbCatalogCategories */
/* @var $form CActiveForm */
$userList = new UserList();
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-catalog-categories-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'lb_category_name'); ?>
		<?php echo $form->textField($model,'lb_category_name',array('size'=>60,'maxlength'=>100,'class'=>'span5')); ?>
		<?php echo $form->error($model,'lb_category_name'); ?>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'lb_category_description'); ?>
		<?php echo $form->textArea($model,'lb_category_description',array('size'=>60,'maxlength'=>255,'class'=>'span5','rows'=>5)); ?>
		<?php echo $form->error($model,'lb_category_description'); ?>
	</div>
        
	<div class="control-group">
		<?php echo $form->labelEx($model,'lb_category_parent'); ?>
		<?php echo LbCatalogCategories::model()->menuSelectPage(0, '', $model->lb_category_parent,'class=span5') ?>
		<?php echo $form->error($model,'lb_category_parent'); ?>
	</div>

	<div class="control-group buttons">
		<?php echo LBApplicationUI::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->