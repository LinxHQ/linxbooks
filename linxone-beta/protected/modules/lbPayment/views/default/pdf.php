<?php

$thousand =LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$decimal= LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;
$strnum = new LbInvoiceTotal();
$method = LBPayment::model()->method;
$date_from = date('Y-m-d');
$date_to = date('Y-m-d', strtotime("+1 month -1 day"));

if (isset($_REQUEST['search_date_from']) && $_REQUEST['search_date_from'] != "" )
    $date_from = date('Y-m-d', strtotime($_REQUEST['search_date_from']));
if (isset($_REQUEST['search_date_to']) && $_REQUEST['search_date_to'] != "")
    $date_to = date('Y-m-d', strtotime($_REQUEST['search_date_to']));


?>



<?php

        $country = LBApplicationUI::countriesDropdownData();
        $html_logo = "";
        $company = (isset($model->owner) ? $model->lb_invoice_company_id : '');
        $folder ='images/logo/';
        $path = "./images/logo/";
            $logo ="";
        $filename = '';
        $file_arr = array_diff(scandir($folder),array('.','..'));
        $subcription = LBApplication::getCurrentlySelectedSubscription();
        $logo="";
        foreach ($file_arr as $key => $file) {
            $file_name = explode('.', $file); 
            $file_name_arr = explode('_', $file_name[0]);
            if($file_name_arr[0] == $subcription && $file_name_arr[1] == $company) {
                    $logo = "<img src='".$path.$file."' style='height:80' />";
                 }
            }
            if(count($file_arr)>0)
            {
            $html_logo = '
            <tr>
                <td colspan="2" align="center">'.$logo.'</td>
            </tr>
                ';
            }
$address = "";
if (isset($model->customerAddress)) {
    $address = (isset($model->customerAddress->lb_customer_address_line_1) ? $model->customerAddress->lb_customer_address_line_1 . '. ' : '') .
            (isset($model->customerAddress->lb_customer_address_line_2)  ? $model->customerAddress->lb_customer_address_line_2 . '<br>' : '') .
            ($model->customerAddress->lb_customer_address_state != null  ? $model->customerAddress->lb_customer_address_state . ', ' : '') .
            ($model->customerAddress->lb_customer_address_city != null ? $model->customerAddress->lb_customer_address_city . ', ' : '') .
            (isset($model->customerAddress->lb_customer_address_country) != null && $model->customerAddress->lb_customer_address_country != 0 ? $country[$model->customerAddress->lb_customer_address_country]." " : '') .
            (isset($model->customerAddress->lb_customer_address_postal_code ) ? $model->customerAddress->lb_customer_address_postal_code . '<br>' : '') .
            (isset($model->customerAddress->lb_customer_address_phone_1 ) ? 'Phone: ' . $model->customerAddress->lb_customer_address_phone_1." " : '') .
            (isset($model->customerAddress->lb_customer_address_fax ) ? 'Fax: ' . $model->customerAddress->lb_customer_address_fax : '') . '<br>' .
            (isset($model->customerAddress->lb_customer_address_website_url ) ? $model->customerAddress->lb_customer_address_website_url : '')
    ;
}
$att = "";
$invoice_total = LbInvoiceTotal::model()->find('lb_invoice_id=' . intval($model->lb_record_primary_key));
if(isset($model->customerContact))
{
    $att = (($model->customerContact->lb_customer_contact_first_name != null) ? $model->customerContact->lb_customer_contact_first_name.' ' : '').
           (($model->customerContact->lb_customer_contact_last_name != NULL) ? $model->customerContact->lb_customer_contact_last_name : ''); 
}
$add ="";
if(isset($model->ownerAddress->lb_customer_address_line_1) || isset($model->ownerAddress->lb_customer_address_line_2))
    $add = 'Address: ';
