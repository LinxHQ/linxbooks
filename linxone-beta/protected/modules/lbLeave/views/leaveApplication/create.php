<?php
/* @var $this LeaveApplicationController */
/* @var $model LeaveApplication */

$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LeaveApplication', 'url'=>array('index')),
	array('label'=>'Manage LeaveApplication', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>