<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$method = LBPayment::model()->method;
$customer_id =false;
if(isset($_POST['customer_id']) && $_POST['customer_id']!="")
    $customer_id=$_POST['customer_id'];
//echo $customer_id;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d',strtotime("+1 month -1 day"));

if(isset($_POST['search_date_from']) && $_POST['search_date_from']!="")
    $date_from = date('Y-m-d',  strtotime ($_POST['search_date_from']));
if(isset($_POST['search_date_to']) && $_POST['search_date_to']!="")
    $date_to = date('Y-m-d',  strtotime ($_POST['search_date_to']));

$customer_arr= LbCustomer::model()->getCompaniesByPayment('lb_customer_name ASC', LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY,$customer_id,$date_from,$date_to);
?>

<div class ="ab" style="float: right; z-index: 9999; top: 150px; position: fixed; width: 60px; height: 300px; margin-left: 1020px;
 border-bottom-right-radius: 5px; border-top-right-radius: 5px;
 padding: 10px;">
   <?php
/*
        if($canAdd)
            echo LBApplication::workspaceLink(
                CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_new.png', 'Share', array('class'=>'lb-side-icon'))
           );

        echo LBApplication::workspaceLink(
            CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_payment.png', 'Payment', array('class'=>'lb-side-icon'))
        );
        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_email_1.png', 'Email', array('class'=>'lb-side-icon')), '#', array('data-toggle'=>"tooltip",'onclick'=>'onclickFormEmail();', 'title'=>"Email", 'class'=>'lb-side-link-invoice'));


//pdf

        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_pdf.png','#', array('class'=>'lb-side-icon', 'onclick'=>'printPDF();return false;')));//LbPayment::model()->getActionURL('pdf',array('customer_id'=>$customer_id,'search_date_from'=>$date_from,'search_date_to'=>$date_to))

        echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_share_2.png','#', array('class'=>'lb-side-icon')));

        echo LBApplication::workspaceLink(
        CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_first.png', 'First', array('class'=>'lb-side-icon'))
        );

    echo LBApplication::workspaceLink(
    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_previous.png', 'Previous', array('class'=>'lb-side-icon'))
    );

echo LBApplication::workspaceLink(
    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_next.png', 'Next', array('class'=>'lb-side-icon')));

echo LBApplication::workspaceLink(
    CHtml::image(Yii::app()->baseUrl . '/images/icons/icon_last.png', 'Last', array('class'=>'lb-side-icon')));
*/

?>
</div>
<?php 
if(count($customer_arr)==0)
{
    echo '<div id="container_result" style="color: #000000;font-size: 20px;width: 98%; margin: 0;font-weight: bold;text-align:center; position: relative;top:60px;margin-right: 6px;">'.Yii::t("lang","No results found").'.</div>';
} 
?>

<?php foreach ($customer_arr as $data) { ?>
<form>
    <fieldset>
        <legend style="color: #000000;font-size: 20px;width: 98%; margin: 0;font-weight: bold;">
            <div style="float:left;width: 100%;position: relative;top: 20px;"><?php echo $data->lb_customer_name; ?></div>
            <div style="float:left;width: 100%; font-size: 14px;text-align: right;position: relative;top: 10px;">
                <?php echo Yii::t('lang','Total');?>: <span style="font-weight: normal"><?php echo number_format(LbInvoiceTotal::model()->getTotalCustomer($data->lb_record_primary_key, "Total"),2) ?> | </span>
                <?php echo Yii::t('lang','Total Paid');?>: <span style="font-weight: normal"><?php echo number_format(LbInvoiceTotal::model()->getTotalCustomer($data->lb_record_primary_key,"Total Paid"),2); ?> | </span>
                <?php echo Yii::t('lang','Total Due');?>: <span style="font-weight: normal"><?php echo number_format(LbInvoiceTotal::model()->getTotalCustomer($data->lb_record_primary_key,"Total Due"),2); ?></span>
            </div>
        </legend>
        <?php 
            $invoice_arr = LbInvoice::model()->getInvoicePaidByCustomer($data->lb_record_primary_key);
            //$payment = $invoice_arr->customerAddress;
            foreach ($invoice_arr as $data_invocie) 
            {
                $invoice_total = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data_invocie->lb_record_primary_key));
       ?>
        <h5 style="margin: 20px 0px 5px 0px;font-weight: bold;">
            <span>
                <input class="pdf_checkbox" name="<?php echo $data_invocie->lb_record_primary_key; ?>" type="checkbox" value="<?php echo $data_invocie->lb_record_primary_key; ?>" />
            </span>
            <span style="text-decoration: underline;">
                
                <?php echo LBApplication::workspaceLink($data_invocie->lb_invoice_no,  LbInvoice::model()->getViewInvoiceURL($data_invocie->lb_record_primary_key,$data->lb_customer_name)); ?>
            </span> 
            <sapn style="margin-left: 65px;color: #000000; font-weight: normal">Total: <?php echo $invoice_total->lb_invoice_total_after_taxes; ?></span>
        </h5>
        <table border="0" width="100%" class="items table table-bordered">
            <thead>
                <tr>
                    <th width="250" class="lb-grid-header"><?php echo Yii::t('lang','Amount Paid'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Method'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                    <th class="lb-grid-header"><?php echo Yii::t('lang','Notes'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $paymentItem = LbPaymentItem::model()->findAll('lb_invoice_id='.  intval($data_invocie->lb_record_primary_key));
            foreach ($paymentItem as $data_paymentItem) 
            {
                $payment = LbPayment::model()->findByPk(intval($data_paymentItem->lb_payment_id));

            ?>
                    <tr>
                        <td style="text-align: right"><?php echo number_format($data_paymentItem->lb_payment_item_amount,2); ?></td>
                        <td style="text-align: center"><?php echo $method[$payment->lb_payment_method]; ?></td>
                        <td style="text-align: center"><?php echo $payment->lb_payment_date; ?></td>
                        <td><?php echo $data_paymentItem->lb_payment_item_note; ?></td>
                    </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                    <tr >
                        <td style="text-align: right;color: #6E8900;"><div style="width: 50%;float: left;text-align: left"><?php echo Yii::t('lang','Total Paid');?>: </div><?php echo $invoice_total->lb_invoice_total_paid; ?></td>
                        <td colspan="3" style="border-left: 0px;" ></td>
  
                    </tr>
                    <tr>
                        <td style="text-align: right;color: #6E8900;"><div style="width: 50%;float: left;text-align: left"><?php echo Yii::t('lang','Total Balance');?>: </div><?php echo $invoice_total->lb_invoice_total_outstanding; ?></td>
                        <td colspan="3" style="border-left: 0px;"></td>
                    </tr>
            </tfoot>
        </table>
<!--        <div style="width: 98%">
            <div>Total Paid:</div>
            <div><?php echo $invoice_total->lb_invoice_total_paid; ?></div>
        </div>
        <div style="width: 98%">
            <div>Total Balance:</div>
            <div><?php echo $invoice_total->lb_invoice_total_outstanding; ?></div>
        </div>-->
     <?php } ?>
    </fieldset>
    
</form>
<?php }?>
<script type="text/javascript">
    function printPDF() {
        var id;
        if($('.pdf_checkbox:checked').length > 1) {
            alert('You can only choose Payment.');
        } else if($('.pdf_checkbox:checked').length == 0) {
            alert('please checked invoice to print.');
        } else {
            id = $('.pdf_checkbox:checked').val();
            window.open('pdf?invoice='+id+'&search_date_from=<?php echo $date_from; ?>&search_date_to=<?php echo $date_to ?>', '_target');
        }
    }
</script>
