<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $form CActiveForm */

/**
 * ===== SUPPLIER SECTION =====
 */
echo '<div id="container-invoice-supplier-section">';

// logo
echo '<div id="container-supplier-logo" style="">';
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
        //'minSizeLimit' => 1 * 1024, // minimum file size in bytes
        'multiple' => true,
        'onComplete' => "js:function(id, fileName, responseJSON){
                                    $('#uploadFile .qq-upload-list').html('');
                                    //$('#logo_wrapper img').attr('src','" . $path . "'+fileName);
                                    window,location.reload(true);
                               }",
    )
));
echo '</div>';
echo '</div>'; // end logo

//
// supplier address info
//
echo '<div id="supplier-info-container">';
echo '<h4>' . (isset($model->owner) ? $model->owner->lb_customer_name : '') . '</h4>';
if (isset($model->owner) && $model->owner->lb_customer_registration)
    echo 'Registration No: ' . $model->owner->lb_customer_registration . '.&nbsp;';
if (isset($model->owner)) {
    echo (($model->owner->lb_customer_website_url != NULL) ? 'Website: ' . $model->owner->lb_customer_website_url . '' : '');
}

$country_arr = LBApplicationUI::countriesDropdownData();
// supplier address and info
echo '<div id="container-supplier-contact" class="">';
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
echo '</div>'; // end #supplier-info-container
echo '</div>'; // end #container-invoice-supplier-section
// ===== END SUPPLIER SECTION =============================================

/**
 * ==== Invoice basic info ====
 */
//created by
$create_by = AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name, $model->lb_record_primary_key)->lb_created_by);

 $term = UserList::model()->getItemsForListCode('term');  
 $option_term = CHtml::listData($term, 'system_list_item_id', 'system_list_item_name');
echo '<div id="invoice-basic-info-container" class="lb_div_InvoiceInfo lb_table_InvoiceInfo_invoice">';

// Invoice number, date and due
    echo '<table class="items table lb_table_InvoiceInfo ">';
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
                                        + array("0"=>"Select Currency", "-1"=>"-- Add new currency --"),
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

// end invoice number, date, due


/**
 * ===== CUSTOMER SECTION =====
 */
echo '<div id="container-invoice-customer-info" class="lb_customer_info" style="">';

// customer name
echo '<div id="container-invoice-customer-name">';
//echo '<div class="field-label-left"><h4>'.Yii::t('lang','To').':</h4></div>';
echo '<div class="field-value-left" style="padding: 0px !important; width: auto !important;">';
echo '<h4>';
$this->widget('editable.EditableField', array(
        'type'      => 'select',
        'model'     => $model,
        'attribute' => 'lb_invoice_customer_id',
		'emptytext' => 'Choose customer',
        'url'       => $model->getActionURLNormalized('ajaxUpdateCustomer'), 
        'source'    => $this->createUrl('/lbCustomer/default/dropdownJSON',array('allow_add'=>YES)), 
        //you can also use js function returning string url
        //'source'    => 'js: function() { return "?r=site/getStatusList"; }',
        'placement' => 'right',
        'validate' => 'function(value){
            if (value < 0) return "Please select a valid customer";
        }',
		'success' => 'js: function(response, newValue) {
                    var jsonResponse = jQuery.parseJSON(response);
                    if(jsonResponse.customer >0){
                                    var cutomer_id=jsonResponse.customer;
                                    var customer_name=jsonResponse.customer_name;
                                    $("#user").attr("href", "'.$this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/lbCustomer/"+cutomer_id+"-"+customer_name+"').'");
                                }

		    updateInvoiceAddressLines(jsonResponse);
		    updateAttentionUI('.$model->lb_record_primary_key.',0,"Choose contact");
                    lbInvoice_choose_customer = true;
		
			// put customer id into hidden field
			$("#hidden-invoice-customer-id").val(newValue);
		}',
		'display' => 'js: function(value, sourceData) {
			var el = $(this);
			$.each(sourceData, function(index) {
				if (sourceData[index].value == value) {
					el.html(sourceData[index].text);
				}
			});
		}',
        'options'	=> array(
            'sourceCache'=> false,
        ),
        'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeCustomerDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
        'htmlOptions'=>array(
            'id'=>'LbInvoice_invoice_customer_id_'.$model->lb_record_primary_key,
        ),
    ));

$custoemr_id=0;
$custoemr_name="";
if($model->lb_invoice_customer_id){
    $custoemr_id=$model->lb_invoice_customer_id;
    if(isset($model->customer)){
        $custoemr_name = str_replace( ' ', '-',$model->customer->lb_customer_name);
    }
}
if($custoemr_id>0){
    echo '&nbsp;&nbsp;<a id="user" href="'.$this->createUrl('/'.LBApplication::getCurrentlySelectedSubscription().'/lbCustomer/'.$model->lb_invoice_customer_id.'-'.$custoemr_name).'"><i class="icon-search"></i></a>';
} else {
    echo '&nbsp;&nbsp;<a id="user"><i class="icon-search"></i></a>';
}
echo '</h4>';
echo '</div>'; // end div for customer name's txt
echo CHtml::hiddenField('hidden-invoice-customer-id', $model->lb_invoice_customer_id, 
		array('id'=>'hidden-invoice-customer-id'));

