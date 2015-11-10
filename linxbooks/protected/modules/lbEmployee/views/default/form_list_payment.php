<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
//echo $m;
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');

$model = new LbEmployeePayment();
echo '<div id="lb-container-header">';
            
            echo '<div style="margin-left: -10px" class="lb-header-right"><h4>Employees</h4></div>';
            echo '<div class="lb-header-left">';
//            LBApplicationUI::backButton(LbExpenses::model()->getActionURLNormalized('expenses'));


            echo '&nbsp;';
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type' => '',
                'buttons' => array(
                    array('label' => '<i class="icon-plus"></i> '.Yii::t('lang','New'), 'items'=>array(
                        array('label'=>Yii::t('lang','New Employee'),'url'=> LbEmployee::model()->getActionURLNormalized('create')),
                        array('label'=>Yii::t('lang','New Payment Voucher'),'url'=> LbExpenses::model()->getActionURLNormalized('createPaymentVoucher')),
                     )),
                ),
                'encodeLabel'=>false,
            ));
            echo '</div>';
echo '</div><br>';
?>
<div class="panel">
    <div style="margin-top: 10px;" class="panel-header-title">
        <div class="panel-header-title-left">
            <span style="font-size: 16px;"><b><?php echo Yii::t('lang','Enter Payment'); ?></b></span>
        </div>
        <div style="margin-left:-50px;" class="panel-header-title-right">   
            <?php if($canAdd){ ?>
                <a href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Employee'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
            <?php if($canAddPayment) { ?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('lbPayment/default/create'); ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','Enter Payment'); ?></a>
            <?php } ?>
        </div>
        <div style="float:right;margin-bottom:5px; ">
            <input type="text" placeholder="Search" value="" style="border-radius: 15px;" id="name_val" onKeyup="search_payment(this.value);">
        </div>
    </div>

<?php
$date_now = date('Y-m-d');

$month_default= date('m', strtotime($date_now)); 
$year_default=  date('Y',strtotime($date_now));
echo '<div align="right">   
    <button style="margin-right:580px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_payment(); return false;">Print PDF</button>
    <span><b>Paid For Month:</b></span>
    <input type="text" id="paidForDate" class="text" value="'.date('m-Y').'"/>
    </div>';

$create_by = AccountProfile::model()->getFullName(Yii::app()->user->id);
//echo date('d', strtotime('12-08-3012'));
echo '<div id="show_payment">';

$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search(false,$month_default,$year_default),
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
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->employee_id)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->employee_id),2)',
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
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->employee_id)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->employee_id)-LbEmployeePayment::model()->totalPaidByDate($data->payment_month,$data->employee_id,$data->payment_year,$data->payment_date),2)',
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
//                    array(
//                            'header'=>Yii::t('lang','Created By'),
//                            'type'=>'raw',  
//                            'value'=> 'AccountProfile::model()->getFullName($data->payment_created_by)',
//                            'htmlOptions'=>array('width'=>'130'),  
//                        ),
              
            )
        ));

echo '</div><br/>';

?>
    
</div>
<script lang="javascript">
    $(function () {
            $('#paidForDate').datepicker({
               
                format: 'mm-yyyy',
                viewMode:'months',
                minViewMode:'years',
                onClose: function (dateText, inst) {

                    //Get the selected month value
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();

                    //Get the selected year value
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

                    //set month value to the textbox 
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            }).on('changeDate', function(ev) {
                var name_value = $('#name_val').val();
                search_payment(name_value);
            });
            
    });
    
    function search_payment(name)
    {
        var date_value = $('#paidForDate').val();
        name = replaceAll(name," ", "%");
        $('#show_payment').load('<?php echo $this->createUrl('/lbEmployee/default/_search_Payment');?>?name='+name+'&date='+date_value);
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    function printPDF_payment(){
        var date_value = $('#paidForDate').val();
         var name_value = $('#name_val').val();
        window.open('printPDF_AllPayment?month_year='+date_value+'&employee_name='+name_value+'','_target');
    } 
</script>