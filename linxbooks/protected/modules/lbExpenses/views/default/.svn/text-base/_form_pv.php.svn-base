<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




$pv_no = LbPaymentVoucher::model()->createPVno();
$pv_date = date('d-m-Y');
$pv_title = false;
$lb_pv_description = false;
$creditBy = AccountProfile::model()->getFullName(Yii::app()->user->id);
if (isset($_REQUEST['id']))
{
     $modelPV = LbPaymentVoucher::model()->findByPk($_REQUEST['id']);
     $pv_no= $modelPV['lb_payment_voucher_no'];
     $pv_date= DateTime::createFromFormat('Y-m-d', $modelPV['lb_pv_date'])->format('d-m-Y');
     
     $pv_title= $modelPV['lb_pv_title'];
     $pv_create_by= $modelPV['lb_pv_create_by'];
     $lb_pv_description= $modelPV['lb_pv_description'];
     $creditBy = AccountProfile::model()->getFullName($modelPV['lb_pv_create_by']);
    
}



echo '<span>Fields with * are required.</span><br /><br />';
echo '<div class = "_form_pv">';
echo '<table>';
echo '<tr><td >'.Yii::t('lang','PV No*').':</td>'
        .'<td style="padding-left:10px;padding-right:200px"><input id = "pv_no" type = "text" value="'.$pv_no.'" /></td>';
 echo '<td>'.Yii::t('lang','Date').':</td>'
        .'<td style="padding-left:10px;"><input type="text" id="pv_date" name="LbExpenses[lb_expenses_date]" value="'.$pv_date.'"><span style="display: none" id="LbExpenses_lb_expenses_date_em_" class="help-inline error"></span></td>'
        .'</tr>';

echo '<tr><td >'.Yii::t('lang','Title').':</td>'
        .'<td style="padding-left:10px;padding-right:200px"><input id="pv_title" type = "text" value="'.$pv_title.'" /></td>'
        .'<td>'.Yii::t('Create ','Create By').':</td>'
        .'<td style="padding-left:10px;"><input type = "text" value="'.$creditBy.'" /></td>'
        .'</tr>';


echo '<tr><td >'.Yii::t('lang','Description').':</td>'
        .'<td style="padding-left:10px;padding-right:200px"><textarea id="pv_description" type = "text" >'.$lb_pv_description.'</textarea></td>'
        
        .'</tr>';

echo '</table>';
echo '</div>';

?>
<script language="javascript">
 $(document).ready(function(){
        var from_date = $("#pv_date").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
    });
    </script>