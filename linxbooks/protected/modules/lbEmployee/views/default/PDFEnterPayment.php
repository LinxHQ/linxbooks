<?php

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');


$month_year = false;
if(isset($_GET['month_year']) & $_GET['month_year'] !="")
    $month_year = $_GET['month_year'];
if(isset($_GET['employee_name']) && $_GET['employee_name']!=""){
               $employee_name = $_GET['employee_name'];
           }
function dateMY($date){
    $arr = explode('-',$date);
    return $arr;
}


$PDFPayment = '<table border="0" style="margin:auto; width:100%;" cellpading="0" cellpacing="0">'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0" >
                    <tr><td>
                        <span style="font-size:20px; font-weight:bold;">Employee Payment</span>
                    </td></tr>
                </table>
            </td></tr>'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0">
                    <tr><td>
                        <span style="margin-top:5px;">Paid For Month:  '.$month_year.'</span><br/>
                        <span style="margin-top:5px;">Date:  '.date('d-m-Y').'</span>
                        <span style="margin-top:20px;"></span>
                    </td></tr>
                </table>
            </td></tr>'
            .'</table>
          
            <table border="1" style="width:90%;margin-top:20px;margin-left:50px;" cellpadding="0" cellspacing="0">';
                $PDFPayment .= '<thead>
                    
                        <tr style="font-weight:bold;" align="center">                        
                           
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Name').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang',' Salary').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Pay').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Paid').'</td>
                            
                            <td width="200" class="lb-grid-header">'.Yii::t('lang','Note').'</td>
                        </tr>
                </thead>';
                 $month = dateMY($month_year)[0];
                 $year = dateMY($month_year)[1];
                 $date = date('Y-m-d');
                 //$model = LbEmployeePayment::model()->getAllByMonthYearAndEmployee($employee_name,$month,$year);
                 $totalAllPaid = 0;
                 $totalAllSalary = 0;
                 $totalAllPayment = 0;
                 $totalAllBalance = 0;
                 $a = LbEmployeePayment::model()->getAllPaymentByDateMonthYearAndEmployee($employee_name, $month, $year, $date);
//                foreach ($a as $value) {
//                     $salary = LbEmployeeSalary::model()->totalSalaryEmployee($value['employee_id']);
//                     $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($value['employee_id']);
//                     $totalSalary = $salary-$benefit;
//                     $totalAllSalary += $totalSalary;
//                 }
               foreach($a as $value ){                   
                    
                    //Employee name
                        $employee = LbEmployee::model()->getInfoEmployee($value['employee_id'])["employee_name"];
                    // total salary
                        $payment = LbEmployeePayment::model()->getPaidByEmployee($value['employee_id'],$month, $year) ;
                        $salary = LbEmployeeSalary::model()->totalSalaryEmployee($value['employee_id']);
                        $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($value['employee_id']);                        
                        //$totalSalary = $salary-$benefit-$payment+$value->payment_paid;
                        $totalSalary = $salary-$benefit;
                        $pay = $totalSalary - $payment;
                        $totalAllSalary += $totalSalary;
                    //Paid salary
                        $paid = LbEmployeePayment::model()->getPaidByMonth($month, $value['employee_id'], $year);
                        $balance = $totalSalary - $paid;
                        $totalAllPaid+=$paid;
                        $totalAllBalance+=$balance;
                    //total Payment
                        // $payment = LbEmployeePayment::model()->getPaidByEmployee($value['employee_id'],$month, $year) ;
                        $payment = $value->payment_paid;   
                        
                        $totalAllPayment += $payment;
//                    //amount
//                        
//                        $amount = $totalSalary-$payment ;
//                        $totalAllAmount += $amount;
                    //note
                        $note = $value['payment_note'];
                    //view report
                        
                        $PDFPayment.='<tr>';
                    //    $PDFPayment.='<td align="center">'.date('d-m-Y',strtotime($value->payment_date)).'</td>';
                        $PDFPayment.='<td>'.$employee.'</td>';                   
                        $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($pay,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($paid,2).'</td>';
                       // $PDFPayment.='<td align="right">$'.number_format($payment,2).'</td>';
                       // $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                        $PDFPayment.='<td>'.$note.'</td>';
                        $PDFPayment.='</tr>';
                        
                       
                   
                }
                
//                $PDFPayment.='<tr>';
//                $PDFPayment.='<td width="150" colspan="2" style="font-weight:bold;border-top:1px solid #000;" align="center" >'.Yii::t('lang','Total:').'</td>';
//                $PDFPayment.='<td style="font-weight:bold border-top:1px solid #000; text-align:right" >$'.  number_format($totalAllSalary,2).'</td>';
//                $PDFPayment.='<td style="font-weight:bold border-top:1px solid #000; text-align:right" >$'.number_format($totalAllPayment,2).'</td>';
//              //  $PDFPayment.='<td style="font-weight:bold border-top:1px solid #000; text-align:right" >$'.number_format($totalAllAmount,2).'</td>';
//                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" ></td>';               
//                $PDFPayment.='</tr>';
//                
//                
                $PDFPayment.='
            </table>';
  


$PDFPayment.= '<div style="margin-left:480px; margin-top:20px; width:30%; border: 1px solid black">'
                    . '<table style="text-align:right;width:100%;">'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Total Salary:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($totalAllSalary,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Total Paid:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($totalAllPaid,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Total Pay:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($totalAllBalance,2).'</b></td>'
                        . '</tr>'
//                        . '<tr>'
//                            . '<td style="text-align:left;padding:6px;"><b>Total Payment:</b></td>'
//                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($totalAllPayment,2).'</b></td>'
//                        . '</tr>'
                        
                       

                    . '</table>'
                . '</div>';
echo $PDFPayment;


