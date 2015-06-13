<?php
/* @var $expenses_customer array of LbExpensesCustomer models */
$canAddCustomer = BasicPermission::model()->checkModules('lbCustomer', 'add');
$canAddDelete = BasicPermission::model()->checkModules('lbCustomer', 'delete');

if($canAddCustomer)
{
    echo '<div class="btn-toolbar">';
        LBApplicationUI::newButton(Yii::t('lang','New Customer'), array('url'=>$this->createUrl('addCustomer')));
    echo '</div>';
}

$i=0;
foreach ($expenses_customer as $customer)
{
        $client = LbCustomer::model()->findByPk($customer->lb_customer_id);
        if (count($client) > 0) {
            $i++;
            echo "
                <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'>
                    <div style='float:left'>
                        <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span> {$client->lb_customer_name}</h4>
                    </div>";
            if($canAddDelete)  
                echo    "<div style='float:right;margin-top:5px;'>
                            <a href='#' onclick='ajaxDeleteCustomerExpenses(".$client->lb_record_primary_key."); return false;'>
                                <i class='icon-trash'></i>
                                Delete
                            </a>
                        </div>";
            
            echo   "</div>
                <div id='error_delete_expense_customer_".$client->lb_record_primary_key."' class='alert alert-block alert-error' style='display:none;'></div>
            ";
        }
} // end for
?>
<script>

    function ajaxDeleteCustomerExpenses(id)
    {
        
        $.ajax({
            type:'POST',
            url: "<?php echo $this->createUrl('deleteCustomerExpenses'); ?>",
            success:function(response){
                var responseJSON = jQuery.parseJSON(response);
                if(responseJSON!=null)
                {
                    $("#error_delete_expense_customer_"+id).css("display","block");
                    $("#error_delete_expense_customer_"+id).html(responseJSON.exist);
                }
                else
                {
                    
                    $('#tab1').load("<?php echo $this->createUrl('loadAjaxTabCustomer',array('id'=>$expenses_id)); ?>");
                }
            },
            data:{customer_id:id,expenses_id:<?php echo $expenses_id ?>},
        });
    }
    
</script>
