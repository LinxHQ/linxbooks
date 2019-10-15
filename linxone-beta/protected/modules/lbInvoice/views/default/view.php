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
         'expenses_id'=>$expenses_id,
));

$this->renderPartial('_form', array(
		'model'=>$model,
                 'expenses_id'=>$expenses_id,
    )); 

$this->renderPartial('_form_line_items', array(
	'model'=>$model,
	'invoiceItemModel'=>$invoiceItemModel,
    'invoiceDiscountModel'=>$invoiceDiscountModel,
    'invoiceTaxModel'=>$invoiceTaxModel,
    'invoiceTotal'=>$invoiceTotal,
     'expenses_id'=>$expenses_id,
));
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
