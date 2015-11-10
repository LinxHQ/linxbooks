<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */

$this->breadcrumbs=array(
	'Lb Employees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbEmployee', 'url'=>array('index')),
	array('label'=>'Manage LbEmployee', 'url'=>array('admin')),
);
?>

<h1>Create LbEmployee</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'salaryModel'=>$salaryModel,'benefitModel'=>$benefitModel)); ?>