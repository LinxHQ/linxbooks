<?php
/* @var $this TaskProgressController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Task Progresses',
);

$this->menu=array(
	array('label'=>'Create TaskProgress', 'url'=>array('create')),
	array('label'=>'Manage TaskProgress', 'url'=>array('admin')),
);
?>

<h1>Task Progresses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
