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
echo '<h3><a style="color:#fff !important;" href="' . LbInvoice::model()->getActionURLNormalized("dashboard") . '"><span id="invoice_no_change">' . $model->lb_invoice_no . '</span></a></h3>';
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
    <a href="<?php echo $url_first; ?>" style="color: #fff;" ><i class="lb_glyphicons-halflings lb_icon_backward"></i></a>&nbsp;
    <a href="<?php echo $url_previous; ?>"><i class="lb_glyphicons-halflings lb_icon_forward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="search" onKeyup="search_name(this.value);" id="search_invoice" value="" class="lb_input_search" value="" placeholder="Search" />
    <div id="data_search"></div>
    <a href="<?php echo $url_next ?>"><i class="lb_glyphicons-halflings lb_icon_fast_backward">&nbsp;</i></a>
    <a href="<?php echo $url_last; ?>"><i class="lb_glyphicons-halflings lb_icon_fast_forward"></i></a>
</div>
<?php
//            echo '<div class="lb-header-left" style="margin-left:397px;margin-top:-15px;">';
//           // LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
//             if($expenses_id >0){
//                        LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('View',array('id'=>$expenses_id)));
//                    }else{
//                         LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));  
//                    }        
//            echo '&nbsp;';
//            $this->widget('bootstrap.widgets.TbButtonGroup', array(
//                'type' => '',
//                'buttons' => array(
//                    array('label' => '<i class="icon-th-large"></i> Action', 'items' => array(
//                            array('label' => 'Email', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormEmail();')),
//                            array('label' => 'Enter Payment', 'url' => LbPayment::model()->getCreateURLNormalized(array('id'=>$model->lb_invoice_customer_id))),
//                            array('label' => 'Copy Invoice', 'url' => '#','linkOptions'=>array('onclick'=>'onclickCopyInvoice();')),
//                            array('label' => 'Generate PDF', 'url' => LbInvoice::model()->getActionURL('pdf',array('id'=>$model->lb_record_primary_key)),'linkOptions'=>array('target'=>'_blank')),
//                            array('label' => 'Get Public URL', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormGetPublicPDF();return false;')),
//                    )),
//                ),
//                'encodeLabel'=>false,
//            ));
//            echo '</div>';
echo '</div>';

//echo AutoComplete::widget([
//    'model' => $model,
//    'attribute' => 'country',
//    'clientOptions' => [
//        'source' => ['USA', 'RUS'],
//    ],
//]);
echo '<div id="logo_wrapper" class="lb_logo">';
$company = (isset($model->owner) ? $model->lb_invoice_company_id : '');
$folder = 'images/logo/';
$path = YII::app()->baseUrl . "/images/logo/";

$filename = '';
$file_arr = array_diff(scandir($folder), array('.', '..'));
$subcription = LBApplication::getCurrentlySelectedSubscription();
foreach ($file_arr as $key => $file) {
    $file_name = explode('.', $file);
    $file_name_arr = explode('_', $file_name[0]);
//                 print_r($file_name_arr);
    if ($file_name_arr[0] == $subcription && $file_name_arr[1] == $company)
        echo "<img src='" . $path . $file . "' style='max-height:50px' />";
}
$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
    'id' => 'uploadFile',
    'config' => array(
        'action' => $this->createUrl('uploadLogo', array('id' => $model->lb_record_primary_key, 'sub_cription' => $subcription, 'company_id' => $company)),
        'allowedExtensions' => array("jpeg", "jpg", "gif", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
        'sizeLimit' => 10 * 1024 * 1024, // maximum file size in bytes
        'minSizeLimit' => 1 * 1024, // minimum file size in bytes
        'multiple' => true,
        'onComplete' => "js:function(id, fileName, responseJSON){
                                    $('#uploadFile .qq-upload-list').html('');
                                    //$('#logo_wrapper img').attr('src','" . $path . "'+fileName);
                                    window,location.reload(true);
                               }",
    )
));
echo '</div>';

//created by
$create_by = AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name, $model->lb_record_primary_key)->lb_created_by);
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

$country_arr = LBApplicationUI::countriesDropdownData();
// supplier address and info
echo '<div id="container-supplier-contact" class="lb_address_info">';
if (isset($model->ownerAddress) && $model->ownerAddress) {
    $ownCompanyAddress = $model->ownerAddress;

    // line 1
    echo '<div id="container-supplier-info-line-1" style="display: block">';
    echo 'Address: ' . $ownCompanyAddress->lb_customer_address_line_1;
    echo '.&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_line_2 != NULL)
        echo $ownCompanyAddress->lb_customer_address_line_2 . '.&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_city != NULL)
        echo $ownCompanyAddress->lb_customer_address_city . '.&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_state != NULL)
        echo $ownCompanyAddress->lb_customer_address_state . '.&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_country != NULL)
        echo $country_arr[$ownCompanyAddress->lb_customer_address_country] . '&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_postal_code != NULL)
        echo $ownCompanyAddress->lb_customer_address_postal_code;
    echo '</div>';

    // line 2
    echo '<div id="container-supplier-info-line-2" style="display: block">';
    if ($ownCompanyAddress->lb_customer_address_phone_1 != NULL)
        echo 'Phone: ' . $ownCompanyAddress->lb_customer_address_phone_1 . '&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_fax != NULL)
        echo 'Fax: ' . $ownCompanyAddress->lb_customer_address_fax . '&nbsp;';
    if ($ownCompanyAddress->lb_customer_address_email != NULL)
        echo 'Email: ' . $ownCompanyAddress->lb_customer_address_email . '&nbsp;';
    echo '</div>';

    // line 3
    /**
      echo '<div id="container-supplier-info-line-3" style="display: block">';
      if ($ownCompany->lb_customer_registration)
      echo 'Registration No: ' . $ownCompany->lb_customer_registration. '&nbsp;';
      echo '</div>';* */
}
echo '</div>'; // end address info
// Invoice number, date and due
 $term = UserList::model()->getItemsForListCode('term');  
 $option_term = CHtml::listData($term, 'system_list_item_id', 'system_list_item_name');