//echo $html_logo;
$a = '<table border="0" style="width:100%;margin-left:10px;" cellpadding="0" cellspacing="0">
    <tr><td>
        <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
        ' . $html_logo . '
    </table></td></tr>
    <tr><td>
    <table border="0" style="width:98%;" cellpadding="0" cellspacing="0">
        <tr valign="top">
            <td >
                <span style="font-size:20px;font-weight:bold;">PAYMENT RECEIPT</span><br>
               ';
                if($_REQUEST['search_date_from'] == "false" && $_REQUEST['search_date_to'] == "false")
                    $a .='<br/>';
                else
                {
                $a .='Date From:' . date('d-M-Y',  strtotime($date_from)) . ' <br>
                    Date To: ' . date('d-M-Y',  strtotime($date_to)) . '<br>';
                }
           $a .='</td>
            <td  align="right">
                
                <span style="font-size:16px;font-weight:bold;">' . (isset($model->owner->lb_customer_name) ? $model->owner->lb_customer_name :'') . '</span><br>
                ' . (isset($model->owner->lb_customer_registration) ? "Registration No: " . $model->owner->lb_customer_registration . '. ' : '') . '
                ' . (isset($model->owner->lb_customer_website_url) ? "Website: " . $model->owner->lb_customer_website_url . '' : '') . '<br>
                 '.$add . (isset($model->ownerAddress->lb_customer_address_line_1) && $model->ownerAddress->lb_customer_address_line_1 != "" ? $model->ownerAddress->lb_customer_address_line_1 . '. ' : '') . '
                        ' . (isset($model->ownerAddress->lb_customer_address_line_2) && $model->ownerAddress->lb_customer_address_line_2 != "" ? $model->ownerAddress->lb_customer_address_line_2 . '. ' : '') . '
                        ' . (isset($model->ownerAddress->lb_customer_address_city) && $model->ownerAddress->lb_customer_address_city != ""  ? $model->ownerAddress->lb_customer_address_city . '. ' : '') . '
                        ' . (isset($model->ownerAddress->lb_customer_address_state) && $model->ownerAddress->lb_customer_address_state != "" ? $model->ownerAddress->lb_customer_address_state . '. ' : '') . '
                        ' . (isset($model->ownerAddress->lb_customer_address_country) && $model->ownerAddress->lb_customer_address_country == "Select" ? $country[$model->ownerAddress->lb_customer_address_country] : '') . '
                        ' . (isset($model->ownerAddress->lb_customer_address_postal_code) ? $model->ownerAddress->lb_customer_address_postal_code : '') . '<br>
               ' . (isset($model->ownerAddress->lb_customer_address_phone_1) ? "Phone: " . $model->ownerAddress->lb_customer_address_phone_1 : '') . '
               ' . (isset($model->ownerAddress->lb_customer_address_fax) ? "Fax: " . $model->ownerAddress->lb_customer_address_fax : '') . '<br>
               ' . (isset($model->ownerAddress->lb_customer_address_email) ? "Email: " . $model->ownerAddress->lb_customer_address_email : '') . '
            </td>
            </tr>
            <tr><td height="25">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <table border="0"  style="width:98%">
                        <tr>
                            <td width="110">
                                To:
                             </td>
                             <td width="400">
                                <b>' . (isset($model->customer) ? $model->customer->lb_customer_name : '') . '</b><br>
                             </td>
                             <td>
                                ' . $model->lb_invoice_no . ' |
                            </td>
                            <td><span style="margin-left: 0px;color: #000000; font-weight: bold">Total:</span>' . $strnum->adddotstring($invoice_total->lb_invoice_total_after_taxes, $thousand, $decimal) . '</td>
                        </tr>
                        <tr valign="top">
                            <td>
                                Biiling Address: 
                            </td>
                            <td>
                            ' . $address . '
                             </td>
                        </tr>
                    <tr>
                        <td>
                            Attention: 
                        </td>
                        <td>
                            ' . $att . '
                        </td>
                    </tr>
                    </table>
                    </td>
                   
            </tr></table></td></tr>';
$a .= '<tr><td>
                    <table border="1" style="width:90%;margin-top:10px;" cellpadding="0" cellspacing="0">
                       <tr style="background-color:#ddd">
                                <td  style="width:20%;height:30px;">Receipt Nos</td>
                                <td height="40" style="width:20%">Amount Paid</td>
                                <td style="text-align:center;width:20%">Method</td>
                                <td style="width:20%">Data</td>
                                <td style="width:20%">Notes</td>
                        </tr>';

$data_paymentItem = LbPaymentItem::model()->findAll('lb_invoice_id=:invoice_id', array(':invoice_id' => $model->lb_record_primary_key));

foreach ($data_paymentItem as $payment_invoice) {
   
    $payment = LbPayment::model()->findByPk($payment_invoice->lb_payment_id);
  
    $a .='<tr>              <td class="lb-grid" style="text-align: center">' . $payment->lb_payment_no . '</td>
                            <td class="lb-grid" style="text-align: right;">' . $strnum->adddotstring($payment_invoice->lb_payment_item_amount,$thousand,$decimal) . '</td>';
                            if(isset($payment))
                            {
                                
                                $a .='
                                
                                <td class="lb-grid" style="text-align: center">' . $method[$payment->lb_payment_method] . '</td>
                                <td style="text-align: center">' . date('d-M-Y',  strtotime($payment->lb_payment_date)) . '</td>
                                <td width="200px">' . $payment_invoice->lb_payment_item_note . '</td>';
                            }
    $a .= '</tr>';
}


$a .= '<tr>
                        <td height="20" style="text-align: left;color: #6E8900;float:right;"><span style="float: left;text-align: left;">Total Paid: </span>$' .$strnum->adddotstring($invoice_total->lb_invoice_total_paid,$thousand, $decimal) . '</td>
                        <td colspan="4" style="border-left: 0px;" ></td>
  
                    </tr>
                    <tr>
                        <td height="20" style="color: #6E8900;"><span style="width: 50%;float: left;text-align: left">Total Balance: </span>$' .$strnum->adddotstring($invoice_total->lb_invoice_total_outstanding, $thousand, $decimal)  . '</td>
                        <td colspan="4" style="border-left: 0px;"></td>
                    </tr>
                </table></td></tr>
                </table>';

echo $a;
?>

<style>
    .lb-grid
    {
        width: 150px;
       // border-right: solid 1px #0099FF;
        height: 30px;

    }
    .a
    {
        // float: left;
        text-align: left;
    }
    table{
        /*border: solid 1px #0099FF;*/
    }

</style>
