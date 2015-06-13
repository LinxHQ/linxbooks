<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$this->breadcrumbs=array(
	'Lb Contracts'=>array('index'),
	'Manage',
);

//$this->menu=array(
//	array('label'=>'List LbContracts', 'url'=>array('index')),
//	array('label'=>'Create LbContracts', 'url'=>array('create')),
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-contracts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>Contracts</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> New Contract', 'url'=>$this->createUrl('create') ),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';
echo '<br>';
?>
<div style="width: 100%;text-align: center;">
<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
    'buttons' => array(
        array('label'=>'Active','url'=>$this->createUrl('admin')),
        array('label'=>'No Active','url'=>$this->createUrl('admin',array('status'=>LbContracts::LB_CONTRACT_STATUS_NO_ACTIVE))),
        array('label'=>'Has Renew','url'=>$this->createUrl('admin',array('status'=>LbContracts::LB_CONTRACT_STATUS_HAS_RENEWED))),
        array('label'=>'End Contract','url'=>$this->createUrl('admin',array('status'=>LbContracts::LB_CONTRACT_STATUS_END)))
    ),
)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-contracts-grid',
	'dataProvider'=>$model->getContract($status,20,$canList),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header'=>'Contract No',
                    'name'=>'lb_contract_no',
                    'type'=>'raw',
                    'value'=>'($data->lb_contract_no ?
					LBApplication::workspaceLink($data->lb_contract_no, $data->getViewURL($data->customer->lb_customer_name) )
					:LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
				)
                        ',
                    'htmlOptions'=>array('width'=>'120'),
                    'filter' => CHtml::activeTextField($model, 'lb_contract_no', array('class' => 'input-small')),
                ),
                array(
                    'header'=>'Customer Name',
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->customer->lb_customer_name',
                    'htmlOptions'=>array('width'=>'250'),
                ),
                array(
                    'header'=>'Contract Name',
                    'name'=>'lb_contract_type',
                    'type'=>'raw',
                    'value'=>'$data->lb_contract_type',
                    'htmlOptions'=>array('width'=>'200'),
                    'filter' => CHtml::activeTextField($model, 'lb_contract_type', array('class' => 'input-medium')),
                ),
                array(
                    'header'=>'Date Start',
                    'name'=>'lb_contract_date_start',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y", strtotime($data->lb_contract_date_start))',
                    'filter' => CHtml::activeTextField($model, 'lb_contract_date_start', array('class' => 'input-small')),
                ),
                array(
                    'header'=>'Date End',
                    'name'=>'lb_contract_date_end',
                    'type'=>'raw',
                    'value'=>'date("d-M-Y", strtotime($data->lb_contract_date_end))',
                    'filter' => CHtml::activeTextField($model, 'lb_contract_date_end', array('class' => 'input-small')),
                ),
		/*
                'lb_address_id',
                'lb_record_primary_key',
                'lb_customer_id',
                'lb_contact_id',
		'lb_contract_date_start',
		'lb_contract_date_end',
		'lb_contract_type',
		'lb_contract_amount',
		'lb_contract_parent',
		'lb_contract_status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
