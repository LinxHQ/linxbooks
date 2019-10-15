<style>
    .qq-upload-button {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
        border-bottom: medium none;
        color: #dcdcdc;
        display: block;
        padding: 7px 0;
        left: 460px;
        text-align: center;
        font-size: 10px;
        text-shadow: none !important;
    }
    #lb-employee-form{
        width: 100%;
    }
    #invoice-header-container{
        width: 100%;
    }
    
</style>
<!--<img src="/linxbooks/img/glyphicons-halflings-white.png" alt=""/>-->
<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $ownCompany LbCustomer */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-employee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'type' => 'inline',
));
// header container div
echo '<div id="invoice-header-container" class="container-header" style="position: relative">';

// ribbon to show status
//echo '<div class="ribbon-wrapper"><div class="ribbon-green">';
//echo LbInvoice::model()->getDisplayInvoiceStatus($model->lb_invoice_status_code);
//echo '</div></div>';

echo '<div id="lb-view-header">';
//            if(isset($model->lb_invoice_no)){
//                echo '<div class="lb-header-right"><h3><a style="color:#fff !important;" href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'">'.$model->lb_invoice_no.'</a></h3></div>';
//            }else{
//                echo '<div class="lb-header-right"><h3><a style="color:#fff !important;" href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'">Invoices</a></h3></div>';
//            }
echo '<div class="lb-header-right" style="margin-top: 30px;">';
echo '<h3 style="margin-left: -11px;"><a style="" href="' . LbInvoice::model()->getActionURLNormalized("dashboard") . '"><span id="invoice_no_change">' . $model->lb_invoice_no . '</span></a></h3>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'htmlOptions' => array('class' => 'lb_icon_action'),
    'items' => array(
        array(
            'htmlOptions' => array('style' => 'background:rgb(91,183,91)'),
            'label' => '<label class="lb_glyphicons-halflings lb_group_action"></label>', 'items' => array(
                array('label' => 'Email', 'url' => '#', 'linkOptions' => array('onclick' => 'onclickFormEmail();')),
                array('label' => 'Enter Payment', 'url' => LbPayment::model()->getCreateURLNormalized(array('id' => $model->lb_invoice_customer_id))),
                array('label' => 'Copy Invoice', 'url' => '#', 'linkOptions' => array('onclick' => 'onclickCopyInvoice();')),
                array('label' => 'Generate PDF', 'url' => LbInvoice::model()->getActionURL('pdf', array('id' => $model->lb_record_primary_key)), 'linkOptions' => array('target' => '_blank')),
                array('label' => 'Get Public URL', 'url' => '#', 'linkOptions' => array('onclick' => 'onclickFormGetPublicPDF();return false;')),
            )),
    ),
    'encodeLabel' => false,
));
echo '<label class="lb_badge_status_left">' . LbInvoice::model()->getBadgeStatusView($model->lb_invoice_status_code) . '</label>';
//echo "<label id='show_link' onclick='show_link();' class='lb_glyphicons-halflings lb_group_action' ></label>";
echo '</div>';
## Next,Previous,Last,First ##########
            $invoice_next = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"next");
            $invoice_previous = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"previous");
            $invoice_last = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"last");
            $invoice_first = LbInvoice::model()->getMoveInvoiceNum($model->lb_invoice_no,"first");

            $url_first = ($invoice_first) ? $model->getViewURLByIdNormalized($invoice_first[0],$invoice_first[1]) : '#';
            $url_previous = ($invoice_previous) ? $model->getViewURLByIdNormalized($invoice_previous[0],$invoice_previous[1]) : '#';
            $url_next = ($invoice_next) ? $model->getViewURLByIdNormalized($invoice_next[0],$invoice_next[1]) : '#';
            $url_last = ($invoice_last) ? $model->getViewURLByIdNormalized($invoice_last[0],$invoice_last[1]) : '#';
            ?>

<div id="" class="lb-header-left lb-header-left_search" >
    <a href="<?php echo $url_first; ?>" style="" ><i class="lb_glyphicons-halflings lb_icon_backward"></i></a>&nbsp;
    <a href="<?php echo $url_previous; ?>"><i class="lb_glyphicons-halflings lb_icon_forward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />
    <div id="data_search"></div>
    <a href="<?php echo $url_next ?>"><i class="lb_glyphicons-halflings lb_icon_fast_backward">&nbsp;</i></a>
    <a href="<?php echo $url_last; ?>"><i class="lb_glyphicons-halflings lb_icon_fast_forward"></i></a>
</div>
<?php
echo '</div>';

/**
 * ===== CUSTOMER SECTION =====
 */


// ===== END CUSTOMER SECTION =====
echo '</div>'; // end header container div
$this->endWidget();
?>
<script lang="javascript">
    function link(e,r)
    {
      //  alert(r)
        window.open('<?php LbInvoice::model()->getActionModuleURL('default', 'view') ?>?invoice_no=' + r);
    }



    function search_name(name)
    {

        name = replaceAll(name, " ", "%");
        if(name!==""){
            $.ajax({
                url: "<?php echo LbInvoice::model()->getActionURLNormalized('Search_Invoice'); ?>",
                data: {search_name: name},
                success: function (data) {
                    if (data !== "") {
                        $("#data_search").show();
                        $("#data_search").html(data);
                    } 
                }
            });
        }else{
            $('#data_search').hide();
        }

    }
    function replaceAll(string, find, replace) {
        return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    function selectValue(val){
        $('#search_invoice').val(val);
        $('#data_search').hide();
    }
    function onChangeCurrencyDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(invoice_id, 'New Currency','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateCurrency",
                    array("ajax"=>1,
                    "invoice_id"=>$model->lb_record_primary_key)); ?>');
        }
    }
</script>