echo '</div>'; // end customer name

// customer address
echo '<div id="container-invoice-customer-address">';
//echo '<div class="field-label-left">'.Yii::t('lang','Billing Address').':</div>';
echo '<div class="field-value-left" style="padding: 0px !important; width: auto !important;">';
$this->widget('editable.EditableField', array(
		'type'      => 'select',
		'model'     => $model,
		'attribute' => 'lb_invoice_customer_address_id',
		'emptytext' => 'Choose billing address',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'source'    => $this->createUrl('/lbCustomerAddress/default/dropdownJSON',
				array('allow_add'=>YES, 'invoice_id'=>$model->lb_record_primary_key)),
		'placement' => 'right',
		/**
		'success' => 'js: function(response, newValue) {
			if(!response.success) return response.msg;
		}',**/
		'display' => 'js: function(value, sourceData) {
			var el = $(this);
			$.get("'.LbCustomerAddress::model()->getActionURLNormalized('addressLinesJSON').'?id="+value,function(response){
				var jsonResponse = jQuery.parseJSON(response);
				updateInvoiceAddressLines(jsonResponse);
			});
		}',
        'validate' => 'function(value){
            if (value < 0) return "Please select a valid address";
        }',
		'options'	=> array(
			'sourceCache'=> false,
		),
        'htmlOptions'=>array(
            'id'=>'LbInvoice_invoice_customer_address_id_'.$model->lb_record_primary_key,
        ),
        'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeAddressDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
    ));


echo '</div>';
echo '</div>'; // end customer address

echo '<div id="container-invoice-customer-attention">';
//echo '<div class="field-label-left">'.Yii::t('lang','Attention').':</div>';
echo '<div class="field-value-left" style="padding: 0px !important; width: auto !important;">';
$this->widget('editable.EditableField', array(
    'type'      => 'select',
    'model'     => $model,
    'attribute' => 'lb_invoice_attention_contact_id',
    'emptytext' => 'Choose contact',
    'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
    'source'    => LbCustomerContact::model()->getActionURLNormalized('dropdownJSON',
        array('allow_add'=>YES, 'invoice_id'=>$model->lb_record_primary_key)),
    'placement' => 'right',
    /**
    'success' => 'js: function(response, newValue) {
    if(!response.success) return response.msg;
    }',**/
    'options'	=> array(
        'sourceCache'=> false,
    ),
    'htmlOptions'=>array(
        'id'=>'LbInvoice_invoice_attention_contact_id_'.$model->lb_record_primary_key,
    ),
    'onShown' => 'js: function() {
            var $tip = $(this).data("editableContainer").tip();
            var dropdown = $tip.find("select");
            $(dropdown).bind("change", function(e){
                onChangeAttentionDropdown(e,'.$model->lb_record_primary_key.');
            });
        }',
));
echo '</div>';
echo '</div>'; // end attention

echo '</div>'; // end #container-invoice-customer-info

echo '</div>'; // end # invoice-basic-info-container
// ====  END Invoice basic info ====

($model->lb_invoice_status_code) ? $lb_invoice_status = $model->lb_invoice_status_code : $lb_invoice_status="";
($model->lb_invoice_customer_id) ? $lb_invoice_customer_id = $model->lb_invoice_customer_id : $lb_invoice_customer_id="";
?>

<br>
<div id="container-invoice-customer-subject" class="lb_subject_invoice">
    <!--h4><?php //echo Yii::t('lang','Subject'); ?>:</h4-->
    <?php
        $this->widget('editable.EditableField', array(
            'type'        => 'textarea',
            'inputclass'  => 'input-large-textarea',
            'emptytext'   => 'Enter invoice subject',
            'model'       => $model,
            'attribute'   => 'lb_invoice_subject',
            'url'         => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement'   => 'right',
            //'showbuttons' => 'bottom',
            'htmlOptions' => array('class'=>'lb_edit_table'),
            'options'	=> array(
            ),
        ));
    ?>
</div>

<script language="javascript">
    var lb_invoice_customer_id = "<?php echo $lb_invoice_customer_id; ?>";
    var lb_invoice_status = "<?php echo $lb_invoice_status; ?>";
    
    var lbInvoice_choose_customer = false;
    var lbInvoice_status_draft = false;
    if(lb_invoice_customer_id!="")
    {
        lbInvoice_choose_customer = true;
    }
    if(lb_invoice_status=="<?php echo LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT ?>")
    {
        lbInvoice_status_draft = true
    }
    function onChangeCustomerDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == 0)
        {
            lbAppUILoadModal(invoice_id, 'New Customer','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateCustomer",
                    array("ajax"=>1, "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

    function onChangeAddressDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(invoice_id, 'New Address','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateAddress",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }

    function onChangeAttentionDropdown(e, invoice_id)
    {
        var target = e.target;
        //console.log($(target).val());
        if ($(target).val() == -1)
        {
            lbAppUILoadModal(invoice_id, 'New Contact','<?php
                echo LbInvoice::model()->getActionURLNormalized("ajaxQuickCreateContact",
                    array("ajax"=>1,
                    "id"=>$model->lb_record_primary_key)); ?>');
        }
    }
</script>
