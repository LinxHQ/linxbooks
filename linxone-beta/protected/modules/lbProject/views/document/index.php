<?php
/* @var $this DocumentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Documents',
);

$this->menu=array(
	array('label'=>'Create Documents', 'url'=>array('create')),
	array('label'=>'Manage Documents', 'url'=>array('admin')),
);
?>

<h1>Documents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
