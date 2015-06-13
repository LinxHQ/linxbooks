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
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $ownCompany LbCustomer */

// header container div
echo '<div id="invoice-header-container" class="container-header" style="position: relative">';

// ribbon to show status
//echo '<div class="ribbon-wrapper"><div class="ribbon-green">';
//echo LbInvoice::model()->getDisplayInvoiceStatus($model->lb_invoice_status_code);
//echo '</div></div>';

echo '<div id="lb-view-header">';
            echo '<div class="lb-header-right" style="width:96px;"><h3><a href="'.LbInvoice::model()->getActionURLNormalized("dashboard").'">Invoices</a></h3></div>';
           
                        
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
            <div id="" style="margin-right:500px;margin-bottom: -22px; width:658px;">
                <a href="<?php echo $url_first;  ?>" ><i class="icon-fast-backward"></i></a>&nbsp;
                <a href="<?php echo $url_previous; ?>"><i class="icon-backward"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="search" id="search_invoice" value="" style="border-radius: 15px;" value="" placeholder="Search" />
                <a margin-top:-31px; href="<?php echo $url_next ?>"><i class="icon-forward">&nbsp;</i></a>
                <a margin-top:-31px;; href="<?php echo $url_last; ?>"><i class="icon-fast-forward"></i></a>
            </div>
            
            <?php
            echo '<div class="lb-header-left" style="margin-left:397px;margin-top:-15px;">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-th-large"></i> Action', 'items' => array(
                            array('label' => 'Email', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormEmail();')),
                            array('label' => 'Enter Payment', 'url' => LbPayment::model()->getCreateURLNormalized(array('id'=>$model->lb_invoice_customer_id))),
                            array('label' => 'Copy Invoice', 'url' => '#','linkOptions'=>array('onclick'=>'onclickCopyInvoice();')),
                            array('label' => 'Generate PDF', 'url' => LbInvoice::model()->getActionURL('pdf',array('id'=>$model->lb_record_primary_key)),'linkOptions'=>array('target'=>'_blank')),
                            array('label' => 'Get Public URL', 'url' => '#','linkOptions'=>array('onclick'=>'onclickFormGetPublicPDF();return false;')),
                    )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';
echo '<div id="logo_wrapper" style="overflow:hidden;text-align: center;clear:bold;">';
            $company = (isset($model->owner) ? $model->lb_invoice_company_id : '');
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
                           'action'=>$this->createUrl('uploadLogo',array('id'=>$model->lb_record_primary_key, 'sub_cription'=>$subcription,'company_id'=>$company)),
                           'allowedExtensions'=>array("jpeg","jpg","gif","png"),//array("jpg","jpeg","gif","exe","mov" and etc...
                           'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                           'minSizeLimit'=>1*1024,// minimum file size in bytes
                           'multiple' => true,
                           'onComplete'=>"js:function(id, fileName, responseJSON){
                                    $('#uploadFile .qq-upload-list').html('');
                                    //$('#logo_wrapper img').attr('src','".$path."'+fileName);
                                    window,location.reload(true);
                               }",
                          )
            ));
echo '</div>';

//created by
$create_by = AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name,$model->lb_record_primary_key)->lb_created_by);
// Invoice number, date and due
echo '<div id="invoice-basic-info-container" style="float: left;width:36%;">';
echo '<h3 id="invoice-number-container">';
echo $model->lb_invoice_no; // SHALL NOT ALLOW UPDATING OF INVOICE NO
/**
if ($model->lb_invoice_status_code == $model::LB_INVOICE_STATUS_CODE_DRAFT)
{
    echo $model->lb_invoice_no;
} else {
    $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'lb_invoice_no',
            'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
            'placement' => 'right',
        ));
}**/
echo '</h3><br/>';
echo Yii::t('lang','Invoice Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'date',
		'model'     => $model,
		'attribute' => 'lb_invoice_date',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
                'placement' => 'right',
               'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
               'viewformat' => 'dd/mm/yyyy', //format in which date is displayed
));
echo '&nbsp;';
echo Yii::t('lang','Due Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'date',
		'model'     => $model,
		'attribute' => 'lb_invoice_due_date',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'placement' => 'right',
               'format' => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
               'viewformat' => 'dd/mm/yyyy', //format in which date is displayed
    
));

