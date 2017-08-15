<?php
$model = LbPaymentVoucher::model()->findBypk($_REQUEST['id']);
// LOGO
            $company = $model->lb_pv_company_id ;
            $folder ='images/logo/';
            $path = "./images/logo/";
            $logo = "";
            $filename = '';
            $file_arr = array_diff(scandir($folder),array('.','..'));
             $subcription = LBApplication::getCurrentlySelectedSubscription();
            foreach ($file_arr as $key => $file) {
                 $file_name = explode('.', $file); 
                 $file_name_arr = explode('_', $file_name[0]);
//                 print_r($file_name_arr);
                 if($file_name_arr[0] == $subcription && $file_name_arr[1] == $company) {
                    $logo = "<img src='".$path.$file."' style='height:80' />";
                 }
            }
           // if(count($file_arr)>0)
            //{
            $html_logo = '
            <tr>
                <td colspan="2" align="center">'.$logo.'</td>
            </tr>
                ';

  echo '<br>';
echo '<br>';         
$tbl= '<table border="0" style="width:100%;" cellpadding="0" cellspacing="0">
        '.$html_logo.'
        <tr >
           
            
           
        </tr>
        <tr>
       
        </tr>
       
          
    </table>
    ';

echo $tbl;

//information payment voucher
$add ="";

$modelCustomer = LbCustomer::model()->find('lb_record_primary_key='.$model->lb_pv_company_id);

$modelAddress = LbCustomerAddress::model()->find('lb_record_primary_key = '.$model->lb_pv_company_address_id);
if(isset($modelAddress->lb_customer_address_line_1) || isset($modelAddress->lb_customer_address_line_2))
    $add = 'Address: ';
$tblPV= '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
        '.$html_logo.'
        <tr valign="top">
            <td width="300">
                <span style="font-size:20px;font-weight:bold;">PAYMENT VOUCHER</span><br>
                Payment Voucher No: '.$model->lb_payment_voucher_no.'<br>
                Payment Voucher Date: '.date('d-M-Y',  strtotime($model->lb_pv_date)).'<br>
                Title : '.$model->lb_pv_title.'<br />
                Description : '.$model->lb_pv_description.'<br />
                Create By : '.AccountProfile::model()->getFullName($model->lb_pv_create_by).'<br />
                
            </td>
            <td width="400" align="right">
                <span style="font-size:16px;font-weight:bold;">'.(isset($modelCustomer->lb_customer_name) && $modelCustomer->lb_customer_name != "" ? $modelCustomer->lb_customer_name.'. ' : '').'</span><br>
                '.(isset($modelCustomer->lb_customer_registration) && $modelCustomer->lb_customer_registration != "" ? "Registration No: ".$modelCustomer->lb_customer_registration."." : '').'
                '.(isset($modelCustomer->lb_customer_website_url) ? "Website: ".$modelCustomer->lb_customer_website_url : '').'<br>
                '.$add.(isset($modelAddress->lb_customer_address_line_1) && $modelAddress->lb_customer_address_line_1 != "" ? $modelAddress->lb_customer_address_line_1.'. ' : '').'
                        '.(isset($modelAddress->lb_customer_address_line_2) && $modelAddress->lb_customer_address_line_2 != "" ? $modelAddress->lb_customer_address_line_2.'. ' : '').'
                        '.(isset($modelAddress->lb_customer_address_city) && ($modelAddress->lb_customer_address_city != "") ? $modelAddress->lb_customer_address_city.'. ' : '').'
                        '.(isset($modelAddress->lb_customer_address_state) && ($modelAddress->lb_customer_address_state != "") ? $modelAddress->lb_customer_address_state.'. ' : '').'
                        '.(isset($modelAddress->lb_customer_address_country) ? $modelAddress->lb_customer_address_country.'&nbsp;&nbsp;' : '').'
                        '.(isset($modelAddress->lb_customer_address_postal_code) ? $modelAddress->lb_customer_address_postal_code : '').'<br>
               '.(isset($modelAddress->lb_customer_address_phone_1) ? "Phone: ".$modelAddress->lb_customer_address_phone_1."&nbsp;" : '').'
               '.(isset($modelAddress->lb_customer_address_fax) ? "Fax: ".$modelAddress->lb_customer_address_fax : '').'<br>
               '.(isset($modelAddress->lb_customer_address_email) ? "Email: ".$modelAddress->lb_customer_address_email : '').'
            </td>
           
        </tr>';
$tblPV .='</table>';


echo $tblPV.'<br /><br />';


//item expenses
$i= 0;
$strnum = new LbInvoiceTotal();
$thousand =LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$decimal= LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;

$item_quotation_arr = LbPvExpenses::model()->findAll('lb_payment_voucher_id = '.$model->lb_record_primary_key);
if(count($item_quotation_arr) > 0){
$tblEx = '<table border="1" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">';
$tblEx.=                          '<tr>
                                        <td height="35" align="center" width="50">#</td>
                                        <td width="100"><b>Expenses Date</b></td>
                                        <td width="200"><b>Expenses No</b></td>
                                        <td width="100"><b>Expenses category</b></td>
                                        <td width="100"><b>Expenses note</b></td>
                                        
                                        <td  width="100"><b>Total</b></td>
                                        
                                    </tr>';
$subtotalEx = 0;
foreach ($item_quotation_arr as $item_quotation_row) { 
    $i++;
    $expensesManage = LbExpenses::model()->findByPk($item_quotation_row['lb_expenses_id']);
    $subtotalEx = $subtotalEx + $expensesManage['lb_expenses_amount'];
    $tblEx.=                          '<tr>
                                        <td height="35" align="center" width="32">'.$i.'</td>
                                        <td >'.$expensesManage['lb_expenses_date'].'</td>
                                        <td >'.$expensesManage['lb_expenses_no'].'</td>
                                        <td width="">'.$expensesManage['lb_category_id'].'</td>
                                        <td width="">'.$expensesManage['lb_expenses_note'].'</td>
                                        <td align="" width="">'.$strnum->adddotstring($expensesManage['lb_expenses_amount'], $thousand, $decimal).'</td>
                                        
                                    </tr>';
}
$tblEx.=                         '</table>';

echo $tblEx;
echo '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">';
echo '<tr>
                                        <td height="35" align="center" width="50"></td>
                                        <td width="100"></td>
                                        <td width="200"></td>
                                        <td width="100"></td>
                                        <td width="100" align="center"><b>Total</b></td>
                                        
                                        <td  width="100" align="left">$'.number_format($subtotalEx,2,'.',',').'</td>
                                        
                                    </tr>';
echo '</table>';

}