<?php
/* @var $this LbCustomerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Customers',
);

$this->menu=array(
	array('label'=>'Create LbCustomer', 'url'=>array('create')),
	array('label'=>'Manage LbCustomer', 'url'=>array('admin')),
);
?>

<h1>Lb Customers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
