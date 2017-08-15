<?php
/* @var $this LeaveInLieuController */
/* @var $model LeaveInLieu */

$this->breadcrumbs=array(
	'Leave In Lieus'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LeaveInLieu', 'url'=>array('index')),
	array('label'=>'Manage LeaveInLieu', 'url'=>array('admin')),
);
?>

<!-- <h1>Create LeaveInLieu</h1> -->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

