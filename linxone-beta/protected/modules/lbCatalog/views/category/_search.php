<?php
/* @var $this CategoryController */
/* @var $model LbCatalogCategories */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
        'htmlOptions'=>array(
            'class'=>'form-inline'
        ),
	'method'=>'get',
)); ?>

	<div class="control-group">
		<?php echo $form->label($model,'lb_category_name'); ?>
		<?php echo $form->textField($model,'lb_category_name',array('size'=>60,'maxlength'=>100,'placeholder'=>Yii::t('app', 'Enter category name to search'))); ?>
            <?php echo CHtml::submitButton('Search',array('encodeLabel'=>false,'class'=>'btn btn-default')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->