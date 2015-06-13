<?php
/* @var $this LbCustomerContactController */
/* @var $model LbCustomerContact */

$this->breadcrumbs=array(
	'Lb Customer Contacts'=>array('index'),
	$model->lb_customer_contact_id,
);

$this->menu=array(
	array('label'=>'List LbCustomerContact', 'url'=>array('index')),
	array('label'=>'Create LbCustomerContact', 'url'=>array('create')),
	array('label'=>'Update LbCustomerContact', 'url'=>array('update', 'id'=>$model->lb_customer_contact_id)),
	array('label'=>'Delete LbCustomerContact', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_customer_contact_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbCustomerContact', 'url'=>array('admin')),
);
?>

<h1>View LbCustomerContact #<?php echo $model->lb_customer_contact_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lb_customer_contact_id',
		'lb_customer_id',
		'lb_customer_contact_first_name',
		'lb_customer_contact_last_name',
		'lb_customer_contact_office_phone',
		'lb_customer_contact_office_fax',
		'lb_customer_contact_mobile',
		'lb_customer_contact_email_1',
		'lb_customer_contact_email_2',
		'lb_customer_contact_note',
		'lb_customer_contact_is_active',
	),
)); ?>
