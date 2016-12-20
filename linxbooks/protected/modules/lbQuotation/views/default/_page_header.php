<style>
    .qq-upload-button {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        border-bottom: medium none;
        color: #dcdcdc;
        display: block;
        padding: 7px 0;
        left: 460px;
        text-align: center;
        font-size: 10px;
    }
    .infoQuotation{
        //margin-right: -178px;
        margin-top: 20px;
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
echo '<div class="lb-header-right">';
echo '<h3><a id="quotation-number-container" style="color:#fff !important;" href="' . LbInvoice::model()->getActionURLNormalized("dashboard") . '">' . $model->lb_quotation_no . '</a></h3>';
$this->widget('bootstrap.widgets.TbMenu', array(
    'htmlOptions' => array('class' => 'lb_icon_action'),
    'items' => array(
        array(
            'htmlOptions' => array('style' => 'background:rgb(91,183,91)'),
            'label' => '<label class="lb_glyphicons-halflings lb_group_action"></label>', 'items' => array(
                array('label' => 'Email', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFromEmailQuotation('.$model->lb_record_primary_key.');')),
                            array('label' => 'Create Invoice', 'url' =>'#','linkOptions'=>array('onclick'=>'onclickCopyQuotationToInvoice();')),
                            array('label' => 'Copy Quotation', 'url' => '#','linkOptions'=>array('onclick'=>'onclickCopyQuotation();')),
                            array('label' => 'Generate PDF', 'url' => LbQuotation::model()->getActionURL('PDFQuotation',array('id'=>$model->lb_record_primary_key)),'linkOptions'=>array('target'=>'_blank')),
                            array('label' => 'Get Public URL', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormGetPublicPDF('.$model->lb_record_primary_key.');return false;')),
            )),
    ),
    'encodeLabel' => false,
));
//echo '<pre>';
//print_r($model);
echo '<div class="lb_badge_status" style="margin-left:10px;">';
$modelStatusQuotation =LbQuotation::model()->getBadgeStatusView($model->lb_quotation_status);
//echo $modelStatusQuotation;
$this->widget('editable.EditableField', array(
                        'type'      => 'select',
                        'model'     => $model,
                        'attribute' => "lb_quotation_status",
                        
                        'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                        'emptytext'=>LbQuotation::model()->getDisplayQuotationStatus($model->lb_quotation_status),
//                        'source' => CHtml::listData(LbQuotation::model()->getAllQuotationByStatus(),
//                                        function($gene){return $gene->lb_quotation_status;},
//                                        function($gene){return false;})
//                                        ,
                        'source' => Editable::source( LbQuotation::model()->getItemsForListCode(), 'system_list_item_id', 'system_list_item_name'),
                        'placement' => 'right',
                        'htmlOptions'=>array(
                            'id'=>'LbQuotation_quotation_genera_id_'.$model->lb_record_primary_key,),
                            'onShown' => 'js: function() {
                            var $tip = $(this).data("editableContainer").tip();
                            var dropdown = $tip.find("select");
                            $(dropdown).bind("change", function(e){
                                onChangeCurrencyDropdown(e,'.$model->lb_record_primary_key.');
                            });
                        }',
 ));
echo '</div>';
//echo '<label class="lb_badge_status_left">' . LbQuotation::model()->getBadgeStatusView($model->lb_quotation_status) . '</label>';
//echo "<label id='show_link' onclick='show_link();' class='lb_glyphicons-halflings lb_group_action' ></label>";
echo '</div>';

## Next,Previous,Last,First ##########
$quotation_next = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,'next');
$quotation_previous = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"previous");
$quotation_last = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"last");
$quotation_first = LbQuotation::model()->getMoveIQuotationNum($model->lb_quotation_no,"first");

$url_first = ($quotation_first) ? $model->getViewURLByIdNormalized($quotation_first[0],$quotation_first[1]) : '#';
$url_previous = ($quotation_previous) ? $model->getViewURLByIdNormalized($quotation_previous[0],$quotation_previous[1]) : '#';
$url_next = ($quotation_next) ? $model->getViewURLByIdNormalized($quotation_next[0],$quotation_next[1]) : '#';
$url_last = ($quotation_last) ? $model->getViewURLByIdNormalized($quotation_last[0],$quotation_last[1]) : '#';
?>
<div id="" class="lb-header-left lb-header-left_search" >
    <a href="<?php echo $url_first; ?>" style="color: #fff;" ><i class="lb_glyphicons-halflings lb_icon_backward"></i></a>&nbsp;
    <a href="<?php echo $url_previous; ?>"><i class="lb_glyphicons-halflings lb_icon_forward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />
    <div id="data_search"></div>
    <a href="<?php echo $url_next ?>"><i class="lb_glyphicons-halflings lb_icon_fast_backward">&nbsp;</i></a>
    <a href="<?php echo $url_last; ?>"><i class="lb_glyphicons-halflings lb_icon_fast_forward"></i></a>
