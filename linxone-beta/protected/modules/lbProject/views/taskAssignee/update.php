<?php
/* @var $this TaskAssigneeController */
/* @var $model TaskAssignee */

$this->breadcrumbs=array(
	'Task Assignees'=>array('index'),
	$model->task_assignee_id=>array('view','id'=>$model->task_assignee_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TaskAssignee', 'url'=>array('index')),
	array('label'=>'Create TaskAssignee', 'url'=>array('create')),
	array('label'=>'View TaskAssignee', 'url'=>array('view', 'id'=>$model->task_assignee_id)),
	array('label'=>'Manage TaskAssignee', 'url'=>array('admin')),
);
?>

<h1>Update TaskAssignee <?php echo $model->task_assignee_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>