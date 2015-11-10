<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$create_by = AccountProfile::model()->getFullName(Yii::app()->user->id);
//echo date('d', strtotime(date('Y-m-d')));

$date_now=  date_format(date_create('01-'.$date),'Y-m-d');
$month_default= date('m', strtotime($date_now)); 
$year_default=  date('Y',strtotime($date_now));
//echo LbEmployeePayment::model()->getPaidByEmployee(12,$month_default,$year_default);
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model,
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(

                    array(
                        'header'=>Yii::t('lang','Name'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->employee_name,$data->getViewURLNormalized("update",array("id"=>$data->lb_record_primary_key)))',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    
                  
                    array(
                        'header'=>Yii::t('lang','Salary'),
                        'type'=>'raw',  
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->lb_record_primary_key)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->lb_record_primary_key)-LbEmployeePayment::model()->getPaidByEmployee($data->lb_record_primary_key,'.$month_default.','.$year_default.'),2)',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    
                    array(
                        'header'=>Yii::t('lang','Paid'),
                        'type'=>'raw',  
                        'value'=> 'CHtml::textField("paid_".$data->lb_record_primary_key,"",array("style"=>"width:80","onchange"=>"addData($data->lb_record_primary_key)"))',
                        'htmlOptions'=>array('width'=>'80'),  
                    ),
                    
                    array(
                        'header'=>Yii::t('lang','Note'),
                        'type'=>'raw',  
                        'value'=> 'CHtml::textArea("note_".$data->lb_record_primary_key,"",array("onchange"=>"addData($data->lb_record_primary_key)"))',
                        'htmlOptions'=>array('width'=>'130'),  
                    ), 
                    array(
                            'header'=>Yii::t('lang','Created By'),
                            'type'=>'raw',  
                            'value'=> "'".$create_by."'",
                            'htmlOptions'=>array('width'=>'130'),  
                        ),
                    
              
                   
            )
        ));

echo '<br/>';