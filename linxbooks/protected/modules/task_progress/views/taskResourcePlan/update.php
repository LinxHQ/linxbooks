<?php
/* @var $this TaskResourcePlanController */
/* @var $model TaskResourcePlan */

$this->breadcrumbs=array(
	'Task Resource Plans'=>array('index'),
	$model->trp_id=>array('view','id'=>$model->trp_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TaskResourcePlan', 'url'=>array('index')),
	array('label'=>'Create TaskResourcePlan', 'url'=>array('create')),
	array('label'=>'View TaskResourcePlan', 'url'=>array('view', 'id'=>$model->trp_id)),
	array('label'=>'Manage TaskResourcePlan', 'url'=>array('admin')),
);
?>

<h1>Update TaskResourcePlan <?php echo $model->trp_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>