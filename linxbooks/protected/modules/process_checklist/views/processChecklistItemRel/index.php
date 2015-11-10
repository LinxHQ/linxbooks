<?php
/* @var $this ProcessChecklistItemRelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Process Checklist Item Rels',
);

$this->menu=array(
	array('label'=>'Create ProcessChecklistItemRel', 'url'=>array('create')),
	array('label'=>'Manage ProcessChecklistItemRel', 'url'=>array('admin')),
);
?>

<h1>Process Checklist Item Rels</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
