<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
");
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'lb-invoice-grid',
	'dataProvider'=>$invoiceModel->search(),
	'filter'=>$invoiceModel, 
	'columns'=>array(
		array(
                    'name'=>'check',
                    'class'=>'CCheckBoxColumn',
                    'id'=>'selectedIds',
                    'value'=>'$data->lb_record_primary_key',
                    'selectableRows'=>'100',
                    'htmlOptions'=>array('width'=>'3px'),
                    'checkBoxHtmlOptions'=>array("name"=>"invoice_id[]"),
                ),
                array(
                    'name'=>'lb_invoice_no',
                    'type'=>'raw',
                    'value'=>'LBApplication::workspaceLink($data->lb_invoice_no,
                        $data->customer ? $data->getViewURL($data->customer->lb_customer_name) : $data->getViewURL("No customer"))',
                    'htmlOptions'=>array('width'=>'50'),
                    'headerHtmlOptions'=>array('width'=>'50'),
                    'filter' => CHtml::activeTextField($invoiceModel, 'lb_invoice_no', array('class' => 'input-mini','style'=>'width:80%')),
                ),
		
                array(
                    'header'=>Yii::t('lang','Amount'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_after_taxes : "0.00")',
                    'htmlOptions'=>array('width'=>'50','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'50','style'=>'text-align:right'),
                ),
                array(
                    'header'=>Yii::t('lang','Outstanding'),
                    'type'=>'raw',
                    'value'=>'($data->total_invoice ? LbInvoice::CURRENCY_SYMBOL.$data->total_invoice->lb_invoice_total_outstanding : "0.00")',
                    'htmlOptions'=>array('width'=>'50','style'=>'text-align:right'),
                    'headerHtmlOptions'=>array('width'=>'50','style'=>'text-align:right'),
                ),
               
		
	),
)); 
echo '<br/><br/><br/>';
LBApplicationUI::submitButton('Save',array(
    'htmlOptions'=>array(
        'onclick'=>'SaveInvoice();',
    ),
));
echo '&nbsp&nbsp&nbsp';
LBApplicationUI::submitButton('Close',array(
    'htmlOptions'=>array(
        'data-dismiss'=>'modal'
    ),
));
?>
<script>
    function SaveInvoice(){
         var invoice_id = $("input[type]:checked").serialize();
        $.post("<?php echo LbExpenses::model()->getActionURLNormalized('AssignInvoice',array('expenses_id'=>$expensesModel->lb_record_primary_key))?>",invoice_id);
        refreshInvoice();
        $("#modal-invoice-assign-form").modal("hide");
    }
</script>