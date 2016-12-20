<?php
/* @var $this LbContractsController */
/* @var $model LbContracts */

$m = $this->module->id;
$canView = BasicPermission::model()->checkModules($m, 'view');
$canEdit = BasicPermission::model()->checkModules($m, 'edit');
$canAddInvoice = BasicPermission::model()->checkModules('lbInvoice', 'add');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}
    
//$this->breadcrumbs=array(
//	'Lb Contracts'=>array('index'),
//	$model->lb_record_primary_key,
//);

//$this->menu=array(
//	array('label'=>'List LbContracts', 'url'=>array('index')),
//	array('label'=>'Create LbContracts', 'url'=>array('create')),
//	array('label'=>'Update LbContracts', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
//	array('label'=>'Delete LbContracts', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LbContracts', 'url'=>array('admin')),
//);
//?>
<?php
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px"><h3>Contracts</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbContracts::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New Contract'), 'url'=>$this->createUrl('create') ),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><Br>';
?>
<div style="overflow: hidden; clear: both;">
    <div style="float: left;width: 300px;"><span style="font-size:16px;"><b>Contract: <?php echo $model->lb_contract_no; ?></b></span></div>
   <div style="text-align: right;"><span style="font-size:16px;"><b><?php echo $model->customer->lb_customer_name; ?></span></div>
</div>
<?php
    if($canEdit)
    {
        echo '<div class="btn-toolbar">';

            $this->widget('bootstrap.widgets.TbButton', array(
               'url'=>$this->createUrl('renew',array('id'=>$model->lb_record_primary_key)),
               'label'=>'<icon class=\'icon-refresh\'></icon> '.Yii::t('lang','Renew Contract'),
               'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'encodeLabel'=>false,
            )); 
            echo CHtml::ajaxSubmitButton(Yii::t('lang','Cancel Contract'),
                            $this->createUrl('ajaxUpdateStatusContract',array('id'=>$model->lb_record_primary_key,'status_update'=> LbContracts::LB_CONTRACT_STATUS_NO_ACTIVE)), 
                            array(
                                    'beforeSend' => 'function(data){
                                            if(confirm("You want to cancel contract?"))
                                                return true;
                                            return false
                                    } ',
                                    'success' => 'function(data, status, obj) {
                                       // code...
                                    }'
                            ),
                            array('class'=>'btn','id'=>'ajax_contract_update_cancel_contract_'.$model->lb_record_primary_key));

            echo CHtml::ajaxSubmitButton(Yii::t('lang','End Contract'),
                            $this->createUrl('ajaxUpdateStatusContract',array('id'=>$model->lb_record_primary_key,'status_update'=> LbContracts::LB_CONTRACT_STATUS_END)), 
                            array(
                                    'beforeSend' => 'function(data){
                                            if(confirm("You want to end contract?"))
                                                return true;
                                            return false
                                    } ',
                                    'success' => 'function(data, status, obj) {
                                       // code...
                                    }'
                            ),
                            array('class'=>'btn','id'=>'ajax_contract_update_end_contract_'.$model->lb_record_primary_key));
        echo '</div>';
    }
