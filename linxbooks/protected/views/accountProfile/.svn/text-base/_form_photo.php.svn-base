<?php
/* @var $model AccountProfile */
?>

<h3>Profile Photo for <?php echo $model->getShortFullName(); ?></h3>
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-profile-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<fieldset>
	Photo must be smaller than 200Kb in size, and of type PNG, JPEG, or JPG.
	<?php echo $form->fileFieldRow($model, 'account_profile_photo'); ?>
</fieldset>
	<?php echo CHtml::submitButton('Save'); ?>

<?php $this->endWidget(); ?>

</div>