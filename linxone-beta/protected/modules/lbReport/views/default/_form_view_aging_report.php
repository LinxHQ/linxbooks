<?php
/* @var $this LbInvoiceController */
/* @var $model LbInvoice */

$customer_arr=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_MODELS_ARRAY);


$m = $this->module->id;
//$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list'); 
$now = getdate();
//$currentDate = $now["year"] . "-0" . $now["mon"] . "-" . $now["mday"];
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
if(isset($_POST['search_date_from']))
    $date_from = date('Y-m-d',  strtotime ($_POST['search_date_from']));
$Time_Range_search = 0;
if(isset($_POST['select_timeRange']))
    $Time_Range_search = $_POST['select_timeRange'];
$customer_id = false;
if(isset($_POST['customer_id']))
    $customer_id = $_POST['customer_id'];
$invoiceSearch = LbInvoice::model()->getInvoiceByCustomerDate($customer_id,false);

?>
<!--<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_agingReport(); return false;">Print PDF</button>-->
<input hidden="true" id="customer_id" value ='<?php echo $customer_id; ?>'/>
<input hidden="true" id="Time_Range_search" value ='<?php echo $Time_Range_search; ?>'/>
<div style="width:100%;margin-top:10px;margin-bottom:3px;">
   
<button class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_agingReport(); return false;">Print PDF</button>
</div>
<form>
    <fieldset>
