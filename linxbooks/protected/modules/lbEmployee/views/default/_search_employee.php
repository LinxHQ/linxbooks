<?php
$m = $this->module->id;
$canList = BasicPermission::model()->checkModules($m, 'list');

 $this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=> LbEmployee::model()->searchEmployeeByName($name),
           // 'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
                    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                             'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}'
                        ),
                    array(
                        'header'=>Yii::t('lang','Name'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->employee_name,$data->getViewURLNormalized("update",array("id"=>$data->lb_record_primary_key)))',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                  
                    array(
                        'header'=>Yii::t('lang','Birthday'),
                        'type'=>'raw',
                        'value'=>'date("d-m-Y", strtotime($data->employee_birthday))',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Phone 1'),
                        'type'=>'raw',
                        'value'=>'$data->employee_phone_1',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Email 1'),
                        'type'=>'raw',
                        'value'=>'$data->employee_email_1',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                   
                    array(
                        'header'=>Yii::t('lang','Salary'),
                        'type'=>'raw',
                        'value'=>'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->lb_record_primary_key)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->lb_record_primary_key),2)',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                    
                    array(
                        'header'=>Yii::t('lang','Note'),
                        'type'=>'raw',
                        'value'=>'$data->employee_note',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                  
            )
        ));

echo '</div>';