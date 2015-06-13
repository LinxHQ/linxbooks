<style>
    span a{
        color: #000;
    }
    .chzn-container{
        top: 7px;
    }
</style>
<?php
$current_data_cash = date('d-m-Y');
$lastMonth_data = date('d-m-Y',strtotime("+1 month -1 day"));

$customer_option=LbCustomer::model()->getCompanies($sort = 'lb_customer_name ASC',
                            LbCustomer::LB_QUERY_RETURN_TYPE_DROPDOWN_ARRAY);
$customer_option=array(0=>'All')+$customer_option;
?>

<?php $this->widget( 'ext.EChosen.EChosen', array(
  'target' => '#select_customer',
)); ?>
<div style="margin-bottom: 15px;">
    <span style="font-size: 16px;"><?php echo Yii::t('lang','Customer name');?>:</span>
    <?php echo CHtml::dropDownList('customer_gstReport','', $customer_option,array('class'=>'span4')); ?>
    <?php echo CHtml::label(Yii::t('lang','From'), "search_data_from_gstReport",array('style'=>'display:inline;margin-left: 15px;'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_from_gstReport',
                'value'=>  $current_data_cash,
                'options' => array(
                    'format' => 'dd-mm-yyyy',
                    'viewformat' => 'dd-mm-yyyy',
                    'placement' => 'right',
                    'todayBtn'=>true,
                ),
                'htmlOptions'=>array('class'=>'span2','placeholder'=>'Date from','style'=>'margin-top: 8px;margin-right: 15px;'),
            ));
    ?>
    <?php echo CHtml::label(Yii::t('lang','To'), "search_data_to_journal",array('style'=>'display:inline'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_to_gstReport',
                'value'=>  $lastMonth_data,
                'options' => array(
                    'format' => 'dd-mm-yyyy',
                    'viewformat' => 'dd-mm-yyyy',
                    'placement' => 'right',
                    'todayBtn'=>true,
                ),
                'htmlOptions'=>array('class'=>'span2','placeholder'=>'Date from','style'=>'margin-top: 8px;margin-right: 15px;'),
            ));
    ?>  
    
    <?php echo CHtml::button(Yii::t('lang','Search'), array('onclick'=>'load_search_view_gstReport();return false;','class'=>'btn','style'=>'margin-top:-3px;')) ?>
</div>


<div id="form_view_cash_gstReport">
        
</div>

<script>
   $('#form_view_cash_gstReport').load('AjaxLoadFormViewgstReport');

   function load_search_view_gstReport(){
       var customer_id_gstReport = $('#customer_gstReport').val();
       var search_data_from_gstReport = $('#search_data_from_gstReport').val();
       var search_data_to_gstReport = $('#search_data_to_gstReport').val();
      
       $('#form_view_cash_gstReport').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');
       $('#form_view_cash_gstReport').load('AjaxLoadFormViewgstReport',{customer_id_gstReport:customer_id_gstReport,search_data_from_gstReport:search_data_from_gstReport,search_data_to_gstReport:search_data_to_gstReport});
   } 
</script>