<table border="0" width="100%" class="items table table-bordered">
            <thead>
                <tr>
                    <th width="250" class="lb-grid-header"><?php echo Yii::t('lang','Number'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Date'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','0 - 30 Days'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','31 - 60 Days'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','61 - 90 Days'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','90 + Days 	'); ?></th>
                    <th width="150" class="lb-grid-header"><?php echo Yii::t('lang','Balance'); ?></th>
                </tr>
            </thead>
           
            
  
        
<?php 
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
                
                ?>
             <?php    
                $invoice_total = LbInvoiceTotal::model()->find('lb_invoice_id='.  intval($data_invocie->lb_record_primary_key));
                $lb_invoice = LbInvoice::model()->find('lb_record_primary_key='.  intval($data_invocie->lb_record_primary_key));
                $total = $invoice_total->getTotalInvoiceByCustomer($customer_id);
               
                $customer_name = LbCustomer::model()->customerInformation($customer_id)->attributes['lb_customer_name'];

                
                if($total > 0)
                {
                    ?>
                    
                        <?php if($Time_Range_search == 0)
                            {?>
            <tbody>
                        <tr>
                            <td width="250"><?php echo $lb_invoice->lb_invoice_no ?></td>
                            <td style="text-align: left;width:150"> <?php echo $lb_invoice->lb_invoice_date; ?></td>
                            <td style="text-align: left;width:150"> <?php 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {
                                          echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        //                                echo $lb_invoice->lb_invoice_date; 
                                    }
                                    else
                                        echo '$0.00';
    //                            echo $lb_invoice->lb_invoice_due_date; ?></td>
                                <td style="text-align: left;width:150">
                                <?php
                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                         echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                         $total2 = $total2 + $invoice_total->lb_invoice_total_outstanding;


                                    }
                                    else
                                        echo '$0.00';
                                ?></td>
                                <td style="text-align: left;width:150">
                                <?php
                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {
                                        $total3 = $total3 + $invoice_total->lb_invoice_total_outstanding;
                                        echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                    }
                                    else
                                        echo '$0.00';
                                ?></td>
                                <td style="text-align: left;width:150"> 
                                <?php
                                    if($dateNumber > 90)
                                    {
                                     $total4 = $total4 + $invoice_total->lb_invoice_total_outstanding;
                                        echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                        
                                    }
                                    else
                                        echo '$0.00';
                                ?></td>
                                <td style="text-align: left;width:150"><?php echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);?></td>


                            </tr>
                            
                    </tbody>
                    <tfoot>
                        <tr>
                            
                        <?php 
                        
                             if($i == $j)
                             {
                             ?>
                                
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total2,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total3,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total4,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total,2); ?></b></td>
                            </tr>
                        
                        <?php
                             }
                        ?>
                  </tfoot>  
                 <?php }
                 else if($Time_Range_search == 1)
                 {
                    ?> 
                     <tbody>
                        <tr>
                            
                             <?php 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                                    
                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    ?>
                            
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                            
                        <?php 
                        
                             if($i == $j)
                             {
                             ?>
                             
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$0.00' ?></b></td>
                            </tr>
                        
                        <?php
                             }
                        ?>
                  </tfoot>
                                <?php
                 }
                 else if($Time_Range_search == 2)
                 {
                    ?> 
                     <tbody>
                        <tr>
                            
                             <?php 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    ?>
                            
                        </tr>
                     </tbody>
                                <?php
                 }
                 else if($Time_Range_search == 3)
                  {
                    ?> 
                     <tbody>
                        <tr>
                            
                             <?php 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {
                                       
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    ?>
                            
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                            
                        <?php 
                        
                             if($i == $j)
                             {
                             ?>
                             
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total1,2) ?></b></td>
                            </tr>
                        
                        <?php
                             }
                        ?>
                  </tfoot>
                                <?php
                 }
                 else if($Time_Range_search == 4)
                     {
                    ?> 
                     <tbody>
                        <tr>
                            
                             <?php 
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);
                            
                                    if($dateNumber > 90)
                                    {
                                       
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          
                                          
                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
        
                                        }
                                    }

                                    ?>
                            
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                            
                        <?php 
                        
                             if($i == $j)
                             {
                             ?>
                             
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
                               
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               
                            </tr>
                        
                        <?php
                             }
                        ?>
                  </tfoot>
                                <?php
                 }
                    
                ?>
                
                   
                     
                <?php }
                
                }
            
           
            return;
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
                    ?>
                    <tbody>
                        <tr>
                            <td width="250"><?php echo LBApplication::workspaceLink($data_invocie->lb_invoice_no,  LbInvoice::model()->getViewInvoiceURL($data_invocie->lb_record_primary_key,$data->lb_customer_name)); ?></td>
                            <td style="text-align: left;width:150"> <?php echo $lb_invoice->lb_invoice_date; ?></td>
                            <td style="text-align: left;width:150"> <?php
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);

                                if($dateNumber >= 0 && $dateNumber <= 30)
                                {
                                      echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                      $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;
    //                                echo $lb_invoice->lb_invoice_date;
                                }
                                else
                                    echo '$0.00';