?>
<br>
<h4><?php echo Yii::t('lang','Detail'); ?></h4>
<?php 
//$this->widget('bootstrap.widgets.TbDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
//		array(
//                    'label'=>'Customer',
//                    'value'=>$model->customer->lb_customer_name,
//                ),
//		array(
//                    'label'=>'Address',
//                    'value'=>($model->customer_address) ? $model->customer_address->lb_customer_address_line_1 : "",
//                ),
//		array(
//                    'label'=>'Contact',
//                    'value'=>($model->customer_contact) ? $model->customer_contact->lb_customer_contact_first_name." ". $model->customer_contact->lb_customer_contact_last_name : "",
//                ),
//		array(
//                    'label'=>'Date Start',
//                    'value'=>  date('d-M-Y', strtotime($model->lb_contract_date_start)),
//                ),
//		array(
//                    'label'=>'Date End',
//                    'value'=>date('d-M-Y', strtotime($model->lb_contract_date_end)),
//                ),
//                array(
//                    'class' => 'editable.EditableColumn',
//                    'name'=>'Contract Type',
//                    'value'=>$model->lb_contract_type,
//                    'editable' => array(
//                               'url'        => $model->getActionURLNormalized('ajaxUpdateField'),
//                               'placement'  => 'right',
//                               'inputclass' => 'span3',
//                               'name'=>'lb_contract_type',
//                             ),
//                ),
//                array(
//                    'name'=>'Contract Note',
//                    'value'=>$model->lb_contract_notes,
//                ),
//                array(
//                    'name'=>'Status',
//                    'value'=>$model->lb_contract_status,
//                ),
//                array(
//                    'name'=>'Contact Amount',
//                    'value'=>  number_format($model->lb_contract_amount, 2),
//                )
////		'lb_customer_id',
////		'lb_address_id',
////		'lb_contact_id',
////		'lb_contract_no',
////		'lb_contract_notes',
////		'lb_contract_date_start',
////		'lb_contract_date_end',
////		'lb_contract_type',
////		'lb_contract_amount',
////		'lb_contract_parent',
////		'lb_contract_status',
//	),
//)); 
?>
<?php
    $this->widget('editable.EditableDetailView', array(
        'id' => 'user-details',
        'data' => $model,
        'url'   => $model->getActionURL('ajaxUpdateField'), //common submit url for all editables
        'placement'     => 'right',
        'attributes'=>array(
            array( //select loaded from database
                'name' => 'lb_customer_id',
                'editable' => array(
                'type' => 'select',
                'source' => CHtml::listData(LbCustomer::model()->findAll(), 'lb_record_primary_key', 'lb_customer_name')
                )
           ),
            array( //select loaded from database
                'name' => 'lb_address_id',
                'editable' => array(
                'type' => 'select',
                'source' => CHtml::listData(LbCustomerAddress::model()->findAll(), 'lb_record_primary_key', 'lb_customer_address_line_1')
                )
           ),
            array( //select loaded from database
                'name' => 'lb_contact_id',
                'editable' => array(
                'type' => 'select',
                'source' => CHtml::listData(LbCustomerContact::model()->getResultsAsFindAll(), 'lb_record_primary_key', 'lb_customer_contract_name')
                )
           ),
//            array(
//                'name'=>'lb_contract_date_start',
//                'value'=>date('d-M-Y', strtotime($model->lb_contract_date_start)),
//            ),
            array(
                'name' => 'lb_contract_date_start',
                         'editable' => array(
                             'type' => 'date',
                             'viewformat' => 'dd-mm-yyyy',
                             'format'=>'yyyy-mm-dd',
                         )
           ),
            array(
                'name' => 'lb_contract_date_end',
                         'editable' => array(
                             'type' => 'date',
                             'viewformat' => 'dd-mm-yyyy',
                             'format'=>'yyyy-mm-dd',
                         )
           ),
            array( //select loaded from database
                'name' => 'lb_contract_type',
                'editable' => array(
                    'type' => 'text',
                )
           ),
            array( //select loaded from database
                'name' => 'lb_contract_notes',
                'editable' => array(
                    'type' => 'textarea',
                )
           ),
            array( //select loaded from database
                'name' => 'lb_contract_status',
                'editable' => array(
                    'type' => 'select',
                    'source'=>  LbContracts::$ContractStatusArray,
                ),
            ),
           'lb_contract_amount',
        ),

    ));
