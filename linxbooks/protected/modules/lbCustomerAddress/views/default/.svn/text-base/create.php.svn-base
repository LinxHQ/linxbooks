<?php
/* @var $this LbCustomerAddressController */
/* @var $model LbCustomerAddress */

$this->breadcrumbs=array(
	'Lb Customer Addresses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LbCustomerAddress', 'url'=>array('index')),
	array('label'=>'Manage LbCustomerAddress', 'url'=>array('admin')),
);
?>
<div style="overflow: hidden;">
    <div style="float: left;width: 300px;">
        <h1>New Address</h1>
    </div>
    <div style="text-align: right;">
        <h3><?php echo LbCustomer::model()->findByPk($customer_id)->lb_customer_name; ?></h3>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
