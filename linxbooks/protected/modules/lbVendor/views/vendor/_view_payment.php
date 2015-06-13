<style>
    span a{
        color: #000;
    }
    .chzn-container{
        top: 7px;
    }
</style>

<?php
$current_data = date('d-m-Y');
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
    <?php echo CHtml::dropDownList('select_customer','', $customer_option,array('class'=>'span4')); ?>
    <?php echo CHtml::label(Yii::t('lang','From'), "search_data_from",array('style'=>'display:inline;margin-left: 15px;'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_from',
                'value'=>  $current_data,
                'options' => array(
                    'format' => 'dd-mm-yyyy',
                    'viewformat' => 'dd-mm-yyyy',
                    'placement' => 'right',
                    'todayBtn'=>true,
                ),
                'htmlOptions'=>array('class'=>'span2','placeholder'=>'Date from','style'=>'margin-top: 8px;margin-right: 15px;'),
            ));
    ?>
    <?php echo CHtml::label(Yii::t('lang','To'), "search_data_to",array('style'=>'display:inline'));?>
    <?php $this->widget('ext.rezvan.RDatePicker',array(
                'name'=>'search_data_to',
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
    
    <?php echo CHtml::button(Yii::t('lang','Search'), array('onclick'=>'load_search_view_payment();return false;','class'=>'btn','style'=>'margin-top:-3px;')) ?>
</div>


<div id="form_view_detail_payment">
    <?php LBApplication::renderPartial($this,'_form_view_payment',  array()) ?>
</div>

<script>
   function load_search_view_payment(){
       var customer_id = $('#select_customer').val();
       var search_date_from = $('#search_data_from').val();
       var search_date_to = $('#search_data_to').val();
       $('#form_view_detail_payment').html('<img src="<?php echo YII::app()->baseUrl; ?>/images/loading.gif" /> Loading...');
       $('#form_view_detail_payment').load('AjaxLoadFormViewPayment',{customer_id:customer_id,search_date_from:search_date_from,search_date_to:search_date_to});
   } 
</script>