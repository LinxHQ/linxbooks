<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $quotationModel LbQuotation */

if(isset(Yii::app()->user->id))
    $lang = lbLangUser::model()->getLangName(Yii::app()->user->id);



if($lang != "")
{
    Yii::app()->language=$lang;
    $_SESSION["sess_lang"] = strtolower($lang);
}

$m = $this->module->id;
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
}
$status='("'.LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OPEN.'","'.LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE.'")';
$count_invoice=  LbInvoice::model()->getInvoiceByStatus($status);
$count_invoice= $count_invoice->totalItemCount;
$count_quotation= LbQuotation::model()->getQuotationByStatus('("'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_SENT.'","'.LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED.'")');
$count_quotation=$count_quotation->totalItemCount;
// Buttons

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left: -10px"><h4>'.Yii::t("lang","Invoice Dashboard").'</h4></div>';
            echo '<div class="lb-header-left">';
            echo '<div class="btn-toolbar" style="margin-top:2px;">';
            if($canAdd)
                echo '<button id="btn_invoice" class = "btn" onclick="view_oustanding_invoice()">Outstanding Invoice<span class="notification-badge">'.$count_invoice.'</span></button>';
            if($canAddQuotation)
                echo '<button id="btn_quotation" class = "btn" onclick="view_oustanding_quotation()">Outstanding Quotation<span class="notification-badge">'.$count_quotation.'</span></button>';
            if($canAddPayment)
                echo '<button id="btn_graph" class = "btn" onclick="view_chart()">Chart</button>';
            echo '</div>';
            echo '</div>';
echo '</div>';
echo '<br />';
echo '<div id ="view_invoice">';

echo '</div>';
?>


<script lang="Javascript">
view_oustanding_invoice();
function view_oustanding_invoice()
{
//    $('#view_invoice').block();
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_invoice') ?>',{year:<?php echo date('Y')?>},function(){
//        $('#view_invoice').unblock();
    });

    $("#btn_invoice").css("background-color","#5bb75b");
    $("#btn_invoice").css("color","#fff");
    $("#btn_graph").css("background-color","#f5f5f5");
    $("#btn_quotation").css("background-color","#f5f5f5");
     $("#btn_graph").css("color","black");

    $("#btn_quotation").css("color","black");
}

function view_oustanding_quotation()
{
    $("#btn_graph").css("color","black");
  
    $("#btn_invoice").css("color","black");
     $("#btn_quotation").css("color","#fff");
    $("#btn_quotation").css("background-color","#5bb75b");
    $("#btn_invoice").css("background-color","#f5f5f5");
    $("#btn_graph").css("background-color","#f5f5f5");
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('_form_oustanding_quotation') ?>');
}
function view_chart()
{
    $("#btn_graph").css("color","#fff");
    $("#btn_invoice").css("color","black");
    $("#btn_quotation").css("color","black");
   $("#btn_graph").css("background-color","#5bb75b");
   $("#btn_invoice").css("background-color","#f5f5f5");
   $("#btn_quotation").css("background-color","#f5f5f5");
    $('#view_invoice').load('<?php echo LbInvoice::model()->getActionURLNormalized('chart') ?>');
}
</script>
<style>
    .notification-badge {
    background-color:#e9852f;
    border-radius: 9px;
    color: #fff;
    display: inline-block;
    font-size: 9pt;
    font-weight: bold;
    left: -5px;
    line-height: 14px;
    padding: 2px 8px;
    position: relative;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    margin-left: 7px;
    vertical-align: baseline;
    white-space: nowrap;
    margin-right: -14px;
}
</style>



