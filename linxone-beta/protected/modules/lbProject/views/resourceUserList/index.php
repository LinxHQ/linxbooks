<?php
/* @var $this ResourceUserListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Resource User Lists',
);

$this->menu=array(
	array('label'=>'Create ResourceUserList', 'url'=>array('create')),
	array('label'=>'Manage ResourceUserList', 'url'=>array('admin')),
);
?>

<h1>Resource User Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
