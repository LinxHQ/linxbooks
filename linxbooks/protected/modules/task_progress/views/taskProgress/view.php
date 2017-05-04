<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */

$this->breadcrumbs=array(
	'Task Progresses'=>array('index'),
	$model->tp_id,
);

$this->menu=array(
	array('label'=>'List TaskProgress', 'url'=>array('index')),
	array('label'=>'Create TaskProgress', 'url'=>array('create')),
	array('label'=>'Update TaskProgress', 'url'=>array('update', 'id'=>$model->tp_id)),
	array('label'=>'Delete TaskProgress', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->tp_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TaskProgress', 'url'=>array('admin')),
);
?>

<h1>View TaskProgress #<?php echo $model->tp_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'tp_id',
		'task_id',
		'account_id',
		'tp_percent_completed',
		'tp_days_completed',
		'tp_last_update',
		'tp_last_update_by',
	),
)); ?>
