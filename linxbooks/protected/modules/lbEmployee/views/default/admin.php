<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LbEmployee', 'url'=>array('index')),
	array('label'=>'Create LbEmployee', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-employee-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lb Employees</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lb-employee-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lb_record_primary_key',
		'employee_name',
		'employee_address',
		'employee_birthday',
		'employee_phone_1',
		'employee_phone_2',
		/*
		'employee_email_1',
		'employee_email_2',
		'employee_code',
		'employee_tax',
		'employee_bank',
		'employee_note',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
