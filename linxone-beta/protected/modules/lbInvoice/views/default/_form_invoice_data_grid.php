<?php

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-invoice-grid',
	'dataProvider'=>$model->search($canList,$status_id),
	'filter'=>$model, 
	'columns'=>array(
		//'lb_record_primary_key',
		//'lb_invoice_group',
		//'lb_generated_from_quotation_id',
		//'lb_invoice_no',
        array(
            'name'=>'lb_invoice_no',
            'type'=>'raw',
            'value'=>'LBApplication::workspaceLink($data->lb_invoice_no,
                $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
            'htmlOptions'=>array('width'=>'100'),
            'headerHtmlOptions'=>array('width'=>'100'),
            'filter' => CHtml::activeTextField($model, 'lb_invoice_no', array('class' => 'input-mini')),
        ),
		array(
                    'name'=>'lb_invoice_customer_id',
                                'type'=>'raw',
                                'value'=>'
                                        ($data->customer ?
                                                LBApplication::workspaceLink( $data->customer->lb_customer_name, $data->getViewURL($data->customer->lb_customer_name) )
                                                :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
                                        )."<br><span style=\'color:#666;\'>". $data->lb_invoice_subject."</span>"
                                        '
		),
                array(
                    'name'=>'lb_invoice_date',
                    'value'=>'$data->lb_invoice_date',
                    'htmlOptions'=>array('width'=>'80'),
                    'filter' => CHtml::activeTextField($model, 'lb_invoice_date', array('class' => 'input-mini')),
                ),
                array(
                    'name'=>'lb_invoice_due_date',
                    'value'=>'$data->lb_invoice_due_date',
                    'htmlOptions'=>array('width'=>'80'),
                    'filter' => CHtml::activeTextField($model, 'lb_invoice_due_date', array('class' => 'input-mini')),
                ),
                array(
                    'name'=>'lb_invoice_status_code',
                    'type'=>'raw',
                    'value'=>'lbInvoice::model()->getDisPlayInvoiceStatus($data->lb_invoice_status_code)',
                    'htmlOptions'=>array('width'=>'50'),
                    'filter' => CHtml::activeTextField($model, 'lb_invoice_status_code', array('class' => 'input-mini')),
                ),
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_after_taxes : "0.00")',
                    'htmlOptions'=>array('width'=>'100','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                ),
                array(
                    'header'=>Yii::t('lang','Outstanding'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_outstanding : "0.00")',
                    'htmlOptions'=>array('width'=>'100','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                ),
               array(
                        'header'=>Yii::t('lang','Created By'),
                        'type'=>'raw',
                        'value'=>'AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name,$data->lb_record_primary_key)->lb_created_by)',
                        'headerHtmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
		/*
		'lb_invoice_company_id',
		'lb_invoice_company_address_id',
		'lb_invoice_customer_id',
		'lb_invoice_customer_address_id',
		'lb_invoice_attention_contact_id',
		'lb_invoice_subject',
		'lb_invoice_note',
		'lb_invoice_status_code',
		*/
//		array(
//			'class'=>'CButtonColumn',
//                            'buttons'=>array(
//                               'delete'=>array(
//                                   'visible'=>'$data->lb_invoice_status_code==LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT',
//                            )),
//		),
	),
)); 
?>