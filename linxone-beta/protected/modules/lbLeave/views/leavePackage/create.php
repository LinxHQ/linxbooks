<?php
/* @var $this LeavePackageController */
/* @var $model LeavePackage */

$this->breadcrumbs=array(
	'Leave Packages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LeavePackage', 'url'=>array('index')),
	array('label'=>'Manage LeavePackage', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>