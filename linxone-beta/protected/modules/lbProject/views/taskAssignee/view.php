<?php
/* @var $this TaskAssigneeController */
/* @var $model TaskAssignee */

$this->breadcrumbs=array(
	'Task Assignees'=>array('index'),
	$model->task_assignee_id,
);

$this->menu=array(
	array('label'=>'List TaskAssignee', 'url'=>array('index')),
	array('label'=>'Create TaskAssignee', 'url'=>array('create')),
	array('label'=>'Update TaskAssignee', 'url'=>array('update', 'id'=>$model->task_assignee_id)),
	array('label'=>'Delete TaskAssignee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->task_assignee_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TaskAssignee', 'url'=>array('admin')),
);
?>

<h1>View TaskAssignee #<?php echo $model->task_assignee_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'task_assignee_id',
		'task_id',
		'account_id',
		'task_assignee_start_date',
	),
)); ?>
