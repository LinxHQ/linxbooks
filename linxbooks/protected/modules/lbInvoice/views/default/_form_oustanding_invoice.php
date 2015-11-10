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

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
} 

?>
<div class="panel">
    <div style="margin-top: 10px;" class="panel-header-title">
        <div class="panel-header-title-left">
            <span style="font-size: 16px;"><b><?php echo Yii::t('lang','Outstanding Invoice'); ?></b></span>
        </div>
        <div class="panel-header-title-right">
            <?php if($canAdd){ ?>
                <a href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Invoice'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
            <?php if($canAddPayment) { ?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('lbPayment/default/create'); ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','New Payment'); ?></a>
            <?php } ?>
        </div>
        <div style="float:right;margin-bottom:5px; ">
            <input type="text" placeholder="Search" value="" style="border-radius: 15px;" onKeyup="search_name(this.value);">
        </div>
    </div>
    <div>
        <div id ="show_invoice">
    <?php $status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")'; ?>
    <?php
   
                $this->widget('bootstrap.widgets.TbGridView',array(
                    'id'=>'lb-invoice-Outstanding-grid',
                    'type'=>'striped',
                    'dataProvider'=>$model->getInvoiceByStatus($status,FALSE,10,$canList),
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
                            'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_outstanding : "0.00")',
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
        </div>
    </div>
    <div>
        <a class="more" href="<?php echo LbInvoice::model()->getActionURLNormalized('admin'); ?>"><?php echo Yii::t('lang','see more invoices'); ?></a>
    </div>
</div>
<script lang="javascript">
    function search_name(name)
    {
        name = replaceAll(name," ", "%");
        
        if(name.length >= 3){
        $('#show_invoice').load('<?php echo $this->createUrl('/lbInvoice/default/_search_invoice');?>?name='+name
                  
            );
        }
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
</script>