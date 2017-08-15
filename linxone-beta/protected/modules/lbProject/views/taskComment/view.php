<?php
/* @var $this TaskCommentController */
/* @var $model TaskComment */

$this->breadcrumbs=array(
	'Task Comments'=>array('index'),
	$model->task_comment_id,
);

$this->menu=array(
	array('label'=>'List TaskComment', 'url'=>array('index')),
	array('label'=>'Create TaskComment', 'url'=>array('create')),
	array('label'=>'Update TaskComment', 'url'=>array('update', 'id'=>$model->task_comment_id)),
	array('label'=>'Delete TaskComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->task_comment_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TaskComment', 'url'=>array('admin')),
);
?>

<h1>View TaskComment #<?php echo $model->task_comment_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'task_comment_id',
		'task_id',
		'task_comment_owner_id',
		'task_comment_last_update',
		'task_comment_created_date',
		'task_comment_content',
		'task_comment_internal',
	),
)); ?>
