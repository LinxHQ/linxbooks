<?php
$m = $this->module->id;
$canList = BasicPermission::model()->checkModules($m, 'list',Yii::app()->user->id);
 
   
                $this->widget('bootstrap.widgets.TbGridView',array(
                    'id'=>'lb-invoice-Outstanding-grid',
                    'type'=>'striped',
                    'dataProvider'=>LbInvoice::model()->searchInvoiceByName($_REQUEST['name'],10,$canList),
                    //'template' => "{items}",
                    'columns'=>array(
                        array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                             'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}',
                            'htmlOptions'=>array('width'=>'20'),
                        ),
                        array(
                            'header'=>Yii::t('lang','Invoice No'),
                            'type'=>'raw',
                            'value'=>'LBApplication::workspaceLink($data->lb_invoice_no,
                                        $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer")) . "<br/>".
                                        LBApplicationUI::getStatusBadge($data->lb_invoice_status_code)',
                            'htmlOptions'=>array('width'=>'130'),
                        ),
                        array(
                            'header'=>Yii::t('lang','Customer'),
                            'type'=>'raw',
                            'value'=>'$data->customer ? $data->customer->lb_customer_name."<br><span style=\'color:#666;\'>". $data->lb_invoice_subject."</span>" : "No customer"
                                    ."<br><span style=\'color:#666;\'>". $data->lb_invoice_subject."</span>"',
                            'htmlOptions'=>array('width'=>''),
                        ),
                        array(
                            'header'=>Yii::t('lang','Due Date'),
                            'type'=>'raw',
                            'value'=>'$data->lb_invoice_due_date',
                            'htmlOptions'=>array('width'=>'100'),
                        ),
                        array(
                            'header'=>Yii::t('lang','Amount'),
                            'type'=>'raw',
                            'value'=>'($data->total_invoice ? number_format($data->total_invoice->lb_invoice_total_outstanding,2,LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol,LbGenera::model()->getGeneraSubscription()->lb_thousand_separator) : "0.00")',
                            'htmlOptions'=>array('width'=>'120','style'=>'text-align:right'),
                        ),
                        /**
                        array(
                            'header'=>Yii::t('lang','Status'),
                            'type'=>'raw',
                            'value'=>'LbInvoice::model()->getDisplayInvoiceStatus($data->lb_invoice_status_code)',
                            'htmlOptions'=>array('width'=>'100','style'=>'text-align:center'),
                            'headerHtmlOptions'=>array('style'=>'text-align:center')
                        ),
                        array(
                            'header'=>Yii::t('lang','Created By'),
                            'type'=>'raw',
                            'value'=>'AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name,$data->lb_record_primary_key)->lb_created_by)',
                        ),**/
                        

                    ),

                ))
            
  ?>