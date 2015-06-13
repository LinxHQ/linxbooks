<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */

$this->breadcrumbs=array(
	'Lb Contracts'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbContracts', 'url'=>array('index')),
	array('label'=>'Create LbContracts', 'url'=>array('create')),
	array('label'=>'View LbContracts', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbContracts', 'url'=>array('admin')),
);
?>

<h1>Update LbContracts <?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>