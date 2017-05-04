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

?>
<div class="panel">
    <div style="margin-top: 10px;" class="panel-header-title">
        <div class="panel-header-title-left">
            <span style="font-size: 20px;"><b><?php echo Yii::t('lang',' Payment Report'); ?></b></span>
        </div>
       
        
    </div>

<?php
$date_now = date('Y-m-d');


echo '<div align="right">   
    <button style="margin-right:580px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_payment(); return false;">Print PDF</button>
    <span><b>Paid For Month:</b></span>
    <input type="text" id="paidForDate" class="text" value="'.date('m-Y').'"/>
    </div>';

//$create_by = AccountProfile::model()->getFullName(Yii::app()->user->id);
//echo date('d', strtotime('12-08-3012'));
echo '<div id="show_payment">';



echo '</div><br/>';

?>
    
</div>
<script lang="javascript">
    
    var date_value = $('#paidForDate').val();
    $('#show_payment').load('AjaxLoadFormViewPayment',{month_year:date_value});
    
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
                //var name_value = $('#name_val').val();
                load_search_payment();
            });
            
    });
   
    function load_search_payment()
    {
        var date_value = $('#paidForDate').val();
       
        $('#show_payment').html('<img src="<?php echo YII::app()->baseUrl;?>/images/loading.gif"/>Loading...');
        $('#show_payment').load('AjaxLoadFormViewPayment',{month_year:date_value});
     
   
    }

    function printPDF_payment(){
        var date_value = $('#paidForDate').val();
        window.open('printPDF_payment?month_year='+date_value+'','_target');
    } 
</script>
