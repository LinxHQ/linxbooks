<?php
/* @var $this LeavePackageItemController */
/* @var $model LeavePackageItem */

$this->breadcrumbs=array(
	'Leave Package Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LeavePackageItem', 'url'=>array('index')),
	array('label'=>'Manage LeavePackageItem', 'url'=>array('admin')),
);
?>

<h1>Create LeavePackageItem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>