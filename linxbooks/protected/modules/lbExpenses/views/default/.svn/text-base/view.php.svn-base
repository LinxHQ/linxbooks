<?php
/* @var $this LbExpensesController */
/* @var $model LbExpenses */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canEdit = BasicPermission::model()->checkModules($m, 'update');
$canDelete = BasicPermission::model()->checkModules($m, 'delete');
$canView = BasicPermission::model()->checkModules($m, 'view');

if(!$canView)
{
    echo "Have no permission to see this record";
    return;
}
$templateDelete=false;
if($canDelete)
    $templateDelete = "{delete}";

$this->breadcrumbs=array(
	'Lb Expenses'=>array('index'),
	$model->lb_record_primary_key,
);

//$this->menu=array(
//	array('label'=>'List LbExpenses', 'url'=>array('index')),
//	array('label'=>'Create LbExpenses', 'url'=>array('create')),
//	array('label'=>'Update LbExpenses', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
//	array('label'=>'Delete LbExpenses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LbExpenses', 'url'=>array('admin')),
//);

// Customer

?>
<?php
echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>Expenses</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbExpenses::model()->getAdminURLNormalized());
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','New Expenses'),'url'=>  LbExpenses::model()->getActionURLNormalized('create')),
                        array('label'=>Yii::t('lang','New Payment Voucher'),'url'=> LbExpenses::model()->getActionURLNormalized('createPaymentVoucher')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';
?>


<div style="overflow: hidden;">
    <h3 style="line-height: 10px;"><?php echo Yii::t('lang','Expenses'); ?>: <?php echo $model->lb_expenses_no; ?></h3>
</div>

<?php
//var_dump(LbBankAccount::model()->getBankAccount(Yii::app()->user->id));
    echo '<div class="btn-toolbar">';
        
        //LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('admin'));
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>Yii::t('lang','Back'),
            'url'=>LbExpenses::model()->getActionURLNormalized('admin'),
        ));
        
        
//        LBApplicationUI::button('Print PDF');
    
    echo '</div><br/>';

//$this->widget('zii.widgets.CDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
//		'lb_record_primary_key',
//		'lb_category_id',
//		'lb_expenses_amount',
//		'lb_expenses_date',
//		'lb_expenses_recurring_id',
//		'lb_expenses_brank_account_id',
//		'lb_expenses_note',
//	),
//)); 
//echo '<div style="float: left; width: 49%;">';
    $this->widget('editable.EditableDetailView', array(
        'id' => 'expenses-detail',
        'data' => $model,
        'url' => $model->getActionURL('ajaxUpdateField'),
        'placement' => 'right',
        'attributes' => array(
            array(
                'name' => 'lb_expenses_no',
                'editable' => false,
            ),
            array(
                'name' => 'lb_category_id',
                'editable' => array(
                    'type' => 'select',
                    'source' => CHtml::listData(SystemList::model()->getItemsForListCode('expenses_category'), 'system_list_item_id', 'system_list_item_name')
                )
            ),
            array(
                'name' => 'lb_expenses_date',
                'editable' => array(
                    'type' => 'date',
                    'viewformat' => 'dd-mm-yyyy',
                    'format'=>'yyyy-mm-dd',
                )
            ),
            'lb_expenses_amount',
            array(
                'name' => 'lb_expenses_note',
                'editable' => array(
                    'type' => 'textarea',
                )
            ),
            array(
                'name' => 'lb_expenses_recurring_id',
                'editable' => array(
                    'type' => 'select',
                    'source' => array(''=>'Choose Recurring')+CHtml::listData(SystemList::model()->getItemsForListCode('recurring'), 'system_list_item_code', 'system_list_item_name')
                )
            ),
            array(
                'name' => 'lb_expenses_bank_account_id',
                'editable' => array(
                    'type' => 'select',
                    'source' => array(''=>'Choose bank account')+CHtml::listData(LbBankAccount::model()->getBankAccount(Yii::app()->user->id), 'lb_record_primary_key', 'lb_bank_account')
                )
            ),
            
        )
    ));
    
    $customers = LbExpensesCustomer::model()->getCustomerExpenses($model->lb_record_primary_key);
    $customer_view = '';
    if (count($customers) > 0) {
        foreach ($customers as $cus) {
            $client = LbCustomer::model()->findByPk($cus->lb_customer_id);
            $customer_view .= $client['lb_customer_name'].'; ';
        }
    }
    $invoices = LbExpensesInvoice::model()->getExpensesInvoice($model->lb_record_primary_key);
    $invoice_view = '';
    if (count($invoices) > 0) {
        foreach ($invoices as $inv) {
            $invoice = LbInvoice::model()->findByPk($inv->lb_invoice_id);
            $invoice_view .= $invoice['lb_invoice_no'].'; ';
        }
    }
//    echo '</div><div style="float: right; width: 49%;">';

//    echo '</div>';
    
?>
    <div style="margin-top: 30px;">
    <h4><?php echo Yii::t('lang','Document'); ?></h4>
    <?php
        $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb-expenses-documnet_grid',
            'dataProvider'=> LbDocument::model()->getDocumentParentTypeProvider(LbDocument::LB_DOCUMENT_PARENT_TYPE_EXPENSES, $model->lb_record_primary_key),
            'template'=>'{items}',
            'hideHeader'=>true,
            'htmlOptions'=>array('width'=>'500'),
            'columns'=>array(
                array(
                    'type'=>'raw',
                    'value'=>'"<a href=\'".Yii::app()->getBaseUrl().$data->lb_document_url."\'><img width=\'100px;\' border=\'0\' alt=\'\' src=\'".Yii::app()->getBaseUrl().$data->lb_document_url."\' />".$data->lb_document_name."</a>"',
                ),
                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'template'=>$templateDelete,
                    'deleteButtonUrl'=>'Yii::app()->createUrl("lbExpenses/default/deleteDocument",array("id"=>$data->lb_record_primary_key))',
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
                                        $.fn.yiiGridView.update('lb-expenses-documnet_grid');
                                        $('#uploadFile .qq-upload-list').html('');
                                   }",
                              )
                )); 
            ?>
    </div>
</div>
<?php
/**
 * Show tabs of other details: address, contact, invoice
 */
$tab_customer = LBApplication::renderPartial($this, '_expenses_customer', array(
		'expenses_customer'=>$customerExpenses,
                'expenses_id'=>$model->lb_record_primary_key,
		),true);
$tab_invoice = LBApplication::renderPartial($this, '_expenses_invoice', array(
		'expenses_invoice'=>$invoiceExpenses,
                'expenses_id'=>$model->lb_record_primary_key,
		),true);

$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'tabs', // 'tabs' or 'pills'
		'encodeLabel'=>false,
		'tabs'=> 
		array(
				array('id'=>'tab1','label'=>'<i class="icon-user"></i> <strong>'.Yii::t('lang','Customers').'</strong>', 
						'content'=> $tab_customer,
						'active'=>true),
				array('id'=>'tab2','label'=>'<i class="icon-file"></i> <strong>'.Yii::t('lang','Invoices').'</strong>',
						'content'=>$tab_invoice,
						'active'=>false),
				array('id'=>'tab3','label'=>'<i class="icon-file"></i> <strong>'.Yii::t('lang','Taxes').'</strong>',
						'content'=>  LBApplication::renderPartial($this, '_view_tax_expenses', array(
                                                                    'model'=>$model,
                                                                ),true),
						'active'=>false),
				)
));
?>
