<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('index'),
	$model->role_id=>array('view','id'=>$model->role_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Roles', 'url'=>array('index')),
	array('label'=>'Create Roles', 'url'=>array('create')),
	array('label'=>'View Roles', 'url'=>array('view', 'id'=>$model->role_id)),
	array('label'=>'Manage Roles', 'url'=>array('admin')),
);
?>

<h1>Update Roles <?php echo $model->role_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>