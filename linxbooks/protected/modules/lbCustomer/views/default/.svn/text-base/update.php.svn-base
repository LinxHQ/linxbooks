<?php
/* @var $this LbCustomerController */
/* @var $model LbCustomer */

$this->breadcrumbs=array(
	'Lb Customers'=>array('index'),
	$model->lb_record_primary_key=>array('view','id'=>$model->lb_record_primary_key),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbCustomer', 'url'=>array('index')),
	array('label'=>'Create LbCustomer', 'url'=>array('create')),
	array('label'=>'View LbCustomer', 'url'=>array('view', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Manage LbCustomer', 'url'=>array('admin')),
);
?>

<h1>Update LbCustomer <?php echo $model->lb_record_primary_key; ?></h1>

<?php $this->renderPartial('_form', 
		array('model'=>$model,
				'addressModel'=>$addressModel,
				'contactModel'=>$contactModel)); ?>
