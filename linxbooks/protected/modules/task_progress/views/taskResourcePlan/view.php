<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */

$this->breadcrumbs=array(
	'Task Resource Plans'=>array('index'),
	$model->trp_id,
);

$this->menu=array(
	array('label'=>'List TaskResourcePlan', 'url'=>array('index')),
	array('label'=>'Create TaskResourcePlan', 'url'=>array('create')),
	array('label'=>'Update TaskResourcePlan', 'url'=>array('update', 'id'=>$model->trp_id)),
	array('label'=>'Delete TaskResourcePlan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->trp_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TaskResourcePlan', 'url'=>array('admin')),
);
?>

<h1>View TaskResourcePlan #<?php echo $model->trp_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'trp_id',
		'task_id',
		'account_id',
		'trp_start',
		'trp_end',
		'trp_work_load',
		'trp_effort',
	),
)); ?>
