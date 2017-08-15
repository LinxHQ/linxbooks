<?php
/* @var $this SystemListItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'System List Items',
);

$this->menu=array(
	array('label'=>'Create SystemListItem', 'url'=>array('create')),
	array('label'=>'Manage SystemListItem', 'url'=>array('admin')),
);
?>

<h1>System List Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
