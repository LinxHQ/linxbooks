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
<?php // echo $model->lb_record_primary_key; 
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>Bills</h3></div>';
            echo '<div class="lb-header-left" style="margin-right:0px;">';
            LBApplicationUI::backButton(LbVendor::model()->getActionURLNormalized('dashboard'));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-th-large"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','Print PDF'),'url'=>  LbVendor::model()->getActionURL('Vendorpdf',array('id'=>$model->lb_record_primary_key))),
                        array('label'=>Yii::t('lang','Get Public URL'),'url'=> '#','linxOptions'=>array('onclick'=>'onclickFormGetPublicPDF();return false;')),
                        array('label'=>Yii::t('lang','Create Invoice'),'url'=> '#','linxOptions'=>array('onclick'=>'onclickCopyQuotationToInvoice();return false;')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';
?>


<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $ownCompany LbCustomer */

// header container div
echo '<div id="invoice-header-container" class="container-header" style="position: relative">';



//echo $model->lb_vendor_company_id;
echo '<div id="logo_wrapper" style="overflow:hidden;text-align: center;">';

//            $company = (isset($model->owner) ? $model->lb_vendor_company_id : '');
                        $folder ='images/logo/';
//            $model=LbVendor::model()->findByPk($id);
            $company = $model->lb_vendor_company_id;
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
//echo '<h3 id="po-number-container">'.$model->getDisplayPOStatus($model->lb_vendor_status).'</h3>';
echo '<div id="invoice-basic-info-container" style="float: left;width:36%;">';
echo '<h3 id="po-number-container">'.$model->lb_vendor_no.'</h3><br />';

//date
echo Yii::t('lang','PO Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'text',
		'model'     => $model,
		'attribute' => 'lb_vendor_date',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'placement' => 'right',
));
echo '&nbsp;';
echo Yii::t('lang','Due Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'text',
		'model'     => $model,
		'attribute' => 'lb_vendor_due_date',
		'url'       => $model->getActionURLNormalized('ajaxUpdateField'),
		'placement' => 'right',
));

echo '<br>';

echo '<div>';

echo Yii::t('lang','Status').': ';
$this->widget('editable.EditableField', array(
    'type' => 'select',
    'model' => $model,
    'attribute' => 'lb_vendor_status',
    'htmlOptions'=>array('id'=>'lb_invocie_status'),
    'url' => $model->getActionURLNormalized('ajaxUpdateField'),
    //'source' => Editable::source(Status::model()->findAll(), 'status_id', 'status_text'),
    //or you can use plain arrays:
    'source' => Editable::source(array(LbVendor::LB_PO_STATUS_CODE_DRAFT => LbVendor::model()->getDisplayPOStatus(LbVendor::LB_PO_STATUS_CODE_DRAFT),
                                        LbVendor::LB_PO_STATUS_CODE_APPROVED=> LbVendor::model()->getDisplayPOStatus(LbVendor::LB_PO_STATUS_CODE_APPROVED),
                                        LbVendor::LB_PO_STATUS_CODE_SEND => LbVendor::model()->getDisplayPOStatus(LbVendor::LB_PO_STATUS_CODE_SEND ),
                                        LbVendor::LB_PO_STATUS_CODE_ACCEPTED=> LbVendor::model()->getDisplayPOStatus(LbVendor::LB_PO_STATUS_CODE_ACCEPTED),
                                        LbVendor::LB_PO_STATUS_CODE_REJECTED=> LbVendor::model()->getDisplayPOStatus(LbVendor::LB_PO_STATUS_CODE_REJECTED),)),
    'placement' => 'right',
    'validate' => 'js: function(value) {
                        if(quotation_status_draft) 
                            return "Please confirm quotation.";
                        else if(value=="'.  LbVendor::LB_PO_STATUS_CODE_DRAFT.'")
                            return "You\'re not allowed to update the status of this quotation back to Draft";
                   }',
    'success' => 'js: function(response, newValue) {
        if(newValue == "'.  LbVendor::LB_PO_STATUS_CODE_ACCEPTED.'")
        {
            quotaiton_status_accepted = true;
        }
        else
        {
            quotaiton_status_accepted = false;
        }
        $("#lb_invocie_status").html(newValue);
    }'
));


echo '</div>';echo '</div>';
echo '<div class="pull-right" style="text-align: right; margin-right: 25px;width:60%">';
$modelCustomer = LbCustomer::model()->find('lb_record_primary_key='.$model->lb_vendor_company_id);
echo '<h3>'.$modelCustomer->lb_customer_name.'</h3><br/>';
echo 'Registration No: ' . $modelCustomer->lb_customer_registration. '.&nbsp;';
echo (($modelCustomer->lb_customer_website_url!=NULL) ? 'Website: '.$modelCustomer->lb_customer_website_url.'<br>' : '');


echo '</div>'
// Invoice number, date and due
?>
