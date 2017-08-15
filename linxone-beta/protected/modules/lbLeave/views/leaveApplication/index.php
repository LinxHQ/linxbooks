<?php
/* @var $this LeaveApplicationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leave Applications',
);

$this->menu=array(
	array('label'=>'Create LeaveApplication', 'url'=>array('create')),
	array('label'=>'Manage LeaveApplication', 'url'=>array('admin')),
);
?>

<h1>Leave Applications</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
