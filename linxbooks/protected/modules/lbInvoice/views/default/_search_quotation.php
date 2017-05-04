 <?php
 $m = $this->module->id;
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');

$status = '("'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_SENT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED.'")';
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'lb-quotation-Outstanding-grid',
                'type'=>'striped bordered condensed',
                'dataProvider'=> LbQuotation::model()->searchQuotationByName($_REQUEST['name'],10,$canListQuotation),
                //'template' => "{items}",
                'columns'=>array(
                     array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                            'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}'
                        ),
                    array(
                    //    'header'=>Yii::t('lang','Quotation No'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->lb_quotation_no,
                                    $data->customer ? $data->getViewParamModuleURL($data->customer->lb_customer_name,null,$data->lb_record_primary_key,"lbQuotation")
                                    : $data->getViewParamModuleURL("No customer",null,$data->lb_record_primary_key,"lbQuotation"))',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    array(
                    //    'header'=>Yii::t('lang','Customer'),
                        'type'=>'raw',
                        'value'=>'$data->customer ? $data->customer->lb_customer_name."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>" : "Customer No"
                                ."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>"' ,
                        'htmlOptions'=>array('width'=>'380'),
                    ),
                    array(
                     //   'header'=>Yii::t('lang','Due Date'),
                        'type'=>'raw',
                        'value'=>'date("d M Y", strtotime($data->lb_quotation_due_date))',
                        'htmlOptions'=>array('width'=>'100'),
                    ),
                    array(
                     //   'header'=>Yii::t('lang','Amount'),
                        'type'=>'raw',
                         'value'=>'LbQuotation::model()->getStatusAmount($data->lb_quotation_status,$data->quotationTotal ? $data->quotationTotal->lb_quotation_total_after_total : "0.00")',
                      //  'value'=>'$data->quotationTotal ? number_format($data->quotationTotal->lb_quotation_total_after_total,2,LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol,LbGenera::model()->getGeneraSubscription()->lb_thousand_separator) : "{LbInvoice::CURRENCY_SYMBOL}0,00"',
                        'htmlOptions'=>array('width'=>'100','style'=>'text-align:right'),
                    ),
                    array(
                     //   'header'=>Yii::t('lang','Status'),
                        'type'=>'raw',
                        'value'=>'LbQuotation::model()->getDisplayQuotationStatus($data->lb_quotation_status)',
                        'htmlOptions'=>array('width'=>'100','style'=>'text-align:center'),
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
//                    array(
//                     //   'header'=>Yii::t('lang','Created By'),
//                        'type'=>'raw',
//                        'value'=>'AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbQuotation::model()->module_name,$data->lb_record_primary_key)->lb_created_by)',
//                    )
                ),
            ));
 