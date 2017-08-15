<?php
/* @var $this LeaveAssignmentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leave Assignments',
);

$this->menu=array(
	array('label'=>'Create LeaveAssignment', 'url'=>array('create')),
	array('label'=>'Manage LeaveAssignment', 'url'=>array('admin')),
);
?>

<h1>Leave Assignments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
