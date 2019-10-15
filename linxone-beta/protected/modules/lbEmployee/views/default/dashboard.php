<?php
$m = $this->module->id;
$canAdd = BasicPermission::model()->checkModules($m, 'add');
$canList = BasicPermission::model()->checkModules($m, 'list');
//echo $m;
$canAddQuotation = BasicPermission::model()->checkModules('lbQuotation', 'add');
$canListQuotation = BasicPermission::model()->checkModules('lbQuotation', 'list');
$canAddPayment = BasicPermission::model()->checkModules('lbPayment', 'add');
$canView = BasicPermission::model()->checkModules($m, 'view');

//date
echo '<div id="lb-container-header">';
            
            echo '<div class="lb-header-right"><h3>Employees</h3></div>';
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
        <div class="panel-header-title-left" >
            <span style="font-size: 16px;"><b><?php echo Yii::t('lang','All Employee'); ?></b></span>
        </div>
        <div class="panel-header-title-right" style="margin-left:-80px;margin-top:-8px;">
            <?php if($canAdd){ ?>
                <a href="<?php echo $model->getCreateURLNormalized(array('group'=>strtolower(LbInvoice::LB_INVOICE_GROUP_INVOICE))); ?>"><i class="icon-plus"></i> <?php echo Yii::t('lang','New Employee'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>
            <?php if($canAddPayment) { ?>
                <a href="<?php echo $model->getActionURLNormalized('EnterPayment') ?>"><img width="16" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','Enter Payment'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php } ?>    
                <a href="" onclick="printPDF_employee(); return false;" target="_blank"><img width="16"  src="<?php echo Yii::app()->baseUrl.'/images/icons/icon_pdf.png' ?>" /> <?php echo Yii::t('lang','Print'); ?></a>                                    
        </div>
        <div style="float:right;margin-bottom:5px; ">
            <input type="text" placeholder="Search" value="" style="border-radius: 15px;" onKeyup="search_employee(this.value);">
        </div>
    </div>
  
    
<?php

echo '<div id="show_employee">';
$this->Widget('bootstrap.widgets.TbGridView',array(
            'id'=>'lb_expenses_gridview',
            'dataProvider'=>  $model->search(),
        //    'type'=>'striped bordered condensed',
            //'template' => "{items}",
            'template' => "{items}\n{pager}\n{summary}", 
            'columns'=>array(
                    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                             'template'=>'{delete}',
                              'htmlOptions'=>array('width'=>'10','height'=>'40px'),
                             'afterDelete'=>'function(link,success,data){ '
                            . 'if(data){ responseJSON = jQuery.parseJSON(data);'
                            . '     alert(responseJSON.error); }'
                            
                            . '}'
                        ),
                    array(
                        'header'=>Yii::t('lang','Name'),
                        'type'=>'raw',
                        'value'=>'LBApplication::workspaceLink($data->employee_name,$data->getViewURL("update",array("id"=>$data->lb_record_primary_key)))',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                  
                    array(
                        'header'=>Yii::t('lang','Birthday'),
                        'type'=>'raw',
                        'value'=>'date("d-m-Y", strtotime($data->employee_birthday))',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Phone 1'),
                        'type'=>'raw',
                        'value'=>'$data->employee_phone_1',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                    array(
                        'header'=>Yii::t('lang','Email 1'),
                        'type'=>'raw',
                        'value'=>'$data->employee_email_1',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                   
                    array(
                        'header'=>Yii::t('lang','Total Salary'),
                        'type'=>'raw',
                        'value'=>'number_format(LbEmployeeSalary::model()->totalSalaryEmployee($data->lb_record_primary_key)-LbEmployeeBenefits::model()->caculatorBenefitByEmployee($data->lb_record_primary_key),2)',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px','style'=>'text-align:right'),
                    ),
                    
                    array(
                        'header'=>Yii::t('lang','Note'),
                        'type'=>'raw',
                        'value'=>'$data->employee_note',
                        'htmlOptions'=>array('width'=>'130','height'=>'40px'),
                    ),
                  
            )
        ));

echo '</div>';

?>
</div>
<script lang="javascript">
    function search_employee(name)
    {
        name = replaceAll(name," ", "%");
        
//        if(name.length >= 3){
        $('#show_employee').load('<?php echo $this->createUrl('/lbEmployee/default/_search_employee');?>?name='+name
                  
            );
//        }
    }
    function replaceAll(string, find, replace) {
      return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }
    function escapeRegExp(string) {
        return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
    }
    function printPDF_employee(){
        window.open('printPDF_employee','_target');
    }
</script>