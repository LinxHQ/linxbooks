<?php
/* @var $this TaskResourcePlanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Task Resource Plans',
);

$this->menu=array(
	array('label'=>'Create TaskResourcePlan', 'url'=>array('create')),
	array('label'=>'Manage TaskResourcePlan', 'url'=>array('admin')),
);
?>

<h1>Task Resource Plans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
