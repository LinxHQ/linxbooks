<?php
//$model =  LbEmployee::model()->findAllBySql('Select * from lb_employee');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$PDFEmployee = '<table border="0" style="margin:auto; width:100%;" cellpadding="0" cellspacing="0">'
        .'<tr><td>
            <table border="0" style="margin:auto;width:100%;" cellpadding="0" cellspacing="0">
                <tr><td>
                    <span style="font-size:20px; font-weight:bold;">List Employee</span>
                </td></tr>
            </table>
          </td></tr>'
        .'</table>   
         <table border="1" style="width:100%;margin-top:20px;margin-left:10px;" cellpadding="0" cellspacing="0">';
                    $PDFEmployee.='<thead>        
                            <tr style="font-weight:bold;" align="center">
                                <th width="120" class="lb-grid-header">'.Yii::t('lang','Name').'</th>
                                <th width="100" class="lb-grid-header">'.Yii::t('lang','Birthday').'</th>
                                <th width="100" class="lb-grid-header">'.Yii::t('lang','Phone').'</th>
                                <th width="100"  class="lb-grid-header">'.Yii::t('lang','Total Salary').'</th>
                                <th width="130" class="lb-grid-header">'.Yii::t('lang','Email').'</th>
                                
                                <th width="70" class="lb-grid-header">'.Yii::t('lang','Address').'</th>
                                
                            </tr>
                    </thead>';
                        foreach ($model as $key => $value) {
                            $salary = LbEmployeeSalary::model()->totalSalaryEmployee($model[$key]['lb_record_primary_key']);
                            $benefit = LbEmployeeBenefits::model()->caculatorBenefitByEmployee($model[$key]['lb_record_primary_key']);
                            $totalSalary = number_format($salary-$benefit,2);
                            $PDFEmployee.='<tr>';
                            $PDFEmployee.='<td>'.$model[$key]['employee_name'].'</td>';
                            $PDFEmployee.='<td align="center">'.date('d/M/Y',  strtotime($model[$key]['employee_birthday'])).'</td>';
                            $PDFEmployee.='<td aligm="center">'.$model[$key]['employee_phone_1'].'</td>';
                            $PDFEmployee.='<td align="right">'.$totalSalary.'</td>';
                            $PDFEmployee.='<td>'.$model[$key]['employee_email_1'].'</td>';                               
                            $PDFEmployee.='<td>'.$model[$key]['employee_address'].'</td>';
                            $PDFEmployee.='</tr> ';
                
                        }        
                    $PDFEmployee.='
                        
          </table>';
        
              
echo $PDFEmployee;
 