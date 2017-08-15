<?php
/* @var $this DefaultControllersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Employees',
);

$this->menu=array(
	array('label'=>'Create LbEmployee', 'url'=>array('create')),
	array('label'=>'Manage LbEmployee', 'url'=>array('admin')),
);
?>

<h1>Lb Employees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
