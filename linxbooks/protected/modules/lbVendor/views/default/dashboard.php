<?php

$m = $this->module->id;
$canView = BasicPermission::model()->checkModules($m, 'view');
if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-12px;" ><h4>Bills</h4></div>';
            echo '<div class="lb-header-left">';
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','New Bill'),'url'=>  LbVendor::model()->getActionModuleURL('vendor', 'create')),
                        array('label'=>Yii::t('lang','New Bill invoice'),'url'=> LbVendor::model()->getActionModuleURL('supplier', 'createSupplier')),
                        array('label'=>Yii::t('lang','New Payment Voucher'),'url'=> LbVendor::model()->getActionModuleURL('vendor', 'addPayment')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';

//vendor 
//echo '<div>';
//    echo '<div class="panel-header-title" style="margin-top: 40px;">
//        <div class="panel-header-title-left">
//            <h4>Vendor</h4>
//        </div> 
//    </div>';
//$this->Widget('bootstrap.widgets.TbGridView',array(
//            'id'=>'lb_expenses_gridview',
//            'dataProvider'=> LbVendor::model()->getVendor(false,5),
//            'type'=>'striped bordered condensed',
//            //'template' => "{items}",
//            'columns'=>array(
//               
//                array(
//                    'header'=>Yii::t('lang','Date'),
//                    'name'=>'lb_customer_id',
//                    'type'=>'raw',
//                    'value'=>'$data->lb_vendor_date ? date("d M, Y", strtotime($data->lb_vendor_date)) : ""',
//                    'htmlOptions'=>array('width'=>'120'),
//                ),
//                array(
//                    'header'=>Yii::t('lang','Vendor No'),
//                    'type'=>'raw',
//                    'value'=>'"<a href=".Yii::app()->createUrl("lbVendor/vendor/view",array("id"=>$data->lb_record_primary_key)).">$data->lb_vendor_no</a>"',
////                  
//                    'htmlOptions'=>array('width'=>'180'),
//                ),
////               array(
////                    'header'=>Yii::t('lang','Category'),
////                    'type'=>'raw',
////                    'value'=>'(SystemList::model()->getItem($data->lb_vd_invoice_category)->system_list_item_name)',
////                    'htmlOptions'=>array('width'=>'150'),
////                ),
//                array(
//                    'header'=>Yii::t('lang','Note'),
//                    'type'=>'raw',
//                    'value'=>'$data->lb_vendor_notes',
//                    'htmlOptions'=>array('width'=>'250'),
//                ),
//                array(
//                    'header'=>Yii::t('lang','Total'),
//                    'type'=>'raw',
//                    'value'=>'LbVendorTotal::model()->getVendorTotal($data->lb_record_primary_key,LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL)->lb_vendor_last_tax',
//                    'htmlOptions'=>array('align'=>'right'),
//                ),
//            )
//        ));
//
////    
//echo '</div>';


//Vendor Invoice
echo '<div>';
    echo '<div class="panel-header-title" style="margin-top: -12px;">
        <div class="panel-header-title-left">
            <h5>Bills</h5>
        </div> 
    </div>';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_vendor_invoice_gridview',
            'dataProvider'=> LbVendorInvoice::model()->search(),
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(
               
                array(
                    'header'=>Yii::t('lang','Date'),
                    'name'=>'lb_customer_id',
                    'type'=>'raw',
                    'value'=>'$data->lb_vd_invoice_date ? date("d M, Y", strtotime($data->lb_vd_invoice_date)) : ""',
                    'htmlOptions'=>array('width'=>'120'),
                ),
                array(
                    'header'=>Yii::t('lang','Bill number'),
                    'type'=>'raw',
                    'value'=>'"<a href=".Yii::app()->createUrl("lbVendor/supplier/viewSupplier/",array("id"=>$data->lb_record_primary_key)).">$data->lb_vd_invoice_no</a>"',
//                  
                    'htmlOptions'=>array('width'=>'180'),
                ),
               array(
                    'header'=>Yii::t('lang','Supplier'),
                    'type'=>'raw',
                    'value'=>'LbCustomer::model()->customerInformation($data->lb_vd_invoice_supplier_id)->lb_customer_name',
                    'htmlOptions'=>array('width'=>'150'),
                ),
                
                array(
                    'header'=>Yii::t('lang','Total'),
                    'type'=>'raw',
                    'value'=>'LbVendorTotal::model()->getVendorTotal($data->lb_record_primary_key,LbVendorTotal::LB_VENDOR_INVOICE_TOTAL)->lb_vendor_last_tax',
                    'htmlOptions'=>array('align'=>'right'),
                ),
                array(
                    'header'=>Yii::t('lang','Status'),
                    'type'=>'raw',
                    'value'=>'LbVendorInvoice::model()->getDisplayInvoiceStatus($data->lb_vd_invoice_status)',
                    'htmlOptions'=>array('align'=>'right'),
                ),
            )
        ));

//    
echo '</div>';





