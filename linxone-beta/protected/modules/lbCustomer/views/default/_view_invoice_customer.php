<?php

/*
 * @var $model LBcustomer
 */

$this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'lb-invoice-Outstanding-grid',
              //  'type'=>'striped bordered condensed',
                'dataProvider'=>LbInvoice::model()->getInvoiceAllByCustomer($model->lb_record_primary_key,5),
                //'template' => "{items}",
                'template' => "{items}\n{pager}\n{summary}",
                'columns'=>array(
                    array(
                        'header'=>Yii::t('lang','Date'),
                        'type'=>'raw',
                        'value'=>'date("d-M-Y",strtotime($data->lb_invoice_date))',
                        'htmlOptions'=>array('width'=>'70'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Invoice No'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->lb_invoice_no,
                                    $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                   array(
                        'header'=>'Subject',
                        'type'=>'raw',
                        'value'=>'$data->lb_invoice_subject',
                        'htmlOptions'=>array('width'=>'250'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Amount'),
                        'type'=>'raw',
                        'value'=>'($data->total_invoice) ? "$".number_format($data->total_invoice->lb_invoice_total_after_taxes,2) : "$0.00"',
                        'htmlOptions'=>array('style'=>'text-align:right','width'=>'80'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Paid'),
                        'type'=>'raw',
                        'value'=>'($data->total_invoice) ? "$".number_format($data->total_invoice->lb_invoice_total_paid,2) : "$0.00"',
                        'htmlOptions'=>array('style'=>'text-align:right','width'=>'80'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Due'),
                        'type'=>'raw',
                        'value'=>'($data->total_invoice) ? "$".number_format($data->total_invoice->lb_invoice_total_outstanding,2) : "$0.00"',
                        'htmlOptions'=>array('style'=>'text-align:right','width'=>'80'),
                    ),
                    
                ),
                
            ));
        

?>
