<?php
/* @var $this ProjectMemberController */
/* @var $model ProjectMember */

$this->breadcrumbs=array(
	'Project Members'=>array('index'),
	$model->project_member_id,
);

$this->menu=array(
	array('label'=>'List ProjectMember', 'url'=>array('index')),
	array('label'=>'Create ProjectMember', 'url'=>array('create')),
	array('label'=>'Update ProjectMember', 'url'=>array('update', 'id'=>$model->project_member_id)),
	array('label'=>'Delete ProjectMember', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->project_member_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProjectMember', 'url'=>array('admin')),
);
?>

<h1>View ProjectMember #<?php echo $model->project_member_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'project_member_id',
		'project_id',
		'account_id',
	),
)); ?>
