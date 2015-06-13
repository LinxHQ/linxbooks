<?php
/* @var $this LbQuotationController */
/* @var $model LbQuotation */
/* @var $ownCompany LbCustomer */
$thousand =LbGenera::model()->getGeneraSubscription()->lb_thousand_separator;
$decimal= LbGenera::model()->getGeneraSubscription()->lb_decimal_symbol;


$currency_name = LbGenera::model()->getGeneraSubscription()->lb_genera_currency_symbol;
// Subtotal quotation
$quotation_subtotal_arr = LbQuotationTotal::model()->getQuotationTotal($model->lb_record_primary_key);
// Discount Quotation
$quotation_discount_arr = LbQuotationDiscount::model()->getQuotationDiscounts($model->lb_record_primary_key);
$strnum = new LbInvoiceTotal();
$quotation_discount = "";
foreach ($quotation_discount_arr->data as $quotation_discount_row) {
    $quotation_discount.=
            '<tr><td>'
                .$quotation_discount_row['lb_quotation_discount_description'].":".
            '</td>
                <td>'.$currency_name.$strnum->adddotstring($quotation_discount_row['lb_quotation_discount_total'], $thousand, $decimal).'</td>
            </tr>';
}
    //End Discount
// Tax Quotation
$quotation_tax_arr = LbQuotationTax::model()->getTaxQuotation($model->lb_record_primary_key);
$quotation_tax = "";
foreach ($quotation_tax_arr->data as $quotation_tax_row) {
    $tax_arr = LbTax::model()->find('lb_record_primary_key='.$quotation_tax_row['lb_quotation_tax_id']);
//    print_r($tax_arr);
    $tax_name = 'Tax';
    if($tax_arr['lb_tax_name']!="")
        $tax_name = $tax_arr['lb_tax_name'];
    $quotation_tax.=
            '<tr>
                <td>'.$tax_name.' ('.$quotation_tax_row['lb_quotation_tax_value']."%):".'</td>
                <td>'.$currency_name.$strnum->adddotstring($quotation_tax_row['lb_quotation_tax_total'], $thousand, $decimal).'</td>
            </tr>';
                    
}

// LOGO
$company = (isset($model->owner) ? $model->lb_company_id : '');
                        $folder ='images/logo/';
            $path = "./images/logo/";
            $logo ="";
            
            $filename = '';
            $file_arr = array_diff(scandir($folder),array('.','..'));
             $subcription = LBApplication::getCurrentlySelectedSubscription();
            foreach ($file_arr as $key => $file) {
                 $file_name = explode('.', $file); 
                 $file_name_arr = explode('_', $file_name[0]);

                 if($file_name_arr[0] == $subcription && $file_name_arr[1] == $company) {
                    $logo = "<img src='".$path.$file."' style='height:80' />";
                 }
            }
          //  if(count($file_arr)>0)
           // {
            $html_logo = '
            <tr>
                <td colspan="2" align="center">'.$logo.'</td>
            </tr>
                ';
            //}



$country = LBApplicationUI::countriesDropdownData();
$address = "";
if(isset($model->customerAddress))
{
    $br1="";$br2="";
    if($model->customerAddress->lb_customer_address_fax!=NULL || $model->customerAddress->lb_customer_address_phone_1!=NULL)
    {
        $br1 = "<br>";
    }
    if($model->customerAddress->lb_customer_address_fax!=NULL || $model->customerAddress->lb_customer_address_phone_1!=NULL
       || $model->customerAddress->lb_customer_address_state!=NULL || $model->customerAddress->lb_customer_address_city!=NULL)
    {
        $br2 = "<br>";
    }
    
    $address =
                 (($model->customerAddress->lb_customer_address_line_1!=NULL) ? $model->customerAddress->lb_customer_address_line_1.'. ' : '').
                 (($model->customerAddress->lb_customer_address_line_2!=NULL) ? $model->customerAddress->lb_customer_address_line_2.'<br>' : '').
                 (($model->customerAddress->lb_customer_address_state!=NULL) ? $model->customerAddress->lb_customer_address_state.', ' : '').
                 (($model->customerAddress->lb_customer_address_city!=NULL) ? $model->customerAddress->lb_customer_address_city.', ' : '').
                 (($model->customerAddress->lb_customer_address_country!=NULL && $country[$model->customerAddress->lb_customer_address_country]!="Select") ? $country[$model->customerAddress->lb_customer_address_country]." " : '').
                 (($model->customerAddress->lb_customer_address_postal_code!=NULL) ? $model->customerAddress->lb_customer_address_postal_code : '').$br2.
                 (($model->customerAddress->lb_customer_address_phone_1!=NULL) ? 'Phone: '.$model->customerAddress->lb_customer_address_phone_1." " : '').
                 (($model->customerAddress->lb_customer_address_fax!=NULL) ? 'Fax: '.$model->customerAddress->lb_customer_address_fax : ' ').$br1.
                 (($model->customerAddress->lb_customer_address_website_url!=NULL) ? $model->customerAddress->lb_customer_address_website_url : '');
}

$att = "";
if(isset($model->customerContact))
{
    $att = (isset($model->customerContact->lb_customer_contact_first_name) ? $model->customerContact->lb_customer_contact_first_name.' ' : '').
           (isset($model->customerContact->lb_customer_contact_last_name) ? $model->customerContact->lb_customer_contact_last_name : ''); 
}
$add ="";
if(isset($model->ownerAddress->lb_customer_address_line_1) || isset($model->ownerAddress->lb_customer_address_line_2))
    $add = 'Address: ';

$subject = "";
if(isset($model->lb_quotation_subject))
{
    $subject='<tr><td>&nbsp;</td></tr>
                    <tr>
                        <td><b>Subject:</b><br></td>
                    </tr>
                    <tr><td colspan="2">'.nl2br($model->lb_quotation_subject).'</td></tr>';
}

$tbl= '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
        '.$html_logo.'
        <tr valign="top">
            <td width="300">
                <span style="font-size:20px;font-weight:bold;">QUOTATION</span><br>
                Quotation No: '.$model->lb_quotation_no.'<br>
                Quotation Date: '.date('d-M-Y',  strtotime($model->lb_quotation_date)).'<br>
                Due Date: '.date('d-M-Y',  strtotime($model->lb_quotation_due_date)).'<br>
            </td>
            <td width="400" align="right">
                <span style="font-size:16px;font-weight:bold;">'.(isset($model->owner->lb_customer_name) && $model->owner->lb_customer_name != "" ? $model->owner->lb_customer_name.'. ' : '').'</span><br>
                '.(isset($model->owner->lb_customer_registration) && $model->owner->lb_customer_registration != "" ? "Registration No: ".$model->owner->lb_customer_registration."." : '').'
                '.(isset($model->owner->lb_customer_website_url) ? "Website: ".$model->owner->lb_customer_website_url : '').'<br>
                '.$add.(isset($model->ownerAddress->lb_customer_address_line_1) && $model->ownerAddress->lb_customer_address_line_1 != "" ? $model->ownerAddress->lb_customer_address_line_1.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_line_2) && $model->ownerAddress->lb_customer_address_line_2 != "" ? $model->ownerAddress->lb_customer_address_line_2.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_city) && ($model->ownerAddress->lb_customer_address_city != "") ? $model->ownerAddress->lb_customer_address_city.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_state) && ($model->ownerAddress->lb_customer_address_state != "") ? $model->ownerAddress->lb_customer_address_state.'. ' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_country) ? $country[$model->ownerAddress->lb_customer_address_country].'&nbsp;&nbsp;' : '').'
                        '.(isset($model->ownerAddress->lb_customer_address_postal_code) ? $model->ownerAddress->lb_customer_address_postal_code : '').'<br>
               '.(isset($model->ownerAddress->lb_customer_address_phone_1) ? "Phone: ".$model->ownerAddress->lb_customer_address_phone_1."&nbsp;" : '').'
               '.(isset($model->ownerAddress->lb_customer_address_fax) ? "Fax: ".$model->ownerAddress->lb_customer_address_fax : '').'<br>
               '.(isset($model->ownerAddress->lb_customer_address_email) ? "Email: ".$model->ownerAddress->lb_customer_address_email : '').'
            </td>
        </tr>
        <tr><td height="25">&nbsp;</td></tr>
        <tr>
            <td colspan="2">
                <table border="0"  style="width:100%;">
                    <tr>
                        <td width="90">
                            To:
                         </td>
                         <td width="590">
                            <b>'.(isset($model->customer) ? $model->customer->lb_customer_name : '').'</b><br>
                         </td>
                    </tr>
                    <tr valign="top">
                        <td>
                            Biiling Address: 
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
                    '.$subject.'
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <tr>
                            <td colspan="2">
                                <table border="1" style="width:100%;border-collapse:collapse;">
                                    <tr >
                                        <th  width="32" height="25" align="center">#</th>
                                        <th width="390">Item</th>
                                        <th width="90" align="center">Quantity</th>
                                        <th width="90" align="center">Unit Price</th>
                                        <th width="90" align="center">Total</th>
                                    </tr>';


$item_quotation_arr = LbQuotationItem::model()->getquotationItems($model->lb_record_primary_key, 'ModelArray');
//print_r($item_invoice_arr);
$i=0;
foreach ($item_quotation_arr as $item_quotation_row) {   
    $i++;
    $tbl.=                          '<tr>
                                        <td height="35" align="center" width="32">'.$i.'</td>
                                        <td width="390">'.$item_quotation_row['lb_quotation_item_description'].'</td>
                                        <td align="right" width="90">'.$strnum->adddotstring($item_quotation_row['lb_quotation_item_quantity'], $thousand, $decimal).'</td>
                                        <td align="right" width="90">'.$strnum->adddotstring($item_quotation_row['lb_quotation_item_price'], $thousand, $decimal).'</td>
                                        <td align="right" width="90">'.$strnum->adddotstring($item_quotation_row['lb_quotation_item_total'], $thousand, $decimal).'</td>
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
                <table border="0" style="width:100%;border-collapse:collapse;font-weight:bold;">
                    <tr>
                        <td align="right" width="620">
                            Sub Total ('.$currency_name.'):
                        </td>
                        <td width="100">'.$currency_name.$strnum->adddotstring($quotation_subtotal_arr->lb_quotation_subtotal, $thousand, $decimal).'</td>
                    </tr>
                        '.$quotation_discount.'
                        '.$quotation_tax.'
                    <tr>
                        <td>Total ('.$currency_name.'):</td>
                        <td>'.$currency_name.$strnum->adddotstring($quotation_subtotal_arr->lb_quotation_total_after_total, $thousand, $decimal).'</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>Note:</b><br>'.nl2br($model->lb_quotation_note).'</td>
        </tr>
    </table>';
 echo $tbl;
