<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => 'payment_voucher_grid',
        'type'=>'bordered',
		'dataProvider' => $model->getSearchBydate($date_from,$date_to),
		'columns' => array(
				
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{delete}',
                                    'deleteButtonUrl'=>'CHtml::normalizeUrl(array("/lbExpenses/default/deletePaymentVoucher", "id"=>$data->lb_record_primary_key))',
                                    'htmlOptions'=>array('width'=>'30'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                    'header'=>Yii::t('lang','Date'),
                                    'name'=>'lb_customer_id',
                                    'type'=>'raw',
                                    'id'=>'$data->lb_record_primary_key',
                                    
                                    'value' =>'$data->lb_pv_date',
                                    'htmlOptions'=>array('width'=>'120'),
                                      'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
////                    
                                 array(
                                        'header'=>Yii::t('lang','Payment Voucher No'),
                                        'type'=>'raw',
                                        'value'=>'($data->lb_payment_voucher_no) ? LBApplication::workspaceLink($data->lb_payment_voucher_no, YII::app()->baseUrl."/index.php/lbExpenses/default/CreatePaymentVoucher/id/".$data->lb_record_primary_key ) : LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
                                        'htmlOptions'=>array('width'=>'180'),
                                     'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                    ),
                                    array(
                                    'header'=>Yii::t('lang','Title'),
                                    'type'=>'raw',
                                    'value' =>'$data->lb_pv_title',
                                    
                                    'htmlOptions'=>array('width'=>'150'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                'header'=>Yii::t('lang','Description'),
                                'type'=>'raw',
                                
                                    'value' =>'$data->lb_pv_description',
                                'htmlOptions'=>array('width'=>'250'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                            ),
                                array(
                                        'header' =>  Yii::t('lang','Create By'),
                                        'type' => 'raw',
                                        'value' =>'AccountProfile::model()->getFullName($data->lb_pv_create_by)',
                                        'htmlOptions'=>array('style'=>'width: 80px;text-align:left;'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),        
                                ),
                                
                    ),
    ));