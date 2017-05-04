<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */

$this->breadcrumbs=array(
	'Task Progresses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TaskProgress', 'url'=>array('index')),
	array('label'=>'Create TaskProgress', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#task-progress-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Task Progresses</h1>

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
	'id'=>'task-progress-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tp_id',
		'task_id',
		'account_id',
		'tp_percent_completed',
		'tp_days_completed',
		'tp_last_update',
		/*
		'tp_last_update_by',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
