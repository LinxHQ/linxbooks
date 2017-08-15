<?php
/* @var $this TaskCommentController */
/* @var $model TaskComment */

$this->breadcrumbs=array(
	'Task Comments'=>array('index'),
	$model->task_comment_id=>array('view','id'=>$model->task_comment_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TaskComment', 'url'=>array('index')),
	array('label'=>'Create TaskComment', 'url'=>array('create')),
	array('label'=>'View TaskComment', 'url'=>array('view', 'id'=>$model->task_comment_id)),
	array('label'=>'Manage TaskComment', 'url'=>array('admin')),
);
?>

<h1>Update TaskComment <?php echo $model->task_comment_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>