</div>
<?php

echo '</div>';
echo '<div id="logo_wrapper" style="overflow:hidden;text-align: center;clear:bold;margin-top:20px;">';
            $company = (isset($model->owner) ? $model->lb_company_id : '');
                        $folder ='images/logo/';
            $path = YII::app()->baseUrl."/images/logo/";
            
            $filename = '';
            $file_arr = array_diff(scandir($folder),array('.','..'));
            $subcription = LBApplication::getCurrentlySelectedSubscription();
            foreach ($file_arr as $key => $file) {
                 $file_name = explode('.', $file); 
                 $file_name_arr = explode('_', $file_name[0]);
//                 print_r($file_name_arr);
                 if($file_name_arr[0] == $subcription && $file_name_arr[1] == $company)
                    echo "<img src='".$path.$file."' style='max-height:120px' />";
            }
            
            $this->widget('ext.EAjaxUpload.EAjaxUpload',

            array(
                    'id'=>'uploadFile',
                    'config'=>array(
                           'action'=>$this->createUrl('uploadLogo',array('id'=>$model->lb_record_primary_key,'sub_cription'=>$subcription,'company_id'=>$company)),
                           'allowedExtensions'=>array("jpeg","jpg","gif","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
                           'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                           'minSizeLimit'=>1*1024,// minimum file size in bytes
                           'onComplete'=>"js:function(id, fileName, responseJSON){
                                    $('#uploadFile .qq-upload-list').html('');
                                    //$('#logo_wrapper img').attr('src','".$path."'+fileName);
                                         window,location.reload(true);
                               }",
                          )
            ));
echo '</div>';

//created by
$create_by = AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbQuotation::model()->module_name, $model->lb_record_primary_key)->lb_created_by);
/**
 * ===== CUSTOMER SECTION =====
 */

// ===== END CUSTOMER SECTION =====
// company info
echo '<div class="pull-right lb_company_info" >';
echo '<h4>' . (isset($model->owner) ? $model->owner->lb_customer_name : '') . '</h4><br/>';
if (isset($model->owner) && $model->owner->lb_customer_registration)
    echo 'Registration No: ' . $model->owner->lb_customer_registration . '.&nbsp;';
if (isset($model->owner)) {
    echo (($model->owner->lb_customer_website_url != NULL) ? 'Website: ' . $model->owner->lb_customer_website_url . '<br>' : '');
}

//$country_arr = LBApplicationUI::countriesDropdownData();
// supplier address and info
echo '<div id="container-supplier-contact" class="lb_address_info">';
if (isset($model->ownerAddress) && $model->ownerAddress) {
    $ownCompanyAddress = $model->ownerAddress;

    // line 1
    echo '<div id="container-supplier-info-line-1" style="display: block">';
    if($ownCompanyAddress)
            {             
                echo 'Address: ' . $ownCompanyAddress->lb_customer_address_line_1;                    
            }
        else {
            echo "";
        }
	echo '.&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_line_2)
		echo $ownCompanyAddress->lb_customer_address_line_2 . '.&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_city)
		echo $ownCompanyAddress->lb_customer_address_city . '.&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_state)
		echo $ownCompanyAddress->lb_customer_address_state . '.&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_country)
		echo $ownCompanyAddress->lb_customer_address_country . '&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_postal_code)
		echo $ownCompanyAddress->lb_customer_address_postal_code;
    echo '</div>';

    // line 2
    echo '<div id="container-supplier-info-line-2" style="display: block">';
    if ($ownCompanyAddress->lb_customer_address_phone_1)
		echo 'Phone: ' . $ownCompanyAddress->lb_customer_address_phone_1. '&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_fax)
		echo 'Fax: ' . $ownCompanyAddress->lb_customer_address_fax. '&nbsp;';
	if ($ownCompanyAddress->lb_customer_address_email)
		echo 'Email: ' . $ownCompanyAddress->lb_customer_address_email. '&nbsp;';
    echo '</div>';

}
echo '</div>'; // end address info
// Invoice number, date and due
 $term = UserList::model()->getItemsForListCode('term');  
 $option_term = CHtml::listData($term, 'system_list_item_id', 'system_list_item_name');
