<?php
/* @var $this VendorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Vendors',
);

$this->menu=array(
	array('label'=>'Create LbVendor', 'url'=>array('create')),
	array('label'=>'Manage LbVendor', 'url'=>array('admin')),
);
?>

<h1>Lb Vendors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
