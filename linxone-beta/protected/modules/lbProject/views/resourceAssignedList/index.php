<?php
/* @var $this ResourceAssignedListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Resource Assigned Lists',
);

$this->menu=array(
	array('label'=>'Create ResourceAssignedList', 'url'=>array('create')),
	array('label'=>'Manage ResourceAssignedList', 'url'=>array('admin')),
);
?>

<h1>Resource Assigned Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
