<?php
/* @var $this TaskAssigneeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Task Assignees',
);

$this->menu=array(
	array('label'=>'Create TaskAssignee', 'url'=>array('create')),
	array('label'=>'Manage TaskAssignee', 'url'=>array('admin')),
);
?>

<h1>Task Assignees</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
