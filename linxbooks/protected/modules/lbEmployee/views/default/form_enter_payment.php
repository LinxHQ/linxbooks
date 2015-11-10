<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
//echo $m;
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');

$model = new LbEmployee();
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
        <div class="panel-header-title-right" style="margin-left:-54px;margin-top:-8px;">
            <?php if($canAdd){ ?>
                <a href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Employee'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
            <?php if($canAddPayment) { ?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('lbPayment/default/create'); ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','Enter Payment'); ?></a>
            <?php } ?>
        </div>
        <div style="float:right;margin-bottom:5px; ">
            <input type="text" placeholder="Search" value="" style="border-radius: 15px;" id="name" onKeyup="search_payment(this.value);">
        </div>
    </div>
    
<?php
echo '<div align="right" >
    <span>Paid For Month:</span>
    <input style="margin-left:72px;margin-top:6px;" type="text" id="paidForDate" class="text" value="'.date('m-Y').'"/>
</div>';
$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;

$employee = LbEmployee::model()->getInfoEmployee($employee_id);
//$employee_name = $employee->employee_name;
//var_dump($employee_name);
$create_by = AccountProfile::model()->getFullName(Yii::app()->user->id);
//echo date('d', strtotime(date('Y-m-d')));
echo '<div id="show_enter_pay">';
$date_now = date('Y-m-d');

$month_default= date('m', strtotime($date_now)); 
$year_default=  date('Y',strtotime($date_now));

$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search(),
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

echo '</div><br/>';
echo '<div style="text-align: center" class="control-group">
     <a onclick="save_payment_employee();return false;" class="btn btn-success btn"><i class="icon-ok icon-white"></i> &nbsp; Save</a>&nbsp;&nbsp;
     <button style="border-radius:4px;border-width:1px;padding:4px 12px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_EnterPayment(); return false;">Print PDF</button>

</div>';
?>
    
</div>
<script lang="javascript">
    var data_post = new Array();
    var arr_date= new Object();
    var i = 0;

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
                var name_value = $('#name').val();
                search_payment(name_value);
            });
            
    });
    function search_payment(name)
    {
        var date_value = $('#paidForDate').val();
        name = replaceAll(name," ", "%");
        $('#show_enter_pay').load('<?php echo $this->createUrl('/lbEmployee/default/_search_Payment');?>?name='+name+'&date='+date_value+'&type=payment');
     
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    
    function addData(id)
    {
        arr_date.employee_id=id;
        arr_date.payment_paid=$('#paid_'+id).val();
        arr_date.payment_note=$('#note_'+id).val();
        
        data_post[id]=arr_date;
        
        i++;
    }
    function save_payment_employee()
    {
        var datePaid='01-'+$('#paidForDate').val();
        $.ajax({
            type:'POST',
            url:'<?php echo LbEmployee::model()->getActionURLNormalized('Payment',array()) ?>',
            data:{LbEmployeePayment:data_post,datePaid:datePaid},
            success:function(data){
               
                    alert("Success payment!");
                    location.reload(true);
                
            }
        });
    }
    function printPDF_EnterPayment(){
        var month_year = $('#paidForDate').val();
        var employee_name = $('#name').val();
       
        window.open('printPDF_EnterPayment?month_year='+month_year+'&employee_name='+employee_name+'','_target');
    }
</script>