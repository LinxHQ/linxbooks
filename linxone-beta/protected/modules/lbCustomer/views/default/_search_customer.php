<?php

$m = $this->module->id;
$canList = BasicPermission::model()->checkModules($m, 'list',Yii::app()->user->id);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-customer-grid',
	'dataProvider'=> LbCustomer::model()->searchCustomer($_REQUEST['name'],10,$canList),
	'columns'=>array(		
		array(
			'type'=>'raw',
			'value'=>'LBApplication::workspaceLink($data->lb_customer_name, $data->getViewURLNormalized($data->lb_customer_name),array("id"=>$data->lb_record_primary_key))',
                        'htmlOptions'=>array('width'=>'40%'),
                        'headerHtmlOptions'=>array('width'=>'250','id'=>'$data->lb_customer_name'),
                ),
		
                array(
                        'htmlOptions'=>array('width'=>'20%'),
                        'headerHtmlOptions'=>array('width'=>'120'),
                        'value'=>'$data->lb_customer_registration',
                    ),
                
                    array(
                        'value'=>'$data->lb_customer_website_url',
                       'htmlOptions'=>array('width'=>'30%'),
                        'headerHtmlOptions'=>array('width'=>'135'),                     
                    ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
));

