<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */

$this->breadcrumbs=array(
	'Task Resource Plans'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TaskResourcePlan', 'url'=>array('index')),
	array('label'=>'Create TaskResourcePlan', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#task-resource-plan-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Task Resource Plans</h1>

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
	'id'=>'task-resource-plan-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'trp_id',
		'task_id',
		'account_id',
		'trp_start',
		'trp_end',
		'trp_work_load',
		/*
		'trp_effort',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
