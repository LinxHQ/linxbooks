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




// LOGO
            $company = $model->lb_vendor_company_id ;
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
$modelCustomer = LbCustomer::model()->find('lb_record_primary_key='.$model->lb_vendor_company_id);
  echo '<br>';
echo '<br>';         
$tbl= '<table border="0" style="width:100%;" cellpadding="0" cellspacing="0">
        '.$html_logo.'
        <tr >
            <td style="float:left; width:400px;">
                
                <b>Vendor No: </b>'.$model->lb_vendor_no.'<br>
                <b>Vendor Date: </b>'.$model->lb_vendor_date.'
                <b>Due Date: </b>'.$model->lb_vendor_due_date.'<br>
              
            </td>
            <td style="float:right">
                <b>'. $modelCustomer->lb_customer_name.'</b><br />
                 <b>Registration No: </b>' . $modelCustomer->lb_customer_registration. '.&nbsp;'.
                (($modelCustomer->lb_customer_website_url!=NULL) ? '<b>Website: </b>'.$modelCustomer->lb_customer_website_url.'<br>' : '').'
            </td>
            
           
        </tr>
        <tr>
        <td><b>Status: </b>'.$model->lb_vendor_status.'</td>
        </tr>
       
          
    </table>
    ';
echo $tbl;
$customerName = false;
if($model->lb_vendor_supplier_id)
    $customerName = LbCustomer::model()->findByPk($model->lb_vendor_supplier_id)['lb_customer_name'];

$billingName= false;
if($model->lb_vendor_supplier_address)
{
    $informationAdd = LbCustomerAddress::model()->findByPk($model->lb_vendor_supplier_address);
    $billingName = $informationAdd['lb_customer_address_line_1'].'. '.$informationAdd['lb_customer_address_line_2'].'<br />';
//    $billingName .=$informationAdd['lb_customer_address_postal_code'].'<br>';
//    $billingName .=$informationAdd['lb_customer_address_website_url'].'<br>';
    
}
$attentionInformation = false;
if($model->lb_vendor_supplier_attention_id)
{
    $attention = LbCustomerContact::model()->findByPk($model->lb_vendor_supplier_attention_id);
    $attentionInformation = $attention['lb_customer_contact_first_name'].' '.$attention['lb_customer_contact_last_name'];
}
$list_name = false;

if($model->lb_vendor_category)
{
    $list_name = SystemList::model()->findByPk($model->lb_vendor_category)['system_list_item_code'];
}
$tbody = '<table border="0" style="width:100%;" cellpadding="0" cellspacing="0">';
$tbody .= '<tr>'
        .'<td style="width:100px;"><b>To: </b> </td><td>'.$customerName.'</td>'
        . '</tr><br />';
$tbody .= '<tr>'
        .'<td><b>Billing Address: </b></td><td>'.$billingName.'</td>'
        . '</tr>';
$tbody .= '<tr>'
        .'<td><b>Attention: </b></td><td>'.$attentionInformation.'</td>'
        . '</tr>';
$tbody .= '<tr>'
        .'<td><b>Category: </b></td><td>'.$list_name.'</td>'
        . '</tr>';

$tbody .='<tr>'
        . '<td><b>Subject:</b></td><td>'
        .$model->lb_vendor_subject.'</td></tr>';
$tbody .= '</table>';

echo $tbody;
echo '<br>';
echo '<br>';
echo '<br>';

//Item

$modelItem = LbVendorItem::model()->findAll('lb_vendor_id=55');

if(count($modelItem) > 0)
{
$tItem = '<table border="1" style="width:100%;" cellpadding="0" cellspacing="0">';
    $tItem .= '<tr>'
            . '<td style="width:200px;height:30px">Item</td>'
            . '<td style="width:100px;">Quantity</td>'
            . '<td style="width:200px;">Price</td>'
            . '<td style="width:200px;">Total</td>'
            . '</tr>';
    foreach ($modelItem as $dataItem)
    {
    $tItem .= '<tr>'
            . '<td style="height:15px">'.$dataItem['lb_vendor_item_description'].'</td>'
            . '<td>'.$dataItem['lb_vendor_item_quantity'].'</td>'
            . '<td>'.$dataItem['lb_vendor_item_price'].'</td>'
            . '<td>'.$dataItem['lb_vendor_item_amount'].'</td>'
           
            . '</tr>';
    }
$tItem .= '</table>';
echo $tItem.'<br />';
}


//Total
$modelTotal = LbVendorTotal::model()->getVendorTotal($model->lb_record_primary_key,  LbVendorTotal::LB_VENDOR_ITEM_TYPE_TOTAL);


//Discount
$discountItem = '<table border="0" style="width:100%;" cellpadding="0" cellspacing="0">';
$discountItem .='<tr>'
                . '<td style="width:100px;"><b>Sub Total : </b></td>'
                . '<td style="border-bottom:1px solid black">$'.$modelTotal->lb_vendor_subtotal.'</td>'
                . '</tr>';
$discountAll = LbVendorDiscount::model()->findAll('lb_vendor_id = '.$model->lb_record_primary_key);
if(count($discountAll) > 0)
{
    $discountItem .='<tr>'
                . '<td><b>Discount  </b></td>'
                
                . '</tr>';
    foreach ($discountAll as $valueDiscount)
    {
        
        $discountItem .='<tr>'
                . '<td>'.$valueDiscount['lb_vendor_description'].'</td>'
                . '<td>$'.$valueDiscount['lb_vendor_value'].'</td>'
                . '</tr>';
    }

}

//tax
$TaxAll = LbVendorTax::model()->findAll('lb_vendor_id = '.$model->lb_record_primary_key);
if(count($TaxAll)> 0)
{
    $discountItem .='<tr>'
                . '<td  ><b>Tax  </b></td>'
                . '<td style="border-top:1px solid black" ></td>'
                
                . '</tr>';
    foreach ($TaxAll as $valueTax)
    {
        
        $discountItem .='<tr>'
                . '<td>'.$valueTax['lb_tax_name'].'</td>'
                . '<td>$'.$valueTax['lb_vendor_tax_total'].'</td>'
                . '</tr>';
    }
}

$discountItem .='<tr>'
                . '<td style=""><b>Total : </b></td>'
                . '<td style="border-top:1px solid black">$'.$modelTotal->lb_vendor_last_tax.'</td>'
                . '</tr>';

$discountItem .='</table>';
echo $discountItem;



