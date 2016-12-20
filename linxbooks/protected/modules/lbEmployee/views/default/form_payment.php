<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
//echo $m;
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');


$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : 0;
$employee = LbEmployee::model()->getInfoEmployee($employee_id);
$create_by = AccountProfile::model()->getFullName(Yii::app()->user->id);
echo '<div id="lb-container-header">';
            
            echo '<div style="margin-left: -10px" class="lb-header-right"><h3>Employees:'.$employee->employee_name.'</h3></div>';
            echo '<div class="lb-header-left">';
            LBApplicationUI::backButton(LbEmployee::model()->getActionURLNormalized('View',array('id'=>$employee_id)));


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
    
    
<?php
echo '<div align="right" >
    <span>Paid For Month:</span>
    <input style="margin-left:72px;margin-top:6px;" type="text" id="paidForDate" class="text" value="'.date('m-Y').'"/>
</div>';

echo '<div id="show_enter_pay">';
$date_now = date('Y-m-d');
$date = date('m-Y');
$month_default= date('m', strtotime($date_now)); 
$year_default=  date('Y',strtotime($date_now));

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
                        'value'=> 'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->lb_record_primary_key)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->lb_record_primary_key),2)',
                        'htmlOptions'=>array('width'=>'130'),
                    ),
                  
                    array(
                        'header'=>Yii::t('lang','Pay'),
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
                        'value'=> 'CHtml::textArea("note_".$data->lb_record_primary_key,"")',
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
               // var name_value = $('#name').val();
                search_payment();
            });
            
    });
    function search_payment()
    {
        var date = $('#paidForDate').val();         
        $('#show_enter_pay').load('<?php echo $this->createUrl('/lbEmployee/default/_search_Payment');?>?employee_id=<?php echo $employee_id ;?>&date='+date+'&type=payment');
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    
    function addData(id)
    {
        
         data_post.push(id);
         var payment_paid_arr = new Array();    
        var check_item = 0;
        for (i = 0; i < data_post.length; i++) {        
            var j = data_post[i];
            payment_paid_arr[i] = $('#paid_'+j).val();           
            if(isNaN(payment_paid_arr[i])===true){
                check_item = 1;
            }
        }
        if(check_item===1){
            alert("Please enter Paid must is number");
            return;
        }
      
       
    }
    
    function save_payment_employee()
    {   
        var datePaid='01-'+$('#paidForDate').val();
        for(i=1; i<=data_post.length; i++){
            var j = data_post[i-1];
            var data_payment = new Array();
            arr_date.employee_id=j;
            arr_date.payment_paid=$('#paid_'+j).val();
            arr_date.payment_note=$('#note_'+j).val();
            data_payment[j] = arr_date;
        $.ajax({
            type:'POST',
            url:'<?php echo LbEmployee::model()->getActionURLNormalized('Payment',array()) ?>',
            data:{LbEmployeePayment:data_payment,datePaid:datePaid},
            success:function(data){
                alert("Success payment!");
                $('#show_enter_pay').load('<?php echo $this->createUrl('/lbEmployee/default/_search_Payment');?>?employee_id=<?php echo $employee_id ;?>&date=<?php echo $date;?>&type=payment');                              
            }
        });
        }

       
    }
    function printPDF_EnterPayment(){
        var month_year = $('#paidForDate').val();
     //   var employee_name = $('#name').val();
       
        window.open('printPDF_EnterPayment?month_year='+month_year+'&employee_name=<?php echo $employee->employee_name;?>','_target');
    }
</script>