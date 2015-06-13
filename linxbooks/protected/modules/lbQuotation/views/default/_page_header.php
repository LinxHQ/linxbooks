<style>
.qq-upload-button {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-bottom: medium none;
    color: #0088CC;
    display: block;
    padding: 7px 0;
    left: 460px;
    text-align: center;
}
</style>
<?php

 //header container div
echo '<div id="quotation-header-container" class="container-header" style="position: relative">';
//
//// ribbon to show status
//echo '<div class="ribbon-wrapper"><div class="ribbon-green" id ="quotation_status_container">';
//echo LbQuotation::model()->getDisplayQuotationStatus($model->lb_quotation_status);
//
//echo '</div></div>';

echo '<div id="lb-view-header">';
            echo '<div class="lb-header-right" ><h3><a href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'">Quotations</a></h3></div>';
            echo '<div class="lb-header-left">';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-th-large"></i> Action', 'items' => array(
                            array('label' => 'Email', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFromEmailQuotation('.$model->lb_record_primary_key.');')),
                            array('label' => 'Create Invoice', 'url' =>'#','linkOptions'=>array('onclick'=>'onclickCopyQuotationToInvoice();')),
                            array('label' => 'Copy Quotation', 'url' => '#','linkOptions'=>array('onclick'=>'onclickCopyQuotation();')),
                            array('label' => 'Generate PDF', 'url' => LbQuotation::model()->getActionURL('PDFQuotation',array('id'=>$model->lb_record_primary_key)),'linkOptions'=>array('target'=>'_blank')),
                            array('label' => 'Get Public URL', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormGetPublicPDF('.$model->lb_record_primary_key.');return false;')),
                    )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';

echo '<div id="logo_wrapper" style="overflow:hidden;text-align: center;">';
//            $folder ='images/logo/';
//            $path = YII::app()->baseUrl."/images/logo/";
//            $file_arr = array_diff(scandir($folder),array('.','..'));
//            if(count($file_arr)>0)
//                echo "<img src='".$path.$file_arr[2]."' style='max-height:120px' />";
//            
//        et    $this->widget('ext.EAjaxUpload.EAjaxUpload',
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
//            echo '<h3>'.(isset($model->owner) ? $model->owner->lb_customer_name : '').'</h3><br/>';
            
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

// Quotation number, date and due
echo '<div id="quotation-basic-info-container" style="float: left;width:36%;">';
echo '<h3 id="quotation-number-container">';
echo $model->lb_quotation_no; // SHALL NOT ALLOW UPDATING OF INVOICE NO
echo '</h3><br/>';
echo Yii::t('lang','Quotation Date').': ';
$this->widget('editable.EditableField',array(
            'type'=>'date',
            'model'=>$model,
            'attribute'=>'lb_quotation_date',
            'url'=>$model->getActionURLNormalized('ajaxUpdateField'),
            'placement' => 'right',
            'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
            'viewformat' => 'dd/mm/yyyy', //format in which date is displayed
));

echo '&nbsp;&nbsp;';
echo Yii::t('lang','Due Date').': ';
$this->widget('editable.EditableField',array(
            'type'=>'date',
            'model'=>$model,
            'attribute'=>'lb_quotation_due_date',
            'url'=>$model->getActionURLNormalized('ajaxUpdateField'),
            'placement' => 'right',
           'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
           'viewformat' => 'dd/mm/yyyy', //format in which date is displayed
));
echo '<br>';
echo '<div id="quotation_status">';
echo Yii::t('lang','Status').': ';
$this->widget('editable.EditableField', array(
    'type' => 'select',
    'model' => $model,
    'attribute' => 'lb_quotation_status',
    'url' => $model->getActionURLNormalized('ajaxUpdateField'),
    //'source' => Editable::source(Status::model()->findAll(), 'status_id', 'status_text'),
    //or you can use plain arrays:
    'source' => Editable::source(array(LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT => LbQuotation::model()->getDisplayQuotationStatus(LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT),
                                        LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED=> LbQuotation::model()->getDisplayQuotationStatus(LbQuotation::LB_QUOTATION_STATUS_CODE_APPROVED),
                                        LbQuotation::LB_QUOTATION_STATUS_CODE_SENT => LbQuotation::model()->getDisplayQuotationStatus(LbQuotation::LB_QUOTATION_STATUS_CODE_SENT),
                                        LbQuotation::LB_QUOTATION_STATUS_CODE_ACCEPTED=> LbQuotation::model()->getDisplayQuotationStatus(LbQuotation::LB_QUOTATION_STATUS_CODE_ACCEPTED),
                                        LbQuotation::LB_QUOTATION_STATUS_CODE_REJECTED=> LbQuotation::model()->getDisplayQuotationStatus(LbQuotation::LB_QUOTATION_STATUS_CODE_REJECTED),)),
    'placement' => 'right',
    'validate' => 'js: function(value) {
                        if(quotation_status_draft) 
                            return "Please confirm quotation.";
                        else if(value=="'.LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT.'")
                            return "You\'re not allowed to update the status of this quotation back to Draft";
                   }',
    'success' => 'js: function(response, newValue) {
        if(newValue == "'.LbQuotation::LB_QUOTATION_STATUS_CODE_ACCEPTED.'")
        {
            quotaiton_status_accepted = true;
        }
        else
        {
            quotaiton_status_accepted = false;
        }
        $("#quotation_status_container").html(newValue);
    }'
));
echo '</div>';

$modelInv = LbInvoice::model()->getInvoiceByQuotation($model->lb_record_primary_key);

if(count($modelInv->data)>0)
{
    echo '<div>';
    echo Yii::t('lang','Quotation').': ';
    foreach ($modelInv->data as $modelInvItem) {
        echo LBApplication::workspaceLink($modelInvItem->lb_invoice_no,
                $modelInvItem->customer ? LbInvoice::model()->getViewParamModuleURL($modelInvItem->customer->lb_customer_name,null,$modelInvItem->lb_record_primary_key,"lbInvoice") :
                LbInvoice::model()->getViewParamModuleURL("No customer",null,$modelInvItem->lb_record_primary_key,"lbInvoice"));
        echo ", ";
    }
    echo '</div>';
}

echo '</div>';

// company info
echo '<div class="pull-right" style="text-align: right; margin-right: 25px;width:60%;">';
echo '<h3>'.(isset($model->owner) ? $model->owner->lb_customer_name : '').'</h3><br/>';
if (isset($model->owner) && $model->owner->lb_customer_registration)
	echo 'Registration No: ' . $model->owner->lb_customer_registration. '.&nbsp;';
echo 'Website: '.(isset($model->owner) ? $model->owner->lb_customer_website_url : '');
echo '<div id="container-supplier-contact" style="float: right; max-width: 600px;">';
if (isset($model->ownerAddress) && $model->ownerAddress)
{
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
	
	// line 3
	/**
	echo '<div id="container-supplier-info-line-3" style="display: block">';
	if ($ownCompany->lb_customer_registration)
		echo 'Registration No: ' . $ownCompany->lb_customer_registration. '&nbsp;';
	echo '</div>';**/
}
echo '</div>'; // end address info

echo '</div>'; // end company info

echo '</div>';
// end header container div
?>

