<?php
/* @var $expenses_customer array of LbExpensesCustomer models */
/* @var $model LbExpenses */
$canAddCustomer = BasicPermission::model()->checkModules('lbCustomer', 'add');
$canAddDelete = BasicPermission::model()->checkModules('lbCustomer', 'delete');

if($canAddCustomer)
{
    echo '<div class="btn-toolbar">';
 

    //    LBApplicationUI::newButton(Yii::t('lang','New Customer'), array('url'=>$this->createUrl('addCustomer')));
      
        $this->widget('bootstrap.widgets.TbButton',array(
          
            'label'=>'New Customer',      
            'htmlOptions'=>array(
                            'onclick'=>'newCustomer();',
                            ),
        ));
    echo  '  &nbsp;$nbsp';
         $this->widget('bootstrap.widgets.TbButton',array(
          
            'label'=>'Assign Customer',      
            'htmlOptions'=>array(
                            'onclick'=>'assignCustomer();',
                            ),
        ));
    echo '</div>';
    
    //form customer

    $this->beginWidget('bootstrap.widgets.TbModal',array('id'=>'modal-customer-form'));
    echo '<div class="modal-header">';
    echo '<a class="close" data-dismiss="modal">&times;</a>';
    echo '<h4>New Customer</h4>';
    echo '</div>';
    
    echo '<div class="modal-body" style="max-height:700px;" id="modal-new-customer-body-'.$expenses_id.'">';    
    echo '</div>';
//    echo '<div class="modal-footer">';
////        $this->widget('bootstrap.widgets.TbButton',array(
////            'label'=>'Save',
////            'url'=>'#',
////            'htmlOptions'=>array('data-dismiss'=>'modal'),
////        ));
////        $this->widget('bootstrap.widgets.TbButton',array(
////            'label'=>'Close',
////            'url'=>'#',
////            'htmlOptions'=>array('data-dismiss'=>'modal'),
////        ));
//    echo '</div>';
    $this->endWidget();
    $this->widget('bootstrap.widget.TbButton', array(
        'type'=>'',
        'htmlOptions'=>array(
            'data-toggle'=>'modal',
            'data-target'=>'#modal-customer-form',
            'style'=>'display:none',
            'id'=>'btn-new-customer',
        ),
    ));
//end form customer
//form assign customer
$this->beginWidget('bootstrap.widgets.TbModal',array('id'=>'modal-customer-assign-form'));
    echo '<div class="modal-header" style="max-width:700px;">';
    echo '<a class="close" data-dismiss="modal">&times;</a>';
    echo '<h4>Assign Customer</h4>';
    echo '</div>';
    
    echo '<div class="modal-body" style="max-height:500px" id="modal-view-customer-body-'.$expenses_id.'">';    
    echo '</div>';
       
$this->endWidget();
 $this->widget('bootstrap.widget.TbButton', array(
        'type'=>'',
        'htmlOptions'=>array(
            'data-toggle'=>'modal',
            'data-target'=>'#modal-customer-assign-form',
            'style'=>'display:none',
            'id'=>'btn_view_customer',
        ),
    ));  
//    end form assign
}

$i=0;
foreach ($expenses_customer as $customer)
{
        $client = LbCustomer::model()->findByPk($customer->lb_customer_id);
        if (count($client) > 0) {
            $i++;
            echo "
                <div style='overflow:hidden; border-top: 1px solid #EEEEEE;margin-top: 5px;'id='list_customer'>
                    <div style='float:left'>
                    
                        <h4><span style='padding: 0 8px;background:#EEEEEE;border-radius:50%;'>$i</span>".LBApplication::workspaceLink($client->lb_customer_name,$client->getViewURLNormalized($client->lb_customer_name))."</h4>
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
    function newCustomer(){
           $('#btn-new-customer').click();
        $('#modal-new-customer-body-'+<?php echo $expenses_id ?>).html(getLoadingIconHTML(false));
        $('#modal-new-customer-body-'+<?php echo $expenses_id ?>).load("<?php echo LbExpenses::model()->getActionURLNormalized('ExpensesNewCustomer', array('form_type'=>'ajax','ajax'=>1,'expenses_id'=>$expenses_id))?>");
    }
    function refreshCustomerName(){

         $('#tab1').load("<?php echo LbExpenses::model()->getActionURLNormalized('LoadAjaxTabCustomer',array('id'=>$expenses_id)); ?>");
    }
    function assignCustomer(){
        $('#btn_view_customer').click();
        $('#modal-view-customer-body-'+<?php echo $expenses_id ?>).html(getLoadingIconHTML(false));
        $('#modal-view-customer-body-'+<?php echo $expenses_id ?>).load("<?php echo LbExpenses::model()->getActionURLNormalized('AssignCustomer',array('form_type'=>'ajax','ajax'=>1,'expenses_id'=>$expenses_id))?>");
    }
</script>
