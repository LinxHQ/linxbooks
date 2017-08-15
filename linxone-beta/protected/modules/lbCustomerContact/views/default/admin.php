<?php
/* @var $this LbCustomerContactController */
/* @var $model LbCustomerContact */

$this->breadcrumbs=array(
	'Lb Customer Contacts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LbCustomerContact', 'url'=>array('index')),
	array('label'=>'Create LbCustomerContact', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-customer-contact-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lb Customer Contacts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lb-customer-contact-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'lb_customer_contact_id',
		'lb_customer_id',
		'lb_customer_contact_first_name',
		'lb_customer_contact_last_name',
		'lb_customer_contact_office_phone',
		'lb_customer_contact_office_fax',
		/*
		'lb_customer_contact_mobile',
		'lb_customer_contact_email_1',
		'lb_customer_contact_email_2',
		'lb_customer_contact_note',
		'lb_customer_contact_is_active',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
