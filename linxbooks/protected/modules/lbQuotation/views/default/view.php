<?php
$m = $this->module->id;
$credit_by = LbCoreEntity::model()->getCoreEntity($m,$model->lb_record_primary_key)->lb_created_by;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canView = BasicPermission::model()->checkModules($m, 'view',$credit_by);
$canList = BasicPermission::model()->checkModules($m, 'list',$credit_by);

$canAddInvoice = BasicPermission::model()->checkModules(LbInvoice::model()->getEntityType(), 'add');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}

LBApplication::renderPartial($this, '_page_header', array('model'=>$model));

$this->renderPartial('_form', array(
		'model'=>$model)); 

$this->renderPartial('_form_line_items',array(
                'model'=>$model,
                'quotationItemModel'=>$quotationItemModel,
                'quotaitonTaxModel'=>$quotaitonTaxModel,
                'quotationDiscountModel'=>$quotationDiscountModel,
                'quotationTotalModel'=>$quotationTotalModel,
));

## Next,Previous,Last,First ##########
$quotation_next = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,'next');
$quotation_previous = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"previous");
$quotation_last = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"last");
$quotation_first = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"first");
#end

echo '<div style="float: right; z-index: 9999; top: 150px; position: absolute; width: 60px; height: 300px; margin-left: 1020px;
 border-bottom-right-radius: 5px; border-top-right-radius: 5px;
 padding: 10px;"></div>';

//if($canAdd)
//{
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_new.png', 'New quotation', array('class'=>'lb-side-icon')), $this->createURL("create"), array('data-toggle'=>"tooltip", 'title'=>"New quotation", 'class'=>'lb-side-link-invoice'));
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_copy.png', 'Create invoice', array('class'=>'lb-side-icon')),'#', array('data-toggle'=>"tooltip",'onclick'=>'onclickCopyQuotation();', 'title'=>"Copy quotation", 'class'=>'lb-side-link-invoice'));
//}
//if($canAddInvoice)
//    echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_invoice.png', 'Create invoice', array('class'=>'lb-side-icon')),'#', array('data-toggle'=>"tooltip",'onclick'=>'onclickCopyQuotationToInvoice();', 'title'=>"Create invoice", 'class'=>'lb-side-link-invoice'));
//
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_email_1.png', 'Email', array('class'=>'lb-side-icon')), '#', array('data-toggle'=>"tooltip",'onclick'=>'onclickFromEmailQuotation('.$model->lb_record_primary_key.');', 'title'=>"Email", 'class'=>'lb-side-link-invoice'));
//
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png','#', array('class'=>'lb-side-icon')),$this->createUrl("PDFQuotation",array('id'=>$model->lb_record_primary_key)),array('target'=>'_blank','data-toggle'=>"tooltip",'title'=>"Generate PDF",'class'=>'lb-side-link-invoice'));
//
//echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_share_2.png','#', array('class'=>'lb-side-icon')),
////            Yii::app()->createAbsoluteUrl('',array('p'=>$model->lb_invoice_encode)),
//            '#',
//            array('target'=>'_blank','data-toggle'=>"tooltip",'onclick'=>'onclickFormGetPublicPDF('.$model->lb_record_primary_key.');return false;','title'=>"Get public URL",'class'=>'lb-side-link-invoice'));
//
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_first.png', 'First', array('class'=>'lb-side-icon')),
//    ($quotation_first) ? $model->getViewURLById($quotation_first[0],$quotation_first[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"First", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_previous.png', 'Previous', array('class'=>'lb-side-icon')),
//    ($quotation_previous) ? $model->getViewURLById($quotation_previous[0],$quotation_previous[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Previous", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_next.png', 'Next', array('class'=>'lb-side-icon')),
//    ($quotation_next) ? $model->getViewURLById($quotation_next[0],$quotation_next[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Next", 'class'=>'lb-side-link-invoice'));
//
//echo LBApplication::workspaceLink(
//    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_last.png', 'Last', array('class'=>'lb-side-icon')),
//    ($quotation_last) ? $model->getViewURLById($quotation_last[0],$quotation_last[1]) : '#',
//    array('data-toggle'=>"tooltip", 'title'=>"Last", 'class'=>'lb-side-link-invoice'));
//
//echo '</div></div>';
?>
<?php 
($model->lb_quotation_status) ? $quotation_status=$model->lb_quotation_status : $quotation_status="";
$modelInv = LbInvoice::model()->getInvoiceByQuotation($model->lb_record_primary_key)->data;
$countInv = count($modelInv);
$invoiceNo = array();
if($countInv>0)
{
    foreach ($modelInv as $modelInvItem) {
        $invoiceNo[] = $modelInvItem->lb_invoice_no;
    }
}
?>

<script language="javascript">
    $(".lb-side-link-invoice").tooltip({placement: 'right'});
    
    var quotation_status = '<?php echo $quotation_status; ?>';
    var quotaiton_status_accepted =false;
    var quotation_status_draft = false;
    if(quotation_status=='<?php echo LbQuotation::LB_QUOTATION_STATUS_CODE_ACCEPTED ?>')
    {
        quotaiton_status_accepted = true;
    }
    if(quotation_status=='<?php echo LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT ?>')
    {
        quotation_status_draft = true;
    }
    function onclickFromEmailQuotation(quotation_id)
    {
        lbAppUILoadModal(quotation_id,'Send Email','<?php
            echo LbQuotation::model()->getActionURLNormalized("formSendEmail",
                array("ajax"=>1,"id"=>$model->lb_record_primary_key)); ?>');
    }
    
    function onclickFormGetPublicPDF(quotation_id)
    {
        lbAppUILoadModal(quotation_id,'Share PDF','<?php
            echo LbQuotation::model()->getActionURLNormalized("formSharePDFQuotation",
                array("ajax"=>1,"id"=>$model->lb_record_primary_key)); ?>');
        $('#modal-holder-'+quotation_id+' .modal-body').css('max-height','900px;');
    }
    
    function onclickCopyQuotationToInvoice()
    {
        $.ajax({
            'url':'<?php echo $this->createURL("ajaxCreateInvoice",array('id'=>$model->lb_record_primary_key)); ?>',
            'beforeSend':function(data){
                            var countInv = <?php echo $countInv; ?>;
                            if(!quotaiton_status_accepted)
                            {
                                alert('Quotation has to be accepted.');
                                return false;
                            }
                            else{
                                if(confirm('Are you sure to create invoice?'))
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
                            }
                         },
                                 
            'success':function(data)
            {
                alert('Invoice has been saved');
                window.location.reload();
            }
        });
    }
    
    function onclickCopyQuotation()
    {
        $.ajax({
            'url':'<?php echo $this->createURL("ajaxCopyQuotation",array('id'=>$model->lb_record_primary_key)); ?>',
            'beforeSend':function(data){
                            if(confirm('Are you sure to copy Quotation?'))
                                 return true;
                             else
                                 return false;
                         },
                                 
            'success':function(data)
            {
                alert('Quotation has been copy');
            }
        });
    }
</script>
