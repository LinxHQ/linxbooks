<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */
/* @var $ownCompany LbCustomer */

$currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
$thousand =LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$decimal= LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;

$strnum = new LbInvoiceTotal();


// Subtotal Invoice

$invoice_subtotal_arr = LbInvoiceTotal::model()->getInvoiceTotal($model->lb_record_primary_key);



// Discount Invoice
$invoice_discount_arr = LbInvoiceItem::model()->getInvoiceDiscounts($model->lb_record_primary_key,'ModelArray');
$invoice_discount = "";
foreach ($invoice_discount_arr as $invoice_discount_row) {
    $invoice_discount.=
            '<tr><td>'
                .$invoice_discount_row['lb_invoice_item_description'].":".
            '</td>
                <td>'.$currency_name.$strnum->adddotstring($invoice_discount_row['lb_invoice_item_total'],$thousand,$decimal).'</td>
            </tr>';
}
    //End Discount
// Tax Invoice
$invoice_tax_arr = LbInvoiceItem::model()->getInvoiceTaxes($model->lb_record_primary_key, 'ModelArray');
$invoice_tax = "";

foreach ($invoice_tax_arr as $invoice_tax_row) {
  
        $tax_arr = LbTax::model()->find('lb_record_primary_key='.$invoice_tax_row['lb_invoice_item_description']);
        if($tax_arr['lb_tax_value'] != null && $tax_arr['lb_tax_name'] != null)
        {
            $tax_name = 'Tax';
            if($tax_arr['lb_tax_name']!="")
                $tax_name = $tax_arr['lb_tax_name'];
        $invoice_tax.=
            '<tr>
                <td>'.$tax_name.' ('.$tax_arr['lb_tax_value']."%):".'</td>
                <td>'.$currency_name.$strnum->adddotstring($invoice_tax_row['lb_invoice_item_total'],$thousand,$decimal).'</td>
            </tr>';
        }
}

// LOGO
            $company = (isset($model->owner) ? $model->lb_invoice_company_id : '');
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
            //}

//END LOGO
$country = LBApplicationUI::countriesDropdownData();

$address = "";
if(isset($model->customerAddress))
{
    $address =
                 (($model->customerAddress->lb_customer_address_line_1!=NULL) ? $model->customerAddress->lb_customer_address_line_1.'. ' : '').
                 (($model->customerAddress->lb_customer_address_line_2!=NULL) ? $model->customerAddress->lb_customer_address_line_2.'<br>' : '').
                 (($model->customerAddress->lb_customer_address_state!=NULL) ? $model->customerAddress->lb_customer_address_state.', ' : '').
                 (($model->customerAddress->lb_customer_address_city!=NULL) ? $model->customerAddress->lb_customer_address_city.', ' : '').
                 (($model->customerAddress->lb_customer_address_country!=NULL && $model->customerAddress->lb_customer_address_country!=0) ? $country[$model->customerAddress->lb_customer_address_country].' ' : '').
                 (($model->customerAddress->lb_customer_address_postal_code!=NULL) ? $model->customerAddress->lb_customer_address_postal_code.'<br>' : '').
                 (($model->customerAddress->lb_customer_address_phone_1!=NULL) ? 'Phone: '.$model->customerAddress->lb_customer_address_phone_1.' ' : '').
                 (($model->customerAddress->lb_customer_address_fax!=NULL) ? 'Fax: '.$model->customerAddress->lb_customer_address_fax : '').'<br>'.
                 (($model->customerAddress->lb_customer_address_website_url!=NULL) ? $model->customerAddress->lb_customer_address_website_url : '')
        ;
}
$att = "";
if(isset($model->customerContact))
{
    $att = (($model->customerContact->lb_customer_contact_first_name != null) ? $model->customerContact->lb_customer_contact_first_name.' ' : '').
           (($model->customerContact->lb_customer_contact_last_name != NULL) ? $model->customerContact->lb_customer_contact_last_name : ''); 
}
$add ="";
if(isset($model->ownerAddress->lb_customer_address_line_1) || isset($model->ownerAddress->lb_customer_address_line_2))
    $add = 'Address: ';

$subject = "";
if(isset($model->lb_invoice_subject))
{
    $subject='<tr><td>&nbsp;</td></tr>
                    <tr>
                        <td><b>Subject:</b><br></td>
                    </tr>
                    <tr><td colspan="2">'.nl2br($model->lb_invoice_subject).'</td></tr>';
}
$create_by = AccountProfile::model()->getFullName(LbCoreEntity::model()->getCoreEntity(LbInvoice::model()->module_name,$model->lb_record_primary_key)->lb_created_by);

$tbl= '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
        '.$html_logo.'
        <tr valign="top">
            <td width="300">
                <span style="font-size:20px;font-weight:bold;">INVOICE</span><br>
                Invoice No: '.$model->lb_invoice_no.'<br>
                Invoice Date: '.date('d-M-Y',  strtotime($model->lb_invoice_date)).'<br>
                Due Date: '.date('d-M-Y',  strtotime($model->lb_invoice_due_date)).'<br>
            </td>
            <td width="400" align="right">
                
                <span style="font-size:16px;font-weight:bold;">'.(isset($model->owner->lb_customer_name) ? $model->owner->lb_customer_name.'. ' : '').'</span><br>
                '.(isset($model->owner->lb_customer_registration) ? "Registration No: ".$model->owner->lb_customer_registration.'. ' : '').'
                '.(isset($model->owner->lb_customer_website_url) ? "Website: ".$model->owner->lb_customer_website_url.'' : '').'<br>
                '.$add.(isset($model->ownerAddress->lb_customer_address_line_1) && $model->ownerAddress->lb_customer_address_line_1 != "" ? $model->ownerAddress->lb_customer_address_line_1.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_line_2) && $model->ownerAddress->lb_customer_address_line_2 != "" ? $model->ownerAddress->lb_customer_address_line_2.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_city) && $model->ownerAddress->lb_customer_address_city != "" ? $model->ownerAddress->lb_customer_address_city.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_state) && $model->ownerAddress->lb_customer_address_state != ""? $model->ownerAddress->lb_customer_address_state.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_country) ? $country[$model->ownerAddress->lb_customer_address_country] : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_postal_code) ? $model->ownerAddress->lb_customer_address_postal_code : '').'<br>
               '.(isset($model->ownerAddress->lb_customer_address_phone_1) ? "Phone: ".$model->ownerAddress->lb_customer_address_phone_1 : '').'
               '.(isset($model->ownerAddress->lb_customer_address_fax) ? "Fax: ".$model->ownerAddress->lb_customer_address_fax : '').'<br>
               '.(isset($model->ownerAddress->lb_customer_address_email) ? "Email: ".$model->ownerAddress->lb_customer_address_email : '').'
            </td>
        </tr>
        <tr><td height="25">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <table border="0"  style="width:100%">
                    <tr>
                        <td width="110">
                            To:
                         </td>
                         <td width="590">
                            <b>'.(isset($model->customer) ? $model->customer->lb_customer_name : '').'</b><br>
                         </td>
                    </tr>
                    <tr valign="top">
                        <td>
                            Billing Address: 
                        </td>
                        <td>
                            '.$address.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Attention: 
                        </td>
                        <td>
                            '.$att.'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Created By: 
                        </td>
                        <td>
                            '.$create_by.'
                        </td>
                    </tr>
                    '.$subject.'
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <tr>
                            <td colspan="2">
                                <table border="1" style="width:100%;border-collapse:collapse;" cellpadding="0" cellspacing="0">
                                    <tr >
                                        <th width="32" height="25" align="center">#</th>
                                        <th width="390">Item</th>
                                        <th width="90" align="center">Quantity</th>
                                        <th width="90" align="center">Unit Price</th>
                                        <th width="90" align="center">Total</th>
                                    </tr>';

//$item_invoice_arr = LbInvoiceItem :: model()->findAll('lb_invoice_id='.$model->lb_record_primary_key,array());
$item_invoice_arr = LbInvoiceItem :: model()->getInvoiceItems($model->lb_record_primary_key,'ModelArray');
//print_r($item_invoice_arr);
$i=0;
foreach ($item_invoice_arr as $item_invoice_row) {   
    
    
    $i++;
    $tbl.=                          '<tr>
                                        <td width="32" height="35" align="center">'.$i.'</td>
                                        <td width="390">'.$item_invoice_row['lb_invoice_item_description'].'</td>
                                        <td width="90" align="right">'.$strnum->adddotstring($item_invoice_row['lb_invoice_item_quantity'], $thousand, $decimal).'</td>
                                        <td width="90" align="right">'.$strnum->adddotstring($item_invoice_row['lb_invoice_item_value'],$thousand,$decimal).'</td>
                                        <td width="90" align="right">'.$strnum->adddotstring($item_invoice_row['lb_invoice_item_total'],$thousand,$decimal).'</td>
                                    </tr>';
}
$tbl.=                         '</table>
                            </td>
                        </tr>
                    </tr>
                </table>   
            </td>
        </tr>
        <tr align="right">
            <td colspan="2" >
                <table border="0" style="width:100%;font-weight:bold;" cellpadding="0" cellspacing="4">
                    <tr>
                        <td align="right" width="616">
                            Sub Total ('.$currency_name.'):
                        </td>
                        <td width="100">'.$currency_name.$strnum->adddotstring($invoice_subtotal_arr['lb_invoice_subtotal'],$thousand,$decimal).'</td>
                    </tr>
                    
                        '.$invoice_discount.'
                        '.$invoice_tax.'
                    <tr>
                        <td>Total ('.$currency_name.'):</td>
                        <td>'.$currency_name.$strnum->adddotstring($invoice_subtotal_arr['lb_invoice_total_after_taxes'],$thousand,$decimal).'</td>
                           
                        
                    </tr>
                    <tr>
                        <td>Paid ('.$currency_name.'):</td>
                        <td>'.$currency_name.$strnum->adddotstring($invoice_subtotal_arr['lb_invoice_total_paid'],$thousand,$decimal).'</td>
                           
                        
                    </tr>
                    <tr>
                        <td>Outstanding ('.$currency_name.'):</td>
                        <td>'.$currency_name.$strnum->adddotstring($invoice_subtotal_arr['lb_invoice_total_outstanding'],$thousand,$decimal).'</td>
                           
                        
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="2"><b>Note:</b></td></tr>
        <tr></tr>
        <tr>
            
            <td colspan="2" width="100px">
                    '.nl2br($model->lb_invoice_note).'</td>
                 
        </tr>
    </table>
    ';
echo $tbl;
