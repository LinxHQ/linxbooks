<?php 
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
//echo $m;
echo $canList;
$canView = BasicPermission::model()->checkModules($m, 'view');
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');

$currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
$lb_thousand_separator = LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$lb_decimal_symbol = LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;


if(!$canView)
{
    echo "Have no permission to see this record";
    return;
} 

?>
<div class="panel">

    <div>
    <div id ="show_invoice">
    <?php 
        if(isset($_REQUEST['status_id'])){
            $status = '("'.$_REQUEST['status_id'].'")';
        }else{
            $status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")'; 
        }
       
    ?>
    <?php
   
                $this->widget('bootstrap.widgets.TbGridView',array(
                    'id'=>'lb-invoice-Outstanding-grid',
                  //  'type'=>'striped',
                    'dataProvider'=>$model->getInvoiceByStatus($status,FALSE,10,$canList),
                    //'template' => "{items}",
                    'template' => "{items}\n{pager}\n{summary}", 
                    'columns'=>array(
              /*          array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                             'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}',
                            'htmlOptions'=>array('width'=>'20'),
                        ),*/
                        array(
                            'type'=>'raw',
                            'value'=>function($data){
                                //return "<a href='#' onclick='ajaxCheckStatus($data->lb_record_primary_key); return false;'>$data->lb_invoice_no</a>"."<br/>".LBApplicationUI::getStatusBadge($data->lb_invoice_status_code);
                                return "<div class='".LBApplicationUI::getStatusBadgeClass($data->lb_invoice_status_code)."'>$data->lb_invoice_no</div>";
                            },
                            'htmlOptions'=>array('width'=>'130'),
                        ),
                        array(
                          //  'header'=>Yii::t('lang','Customer'),
                            'type'=>'raw',
                            'value'=> 'LBApplication::workspaceLink(
                                $data->customer ? $data->customer->lb_customer_name : Yii::t("core","No customer"),
                                $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))'
                                . ' . "<br/><span class=\'grey-sub\'>". $data->lb_invoice_subject . "</span>"',
                            'htmlOptions'=>array('width'=>''),
                        ),
                        array(
                            'type'=>'raw',
                            'value'=>'date("d M Y",strtotime($data->lb_invoice_due_date))',
                            'htmlOptions'=>array('width'=>'100'),
                        ),
                        array(
                            'type'=>'raw',
                            'value'=>'LbInvoice::model()->getStatusAmount($data->lb_invoice_status_code,$data->total_invoice ? $data->total_invoice->lb_invoice_total_outstanding : "0.00")',
                            'htmlOptions'=>array(
                                'width'=>'120',
                                ),
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
        </div>
    </div>
    
    <!--    <div>
        <a class="more" href="<?//php echo LbInvoice::model()->getActionURLNormalized('admin'); ?>"><?//php echo Yii::t('lang','see more invoices'); ?></a>
    </div>-->
</div>
<script lang="javascript">
      function ajaxCheckStatus(invoice_id){            
        $.post('<?php echo LbInvoice::model()->getActionURLNormalized('UpdateStatus')?>',{invoice_id:invoice_id},
            function(data){               
                location.href=data;                         
            }
        );
    }
</script>