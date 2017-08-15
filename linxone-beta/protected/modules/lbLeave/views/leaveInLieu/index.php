<?php
/* @var $this LeaveInLieuController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Leave In Lieus',
);

$this->menu=array(
	array('label'=>'Create LeaveInLieu', 'url'=>array('create')),
	array('label'=>'Manage LeaveInLieu', 'url'=>array('admin')),
);
?>

<h1>Leave In Lieus</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
