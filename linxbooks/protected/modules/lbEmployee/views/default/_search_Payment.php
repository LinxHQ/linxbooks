<?php

echo '<div id="show_payment">';
$date_now=  date_format(date_create('01-'.$date),'Y-m-d');
$month_default= date('m', strtotime($date_now)); 
$year_default=  date('Y',strtotime($date_now));
$model = LbEmployeePayment::model()->search($name,$month_default,$year_default);
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=> $model,
            'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'columns'=>array(

                    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                             'htmlOptions'=>array('width'=>'10'),
                             'deleteButtonUrl'=>'"' . LbEmployee::model()->getActionURLNormalized("ajaxDeletePayment") . '" .
                                                "?id={$data->lb_record_primary_key}"',
                             'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}'
                    ),
                    array(
                        'header'=>Yii::t('lang','Paid For Month'),
                        'type'=>'raw',  
                        'value'=> '$data->payment_month."/".$data->payment_year',
                        'htmlOptions'=>array('width'=>'90'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Date'),
                        'type'=>'raw',  
                        'value'=> 'date("d-m-Y", strtotime($data->payment_date))',
                        'htmlOptions'=>array('width'=>'90'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Name'),
                        'type'=>'raw',  
                        'value'=> ' LbEmployee::model()->getInfoEmployee($data->employee_id)["employee_name"];',
                        'htmlOptions'=>array('width'=>'130'),
                    ), 
                    array(
                        'header'=>Yii::t('lang','Total Salary($)'),
                        'type'=>'raw',  
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->employee_id),2)',
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:right;'),
                    ),                  
                    array(
                        'header'=>Yii::t('lang','Paid($)'),
                        'type'=>'raw',  
                        'value'=> 'number_format(LbEmployeePayment::model()->totalPaidByDate($data->payment_month,$data->employee_id,$data->payment_year,$data->payment_date),2);',
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:right;'),  
                    ),
                    array(
                        'header'=>Yii::t('lang','Balance($)'),
                        'type'=>'raw',  
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->employee_id)-LbEmployeePayment::model()->totalPaidByDate($data->payment_month,$data->employee_id,$data->payment_year,$data->payment_date),2)',
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:right;'),  
                    ),   
                    array(
                        'header'=>Yii::t('lang','New Payment($)'),
                        'type'=>'raw',  
                        'value'=> 'LbEmployeePayment::model()->getEmployeePayment(false,$data->lb_record_primary_key)["payment_paid"];',
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:right;'),  
                    ),  
                    array(
                            'header'=>Yii::t('lang','Note'),
                            'type'=>'raw',  
                           'value'=> 'LbEmployeePayment::model()->getEmployeePayment(false,$data->lb_record_primary_key)["payment_note"];',
                            'htmlOptions'=>array('width'=>'130'),  
                        ),
              
            )
        ));

echo '</div><br/>';