echo '<div id="invoice-basic-info-container" class="lb_div_InvoiceInfo infoQuotation">';
    echo '<table class="items table lb_table_InvoiceInfo">';
        echo '<tbody>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Date</th>';
                echo '<td class="lb_td_InoviceInfo">';
                    $this->widget('editable.EditableField', array(
                        'type' => 'date',
                        'model' => $model,
                        'attribute' => 'lb_quotation_date',
                        'url' => $model->getActionURLNormalized('AjaxUpdateFieldDate'),
                        'placement' => 'right',
                        'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
                        'viewformat' => 'dd M yyyy', //format in which date is displayed
                    ));
                echo '</td>';
            echo '</tr>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Term</th>';
                echo '<td class="lb_td_InoviceInfo">';
                    //echo $form->dropDownList($model,'lb_quotation_term',$option_term,array('empty'=>$model->lb_quotation_term,'name'=>'lb_quotation_term[]','style'=>'width:100px;'));
                     $this->widget('editable.EditableField', array(
                        'type'      => 'select',
                        'model'     => $model,
                        'attribute' => 'lb_quotation_term',
                        'url'       => $model->getActionURLNormalized('AjaxUpdateFieldDate'),
                        'source' => Editable::source( UserList::model()->getItemsForListCode('term'), 'system_list_item_id', 'system_list_item_name'),
                        'placement' => 'left',
                    ));
                echo '</td>';
            echo '</tr>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Currency</th>';                     
                echo '<td class="lb_td_InoviceInfo">';
                    // echo LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
                    $this->widget('editable.EditableField', array(
                        'type'      => 'select',
                        'model'     => $model,
                        'attribute' => 'lb_quotation_currency',
                        'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                         'emptytext'=>LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol,
                     //    'source' => Editable::source(LbGenera::model()->getCurrency("",LbGenera::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),'lb_record_primary_key','lb_genera_currency_symbol'),
                        'source' => CHtml::listData(LbGenera::model()->getCurrency("",LbGenera::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                        function($gene){return "$gene->lb_record_primary_key";},
                                        function($gene){return "$gene->lb_genera_currency_symbol";})
                                        + array("-1"=>"-- Add new currency --"),
                        'placement' => 'left',
                        'htmlOptions'=>array(
                            'id'=>'LbQuotation_quotation_genera_id_'.$model->lb_record_primary_key,),
                        'onShown' => 'js: function() {
                            var $tip = $(this).data("editableContainer").tip();
                            var dropdown = $tip.find("select");
                            $(dropdown).bind("change", function(e){
                                onChangeCurrencyDropdown(e,'.$model->lb_record_primary_key.');
                            });
                        }',
                    ));
                echo '</td>';
            echo '</tr>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Created By</th>';
                echo '<td class="lb_td_InoviceInfo">';
                    echo $create_by;
                echo '</td>';
            echo '</tr>';
        echo '</tbody>';
    echo '</table>';

//if (isset($model->lb_quotation_id) && $model->lb_quotation_id != 0) {
    $modelInv = LbInvoice::model()->getInvByQuotation($model->lb_record_primary_key);
    foreach ($modelInv as $value) {
        $invoice = LbInvoice::model()->findByPk($value['lb_record_primary_key']);
   
     echo '<div>';
    echo Yii::t('lang', 'Invoice') . ': ';
  
    echo LBApplication::workspaceLink($invoice->lb_invoice_no, $invoice->customer ? LbInvoice::model()->getViewParamModuleURL($invoice->customer->lb_customer_name, null, $invoice->lb_record_primary_key, "lbInvoice") :
                    LbQuotation::model()->getViewParamModuleURL("No customer", null, $invoice->lb_record_primary_key, "lbInvoice"));
    echo '</div>';
    }
echo '</div>';
echo '</div>';

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
                url: "<?php echo LbQuotation::model()->getActionURLNormalized('Search_Quotation'); ?>",
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
     function onChangeCurrencyDropdown(e, quotation_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(quotation_id, 'New Currency','<?php
                echo LbQuotation::model()->getActionURLNormalized("ajaxQuickCreateCurrency",
                    array("ajax"=>1,
                    "quotation_id"=>$model->lb_record_primary_key)); ?>');
        }
    }
</script>