<?php

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');


$payment_year = false;
$employee_id = false;
if(isset($_GET['payment_year']) && $_GET['payment_year'] !="")
    $payment_year = $_GET['payment_year'];
if(isset($_GET['employee_id']) && $_GET['employee_id'] !="")
    $employee_id = $_GET['employee_id'];
$year = LbEmployeePayment::model()->getInfoPayment($payment_year);     

$PDFPayment = '<table border="0" style="margin:auto; width:100%;" cellpading="0" cellpacing="0">'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0" >
                    <tr><td>
                        <span style="font-size:20px; font-weight:bold;">Employee Report</span>
                    </td></tr>
                </table>
            </td></tr>'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0">
                    <tr><td>
                        <span style="margin-top:3px;">Year:  '.$year->payment_year.'</span>
                        <span style="margin-top:15px;"></span>
                    </td></tr>
                </table>
            </td></tr>'
            .'</table>
            <table border="1"   style="margin-left:40px;margin-top:50px; width:100%;" class="items table table-bordered">';
                $PDFPayment .= '<thead>
                    
                        <tr style="font-weight:bold;" align="center">                        
                            <td width="150" class="lb-grid-header">'.Yii::t('lang','Paid For Month').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Total Salary').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Payment').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Amount').'</td>
                            <td width="200" class="lb-grid-header">'.Yii::t('lang','Note').'</td>
                        </tr>
                </thead>';
               
                 $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($employee_id, $year->payment_year);
                            $totalAllPayment = 0;
                            $totalAllAmount = 0;
                            $totalAllSalary = 0;
                foreach ($a as $data) {    
                                
                               // total salary
                                 
                                    $salary = LbEmployeeSalary::model()->totalSalaryEmployee($employee_id);
                                    $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($employee_id);
                                    $totalSalary = $salary-$benefit; 
                                     $totalAllSalary+=$totalSalary;
                                //total Payment
                                   
                                    $payment_salary = LbEmployeePayment::model()->getPaidByMonth($data->payment_month,$employee_id, $year->payment_year) ;
                                    
                                    $totalAllPayment += $payment_salary;
                                   // $payment = number_format($payment_salary,2);                       
                                   
                                //amount
                                 
                                    $amount = $totalSalary - $payment_salary;
                                    
                                    $totalAllAmount = $totalAllAmount + $amount;
                    //view report
                        
                        $PDFPayment.='<tr>';
                        $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';                   
                        $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                        $PDFPayment.='<td>'.$data->payment_note.'</td>';
                        $PDFPayment.='</tr>';
                        
                       
                   
                }
                
                $PDFPayment.='<tr>';
                $PDFPayment.='<td width="150" style="font-weight:bold;border-top:1px solid #000;" align="center" >'.Yii::t('lang','Total:').'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.  number_format($totalAllSalary,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.number_format($totalAllPayment,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.number_format($totalAllAmount,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" ></td>';               
                $PDFPayment.='</tr>';
                
                
                $PDFPayment.='
            </table>';
          
            
echo $PDFPayment;