<?php
/* @var $this TaskCommentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Task Comments',
);

$this->menu=array(
	array('label'=>'Create TaskComment', 'url'=>array('create')),
	array('label'=>'Manage TaskComment', 'url'=>array('admin')),
);
?>

<h1>Task Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
