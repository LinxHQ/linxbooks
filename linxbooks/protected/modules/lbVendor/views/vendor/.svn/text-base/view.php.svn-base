<?php
/* @var $this VendorController */
/* @var $model LbVendor */

LBApplication::renderPartial($this, '_page_header', array(
	'model'=>$model,
));


$this->renderPartial('_form', array(
		'model'=>$model)); 

$this->renderPartial('_form_line_items', array(
		'model'=>$model,
		'modelItemVendor'=>$modelItemVendor,
                'modelDiscountVendor'=>$modelDiscountVendor,
                'modelTax'=>$modelTax,
                'modelTotal'=>$modelTotal,
));

//echo '<div style="float: right; z-index: 9999; top: 150px; position: absolute; width: 60px; height: 300px; margin-left: 1050px;
// border-bottom-right-radius: 5px; border-top-right-radius: 5px;
// padding: 10px;">';
//
////echo LBApplication::workspaceLink(
////    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png', 'PDF', array('class'=>'lb-side-icon')),
////    $model->getPDFURLNormalied(array()),
////    array('data-toggle'=>"tooltip", 'title'=>"Generate PDF", 'class'=>'lb-side-link-invoice','target'=>'_blank'));
////echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png', '#', array('class'=>'lb-side-icon')), $model->getPDFURLNormalied($model->lb_record_primary_key), array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice'));
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png','#', array('class'=>'lb-side-icon')), LbVendor::model()->getActionURL('Vendorpdf',array('id'=>$model->lb_record_primary_key)),array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice'),array('model'=>$model));
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
//
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_invoice.png', 'Create invoice', array('class'=>'lb-side-icon')),'#', array('data-toggle'=>"tooltip",'onclick'=>'onclickCopyQuotationToInvoice();', 'title'=>"Create invoice", 'class'=>'lb-side-link-invoice'));
    
    ($model->lb_vendor_status) ? $quotation_status=$model->lb_vendor_status : $quotation_status="";
    $modelInv = LbVendorInvoice::model()->getVendorInvoiceByVendor($model->lb_record_primary_key)->data;
    $countInv = count($modelInv);
    $invoiceNo = array();
    if($countInv>0)
    {
        foreach ($modelInv as $modelInvItem) {
            $invoiceNo[] = $modelInvItem->lb_vendor_no;
        }
    }
    
//echo '</div>';
?>
<script language="javascript">
    var quotation_status = '<?php echo $quotation_status; ?>';
    var quotaiton_status_accepted =false;
    var quotation_status_draft = false;
    if(quotation_status=='<?php echo LbVendor::LB_PO_STATUS_CODE_ACCEPTED ?>')
    {
        quotaiton_status_accepted = true;
    }
    if(quotation_status=='<?php echo LbVendor::LB_PO_STATUS_CODE_DRAFT ?>')
    {
        quotation_status_draft = true;
    }
  function onclickCopyQuotationToInvoice()
    {
        $.ajax({
            'url':'<?php echo $this->createURL("AjaxCreateVendorInvoice",array('id'=>$model->lb_record_primary_key)); ?>',
            'beforeSend':function(data){
                            var countInv = <?php echo $countInv; ?>;
//                            if(!quotaiton_status_accepted)
//                            {
//                                alert('Quotation has to be accepted.');
//                                return false;
//                            }
//                            else{
                                if(confirm('Are you sure to create vendor invoice?'))
                                {
                                    if(countInv>0)
                                    {
                                        if(confirm('At least one invoice has been created from this quotation: <?php echo implode(',', $invoiceNo); ?>. Are you sure to continue?'))
                                        { 
                                            return true;
                                        }
                                        else
                                            return false;
                                    }
                                    else
                                    {
                                        return true;
                                    }
                                }
                                else
                                     return false;
                            },
                         
                                 
            'success':function(data)
            {
                alert('Invoice has been saved');
                window.location.reload();
            }
        });
    }
                            </script>