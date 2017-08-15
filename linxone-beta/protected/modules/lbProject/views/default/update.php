<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->project_id=>array('view','id'=>$model->project_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Project', 'url'=>array('index')),
	array('label'=>'Create Project', 'url'=>array('create')),
	array('label'=>'View Project', 'url'=>array('view', 'id'=>$model->project_id)),
	array('label'=>'Manage Project', 'url'=>array('admin')),
);
?>

<h1>Update Project <?php echo $model->project_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>