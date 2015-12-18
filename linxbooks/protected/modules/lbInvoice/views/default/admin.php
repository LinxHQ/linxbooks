<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
$canQuotationAdd = BasicPermission::model()->checkModules('LbQuotation','add');
$canPaymentAdd = BasicPermission::model()->checkModules('LbPayment','add');

/**
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lb-invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");**/

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" style="margin-left:-11px;"><h4>Invoices</h4></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> New', 'items' => array(
                            array('label' => 'New Invoice', 'url' =>  LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE)))),
                            array('label' => 'New Quotation', 'url' => LbQuotation::model()->getCreateURLNormalized()),
                    )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';
echo '<br>';
// Buttons
//echo '<div class="btn-toolbar">';
//if($canAdd)
//    LBApplicationUI::newButton(Yii::t('lang','New Invoice'), array(
//            'url'=>$model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
//    ));
//if($canQuotationAdd)
//    LBApplicationUI::newButton(Yii::t('lang','New Quotation'));
//if($canPaymentAdd)
//    LBApplicationUI::newButton(Yii::t('lang','New Payment'),array('url'=> Yii::app()->createAbsoluteUrl('lbPayment/default/create')));
//echo '</div><br>';

// END BUTTON ADD
// SEARCH
echo '<div style="text-align:right;width:100%">';
    echo 'Status: '.CHtml::dropDownList('status_inv_id', $status_id,
     LbInvoice::model()->getArrayStatusInvoice(), array('empty' => 'All','onchange'=>'search_invoice();return false;'));
echo '</div>';
// END SEARCH
echo '<div id="container_error" class="alert alert-block alert-error" style="display:none;"></div>';
echo '<div id="invoice_more_date">';
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-invoice-grid',
	'dataProvider'=>$model->search($canList,$status_id),
	'filter'=>$model, 
	'columns'=>array(
		//'lb_record_primary_key',
		//'lb_invoice_group',
		//'lb_generated_from_quotation_id',
		//'lb_invoice_no',
        array(
            'name'=>'lb_invoice_no',
            'type'=>'raw',
            'value'=>'LBApplication::workspaceLink($data->lb_invoice_no,
                $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
            'htmlOptions'=>array('width'=>'100'),
            'headerHtmlOptions'=>array('width'=>'100'),
            'filter' => CHtml::activeTextField($model, 'lb_invoice_no', array('class' => 'input-mini','style'=>'width:80%')),
        ),
		array(
                //    'name'=>'customer.lb_customer_name',
                        'name'=>'lb_invoice_customer_id',
                                'type'=>'raw',
                                'value'=>'
                                        ($data->customer ?
                                                LBApplication::workspaceLink( $data->customer->lb_customer_name, $data->getViewURL($data->customer->lb_customer_name) )
                                                :LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
                                        )."<br><span style=\'color:#666;\'>". $data->lb_invoice_subject."</span>"
                                        ',
                        'filter'=>  CHtml::listData(LbInvoice::model()->with('customer')->findAll(), 'lb_invoice_customer_id', 'customer.lb_customer_name'),                
                    //    'filter'=>  CHtml::activeTextField(LbInvoice::model()->with('customer')->findAll(), 'lb_invoice_customer_id', 'customer.lb_customer_name'),                
		),
                array(
                    'name'=>'lb_invoice_date',
                    'value'=>'$data->lb_invoice_date',
                    'htmlOptions'=>array('width'=>'100'),
                    'filter' => CHtml::activeTextField($model, 'lb_invoice_date', array('class' => 'input-mini')),
                ),
                array(
                    'name'=>'lb_invoice_due_date',
                    'value'=>'$data->lb_invoice_due_date',
                    'htmlOptions'=>array('width'=>'100'),
                    'filter' => CHtml::activeTextField($model, 'lb_invoice_due_date', array('class' => 'input-mini')),
                ),
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_after_taxes : "0.00")',
                    'htmlOptions'=>array('width'=>'100','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                ),
                array(
                    'header'=>Yii::t('lang','Outstanding'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_outstanding : "0.00")',
                    'htmlOptions'=>array('width'=>'100','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                ),
                array(
                    'name'=>'lb_invoice_status_code',
                    'type'=>'raw',
                    'value'=>'lbInvoice::model()->getDisPlayInvoiceStatus($data->lb_invoice_status_code)',
                    'htmlOptions'=>array('width'=>'55'),
                    'filter' =>false,
                ),
               array(
                        'header'=>Yii::t('lang','Created By'),
                        'type'=>'raw',
                        'value'=>'AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name,$data->lb_record_primary_key)->lb_created_by)',
                        'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:center'),
                    ),
		/*
		'lb_invoice_company_id',
		'lb_invoice_company_address_id',
		'lb_invoice_customer_id',
		'lb_invoice_customer_address_id',
		'lb_invoice_attention_contact_id',
		'lb_invoice_subject',
		'lb_invoice_note',
		'lb_invoice_status_code',
		*/
//		array(
//			'class'=>'CButtonColumn',
//                            'buttons'=>array(
//                               'delete'=>array(
//                                   'visible'=>'$data->lb_invoice_status_code==LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT',
//                            )),
//		),
	),
)); 
echo '</div>';
//echo '<div id="test">';
//    $status_id="234";
//    (isset($_POST["status_id"])) ? $status_id=$_POST["status_id"] : $status_id="";
//    echo $status_id;
//echo '</div>';
?>
<script type="text/javascript">
    function search_invoice()
    {
        var status_id = $('#status_inv_id').val();
        open('<?php echo LbInvoice::model()->getAdminURLNormalized(); ?>?status_id='+status_id,'_self');
    }
</script>

