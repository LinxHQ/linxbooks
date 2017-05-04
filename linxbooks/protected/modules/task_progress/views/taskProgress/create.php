<?php
/* @var $this TaskProgressController */
/* @var $model TaskProgress */

$this->breadcrumbs=array(
	'Task Progresses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TaskProgress', 'url'=>array('index')),
	array('label'=>'Manage TaskProgress', 'url'=>array('admin')),
);
?>

<h1>Create TaskProgress</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>