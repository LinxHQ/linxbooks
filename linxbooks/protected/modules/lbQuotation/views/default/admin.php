<?php
$m = $this->module->id;
$canList = BasicPermission::model()->checkModules($m, 'list');
$canAdd = BasicPermission::model()->checkModules($m, 'add');

?>

<?php

echo '<div id="lb-container-header">';
            echo '<div class="lb-header-right" ><h3>'.Yii::t('lang','Quotation').'</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbInvoice::model()->getActionURLNormalized("dashboard"));
            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i>'.Yii::t('lang','New'), 'items' => array(
                            array('label' => Yii::t('lang','New Invoice'), 'url' =>  LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))),
                                    'visib'),
                            array('label' => Yii::t('lang','New Quotation'), 'url' => LbQuotation::model()->getCreateURLNormalized()),
                    )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div>';
echo '<br>';

// SEARCH
echo '<div style="text-align:right;width:100%">';
    echo 'Status: '.CHtml::dropDownList('status_quo_id', $status_id,
    LbQuotation::model()->getArrayStatusQuotation(), array('empty' => 'All','onchange'=>'search_quotation();return false;'));
echo '</div>';
// END SEARCH

echo '<div id="quotation_more_grid">';
$this->widget('bootstrap.widgets.TbGridView',  array(
                'id'=>'lb-quotation-grid',
                'dataProvider'=>$model->search($canList,$status_id),
                'filter'=>$model,
                'columns'=>array(
                    array(
                        'name'=>'lb_quotation_no',
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->lb_quotation_no,
                            $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
                        'htmlOptions'=>array('width'=>'100'),
                        'headerHtmlOptions'=>array('width'=>'100'),
                        'filter' => CHtml::activeTextField($model, 'lb_quotation_no', array('class' => 'input-mini')),
                   ),
                    array(
                        'name'=>'lb_quotation_customer_id',
                        'type'=>'raw',
                        'value'=>'($data->customer ?
					LBApplication::workspaceLink( $data->customer->lb_customer_name, $data->getViewURL($data->customer->lb_customer_name) )
					:LBApplication::workspaceLink("No customer", $data->getViewURL("No customer") )
				)."<br><span style=\'color:#666;\'>". $data->lb_quotation_subject."</span>"',
                         'htmlOptions'=>array('width'=>'250'),
                        'headerHtmlOptions'=>array('width'=>'300'),
                        'filter'=>  CHtml::listData(LbQuotation::model()->with('customer')->findAll(), 'lb_quotation_customer_id', 'customer.lb_customer_name'),                
                   ),
                    array(
                        'name'=>'lb_quotation_date',
                        'value'=>'$data->lb_quotation_date',
                        'headerHtmlOptions'=>array('width'=>'80'),
                        'filter' => CHtml::activeTextField($model, 'lb_quotation_date', array('class' => 'input-mini')),
                   ),
                    array(
                        'name'=>'lb_quotation_due_date',
                        'value'=>'$data->lb_quotation_due_date',
                        'headerHtmlOptions'=>array('width'=>'100'),
                        'filter' => CHtml::activeTextField($model, 'lb_quotation_due_date', array('class' => 'input-mini')),
                   ),
                    array(
                        'header'=>Yii::t('lang','Amount'),
                        'type'=>'raw',
                        'value'=>'$data->quotationTotal ? LbInvoice::CURRENCY_SYMBOL.$data->quotationTotal->lb_quotation_total_after_total : "{LbInvoice::CURRENCY_SYMBOL}0,00"',
                        'htmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                        'headerHtmlOptions'=>array('width'=>'90','style'=>'text-align:right'),
                    ),
                    array(
                        'name'=>'lb_quotation_status',
                        'type'=>'raw',
                        'value'=>'lbQuotation::model()->getDisplayQuotationStatus($data->lb_quotation_status)',
                        'htmlOptions'=>array('width'=>'100'),
                        'filter' =>false,
                    ),
                    array(
                        'header'=>'Create By',
                        'type'=>'raw',
                        'value'=>'(AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbQuotation::model()->module_name,$data->lb_record_primary_key)->lb_created_by)) ? AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbQuotation::model()->module_name,$data->lb_record_primary_key)->lb_created_by) : ""',
                    ),
//                  array(
//			'class'=>'CButtonColumn',
//                        'buttons'=>array(
//                            'delete'=>array(
//                                       'visible'=>'$data->lb_quotation_status==LbQuotation::LB_QUOTATION_STATUS_CODE_DRAFT',
//                    ))
//                            ),
                ),
    
            ));
echo "</div>";
?>

<script type="text/javascript">
    function search_quotation()
    {
        var status_id = $('#status_quo_id').val();
        open('<?php echo LbQuotation::model()->getAdminURLNormalized(); ?>?status_id='+status_id,'_self');
    }
</script>

