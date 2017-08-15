<?php
/* @var $this WikiPageRevisionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wiki Page Revisions',
);

$this->menu=array(
	array('label'=>'Create WikiPageRevision', 'url'=>array('create')),
	array('label'=>'Manage WikiPageRevision', 'url'=>array('admin')),
);
?>

<h1>Wiki Page Revisions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
