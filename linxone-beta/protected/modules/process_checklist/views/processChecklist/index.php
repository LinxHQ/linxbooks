<?php
/* @var $this ProcessChecklistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Process Checklists',
);

$this->menu=array(
	array('label'=>'Create ProcessChecklist', 'url'=>array('create')),
	array('label'=>'Manage ProcessChecklist', 'url'=>array('admin')),
);
?>

<h1>Process Checklists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
