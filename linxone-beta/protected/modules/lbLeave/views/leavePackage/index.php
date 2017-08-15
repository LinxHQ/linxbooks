<?php
/* @var $this LeavePackageController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leave Packages',
);

$this->menu=array(
	array('label'=>'Create LeavePackage', 'url'=>array('create')),
	array('label'=>'Manage LeavePackage', 'url'=>array('admin')),
);
?>

<h1>Leave Packages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
