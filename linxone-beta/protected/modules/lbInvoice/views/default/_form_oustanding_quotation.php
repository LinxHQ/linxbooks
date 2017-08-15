<?php $m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canView = BasicPermission::model()->checkModules($m, 'view');
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
} ?>

<div class="panel">

     <div>
    <div id ="show_quotation">
   
        <?php
            if(isset($_REQUEST['status_id'])){
                $status = '("'.$_REQUEST['status_id'].'")';
            }else{
                $status=false;
//                $status = '("'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_SENT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED.'")';
            }
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'lb-quotation-Outstanding-grid',
                //'type'=>'striped bordered condensed',
                'dataProvider'=>$quotationModel->getQuotationByStatus($status,10,$canListQuotation),
                'template' => "{items}\n{pager}\n{summary}", 
                //'template' => "{items}",
                'columns'=>array(
          /*           array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                            'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}'
                        ),*/
                    array(
                    //    'header'=>Yii::t('lang','Quotation No'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->lb_quotation_no,
                                    $data->customer ? $data->getViewParamModuleURL($data->customer->lb_customer_name,null,$data->lb_record_primary_key,"lbQuotation")
                                    : $data->getViewParamModuleURL("No customer",null,$data->lb_record_primary_key,"lbQuotation"))',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                    array(
                     //   'header'=>Yii::t('lang','Customer'),
                        'type'=>'raw',
                        'value'=>'$data->customer ? $data->customer->lb_customer_name."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>" : "Customer No"
                                ."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>"' ,
                        'htmlOptions'=>array('width'=>'380','height'=>'40px'),
                    ),
                    array(
                      //  'header'=>Yii::t('lang','Due Date'),
                        'type'=>'raw',
                        'value'=>'date("d M Y",strtotime($data->lb_quotation_due_date))',
                        'htmlOptions'=>array('width'=>'100','height'=>'40px'),
                    ),
                    array(
                     //   'header'=>Yii::t('lang','Amount'),
                        'type'=>'raw',
                        'value'=>'LbQuotation::model()->getStatusAmount($data->lb_quotation_status,$data->quotationTotal ? $data->quotationTotal->lb_quotation_total_after_total : "0.00")',
                       // 'value'=>'$data->quotationTotal ? number_format($data->quotationTotal->lb_quotation_total_after_total,2,LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol,LbGenera::model()->getGeneraSubscription()->lb_thousand_separator) : "0,00"',
                        'htmlOptions'=>array('width'=>'100','height'=>'40px','style'=>'text-align:right'),
                    ),
                    array(
                      //  'header'=>Yii::t('lang','Status'),
                        'type'=>'raw',
                        'value'=>'LbQuotation::model()->getDisplayQuotationStatus($data->lb_quotation_status)',
                        'htmlOptions'=>array('width'=>'100','style'=>'text-align:center'),
                        'headerHtmlOptions'=>array('style'=>'text-align:center','height'=>'40px'),
                    ),
//                    array(
//                        //'header'=>Yii::t('lang','Created By'),
//                        'type'=>'raw',
//                        'value'=>'AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbQuotation::model()->module_name,$data->lb_record_primary_key)->lb_created_by)',
//                    )
                ),
            ));

        ?>
    </div>
    
    <!--    <div>
        <a class="more" href="<?//php echo LbQuotation::model()->getActionURLNormalized('admin'); ?>"><?//php echo Yii::t('lang','see more quotations'); ?></a>
    </div>-->
</div>
 <script lang="javascript">
    

</script>
