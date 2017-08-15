<?php
/* @var $this ProcessChecklistDefaultController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Process Checklist Defaults',
);

$this->menu=array(
	array('label'=>'Create ProcessChecklistDefault', 'url'=>array('create')),
	array('label'=>'Manage ProcessChecklistDefault', 'url'=>array('admin')),
);
?>

<h1>Process Checklist Defaults</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
