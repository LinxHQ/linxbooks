<?php
/* @var $this LbCustomerAddressController */
/* @var $model LbCustomerAddress */

$this->breadcrumbs=array(
	'Lb Customer Addresses'=>array('index'),
	$model->lb_customer_address_id,
);

$this->menu=array(
	array('label'=>'List LbCustomerAddress', 'url'=>array('index')),
	array('label'=>'Create LbCustomerAddress', 'url'=>array('create')),
	array('label'=>'Update LbCustomerAddress', 'url'=>array('update', 'id'=>$model->lb_customer_address_id)),
	array('label'=>'Delete LbCustomerAddress', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_customer_address_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbCustomerAddress', 'url'=>array('admin')),
);
?>

<h1>View LbCustomerAddress #<?php echo $model->lb_customer_address_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lb_customer_address_id',
		'lb_customer_id',
		'lb_customer_address_line_1',
		'lb_customer_address_line_2',
		'lb_customer_address_city',
		'lb_customer_address_state',
		'lb_customer_address_country',
		'lb_customer_address_postal_code',
		'lb_customer_address_website_url',
		'lb_customer_address_phone_1',
		'lb_customer_address_phone_2',
		'lb_customer_address_fax',
		'lb_customer_address_email',
		'lb_customer_address_note',
		'lb_customer_address_is_active',
	),
)); ?>
