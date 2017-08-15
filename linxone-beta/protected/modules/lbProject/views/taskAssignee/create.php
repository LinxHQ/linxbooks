<?php
/* @var $this TaskAssigneeController */
/* @var $model TaskAssignee */

$this->breadcrumbs=array(
	'Task Assignees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TaskAssignee', 'url'=>array('index')),
	array('label'=>'Manage TaskAssignee', 'url'=>array('admin')),
);
?>

<h1>Create TaskAssignee</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>