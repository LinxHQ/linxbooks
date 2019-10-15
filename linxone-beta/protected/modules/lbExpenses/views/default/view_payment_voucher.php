<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right"><h3>Expenses</h3></div>';
            echo '<div class="lb-header-left lb-header-left-payment-voucher">';
//            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> New', 'items' => array(
                            array('label' => 'New Expense', 'url' =>  LbExpenses::model()->getActionURL('create',array('type'=>'render'))),
                            array('label' => 'New Payment Voucher', 'url' => LbExpenses::model()->getActionURL('CreatePaymentVoucher',array('type'=>'render'))),
                    )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';
//echo '<div class="btn-toolbar">';
//        if($canAdd)
//        {
//           
//            LBApplicationUI::newButton(Yii::t('lang','New Payment Voucher'), array(
//                    'url'=> $this->createUrl('createPaymentVoucher'),
//            ));
//        }
//echo '</div><br/>';
echo '<div text-size="30px" style="font-size:16px;padding-top:24px;"><b>Payment Voucher</b></div>';
echo '<div style="margin-top:18px;">';
        
        //from
        echo Yii::t('lang','From').':</td>';echo '&nbsp;&nbsp;';
        echo '<input type="text" id="pv_date" name="LbExpenses[lb_expenses_date]" value="'.date('d-m-Y').'"><span style="display: none" id="LbExpenses_lb_expenses_date_em_" class="help-inline error"></span>';
       
        echo '&nbsp;&nbsp;&nbsp;';

        //to
        echo Yii::t('lang','To').':</td>';echo '&nbsp;&nbsp;';
        echo '<input type="text" id="pv_date_to" name="LbExpenses[lb_expenses_date]" value="'.date('d-m-Y').'"><span style="display: none" id="LbExpenses_lb_expenses_date_em_" class="help-inline error"></span>';
       
        echo '&nbsp;&nbsp;&nbsp;';
        echo '<button class="btn" name="yt0" type="submit" onclick = "searchPV()" style="margin-top:-10px">Search</button>';
                  
echo '</div><br/>';
echo '<div id ="list_payment_voucher">';
$this->widget('bootstrap.widgets.TbGridView', array(
		'id' => 'payment_invoice_grid',
      //  'type'=>'bordered',
		'dataProvider' => LbPaymentVoucher::model()->search(),
        'template' => "{items}\n{pager}\n{summary}", 
		'columns' => array(
				
                                array(
                                    'class'=>'CButtonColumn',
                                    'template'=>'{delete}',
                                    'deleteButtonUrl'=>'CHtml::normalizeUrl(array("/lbExpenses/default/deletePaymentVoucher", "id"=>$data->lb_record_primary_key))',
                                    'htmlOptions'=>array('width'=>'30','height'=>'40px'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                    'header'=>Yii::t('lang','Date'),
                                    'name'=>'lb_customer_id',
                                    'type'=>'raw',
                                    'id'=>'$data->lb_record_primary_key',
                                    
                                    'value' =>'$data->lb_pv_date',
                                    'htmlOptions'=>array('width'=>'120','height'=>'40px'),
                                      'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
////                    
                                 array(
                                        'header'=>Yii::t('lang','Payment Voucher No'),
                                        'type'=>'raw',
                                        'value'=>'($data->lb_payment_voucher_no) ? LBApplication::workspaceLink($data->lb_payment_voucher_no, YII::app()->baseUrl."/index.php/lbExpenses/default/CreatePaymentVoucher/id/".$data->lb_record_primary_key ) : LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )',
                                        'htmlOptions'=>array('width'=>'180','height'=>'40px'),
                                     'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                    ),
                                    array(
                                    'header'=>Yii::t('lang','Title'),
                                    'type'=>'raw',
                                    'value' =>'$data->lb_pv_title',
                                    
                                    'htmlOptions'=>array('width'=>'150','height'=>'40px'),
                                    'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                                ),
                                array(
                                'header'=>Yii::t('lang','Description'),
                                'type'=>'raw',
                                
                                    'value' =>'$data->lb_pv_description',
                                'htmlOptions'=>array('width'=>'250','height'=>'40px'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),
                            ),
                                array(
                                        'header' =>  Yii::t('lang','Create By'),
                                        'type' => 'raw',
                                        'value' =>'AccountProfile::model()->getFullName($data->lb_pv_create_by)',
                                        'htmlOptions'=>array('style'=>'width: 80px;height:40px;text-align:left;'),
                                'headerHtmlOptions'=>array('class'=>'lb-grid-header'),        
                                ),
                                
                    ),
    ));
echo '</div>';
?>
<script language="javascript">
 $(document).ready(function(){
        var from_date = $("#pv_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
        var from_date = $("#pv_date_to").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
    });
    
    function searchPV()
    {
        var date_from = $('#pv_date').val();
        var date_to =$('#pv_date_to').val();
        $('#list_payment_voucher').load('AjaxLoadViewPV',{date_from:date_from,date_to:date_to});
      
    }
    </script>