echo '<br>';
echo '<div>';
echo Yii::t('lang','Status').': ';
echo '<span id="lb_invocie_status">';
echo LbInvoice::model()->getDisplayInvoiceStatus($model->lb_invoice_status_code);
echo '</span>';
//$this->widget('editable.EditableField', array(
//		'type'      => 'select',
//		'model'     => $model,
//		'attribute' => 'lb_invoice_status_code',
//		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
//                'source' => Editable::source(
//                                        array(LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT=>  LbInvoice::model()->getDisplayInvoiceStatus(LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT),
//                                         LbInvoice::LB_INVOICE_STATUS_CODE_OPEN=> LbInvoice::model()->getDisplayInvoiceStatus(LbInvoice::LB_INVOICE_STATUS_CODE_OPEN),
//                                         LbInvoice::LB_INVOICE_STATUS_CODE_PAID=>  LbInvoice::model()->getDisplayInvoiceStatus(LbInvoice::LB_INVOICE_STATUS_CODE_PAID),
//                                         LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE=> LbInvoice::model()->getDisplayInvoiceStatus(LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE),
//                                         LbInvoice::LB_INVOICE_STATUS_CODE_WRITTEN_OFF=> LbInvoice::model()->getDisplayInvoiceStatus(LbInvoice::LB_INVOICE_STATUS_CODE_WRITTEN_OFF),
//                            )),
//                'validate' => 'js: function(value) {
//                                    if(lbInvoice_status_draft) 
//                                        return "Please confirm invoice.";
//                               }',
//                'success'=>'js: function(response,newValue)
//                                {
//                                    lbInvoice_status_draft = false;
//                                    $("#invoice-header-container .ribbon-green").html(newValue);
//                                }',
//		'placement' => 'right',
//));
echo '<span style="margin-left:79px;">';
echo Yii::t('lang', 'Created By');
echo ':  ';
echo $create_by.'</span>';
echo '</div>';

if(isset($model->lb_quotation_id) && $model->lb_quotation_id!=0)
{
    $modelQuo = LbQuotation::model()->findByPk($model->lb_quotation_id);
    echo '<div>';
    echo Yii::t('lang','Quotation').': ';
    echo LBApplication::workspaceLink($modelQuo->lb_quotation_no,
            $modelQuo->customer ? LbQuotation::model()->getViewParamModuleURL($modelQuo->customer->lb_customer_name,null,$modelQuo->lb_record_primary_key,"lbQuotation") :
            LbQuotation::model()->getViewParamModuleURL("No customer",null,$modelQuo->lb_record_primary_key,"lbQuotation"));
    echo '</div>';
}
 echo '</div>';
// company info
echo '<div class="pull-right" style="text-align: right; margin-right: 25px;width:60%">';
echo '<h3>'.(isset($model->owner) ? $model->owner->lb_customer_name : '').'</h3><br/>';
if (isset($model->owner) && $model->owner->lb_customer_registration)
	echo 'Registration No: ' . $model->owner->lb_customer_registration. '.&nbsp;';
if(isset($model->owner))
{
    echo (($model->owner->lb_customer_website_url!=NULL) ? 'Website: '.$model->owner->lb_customer_website_url.'<br>' : '');
}

$country_arr = LBApplicationUI::countriesDropdownData();
// supplier address and info
echo '<div id="container-supplier-contact" style="float: right; max-width: 600px;">';
if (isset($model->ownerAddress) && $model->ownerAddress)
{
	$ownCompanyAddress = $model->ownerAddress;
	
	// line 1
        echo '<div id="container-supplier-info-line-1" style="display: block">';
        echo 'Address: ' . $ownCompanyAddress->lb_customer_address_line_1;
        echo '.&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_line_2!=NULL)
                echo $ownCompanyAddress->lb_customer_address_line_2 . '.&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_city!=NULL)
                echo $ownCompanyAddress->lb_customer_address_city . '.&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_state!=NULL)
                echo $ownCompanyAddress->lb_customer_address_state . '.&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_country!=NULL)
                echo $country_arr[$ownCompanyAddress->lb_customer_address_country] . '&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_postal_code!=NULL)
                echo $ownCompanyAddress->lb_customer_address_postal_code;
        echo '</div>';

        // line 2
        echo '<div id="container-supplier-info-line-2" style="display: block">';
        if ($ownCompanyAddress->lb_customer_address_phone_1!=NULL)
                echo 'Phone: ' . $ownCompanyAddress->lb_customer_address_phone_1. '&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_fax!=NULL)
                echo 'Fax: ' . $ownCompanyAddress->lb_customer_address_fax. '&nbsp;';
        if ($ownCompanyAddress->lb_customer_address_email!=NULL)
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
echo '</div>';

echo '</div>'; // end header container div

?>
<script lang="javascript">
    $("#search_invoice").keypress(function (e) {
       var invoice_no = $('#search_invoice').val();
      
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {   
            window.open('<?php LbInvoice::model()->getActionModuleURL('default', 'view') ?>?invoice_no='+invoice_no);
        } 
    });
    </script>