echo '<div id="invoice-basic-info-container" class="lb_div_InvoiceInfo">';
    //
//    $this->widget('editable.EditableDetailView', array(
//        'id' => 'invoice-detail',
//        'data' => $model,
//        'url' => $model->getActionURL('ajaxUpdateField'),
//        'type'=>array('class'=>' lb_table_InvoiceInfo'),
//        'placement' => 'right',
//        'attributes' => array(                        
//            array(
//                'name' =>'lb_invoice_date',
//               // 'value'=>date("d M Y", strtotime($model->lb_invoice_date)),
//                'editable' => array(
//                    'type' => 'date',
//                    'viewformat' => 'dd-mm-yyyy',
//                    'format'=>'dd M yyyy',
//                )
//            ),           
//            array(
//                'name' => 'lb_invoice_term_id',
//                'editable' => array(
//                    'type' => 'select',
//                    'source' => array('0'=>'Choose Term')+CHtml::listData(UserList::model()->getItemsForListCode('term'), 'system_list_item_id', 'system_list_item_name')
//                )
//            ),
//            array(
//            
//            ),
//            array(
//                'name' => 'Create By',
//                'value' => "$create_by",
//                'editable' => false,
//            ),
//            
//        )
//    ));
    //
    echo '<table class="items table lb_table_InvoiceInfo">';
        echo '<tbody>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Date</th>';
                echo '<td class="lb_td_InoviceInfo">';
                    $this->widget('editable.EditableField', array(
                        'type' => 'date',
                        'model' => $model,
                        'attribute' => 'lb_invoice_date',
                       // 'url' => $model->getActionURLNormalized('ajaxUpdateField'),
						'url' => LbInvoice::model()->getActionURLNormalized('AjaxUpdateFieldDate'),
                        'placement' => 'left',
                        'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
                        'viewformat' => 'dd M yyyy', //format in which date is displayed
                    ));
                echo '</td>';
            echo '</tr>';
            echo '<tr class="odd">';
                echo '<th class="lb_th_InvoiceInfo">Term</th>';
                echo '<td class="lb_td_InoviceInfo">';
                    //echo $form->dropDownList($model,'lb_invoice_term',$option_term,array('empty'=>$model->lb_invoice_term,'name'=>'lb_invoice_term[]','style'=>'width:100px;'));
                    $this->widget('editable.EditableField', array(
                        'type'      => 'select',
                        'model'     => $model,
                        'attribute' => 'lb_invoice_term_id',
                      //  'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
						'url' => LbInvoice::model()->getActionURLNormalized('AjaxUpdateFieldDate'),
                        'source' => Editable::source( UserList::model()->getItemsForListCode('term'), 
                        'system_list_item_id', 'system_list_item_name'),
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
                        'attribute' => 'lb_invoice_currency',
                        'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                         'emptytext'=>LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol,
                     //    'source' => Editable::source(LbGenera::model()->getCurrency("",LbGenera::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),'lb_record_primary_key','lb_genera_currency_symbol'),
                        'source' => CHtml::listData(LbGenera::model()->getCurrency("",LbGenera::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
                                        function($gene){return "$gene->lb_record_primary_key";},
                                        function($gene){return "$gene->lb_genera_currency_symbol";})
                                        + array("-1"=>"-- Add new currency --"),
                        'placement' => 'left',
                        'htmlOptions'=>array(
                            'id'=>'LbInvoice_invoice_genera_id_'.$model->lb_record_primary_key,),
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

if (isset($model->lb_quotation_id) && $model->lb_quotation_id != 0) {
    $modelQuo = LbQuotation::model()->findByPk($model->lb_quotation_id);
    echo '<div>';
    echo Yii::t('lang', 'Quotation') . ': ';
    echo LBApplication::workspaceLink($modelQuo->lb_quotation_no, $modelQuo->customer ? LbQuotation::model()->getViewParamModuleURL($modelQuo->customer->lb_customer_name, null, $modelQuo->lb_record_primary_key, "lbQuotation") :
                    LbQuotation::model()->getViewParamModuleURL("No customer", null, $modelQuo->lb_record_primary_key, "lbQuotation"));
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
//        $('#search_invoice').autocomplete({
//            minLength:3,
//            source:function(name,response){
//                $.ajax({
//                    url:"<?php // echo LbInvoice::model()->getActionURLNormalized('Search_Invoice');   ?>",
//                    data:{search_name:name},
//                    success:function(data){
//                        response(JSON.parse(data));
//                    }
//                });
//            },
//        });
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