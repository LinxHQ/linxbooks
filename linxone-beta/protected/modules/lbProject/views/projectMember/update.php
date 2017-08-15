<?php
/* @var $this ProjectMemberController */
/* @var $model ProjectMember */

$this->breadcrumbs=array(
	'Project Members'=>array('index'),
	$model->project_member_id=>array('view','id'=>$model->project_member_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProjectMember', 'url'=>array('index')),
	array('label'=>'Create ProjectMember', 'url'=>array('create')),
	array('label'=>'View ProjectMember', 'url'=>array('view', 'id'=>$model->project_member_id)),
	array('label'=>'Manage ProjectMember', 'url'=>array('admin')),
);
?>

<h1>Update ProjectMember <?php echo $model->project_member_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>