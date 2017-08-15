<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */

$this->breadcrumbs=array(
	'Leave In Lieus'=>array('index'),
	$model->leave_in_lieu_id=>array('view','id'=>$model->leave_in_lieu_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LeaveInLieu', 'url'=>array('index')),
	array('label'=>'Create LeaveInLieu', 'url'=>array('create')),
	array('label'=>'View LeaveInLieu', 'url'=>array('view', 'id'=>$model->leave_in_lieu_id)),
	array('label'=>'Manage LeaveInLieu', 'url'=>array('admin')),
);
?>

<h1>Update LeaveInLieu <?php echo $model->leave_in_lieu_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>