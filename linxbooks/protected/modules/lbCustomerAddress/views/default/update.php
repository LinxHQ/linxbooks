<?php
/* @var $this LbCustomerAddressController */
/* @var $model LbCustomerAddress */

$this->breadcrumbs=array(
	'Lb Customer Addresses'=>array('index'),
	$model->lb_customer_address_id=>array('view','id'=>$model->lb_customer_address_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LbCustomerAddress', 'url'=>array('index')),
	array('label'=>'Create LbCustomerAddress', 'url'=>array('create')),
	array('label'=>'View LbCustomerAddress', 'url'=>array('view', 'id'=>$model->lb_customer_address_id)),
	array('label'=>'Manage LbCustomerAddress', 'url'=>array('admin')),
);
?>

<h1>Update LbCustomerAddress <?php echo $model->lb_customer_address_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>