<?php
/* @var $this LbInvoiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lb Invoices',
);

$this->menu=array(
	array('label'=>'Create LbInvoice', 'url'=>array('create')),
	array('label'=>'Manage LbInvoice', 'url'=>array('admin')),
);
?>

<h1>Lb Invoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
