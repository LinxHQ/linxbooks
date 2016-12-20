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
if($payment_year > 0){
    $year = LbEmployeePayment::model()->getInfoPayment($payment_year);  
    $py = 'Year:'.$year->payment_year;
}else{
    $py = '';
}
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
                        <span style="margin-top:3px;">'.$py.'  </span>
                        <span style="margin-top:15px;"></span>
                    </td></tr>
                </table>
            </td></tr>'
            .'</table>
            <table border="1" style="width:100%;margin-top:20px;margin-left:40px;" cellpadding="0" cellspacing="0">';
                $PDFPayment .= '<thead>
                    
                        <tr style="font-weight:bold;" align="center">                        
                            <td  class="lb-grid-header">'.Yii::t('lang','Paid For Month').'</td>
                            <td  class="lb-grid-header">'.Yii::t('lang','Employee').'</td>
                            <td  class="lb-grid-header">'.Yii::t('lang','Total Salary').'</td>
                            <td  class="lb-grid-header">'.Yii::t('lang','Payment').'</td>
                            <td  class="lb-grid-header">'.Yii::t('lang','Amount').'</td>
                            <td  class="lb-grid-header">'.Yii::t('lang','Note').'</td>
                        </tr>
                </thead>';
               if($employee_id > 0){
                            if($payment_year > 0){
                                $year = LbEmployeePayment::model()->getInfoPayment($payment_year);     
                                    
                                $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($employee_id, $year->payment_year);
                                $totalPayment = 0;
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
                                    $totalPayment += $payment_salary;
                                   // $payment = number_format($payment_salary,2);                                                          
                                //amount
                                    if($totalSalary == 0){
                                        $amount = 0;
                                    }else{
                                        $amount = $totalSalary - $payment_salary;                 
                                    }
                                    $totalAllAmount = $totalAllAmount + $amount;
                                    $employee = LbEmployee::model()->getInfoEmployee($employee_id);
                                    $PDFPayment.='<tr>';
                                    $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';   
                                    $PDFPayment.='<td align="left">'.$employee->employee_name.'</td>';   
                                    $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                                    $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
                                    $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                                    $PDFPayment.='<td>'.$data->payment_note.'</td>';
                                    $PDFPayment.='</tr>';
                                                                
                                }  
                            }else{
                                $year = LbEmployeePayment::model()->getAllPayment();
                                 $totalPayment = 0;
                                    $totalAllAmount = 0;
                                    $totalAllSalary = 0;
                                foreach ($year as $value) {
                                 //   print_r($value->payment_year);
                                     $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($employee_id, $value->payment_year);
                                     
                                     foreach ($a as $data) {    
                                
                                    // total salary

                                         $salary = LbEmployeeSalary::model()->totalSalaryEmployee($employee_id);
                                         $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($employee_id);

                                         $totalSalary = $salary-$benefit; 
                                          $totalAllSalary+=$totalSalary;
                                     //total Payment

                                         $payment_salary = LbEmployeePayment::model()->getPaidByMonth($data->payment_month,$employee_id, $value->payment_year) ;                                   
                                         $totalPayment += $payment_salary;
                                        // $payment = number_format($payment_salary,2);                                                          
                                     //amount
                                         if($totalSalary == 0){
                                             $amount = 0;
                                         }else{
                                             $amount = $totalSalary - $payment_salary;                 
                                         }
                                         $totalAllAmount = $totalAllAmount + $amount;
                                         $employee = LbEmployee::model()->getInfoEmployee($employee_id);
                                         $PDFPayment.='<tr>';
                                        $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';
                                        $PDFPayment.='<td align="left">'.$employee->employee_name.'</td>';   
                                        $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                                        $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
                                        $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                                        $PDFPayment.='<td>'.$data->payment_note.'</td>';
                                        $PDFPayment.='</tr>';                                  
                                     }
                                }
                                
                            }
                           
                        }else{
                            if($payment_year > 0){
                                $employee_arr = LbEmployeePayment::model()->getAllEmployeePayment();
                                $year = LbEmployeePayment::model()->getInfoPayment($payment_year);
                                 $totalPayment = 0;
                                    $totalAllAmount = 0;
                                    $totalAllSalary = 0;
                                foreach ($employee_arr as $value) {
                                 //   print_r($value->employee_id);
                                    $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($value->employee_id, $year->payment_year);
                                    
                                    foreach ($a as $data) {    

                                   // total salary

                                        $salary = LbEmployeeSalary::model()->totalSalaryEmployee($value->employee_id);
                                        $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($value->employee_id);

                                        $totalSalary = $salary-$benefit; 
                                         $totalAllSalary+=$totalSalary;
                                    //total Payment

                                        $payment_salary = LbEmployeePayment::model()->getPaidByMonth($data->payment_month,$value->employee_id, $year->payment_year) ;                                   
                                        $totalPayment += $payment_salary;
                                       // $payment = number_format($payment_salary,2);                                                          
                                    //amount
                                        if($totalSalary == 0){
                                            $amount = 0;
                                        }else{
                                            $amount = $totalSalary - $payment_salary;                 
                                        }
                                        $totalAllAmount = $totalAllAmount + $amount;
                                        $employee = LbEmployee::model()->getInfoEmployee($value->employee_id);
                                            $PDFPayment.='<tr>';
                                            $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';
                                             $PDFPayment.='<td align="left">'.$employee->employee_name.'</td>'; 
                                            $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                                            $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
                                            $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                                            $PDFPayment.='<td>'.$data->payment_note.'</td>';
                                            $PDFPayment.='</tr>';                                  
                                    }  
                                }
                            }else{
                                $employee_arr = LbEmployeePayment::model()->getAllEmployeePayment();
                                 $totalPayment = 0;
                                        $totalAllAmount = 0;
                                        $totalAllSalary = 0;
                                foreach ($employee_arr as $employee_row) {
                                     $year = LbEmployeePayment::model()->getAllPayment();
                                    // print_r($employee_row->employee_id);
                                    foreach ($year as $value) {
                                     //   print_r($value->payment_year);
                                         $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($employee_row->employee_id, $value->payment_year);
                                         
                                         foreach ($a as $data) {    

                                        // total salary

                                             $salary = LbEmployeeSalary::model()->totalSalaryEmployee($employee_row->employee_id);
                                             $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($employee_row->employee_id);

                                             $totalSalary = $salary-$benefit; 
                                              $totalAllSalary+=$totalSalary;
                                         //total Payment

                                             $payment_salary = LbEmployeePayment::model()->getPaidByMonth($data->payment_month,$employee_row->employee_id, $value->payment_year) ;                                   
                                             $totalPayment += $payment_salary;
                                            // $payment = number_format($payment_salary,2);                                                          
                                         //amount
                                             if($totalSalary == 0){
                                                 $amount = 0;
                                             }else{
                                                 $amount = $totalSalary - $payment_salary;                 
                                             }
                                             $totalAllAmount = $totalAllAmount + $amount;
                                              $employee = LbEmployee::model()->getInfoEmployee($employee_row->employee_id);
                                                $PDFPayment.='<tr>';
                                                $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';  
                                                 $PDFPayment.='<td align="left">'.$employee->employee_name.'</td>'; 
                                                $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                                                $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
                                                $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                                                $PDFPayment.='<td>'.$data->payment_note.'</td>';
                                                $PDFPayment.='</tr>';                                
                                         }
                                    }
                                }
                            }
                        }
