<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */

$this->breadcrumbs=array(
	'Task Resource Plans'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TaskResourcePlan', 'url'=>array('index')),
	array('label'=>'Manage TaskResourcePlan', 'url'=>array('admin')),
);
?>

<h1>Create TaskResourcePlan</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>