<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');



if(isset($_GET['employee_id']) && $_GET['employee_id'] > 0)
    $employee_id = $_GET['employee_id'];
$employee = LbEmployee::model()->getInfoEmployee($employee_id);
$PDFSalaryEmployee = '<table border="0" style="margin:auto; width:100%;" cellpading="0" cellpacing="0">'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0" >
                    <tr><td>
                        <span style="font-size:20px; font-weight:bold;">Employee Salary:&nbsp;'.$employee->employee_name.'</span>
                    </td></tr>
                </table>
            </td></tr>'
            .'<tr><td>
                <table border="0" style="margin:auto; width:100%" cellpadding="0" cellpacing="0">
                    <tr><td>
                        <span style="margin-top:5px;">Address:&nbsp;&nbsp;'.$employee->employee_address.'  </span><br/>
                        <span style="margin-top:5px;">Email:&nbsp;&nbsp;'.$employee->employee_email_1.'  </span><br/>
                        <span style="margin-top:5px;">Phone:&nbsp;&nbsp;'.$employee->employee_phone_1.'  </span>
                        <span style="margin-top:20px;"></span>
                    </td></tr>
                </table>
                </td></tr>'
            .'</table>
            <h4 style="margin-left:20px;">Salary Components:</h4>
             <table border="1" style="width:100%;margin-top:20px;margin-left:10px;" cellpadding="0" cellspacing="0">';
                $PDFSalaryEmployee .= '<thead>
                    
                        <tr style="font-weight:bold;" align="center">                        
                           
                            <td width="350" class="lb-grid-header">'.Yii::t('lang','Salary Name').'</td>
                            <td width="350" class="lb-grid-header">'.Yii::t('lang','Salary Amount').'</td>
                            
                        </tr>
                    </thead>';
                 $a = LbEmployeeSalary::model()->getSalaryByEmployee($employee_id);
                 $salary = 0;
               foreach($a as $value ){                   
                   
                    $salary_name = UserList::model()->findByPk($value->salary_name)['system_list_item_name'];
                  
                        $PDFSalaryEmployee.='<tr>';
                     
                        $PDFSalaryEmployee.='<td align="center">'.$salary_name.'</td>';
                        $PDFSalaryEmployee.='<td align="center">$'.number_format($value->salary_amount,2).'</td>';
                       
                        $PDFSalaryEmployee.='</tr>';
                        
                       $salary+=$value->salary_amount;
                 
                }
                

                $PDFSalaryEmployee.='            
            </table>
            <h4 ">Benefits Detail:</h4>
            <table border="1" style="width:100%;margin-top:20px;margin-left:10px;" cellpadding="0" cellspacing="0">';
                $PDFSalaryEmployee .= '<thead>
                        
                        <tr style="font-weight:bold;" align="center">                        
                           
                            <td width="350" class="lb-grid-header">'.Yii::t('lang','Benefit Name').'</td>
                            <td width="350" class="lb-grid-header">'.Yii::t('lang','Benefit Amount').'</td>
                            
                        </tr>
                    </thead>';
                $a = LbEmployeeBenefits::model()->getBenefitsByEmployee($employee_id);
                
                $benefits = 0;
               foreach($a as $value ){                   
                    
                    $benefit_name = UserList::model()->findByPk($value->benefit_name)['system_list_item_name'];
                  
                        $PDFSalaryEmployee.='<tr>';
                   
                        $PDFSalaryEmployee.='<td align="center">'.$benefit_name.'</td>';
                        $PDFSalaryEmployee.='<td align="center">$'.number_format($value->benefit_amount,2).'</td>';
                       
                        $PDFSalaryEmployee.='</tr>';
                        
                       $benefits+=$value->benefit_amount;
                
                }
                

                $PDFSalaryEmployee.='
            </table>';
$PDFSalaryEmployee.= '<div style="margin-left:500px; margin-top:20px; width:30%; border: 1px solid black">'
                    . '<table style="text-align:right;width:100%;">'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b> Salary:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($salary,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Benefits:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($benefits,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Total Salary:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($salary - $benefits,2).'</b></td>'
                        . '</tr>'

                       

                    . '</table>'
                . '</div>';
echo $PDFSalaryEmployee;
