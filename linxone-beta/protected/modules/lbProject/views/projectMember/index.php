<?php
/* @var $this ProjectMemberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Project Members',
);

$this->menu=array(
	array('label'=>'Create ProjectMember', 'url'=>array('create')),
	array('label'=>'Manage ProjectMember', 'url'=>array('admin')),
);
?>

<h1>Project Members</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
