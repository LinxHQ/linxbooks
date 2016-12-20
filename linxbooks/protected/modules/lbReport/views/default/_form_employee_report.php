<style>
    span a{
        color: #000;
    }
    .chzn-container{
        top: 7px;
    }
</style>

<?php
$date_now = date('Y');
?>
<div class="panel">
    <div style="margin-top: 10px;" class="panel-header-title">
        <div class="panel-header-title-left">
            <span style="font-size: 20px;"><b><?php echo Yii::t('lang',' Employee Report'); ?></b></span>
        </div>
       
        
    </div>

    <div style="margin-bottom: 15px; margin-left: 170px;">
        <span style="font-size: 16px;"><?php echo Yii::t('lang','Employee Name');?>:</span>
        <?php 
            echo CHtml::dropDownList('employee', '', 
                  CHtml::listData(LbEmployee::model()->findAll(array('order'=>'employee_name')),
                  'lb_record_primary_key', 'employee_name'),
                  array('empty' => 'All')
                    );
        ?> 
        &nbsp;&nbsp;
        <span style="font-size: 16px;"><?php echo Yii::t('lang','Choose year');?>:</span>
        <?php 
            echo CHtml::dropDownList('payment_year', '', 
                  CHtml::listData(LbEmployeePayment::model()->findAll(array('group'=>'payment_year','order'=>'payment_year')),
                  'lb_record_primary_key', 'payment_year'),
                  array('empty' => 'All','class'=>'span2')
                    );
        ?> &nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::button(Yii::t('lang','Search'), array('onclick'=>'load_search_employee_report();return false;','class'=>'btn','style'=>'margin-top:-9px;')) ?>
        
        </div>
        
       
    </div>
    <div id="form_view_employee_report">



    </div><br/>


    
</div>







<script>
    
   //$('#form_view_employee_report').load('AjaxLoadViewEmployeeReport');

   function load_search_employee_report(){
       var employee_id = $('#employee').val();            
       var payment_year = $('#payment_year').val();
       
       $('#form_view_employee_report').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');      
       $('#form_view_employee_report').load('AjaxLoadViewEmployeeReport',{employee_id:employee_id,payment_year:payment_year});
   } 
   
</script>


