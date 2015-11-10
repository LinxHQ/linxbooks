<?php

$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');

$payment_year = false;
$employee_id = false;
if(isset($_POST['payment_year']) && $_POST['payment_year'] !="")
    $payment_year = $_POST['payment_year'];
if(isset($_POST['employee_id']) && $_POST['employee_id'] !="")
    $employee_id = $_POST['employee_id'];


?>
<button style="margin-right:580px;border-radius:4px;border-width:1px;padding:4px 12px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_employee(); return false;">Print PDF</button>
<br/>     
<form style="margin-top: 10px;">
            <table border="0" width="100%" class="items table table-bordered">
                <thead>
                        <tr style="font-weight:bold;" >
                           
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Paid For Month'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Total Salary'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Payment'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Amount'); ?></th>
                            <th width="150" style="text-align: center;" class="lb-grid-header"><?php echo Yii::t('lang','Note'); ?></th>
                            
                            
                        </tr>
                </thead>  
                
                    <?php                                 
                     //Employee name
                            //$employee = LbEmployee::model()->getInfoEmployee($employee_id);
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
                                 
                                    $amount = $totalSalary - $payment_salary;
                                    
                                    $totalAllAmount = $totalAllAmount + $amount;
                                
                                //view report
                                   // $i=0;
                                                                        
                                    
                                        echo '<tr>';
                                      //  echo '<td style="text-align:center">'.$i.'</td>';
                                        echo '<td style="text-align:center">'.$data->payment_month.'/'.$data->payment_year.'</td>';                   
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
                                echo '<td colspan="1" style="border-top:1px solid #000;text-align:center" ><b>TOTAL:</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalAllSalary,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalPayment,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"><b>$'.number_format($totalAllAmount,2).'</b></td>';
                                echo '<td style="border-top:1px solid #000; text-align:right"></td>';
                                echo '</tr>';
                    ?>
                </tfoot>
            </table>
</form>
<script>
    function printPDF_employee(){
         window.open('PDFEmployee?employee_id=<?php echo $employee_id; ?>&payment_year=<?php echo $payment_year; ?>','_target');
    }
</script>

