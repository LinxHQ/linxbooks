<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */

$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);


$m = $this->module->id;
//$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list'); 
$now = getdate();
// $currentDate = $now["year"] . "-0" . $now["mon"] . "-" . $now["mday"];
$currentDate = date("Y-m-d");

function dateNumber($first,$second)
{
    $firstNumber = strtotime($first);
    $secondNumber = strtotime($second);
    $diff = $firstNumber-$secondNumber;
    $day = round($diff/(60*60*24));
    return $day;
}
$date_from = date('Y-m-d');
$customer_id = 0;
//information search
if(isset($_GET['search_date_from']))
    $date_from = date('Y-m-d',  strtotime ($_GET['search_date_from']));
$Time_Range_search = 0;
if(isset($_GET['Time_Range_search']))
    $Time_Range_search = $_GET['Time_Range_search'];
$customer_id = false;
if(isset($_GET['customer']))
    $customer_id = $_GET['customer'];
$invoiceSearch = LbInvoice::model()->getInvoiceByCustomerDate($customer_id,false);

?>
<?php

$PDFAging = '<table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">'
        . '<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
            <tr><td >
             <span style="font-size:20px;font-weight:bold;">GST Report</span>
             
            </td></tr>
            </table>
            </td></tr>'
        . '<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
            <tr><td >
             
             <span style="margin-top:20px;"> </span>
             
            </td></tr>
            </table>
            </td></tr>'
        
        . '<tr><td>
           <table border="0" width="100%" class="items table table-bordered">';
           $PDFAging .='<thead>
                    <tr>
                        <th  width="100" class="lb-grid-header">'.Yii::t('lang','Number').'</th>
                        <th width="100" class="lb-grid-header">'. Yii::t('lang','Date').'</th>
                        <th width="100"  class="lb-grid-header">'.Yii::t('lang','0 - 30 Days').'</th>
                        <th width="100"  class="lb-grid-header">'.Yii::t('lang','31 - 60 Days').'</th>
                        <th width="100" class="lb-grid-header">'.Yii::t('lang','61 - 90 Days').'</th>
                        <th width="100" class="lb-grid-header">'.Yii::t('lang','90 + Days 	').'</th>
                        <th  width="100" class="lb-grid-header">'.Yii::t('lang','Balance').'</th>
                     </tr>
                </thead>';
           if($customer_id > 0)
            {

            $invoice_arr = LbInvoice::model()->getInvoiceByCustomerDate($customer_id,false);
            $customer_name ='';
            $total = 0;
            $i = count($invoice_arr);
            $j = 0;
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            foreach ($invoice_arr as $data_invocie) 
            {
                $j++;
                  
                $invoice_total = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data_invocie->lb_record_primary_key));
                $lb_invoice = LbInvoice::model()->find('lb_record_primary_key='.  intval($data_invocie->lb_record_primary_key));
                $total = $invoice_total->getTotalInvoiceByCustomer($customer_id);
               
                $customer_name = LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];

                
                if($total > 0)
                {
                    ?>
                    
                        <?php if($Time_Range_search == 0)
                            {
                            $PDFAging .= '<tbody>
                            <tr>
                            <td>'.$lb_invoice->lb_invoice_no.'</td>
                            <td style="text-align: left;">'.$lb_invoice->lb_invoice_date.'</td>';
                            $PDFAging .= '<td style="text-align: left;"> ';
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {
                                          $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        //                                echo $lb_invoice->lb_invoice_date; 
                                    }
                                    else
                                        $PDFAging .= '$0.00';
    //                            echo $lb_invoice->lb_invoice_due_date; 
                                    $PDFAging .= '</td>  <td style="text-align: left;">';
                                
                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                         $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;;
                                         $total2 = $total2 + $invoice_total->lb_invoice_total_outstanding;


                                    }
                                    else
                                        $PDFAging .= '$0.00';
                                
                                $PDFAging .= '</td><td style="text-align: left;">';
                                
                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {
                                        $total3 = $total3 + $invoice_total->lb_invoice_total_outstanding;
                                        $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;
                                    }
                                    else
                                        $PDFAging .= '$0.00';
                                
                                $PDFAging .= '</td><td style="text-align: left"> ';
                                
                                    if($dateNumber > 90)
                                    {
                                     $total4 = $total4 + $invoice_total->lb_invoice_total_outstanding;
                                        $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;;  
                                    }
                                    else
                                        $PDFAging .= '$0.00';
                                
                                $PDFAging .= '</td><td style="text-align: left;width:150">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';


                     $PDFAging .='       </tr>
                            
                    </tbody>';
                     $PDFAging .= '<tfoot>
                        <tr>';
                            
                             if($i == $j)
                             {
                            
                             
                               $PDFAging .= '<td colspan="2"><b>'.$customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total2.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total3.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total4.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total.'</b></td>
                           ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot> ';
                    
                  }
                
                 else if($Time_Range_search == 1)
                 {
                    
                     $PDFAging .= '<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                                    
                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                      $PDFAging .=  '</tr></tbody>';
                      $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                               
                 }
                 else if($Time_Range_search == 2)
                 {
                    
                     $PDFAging .= '<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                                    
                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;width:150">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                      $PDFAging .=  '</tr></tbody>';
                      $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                               
                 } 
                 
                  else if($Time_Range_search == 3)
                 {
                    
                     $PDFAging .= '<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                                    
                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left">$0.00</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                      $PDFAging .=  '</tr></tbody>';
                      $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                               
                 } 
                 
                 else if($Time_Range_search == 4)
                 {
                    
                     $PDFAging .= '<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                                    
                                    if( $dateNumber  > 90)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left">$0.00</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                      $PDFAging .=  '</tr></tbody>';
                      
                            
                       
                        
                             if($i == $j)
                             {
                             
                             $PDFAging .= '<tfoot><tr>';
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                            ';
                        
                               $PDFAging .= '</tr></tfoot>';
                             }
                       
                  
                               
                 } 
                     
                }
            }
            
    }
    else if($customer_id == 0)
    {
    foreach ($customer_arr as $data) { ?>

    <?php
            
            $invoice_arr = LbInvoice::model()->getInvoiceByCustomerDate($data->lb_record_primary_key,false);
            //$payment = $invoice_arr->customerAddress;
            $customer_name = $data->lb_customer_name;
//                            echo $customer_name.'<br>'; 

            $total = 0;
            $i = count($invoice_arr);
           $j = 0;
           $total1 = 0;
           $total2 = 0;
            $total3 = 0;
            $total4 = 0;
            foreach ($invoice_arr as $data_invocie) 
            {
                $j++;
                
                ?>
             <?php    
                $invoice_total = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data_invocie->lb_record_primary_key));
                $lb_invoice = LbInvoice::model()->find('lb_record_primary_key='.  intval($data_invocie->lb_record_primary_key));
                $total = $invoice_total->getTotalInvoiceByCustomer($data->lb_record_primary_key);
                
                if($total > 0)
                {
                    if($Time_Range_search == 0)
                    {
                    
                    $PDFAging .= '<tbody>
                                <tr>';
                            $PDFAging .='<td >'.$data_invocie->lb_invoice_no.'</td>
                            <td style="text-align: left;">'.$lb_invoice->lb_invoice_date.'</td>
                            <td style="text-align: left;">'; 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                               
                                if($dateNumber >= 0 && $dateNumber <= 30)
                                {
                                      $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;
                                      $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
    //                                echo $lb_invoice->lb_invoice_date; 
                                }
                                else
                                    $PDFAging .= '$0.00';
//                            echo $lb_invoice->lb_invoice_due_date; 
                            $PDFAging .= '</td>
                            <td style="text-align: left;">';
                            
                                if($dateNumber > 30 && $dateNumber <= 60)
                                {
                                     $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;;
                                     $total2 = $total2 + $invoice_total->lb_invoice_total_outstanding;
                 
                                }
                                else
                                    $PDFAging .= '$0.00';
                            $PDFAging .= '</td>
                            <td style="text-align: left;">';
                            
                                if($dateNumber > 60 && $dateNumber <= 90)
                                {
                                    $total3 = $total3 + $invoice_total->lb_invoice_total_outstanding;
                                    $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;
                                }
                                else
                                    $PDFAging .= '$0.00';
                            $PDFAging .='</td>
                            <td style="text-align: left;"> ';
                            
                                if($dateNumber > 90)
                                {
                                 $total4 = $total4 + $invoice_total->lb_invoice_total_outstanding;
                                    $PDFAging .= '$'.$invoice_total->lb_invoice_total_outstanding;;  
                                }
                                else
                                    $PDFAging .= '$0.00';
                            $PDFAging .= '</td>
                            <td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>
                            

                        </tr>
                     </tbody> '; 
                     
                        
                        
                             if($i == $j)
                             {
                                $PDFAging .=' <tr><td></td></tr>';

                                $PDFAging .= '<tr >
                                       <td colspan="2"><b>'. $customer_name.'</b></td>

                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total2.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total3.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total4.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total.'</b></td>

                                ';
                               $PDFAging .=' </tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                                
                        
                           }
                       
                    
                         
                }
                else if($Time_Range_search == 1)
                     {
                     
                     $PDFAging .='<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {
                                       
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          

                                          $PDFAging .= '<td style="text-align: left;width:150">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';

                                          
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                       $PDFAging .=' </tr>
                     </tbody>';
                        $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                                
                 }
                 else if($Time_Range_search == 2)
                 {
                    
                     $PDFAging .='<tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                       $PDFAging .= '</tr>
                     </tbody>';
                        $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                                
                 }
                 else if($Time_Range_search == 3)
                  {
                    
                    $PDFAging .=' <tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {
                                       
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                       $PDFAging .=' </tr>
                     </tbody>';
                        $PDFAging .= '<tfoot><tr>';
                            
                       
                        
                             if($i == $j)
                             {
                             
                             
                               $PDFAging .= '<td colspan="2"><b>'. $customer_name.'</b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>$0.00</b></td>
                               <td align="right" style="border-top:1px solid #000"><b>'.$total1.'</b></td>
                            ';
                        
                        
                             }
                       
                  $PDFAging .= '</tr></tfoot>';
                                
                 }
                 else if($Time_Range_search == 4)
                     {
                    $PDFAging .='
                     <tbody>
                        <tr>';
                            
                             
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 90)
                                    {
                                       
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          $PDFAging .= '<td >'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;">'. $lb_invoice->lb_invoice_date.'</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;">$0.00</td>';
                                          $PDFAging .= '<td style="text-align: left;"> $'.$invoice_total->lb_invoice_total_outstanding.'</td>';

                                          $PDFAging .= '<td style="text-align: left;">$'.$invoice_total->lb_invoice_total_outstanding.'</td>';

                                          
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    
                            
                       $PDFAging .= '</tr>
                     </tbody>';
                        if($i == $j)
                             {
                                $PDFAging .=' <tr><td></td></tr>';

                                $PDFAging .= '<tr >
                                       <td colspan="2"><b>'. $customer_name.'</b></td>

                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total1.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total2.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total3.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total4.'</b></td>
                                      <td align="right" style="border-top:1px solid #000"><b>$'.$total.'</b></td>

                                ';
                               $PDFAging .=' </tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                               $PDFAging .=' <tr><td></td></tr>';
                                
                        
                           }
                                
                 }
                    
                

                
                    
                
                
            
        }
    }
    
    }
    }
    
           
            

$PDFAging .='
            </table>
            </td></tr>'
        
        . '</table>';
        
echo $PDFAging;