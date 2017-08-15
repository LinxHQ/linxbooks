<?php
/* @var $this VendorController */
/* @var $model LbVendor */

$this->breadcrumbs=array(
	'Lb Vendors'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbVendor', 'url'=>array('index')),
	array('label'=>'Create LbVendor', 'url'=>array('create')),
	array('label'=>'View LbVendor', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbVendor', 'url'=>array('admin')),
);
?>

<h1>Update LbVendor <?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>