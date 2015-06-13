<?php
/* @var $expenses_invoice array of LbExpensesInvoice models */
$canAddInvoice = BasicPermission::model()->checkModules('lbInvoice', 'add');
$canAddDelete = BasicPermission::model()->checkModules('lbCustomer', 'delete');

if($canAddInvoice)
{
    echo '<div class="btn-toolbar">';
        LBApplicationUI::newButton(Yii::t('lang','New Invoice'), array('url'=>$this->createUrl('addInvoice')));
    echo '</div>';
}

$i=0;
foreach ($expenses_invoice as $ex_invoice)
{
        $invoice = LbInvoice::model()->findByPk($ex_invoice->lb_invoice_id);
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
} // end for
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
    
</script>
