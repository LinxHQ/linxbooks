<?php
$m = 'lbQuotation';
echo $canList = BasicPermission::model()->checkModules($m, 'list');

/*
 * @var $model LBcustomer
 */

$this->widget('bootstrap.widgets.TbGridView',  array(
                'id'=>'lb-quotation-grid',
                'dataProvider'=>$model->search($canList),
                'template' => "{items}\n{pager}\n{summary}", 
//                'filter'=>$model,
                'enableSorting' => false,
                'columns'=>array(
                    array(
                        'name'=>'lb_quotation_no',
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->lb_quotation_no,
                            $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
                        'htmlOptions'=>array('width'=>'120'),
                        'headerHtmlOptions'=>array('width'=>'120'),
//                        'filter' => CHtml::activeTextField($model, 'lb_quotation_no', array('class' => 'input-mini')),
                   ),
                    array(
                        'name'=>'lb_quotation_customer_id',
                        'type'=>'raw',
                        'value'=>'($data->customer ?
					LBApplication::workspaceLink( $data->customer->lb_customer_name, $data->getViewURL($data->customer->lb_customer_name) )
					:LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
				)."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>"',
                         'htmlOptions'=>array('width'=>'320'),
                        'headerHtmlOptions'=>array('width'=>'320'),
                       // 'filter'=>  CHtml::listData(LbQuotation::model()->with('customer')->findAll(), 'lb_quotation_customer_id', 'customer.lb_customer_name'),                
                   ),
                    array(
                        'name'=>'lb_quotation_date',
                        'value'=>'$data->lb_quotation_date',
                        'headerHtmlOptions'=>array('width'=>'120'),
                        //'filter' => CHtml::activeTextField($model, 'lb_quotation_date', array('class' => 'input-mini')),
                   ),
                    array(
                        'name'=>'lb_quotation_due_date',
                        'value'=>'$data->lb_quotation_due_date',
                        'headerHtmlOptions'=>array('width'=>'120'),
                       // 'filter' => CHtml::activeTextField($model, 'lb_quotation_due_date', array('class' => 'input-mini')),
                   ),
                    array(
                        'header'=>Yii::t('lang','Amount'),
                        'type'=>'raw',
                        'value'=>'$data->quotationTotal ? LbInvoice::CURRENCY_SYMBOL.$data->quotationTotal->lb_quotation_total_after_total : "{LbInvoice::CURRENCY_SYMBOL}0,00"',
                        'htmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                        'headerHtmlOptions'=>array('width'=>'120','style'=>'text-align:right'),
                    ),
                    array(
                        'name'=>'lb_quotation_status',
                        'type'=>'raw',
                        'value'=>'lbQuotation::model()->getDisplayQuotationStatus($data->lb_quotation_status)',
                      //  'filter' =>false,
                    ),
                ),
    
            ));
?>