?>
<div style="margin-top: 30px;">
    <h4><?php echo Yii::t('lang','Document'); ?></h4>
    <?php
        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb-contracts-documnet_grid',
            'dataProvider'=>  LbContractDocument::model()->getContractDocument($model->lb_record_primary_key),
            'template'=>'{items}',
            'hideHeader'=>true,
            'htmlOptions'=>array('width'=>'500'),
            'columns'=>array(
                array(
                    'type'=>'raw',
                    'value'=>'"<a href=\'".Yii::app()->getBaseUrl().$data->lb_document_url."\'><img border=\'0\' alt=\'\' src=\'".Yii::app()->getBaseUrl().$data->lb_document_url_icon."\' />".$data->lb_document_name."</a>"',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>"{delete}",
                    'deleteButtonUrl'=>'Yii::app()->createUrl("lbContract/default/deleteDocument",array("id"=>$data->lb_record_primary_key))',
                    'htmlOptions'=>array('width'=>'20'),
                ),
            ),
        ));
    ?>
    <div>
            <?php 
                if($canEdit)
                    $this->widget('ext.EAjaxUpload.EAjaxUpload',
                    array(
                            'id'=>'uploadFile',
                            'config'=>array(
                                   'action'=>$this->createUrl('uploadDocument',array('id'=>$model->lb_record_primary_key)),
                                   'allowedExtensions'=>array("jpeg","jpg","gif","png","pdf","odt","docx","doc","dia"),//array("jpg","jpeg","gif","exe","mov" and etc...
                                   'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                                   'minSizeLimit'=>1*1024,// minimum file size in bytes
                                   'onComplete'=>"js:function(id, fileName, responseJSON){
                                            $.fn.yiiGridView.update('lb-contracts-documnet_grid');
                                            $('#uploadFile .qq-upload-list').html('');
                                       }",
                                   //'messages'=>array(
                                   //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                   //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                   //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                   //                  'emptyError'=>"{file} is empty, please select files again without it.",
                                   //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                   //                 ),
                                   //'showMessage'=>"js:function(message){ alert(message); }"
                                  )
                    )); 
            ?>
    </div>
</div>
<div style="margin-top: 30px;">
    <div style="margin-top: 40px;" class="panel-header-title">
        <div class="panel-header-title-left" style="width: 20%">
            <h4><?php echo Yii::t('lang','Related Invoice'); ?></h4>
        </div>
        <div class="panel-header-title-right">
            <?php if($canAddInvoice && $canEdit) { ?>
                <a href="<?php echo $this->createUrl('createInvoice',array('id'=>$model->lb_record_primary_key)) ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Invoice'); ?></a>
            <?php } ?>
        </div>
    </div>
    <?php
        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb-contracts-invoice_grid',
            'type'=>'striped bordered condensed',
            'dataProvider'=> LbContractInvoice::model()->getContractInvoice($model->lb_record_primary_key),
            'template'=>'{items}',
            'htmlOptions'=>array('width'=>'500'),
            'columns'=>array(
                array(
                    'header'=>Yii::t('lang','Invoice No'),
                    'type'=>'raw',
                    'value'=>'
                            LBApplication::workspaceLink($data->invoice->lb_invoice_no,  LbInvoice::model()->getViewInvoiceURL($data->invoice->lb_record_primary_key,$data->invoice->customer->lb_customer_name));
                        ',
                ),
                array(
                    'header'=>Yii::t('lang','Date'),
                    'type'=>'raw',
                    'value'=>'$data->invoice->lb_invoice_date',
                ),
                array(
                    'header'=>Yii::t('lang','Due Date'),
                    'type'=>'raw',
                    'value'=>'$data->invoice->lb_invoice_due_date',
                ),
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'$data->invoice->total_invoice->lb_invoice_total_after_taxes',
                ),
                array(
                    'header'=>Yii::t('lang','Paid'),
                    'type'=>'raw',
                    'value'=>'$data->invoice->total_invoice->lb_invoice_total_paid',
                ),
                array(
                    'header'=>Yii::t('lang','Outstanding'),
                    'type'=>'raw',
                    'value'=>'$data->invoice->total_invoice->lb_invoice_total_outstanding',
                ),
            ),
        ));
    ?>
</div>