//                            echo $lb_invoice->lb_invoice_due_date; ?></td>
                            <td style="text-align: left;width:150">
                            <?php
                                if($dateNumber > 30 && $dateNumber <= 60)
                                {
                                     echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                     $total2 = $total2 + $invoice_total->lb_invoice_total_outstanding;


                                }
                                else
                                    echo '$0.00';
                            ?></td>
                            <td style="text-align: left;width:150">
                            <?php
                                if($dateNumber > 60 && $dateNumber <= 90)
                                {
                                    $total3 = $total3 + $invoice_total->lb_invoice_total_outstanding;
                                    echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                }
                                else
                                    echo '$0.00';
                            ?></td>

                            <td style="text-align: left;width:150">
                            <?php
                                if($dateNumber > 90)
                                {
                                 $total4 = $total4 + $invoice_total->lb_invoice_total_outstanding;
                                    echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);
                                }
                                else
                                    echo '$0.00';
                            ?></td>
                            <td style="text-align: left;width:150;"><?php echo '$'.number_format($invoice_total->lb_invoice_total_outstanding,2);?></td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <?php

                             if($i == $j)
                             {
                             ?>
                         <tr>
                            
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
    
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total2,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total3,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total4,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total,2); ?></b></td>

                         </tr>

                        <?php
                             }
                        ?>
                     </tfoot>

                <?php }
                else if($Time_Range_search == 1)
                     {
                    ?>
                     <tbody>
                        <tr>

                             <?php
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);

                                    if($dateNumber >= 0 && $dateNumber <= 30)
                                    {

                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';

                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';


                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';



                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;

                                        }
                                    }

                                    ?>

                        </tr>
                     </tbody>
                     <tfoot>
                        <?php

                             if($i == $j)
                             {
                             ?>
                         <tr>
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>
                                
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total1,2); ?></b></td>

                         </tr>

                        <?php
                             }
                        ?>
                     </tfoot>
                                <?php
                                 }
                                 else if($Time_Range_search == 2)
                 {
                    ?>
                     <tbody>
                        <tr>

                             <?php
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);

                                    if($dateNumber > 30 && $dateNumber <= 60)
                                    {
                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                             <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;

                                        }
                                    }

                                    ?>

                        </tr>
                     </tbody>
                     <tfoot>
                        <?php

                             if($i == $j)
                             {
                             ?>
                         <tr>
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>

                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total1,2); ?></b></td>

                         </tr>

                        <?php
                             }
                        ?>
                     </tfoot>
                                <?php
                 }
                 else if($Time_Range_search == 3)
                  {
                    ?>
                     <tbody>
                        <tr>

                             <?php
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);

                                    if($dateNumber > 60 && $dateNumber <= 90)
                                    {

                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;

                                        }
                                    }

                                    ?>

                        </tr>
                     </tbody>
                     <tfoot>
                        <?php

                             if($i == $j)
                             {
                             ?>
                         <tr>
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>

                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total1,2); ?></b></td>

                         </tr>

                        <?php
                             }
                        ?>
                     </tfoot>
                                <?php
                 }
                 else if($Time_Range_search == 4)
                     {
                    ?>
                     <tbody>
                        <tr>

                             <?php
                             $dateNumber = dateNumber($currentDate,$lb_invoice->lb_invoice_date);

                                    if($dateNumber > 90)
                                    {

                                        if($invoice_total->lb_invoice_total_outstanding > 0)
                                        {
                                          echo '<td width="250">'. $lb_invoice->lb_invoice_no.'</td>
                                          <td style="text-align: left;width:150">'. $lb_invoice->lb_invoice_date.'</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150">$0.00</td>';
                                          echo '<td style="text-align: left;width:150"> $'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';

                                          echo '<td style="text-align: left;width:150">$'.number_format($invoice_total->lb_invoice_total_outstanding,2).'</td>';


                                          $total1 = $total1 + $invoice_total->lb_invoice_total_outstanding;

                                        }
                                    }

                                    ?>

                        </tr>
                     </tbody>
                     <tfoot>
                        <?php

                             if($i == $j)
                             {
                             ?>
                         <tr>
                                <td colspan="2"><b><?php echo $customer_name; ?></b></td>

                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>$0.00</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><?php echo '<b>'.number_format($total1,2).'</b>' ;?></td>
                               <td align="right" style="border-top:1px solid #000"><b><?php echo '$'.number_format($total1,2) ?></b></td>

                         </tr>

                        <?php
                             }
                        ?>
                     </tfoot>
                                <?php
                 }

                ?>



                <?php
                }
            }
        }
    }?>
          
             
                   
            

    
</table>
       <!--</legend>-->
    </fieldset>

</form>
         
 <script type="text/javascript">
    function printPDF_agingReport() {
        
            var customer_id=0;
            var Time_Range_search=0
            if($('#customer_id').val() > 0)
                customer_id = $('#customer_id').val();
            if($('#Time_Range_search').val() > 0)
                Time_Range_search = $('#Time_Range_search').val();
            window.open('pdfAgingReport?customer='+customer_id+'&Time_Range_search='+Time_Range_search, '_target');
        
    }
</script>
