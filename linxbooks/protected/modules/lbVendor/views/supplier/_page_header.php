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
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbVendor::model()->getActionURLNormalized('dashboard'));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-th-large"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','Print PDF'),'url'=> '#'),
                        array('label'=>Yii::t('lang','Get Public URL'),'url'=> '#','linkOptions'=>array()),
                        array('label'=>Yii::t('lang','Enter Payment'),'url'=> LbVendor::model()->getActionModuleURL('vendor', 'addPayment'),'linkOptions'=>array()),
//                        array('label'=>Yii::t('lang','Create Invoice'),'url'=> '#','linkOptions'=>array()),
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
            $company = $model->lb_vd_invoice_company_id;
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
echo '<h3 id="po-number-container">';

$this->widget('editable.EditableField', array(
		'type'      => 'text',
		'model'     => $model,
               
		'attribute' => 'lb_vd_invoice_no',
		'url'       => LbVendor::model()->getActionURLNormalized('AjaxUpdateFieldVD'),
		'placement' => 'right',
));
echo '</h3><br />';

//date
echo Yii::t('lang','Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'text',
		'model'     => $model,
		'attribute' => 'lb_vd_invoice_date',
		'url'       => LbVendor::model()->getActionURLNormalized('ajaxUpdateFieldInvoice'),
		'placement' => 'right',
));
echo '&nbsp;';
echo Yii::t('lang','Due Date').': ';
$this->widget('editable.EditableField', array(
		'type'      => 'text',
		'model'     => $model,
		'attribute' => 'lb_vd_invoice_due_date',
		'url'       => LbVendor::model()->getActionURLNormalized('ajaxUpdateFieldInvoice'),
		'placement' => 'right',
));

echo '<br>';

echo '<div>';
echo Yii::t('lang','Status').': ';
echo '<span id="lb_invocie_status">';
echo $model->getDisplayInvoiceStatus($model->lb_vd_invoice_status);
echo '</span>';

echo '</div>';echo '</div>';
echo '<div class="pull-right" style="text-align: right; margin-right: 25px;width:60%">';
$modelCustomer = LbCustomer::model()->find('lb_record_primary_key='.$model->lb_vd_invoice_company_id);
echo '<h3>'.$modelCustomer->lb_customer_name.'</h3><br/>';
echo 'Registration No: ' . $modelCustomer->lb_customer_registration. '.&nbsp;';
echo (($modelCustomer->lb_customer_website_url!=NULL) ? 'Website: '.$modelCustomer->lb_customer_website_url.'<br>' : '');


echo '</div>'
// Invoice number, date and due
?>
