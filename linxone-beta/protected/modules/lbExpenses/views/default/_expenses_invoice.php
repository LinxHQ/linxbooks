<?php
/* @var $expenses_invoice array of LbExpensesInvoice models */
$canAddInvoice = BasicPermission::model()->checkModules('lbInvoice', 'add');
$canAddDelete = BasicPermission::model()->checkModules('lbCustomer', 'delete');

if($canAddInvoice)
{
    echo '<div class="btn-toolbar">';
//        LBApplicationUI::newButton(Yii::t('lang','New Invoice'), array(      
//           'url'=>LbExpenses::model()->getActionURLNormalized('ExpensesNewInvoice',array('expenses_id'=>$expenses_id))
//            ));
        $this->widget('bootstrap.widgets.TbButton',array( 
           
            'label'=>'New Invoice',      
            'url'=>LbInvoice::model()->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE),'expenses_id'=>$expenses_id)),
        ));
        $this->widget('bootstrap.widgets.TbButton',array(
          
            'label'=>'Assign Invoice',      
            'htmlOptions'=>array(
                            'onclick'=>'assignInvoice();',
                            ),
        ));
    echo '</div>';
}

$i=0;
foreach ($expenses_invoice as $ex_invoice)
{
        $invoice = LbInvoice::model()->findByPk($ex_invoice->lb_invoice_id);
        if(count($invoice) > 0){
        $i++;
	echo "
                <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'>
                    <div style='float:left'>
                        <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span> ".LBApplication::workspaceLink($invoice->lb_invoice_no,
                            $invoice->customer ? $invoice->getViewURL($invoice->customer->lb_customer_name) : $invoice->getViewURL("No customer"))."</h4>
                    </div>";
        if($canAddDelete)
            echo       "<div style='float:right;margin-top:5px;'>
                            <a href='#' onclick='ajaxDeleteInvoiceExpenses(".$invoice->lb_record_primary_key."); return false;'>
                                <i class='icon-trash'></i>
                                Delete
                            </a>
                        </div>";
        
        echo    "</div>
                <div id='error_delete_expense_invoice_".$invoice->lb_record_primary_key."' class='alert alert-block alert-error' style='display:none;'></div>
            ";
        }
} // end for
//form assign invoice
    $this->beginWidget('bootstrap.widgets.TbModal',array('id'=>'modal-invoice-assign-form'));
    echo '<div class="modal-header" style="max-width:700px;">';
    echo '<a class="close" data-dismiss="modal">&times;</a>';
    echo '<h4>Assign Invoice</h4>';
    echo '</div>';
    
    echo '<div class="modal-body" style="max-height:500px" id="modal-view-invoice-body-'.$expenses_id.'">';    
    echo '</div>';
       
$this->endWidget();
 $this->widget('bootstrap.widget.TbButton', array(
        'type'=>'',
        'htmlOptions'=>array(
            'data-toggle'=>'modal',
            'data-target'=>'#modal-invoice-assign-form',
            'style'=>'display:none',
            'id'=>'btn_view_invoice',
        ),
    ));  

//end assign invoice
?>
<script>

    function ajaxDeleteInvoiceExpenses(id)
    {
        
        $.ajax({
            type:'POST',
            url: "<?php echo $this->createUrl('deleteInvoiceExpenses'); ?>",
            success:function(response){
                var responseJSON = jQuery.parseJSON(response);
                if(responseJSON!=null)
                {
                    $("#error_delete_expense_invoice_"+id).css("display","block");
                    $("#error_delete_expense_invoice_"+id).html(responseJSON.exist);
                }
                else
                {
                    
                    $('#tab2').load("<?php echo $this->createUrl('loadAjaxTabInvoice',array('id'=>$expenses_id)); ?>");
                }
            },
            data:{invoice_id:id,expenses_id:<?php echo $expenses_id ?>},
        });
    }
//    function assignInvoice(){
//        var modal_element = $("#modal-invoice-assign-form");
//        modal_element.find("#modal-header").html();
//        modal_element.find("#modal-view-invoice-body-").show();
//        modal_element.modal("show");
//    }
//    
    
    function assignInvoice(){
        $('#btn_view_invoice').click();
        $('#modal-view-invoice-body-'+<?php echo $expenses_id ?>).html(getLoadingIconHTML(false));
        $('#modal-view-invoice-body-'+<?php echo $expenses_id ?>).load("<?php echo LbExpenses::model()->getActionURLNormalized('AssignInvoice',array('form_type'=>'ajax','ajax'=>1,'expenses_id'=>$expenses_id))?>");
    }
    function refreshInvoice(){
         $('#tab2').load("<?php echo LbExpenses::model()->getActionURLNormalized('loadAjaxTabInvoice',array('id'=>$expenses_id)); ?>");
    }
</script>
