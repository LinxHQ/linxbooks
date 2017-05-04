<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */

$this->breadcrumbs=array(
	'Task Progresses'=>array('index'),
	$model->tp_id=>array('view','id'=>$model->tp_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TaskProgress', 'url'=>array('index')),
	array('label'=>'Create TaskProgress', 'url'=>array('create')),
	array('label'=>'View TaskProgress', 'url'=>array('view', 'id'=>$model->tp_id)),
	array('label'=>'Manage TaskProgress', 'url'=>array('admin')),
);
?>

<h1>Update TaskProgress <?php echo $model->tp_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>