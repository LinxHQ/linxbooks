<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $invoiceItemModel LbInvoiceItem */
/* @var $invoiceDiscountModel LbInvoiceItem */
/* @var $invoiceTaxModel LbInvoiceItem */
/* @var $invoiceTotal LbInvoiceTotal */
$m = $this->module->id;
$credit_by = LbCoreEntity::model()->getCoreEntity($m,$model->lb_record_primary_key)->lb_created_by;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canView = BasicPermission::model()->checkModules($m, 'view',$credit_by);
$canList = BasicPermission::model()->checkModules($m, 'list',$credit_by);

$canAddPayment = BasicPermission::model()->checkModules('lbPayment','add');

$canReport = DefinePermission::model()->checkFunction($m,'view_report');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

LBApplication::renderPartial($this, '_page_header', array(
	'model'=>$model,
));

$this->renderPartial('_form', array(
		'model'=>$model)); 

$this->renderPartial('_form_line_items', array(
		'model'=>$model,
		'invoiceItemModel'=>$invoiceItemModel,
    'invoiceDiscountModel'=>$invoiceDiscountModel,
    'invoiceTaxModel'=>$invoiceTaxModel,
    'invoiceTotal'=>$invoiceTotal,
));

//echo '<div style="float: right; z-index: 9999; top: 150px; position: absolute; width: 60px; height: 300px; margin-left: 1020px;
// border-bottom-right-radius: 5px; border-top-right-radius: 5px;
// padding: 10px;">';
//
//if($canAdd)
//    echo LBApplication::workspaceLink(
//        CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_new.png', 'Share', array('class'=>'lb-side-icon')),
//        $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
//        array('data-toggle'=>"tooltip", 'title'=>"Create new invoice", 'class'=>'lb-side-link-invoice'));
//if($canAdd)
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_copy.png', 'Copy invoice', array('class'=>'lb-side-icon')),'#', array('data-toggle'=>"tooltip",'onclick'=>'onclickCopyInvoice();', 'title'=>"Copy invoice", 'class'=>'lb-side-link-invoice'));
//if($canAddPayment)
//    echo LBApplication::workspaceLink(
//        CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_payment.png', 'Payment', array('class'=>'lb-side-icon')),
//         LbPayment::model()->getCreateURLNormalized(array('id'=>$model->lb_invoice_customer_id)),
//        array('data-toggle'=>"tooltip", 'title'=>"Enter payment", 'class'=>'lb-side-link-invoice'));
//
///**
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_preview.png', 'Preview', array('class'=>'lb-side-icon')),
//    '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Preview", 'class'=>'lb-side-link-invoice'));
//**/
//
////echo LBApplication::workspaceLink(
////    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_email_1.png', 'Email', array('class'=>'lb-side-icon')),
////    '',
////    array('data-toggle'=>"tooltip",'onclick'=>'onclickFormEmail();', 'title'=>"Email", 'class'=>'lb-side-link-invoice'));
//
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_email_1.png', 'Email', array('class'=>'lb-side-icon')), '#', array('data-toggle'=>"tooltip",'onclick'=>'onclickFormEmail();', 'title'=>"Email", 'class'=>'lb-side-link-invoice'));
//
////echo LBApplication::workspaceLink(
////    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png', 'PDF', array('class'=>'lb-side-icon')),
////    $model->getPDFURLNormalied(array()),
////    array('data-toggle'=>"tooltip", 'title'=>"Generate PDF", 'class'=>'lb-side-link-invoice','target'=>'_blank'));
////echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png', '#', array('class'=>'lb-side-icon')), $model->getPDFURLNormalied($model->lb_record_primary_key), array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice'));
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png','#', array('class'=>'lb-side-icon')),  LbInvoice::model()->getActionURL('pdf',array('id'=>$model->lb_record_primary_key)),array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice'));
////echo LBApplication::workspaceLink(
////    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_share_2.png', 'Share', array('class'=>'lb-side-icon')),
////    Yii::app()->createAbsoluteUrl('lbInvoice/default/GetPublicPDF',array('id'=>$model->lb_record_primary_key)),
////    array('data-toggle'=>"tooltip", 'title'=>"Get public URL", 'class'=>'lb-side-link-invoice','target'=>'_blank'));
//
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_share_2.png','#', array('class'=>'lb-side-icon')),
////            Yii::app()->createAbsoluteUrl('',array('p'=>$model->lb_invoice_encode)),
//            '#',
//            array('target'=>'_blank','data-toggle'=>"tooltip",'onclick'=>'onclickFormGetPublicPDF();return false;','title'=>"Get public URL",'class'=>'lb-side-link-invoice'));
//
//## Next,Previous,Last,First ##########
//$invoice_next = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"next");
//$invoice_previous = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"previous");
//$invoice_last = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"last");
//$invoice_first = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"first");
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_first.png', 'First', array('class'=>'lb-side-icon')),
//    ($invoice_first) ? $model->getViewURLById($invoice_first[0],$invoice_first[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"First", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_previous.png', 'Previous', array('class'=>'lb-side-icon')),
//    ($invoice_previous) ? $model->getViewURLById($invoice_previous[0],$invoice_previous[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Previous", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_next.png', 'Next', array('class'=>'lb-side-icon')),
//    ($invoice_next) ? $model->getViewURLById($invoice_next[0],$invoice_next[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Next", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_last.png', 'Last', array('class'=>'lb-side-icon')),
//    ($invoice_last) ? $model->getViewURLById($invoice_last[0],$invoice_last[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Last", 'class'=>'lb-side-link-invoice'));
//
//echo '</div>';
?>
<script language="javascript">
    $(".lb-side-link-invoice").tooltip({placement: 'right'});
    
    function onclickCopyInvoice()
    {
        $.ajax({
            'url':'<?php echo $this->createURL("ajaxCopyInvoice",array('id'=>$model->lb_record_primary_key)); ?>',
            'beforeSend':function(data){
                            if(confirm('Are you sure to copy invoice?'))
                                 return true;
                             else
                                 return false;
                         },
                                 
            'success':function(data)
            {
                var responseJSON = jQuery.parseJSON(data);
                alert('Invoice has been copy');
                window.location.assign(responseJSON.url);
            }
        });
    }
</script>
