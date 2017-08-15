<?php
/* @var $this AccountTeamMemberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Account Team Members',
);

$this->menu=array(
	array('label'=>'Create AccountTeamMember', 'url'=>array('create')),
	array('label'=>'Manage AccountTeamMember', 'url'=>array('admin')),
);
?>

<h1>Account Team Members</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