//                 $a = LbEmployeePayment::model()->getMonthByEmployeeAndYear($employee_id, $year->payment_year);
//                            $totalAllPayment = 0;
//                            $totalAllAmount = 0;
//                            $totalAllSalary = 0;
//                foreach ($a as $data) {    
//                                
//                               // total salary
//                                 
//                                    $salary = LbEmployeeSalary::model()->totalSalaryEmployee($employee_id);
//                                    $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($employee_id);
//                                    $totalSalary = $salary-$benefit; 
//                                     $totalAllSalary+=$totalSalary;
//                                //total Payment
//                                   
//                                    $payment_salary = LbEmployeePayment::model()->getPaidByMonth($data->payment_month,$employee_id, $year->payment_year) ;
//                                    
//                                    $totalAllPayment += $payment_salary;
//                                   // $payment = number_format($payment_salary,2);                       
//                                   
//                                //amount
//                                 
//                                    $amount = $totalSalary - $payment_salary;
//                                    
//                                    $totalAllAmount = $totalAllAmount + $amount;
//                    //view report
//                        
//                        $PDFPayment.='<tr>';
//                        $PDFPayment.='<td align="center">'.$data->payment_month.'/'.$data->payment_year.'</td>';                   
//                        $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
//                        $PDFPayment.='<td align="right">$'.number_format($payment_salary,2).'</td>';
//                        $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
//                        $PDFPayment.='<td>'.$data->payment_note.'</td>';
//                        $PDFPayment.='</tr>';
//                        
//                       
//                   
//                }
                
                $PDFPayment.='<tr>';
                $PDFPayment.='<td width="150" style="font-weight:bold;border-top:1px solid #000;" align="center" >'.Yii::t('lang','Total:').'</td>';
                   $PDFPayment.='<td style="border-top:1px solid #000; " ></td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.  number_format($totalAllSalary,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.number_format($totalPayment,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" >$'.number_format($totalAllAmount,2).'</td>';
                $PDFPayment.='<td style="border-top:1px solid #000; text-align:right" ></td>';               
                $PDFPayment.='</tr>';
                
                
                $PDFPayment.='
            </table>';
          
            
echo $PDFPayment;