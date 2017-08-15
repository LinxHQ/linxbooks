<?php
/* @var $this LeavePackageItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leave Package Items',
);

$this->menu=array(
	array('label'=>'Create LeavePackageItem', 'url'=>array('create')),
	array('label'=>'Manage LeavePackageItem', 'url'=>array('admin')),
);
?>

<h1>Leave Package Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
