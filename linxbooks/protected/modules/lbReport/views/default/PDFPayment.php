<?php

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');


//$month_year = false;
if(isset($_GET['month_year']) && $_GET['month_year'] !="")
    $month_year = $_GET['month_year'];
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
                        <span style="margin-top:5px;">Paid For Month:  '.$month_year.'</span>
                        <span style="margin-top:20px;"></span>
                    </td></tr>
                </table>
            </td></tr>'
            .'</table>
            <table border="1"   style="margin-left:40px;margin-top:50px; width:100%;" class="items table table-bordered">';
                $PDFPayment .= '<thead>
                    
                        <tr style="font-weight:bold;" align="center">                        
                            <td width="150" class="lb-grid-header">'.Yii::t('lang','Name').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Total Salary').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Payment').'</td>
                            <td width="100" class="lb-grid-header">'.Yii::t('lang','Amount').'</td>
                            <td width="200" class="lb-grid-header">'.Yii::t('lang','Note').'</td>
                        </tr>
                </thead>';
                 $month = dateMY($month_year)[0];
                 $year = dateMY($month_year)[1];
                 $model = LbEmployeePayment::model()->getAllByMonthYear($month,$year);
                 $totalAllAmount = 0;
                 $totalAllSalary = 0;
                 $totalAllPayment = 0;
                foreach($model as $key ){
                   

                    //Employee name
                        $employee = LbEmployee::model()->getInfoEmployee($key['employee_id'])["employee_name"];
                    // total salary
                        $salary = LbEmployeeSalary::model()->totalSalaryEmployee($key['employee_id']);
                        $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($key['employee_id']);
                        $totalSalary = $salary-$benefit;
                        $totalAllSalary += $totalSalary;
                    //total Payment
                        //$totalPaid = 0;
                        $payment_salary = LbEmployeePayment::model()->getPaidByEmployee($key['employee_id'],$month, $year) ;
                        //$totalPaid += $payment_salary;
                        $payment = $payment_salary;                       
                        $totalAllPayment += $payment;
                    //amount
                     //   $amount = number_format(LbEmployeePayment::model()->caculatorAmount($key['employee_id']),2);
                        $amount = $salary - $benefit - $payment_salary;
                        $totalAllAmount += $amount;
                    //note
                        $note = $key['payment_note'];
                    //view report
                        
                        $PDFPayment.='<tr>';
                        $PDFPayment.='<td>'.$employee.'</td>';                   
                        $PDFPayment.='<td align="right">$'.number_format($totalSalary,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($payment,2).'</td>';
                        $PDFPayment.='<td align="right">$'.number_format($amount,2).'</td>';
                        $PDFPayment.='<td>'.$note.'</td>';
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