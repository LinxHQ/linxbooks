<?php

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$month_year = false;
if(isset($_POST['month_year']) && $_POST['month_year'] !="")
    $month_year = $_POST['month_year'];

function dateMY($date){
    $arr = explode('-',$date);
    return $arr;
}
$month = dateMY($month_year)[0];
$year = dateMY($month_year)[1];
 $countEmployee = LbEmployeePayment::model()->getCountEmployeeMonthYear($month,$year);
//var_dump($month);
//var_dump($year);
//var_dump($countEmployee);
?>
 
<form>
            <table border="0" width="100%" class="items table table-bordered">
                <thead>
                        <tr style="font-weight:bold;" >
                           
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Employee'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Total Salary'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Payment'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Amount'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Note'); ?></th>
                            
                            
                        </tr>
                </thead>  
                
                    <?php                                                  
                            $a = LbEmployeePayment::model()->getAllByMonthYear($month,$year);
                            $totalPayment = 0;
                            $totalAllAmount = 0;
                            $totalAllSalary = 0;
                            foreach ($a as $data) {    
                                $payment_month = $data->payment_month;
                                $payment_year = $data->payment_year;
                                //if(($month == $payment_month) ){
                                //Employee name
                                    $employee = LbEmployee::model()->getInfoEmployee($data->employee_id);
                                  
                                // total salary
                                // 
                                    $salary = LbEmployeeSalary::model()->totalSalaryEmployee($data->employee_id);
                                    $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->employee_id);
                                    $totalSalary = $salary-$benefit;
                                    $totalAllSalary+= $totalSalary;
                                //total Payment
                                   
                                    $payment_salary = LbEmployeePayment::model()->getPaidByEmployee($data->employee_id,$month, $year) ;
                                    
                                    $totalPayment += $payment_salary;
                                   // $payment = number_format($payment_salary,2);                       

                                //amount
                                 
                                    $amount = $salary - $benefit - $payment_salary;
                                    
                                    $totalAllAmount = $totalAllAmount + $amount;
                                
                                //view report
                                   // $i=0;
                                                                        
                                    
                                        echo '<tr>';
                                      //  echo '<td style="text-align:center">'.$i.'</td>';
                                        echo '<td>'.$employee->employee_name.'</td>';                   
                                        echo '<td style="text-align:right">$'.number_format($totalSalary,2).'</td>';
                                        echo '<td style="text-align:right">$'.number_format($payment_salary,2).'</td>';
                                        echo '<td style="text-align:right">$'.number_format($amount,2).'</td>';
                                        echo '<td>'.$data->payment_note.'</td>';
                                        echo '</tr>';
                                   

                            }
                
                ?>
              
                <tfoot>
                    <?php
                                echo '<tr >';
                                echo '<td colspan="1" style="border-top:1px solid #000" ><b>TOTAL:</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalAllSalary,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalPayment,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalAllAmount,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"></td>';
                                echo '</tr>';
                    ?>
                </tfoot>
            </table>
</form>
