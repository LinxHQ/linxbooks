<?php
/*
 * @var $model LbInvoice
 */


$expenses_id = ($model->lb_record_primary_key);

$ex_tax = LbExpensesTax::model()->findAll('lb_expenses_id='.$expenses_id);

$i=0;
foreach ($ex_tax as $ex_invoice)
{
       $tax = LbTax::model()->findByPk($ex_invoice['lb_tax_id']);
        $i++;
	echo "
                <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'>
                    <div style='float:left;width:44%;'>
                        <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span> ".$tax['lb_tax_name'].' '.$tax['lb_tax_value']."
                            <span style='float:right'>$".number_format($ex_invoice['lb_expenses_tax_total'],2,'.',',')."</span></h4>
                    </div>";
          
            echo       "<div style='float:right;margin-top:5px;'>
                            <a href='#' onclick='ajaxDeleteInvoiceExpenses(".$ex_invoice['lb_record_primary_key']."); return false;'>
                                <i class='icon-trash'></i>
                                Delete
                            </a>
                        </div>";
        
            echo    "</div>
                <div id='error_delete_expense_invoice_".$ex_invoice['lb_tax_id']."' class='alert alert-block alert-error' style='display:none;'></div>
            ";
} // end for
?>
