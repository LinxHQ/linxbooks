<?php
/* @var $this LeaveAssignmentController */
/* @var $model LeaveAssignment */

$this->breadcrumbs=array(
	'Leave Assignments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LeaveAssignment', 'url'=>array('index')),
	array('label'=>'Manage LeaveAssignment', 'url'=>array('admin')),
);
?>

<h1>Create LeaveAssignment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>