<?php
/* @var $this SmallgroupsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Small Groups',
);

$this->menu=array(
	array('label'=>'Create LbSmallGroups', 'url'=>array('create')),
	array('label'=>'Manage LbSmallGroups', 'url'=>array('admin')),
);
?>

<h1>Lb Small Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
