<?php
/* @var $this TaskController */
/* @var $model Task */

$this->breadcrumbs=array(
	'Tasks'=>array('index'),
	$model->task_id=>array('view','id'=>$model->task_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Task', 'url'=>array('index')),
	array('label'=>'Create Task', 'url'=>array('create')),
	array('label'=>'View Task', 'url'=>array('view', 'id'=>$model->task_id)),
	array('label'=>'Manage Task', 'url'=>array('admin')),
);
?>

<h1>Update Task <?php echo $model->task_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>