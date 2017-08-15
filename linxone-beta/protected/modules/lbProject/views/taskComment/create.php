<?php
/* @var $this TaskCommentController */
/* @var $model TaskComment */

$this->breadcrumbs=array(
	'Task Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TaskComment', 'url'=>array('index')),
	array('label'=>'Manage TaskComment', 'url'=>array('admin')),
);
?>

<h1>Create TaskComment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'comment' => $model)); ?>