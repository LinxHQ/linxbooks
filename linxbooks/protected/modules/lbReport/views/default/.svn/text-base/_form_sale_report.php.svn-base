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
    <?php echo CHtml::dropDownList('customer_saleReport','', $customer_option,array('class'=>'span4')); ?>
    <?php echo CHtml::label(Yii::t('lang','From'), "search_data_from_saleReport",array('style'=>'display:inline;margin-left: 15px;'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_from_saleReport',
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
    <?php echo CHtml::label(Yii::t('lang','To'), "search_data_to_saleReport",array('style'=>'display:inline'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_to_saleReport',
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
    
    <?php echo CHtml::button(Yii::t('lang','Search'), array('onclick'=>'load_search_view_saleReport();return false;','class'=>'btn','style'=>'margin-top:-3px;')) ?>
</div>


<div id="form_view_saleReport">
        
</div>

<script>
   $('#form_view_saleReport').load('AjaxLoadFormViewsaleReport');

   function load_search_view_saleReport(){
       var customer_id_saleReport = $('#customer_saleReport').val();
       var search_data_from_saleReport = $('#search_data_from_saleReport').val();
       var search_data_to_saleReport = $('#search_data_to_saleReport').val();
       $('#form_view_saleReport').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');
       $('#form_view_saleReport').load('AjaxLoadFormViewsaleReport',{customer_id_saleReport:customer_id_saleReport,search_data_from_saleReport:search_data_from_saleReport,search_data_to_saleReport:search_data_to_saleReport});
   } 
</script>