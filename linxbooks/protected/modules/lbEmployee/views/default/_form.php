<?php
/* @var $this DefaultControllersController */
/* @var $model LbEmployee */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'lb-employee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'type' => 'inline',
)); ?>
<fieldset>
	
	<?php 
        $employee_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $date_now = date('m-Y');
        if(isset($employee_id) && $employee_id > 0){
        ?>          
             <p class="note">Fields with <span class="required">*</span> are required. &nbsp;
                
                 <a href="<?php echo LbEmployee::model()->getActionURLNormalized('EnterPayment',array('employee_id'=>$employee_id)) ?>"><img width="16" style="margin-left: 100px;" src="<?php echo Yii::app()->baseUrl.'/images/icons/dolar.png' ?>" /> <?php echo Yii::t('lang','Enter Payment'); ?></a>
                 <a href="<?php echo LbEmployee::model()->getActionURLNormalized('printPDF_DetailSalaryEmployee', array('employee_id'=>$employee_id))?>" target="_blank"><img width="16" style="margin-left: 50px;" src="<?php echo Yii::app()->baseUrl.'/images/icons/icon_pdf.png' ?>" /> <?php echo Yii::t('lang','Print'); ?></a>
             </p>
        <?php   
        }  else {
            echo '<p class="note">Fields with <span class="required">*</span> are required.</p>';
        }
        
        
        $test=array();
        $benefit=array();
        if(isset($_GET['id']))
        {
            $test =LbEmployeeSalary::model()->findAll('employee_id='.$_GET['id']);
            $benefit =  LbEmployeeBenefits::model()->findAll('employee_id='.$_GET['id']);
         
            $salaryModel = new LbEmployeeSalary();
            $benefitModel = new LbEmployeeBenefits();
        }
         $salary = UserList::model()->getItemsForListCode('salary');
         $benefit_employee = UserList::model()->getItemsForListCode('benefit');  
         $option_salary_update = CHtml::listData($salary, 'system_list_item_id', 'system_list_item_name');
         $option_benefit_update = CHtml::listData($benefit_employee, 'system_list_item_id', 'system_list_item_name');
         $option_salary ='<option value="0">choose salary</option>';
            foreach ($salary as $data)
            {
                $option_salary .='<option value="'.$data['system_list_item_id'].'">'.$data['system_list_item_name'].'</option>';
            }
         $option_benefit ='<option value="0">choose benefit</option>';
            foreach ($benefit_employee as $value) {
                $option_benefit .='<option value="'.$value['system_list_item_id'].'">'.$value['system_list_item_name'].'</option>';
            }
        echo $form->errorSummary($model); 
	
		echo '<div class="accordion" id="accordion2">';
		/**
		 * ============= BASIC INFORMATION
		 */
		
		// accordion group starts
		echo '<div class="accordion-group">';
		
		// heading
                echo '<div class="accordion-heading" id="new_payment">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#form_new_payment">
                      <i></i>
                      <span style="color: #fff;font-size: 14px; font-weight: bold">Basic Information</span>
                      </a>
                    </div>';
		
                
                echo '<div id="form_new_payment" class="accordion-body collapse in">
      			<div class="accordion-inner">';
                 ?>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                    <?php echo $form->labelEx($model,'employee_name',array('class'=>'lable-employee','style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_name',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'employee_name'); ?>
                    </div>
                    
                    <div class="right-form">
                    <?php echo $form->labelEx($model,'employee_address',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_address',array('rows'=>6, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'employee_address'); ?>
                
                    </div>
                </div>    
                <br/>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                    <?php echo $form->labelEx($model,'employee_birthday',array('style'=>"width:90px")); ?>
                    <?php // echo $form->dateField($model,'employee_birthday'); ?>
                    <?php 
                 
                    echo $form->textFieldRow($model, 'employee_birthday', 
                    array('hint'=>'Format: dd-mm-yyyy, e.g. 31-12-2013', 'value'=>$model->employee_birthday ? date('d-m-Y', strtotime($model->employee_birthday)) : date('d-m-Y')));?>
                    
                    </div>
                    
                    <div class="right-form">
                    <?php echo $form->labelEx($model,'employee_phone_1',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_phone_1'); ?>
                    <?php echo $form->error($model,'employee_phone_1'); ?>
                </div>
                </div>    
                <br/>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                
                    <?php echo $form->labelEx($model,'employee_phone_2',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_phone_2'); ?>
                    <?php echo $form->error($model,'employee_phone_2'); ?>
                    </div>

                    <div class="right-form">
                    <?php echo $form->labelEx($model,'employee_email_1',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_email_1',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'employee_email_1'); ?>
                    </div>
                </div>    
                <br/>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                
                    <?php echo $form->labelEx($model,'employee_email_2',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_email_2',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'employee_email_2'); ?>
                    </div>

                    <div class="right-form">
                    <?php echo $form->labelEx($model,'employee_code',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_code',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'employee_code'); ?>
                    </div>
                </div>    
                <br/>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                
                    <?php echo $form->labelEx($model,'employee_tax',array('style'=>"width:90px")); ?>
                    <?php echo $form->textField($model,'employee_tax',array('size'=>60,'maxlength'=>255)); ?>
                    <?php echo $form->error($model,'employee_tax'); ?>
                    </div>
                    <div class="right-form">
                    <?php echo $form->labelEx($model,'employee_bank',array('style'=>"width:90px")); ?>
                    <?php echo $form->textArea($model,'employee_bank',array('rows'=>4, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'employee_bank'); ?>
                    </div>
                    
                </div>    
                <br/>
                <div style="margin-bottom:25px;">
                    <div class="left-form">
                    <?php echo $form->labelEx($model,'employee_note',array('style'=>"width:90px")); ?>
                    <?php echo $form->textArea($model,'employee_note',array('rows'=>4, 'cols'=>50)); ?>
                    <?php echo $form->error($model,'employee_note'); ?>
                    </div>
                    
                </div>

	<?php
        echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END CONTACT **/
                
        
                //Employee salary
                echo '<div class="accordion-group">';
		
		// heading
		
                echo '<div class="accordion-heading" id="new_salary">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#form_view_salary">
                      <i></i>
                      <span style="color: #fff;font-size: 14px; font-weight: bold">Salary Components</span>
                      </a>
                    </div>';
                echo '<div id="form_view_salary" class="accordion-body collapse in">
      			<div class="accordion-inner">';

                
		echo '<table id="table_salary" class="items table">';
//                echo '<thead><tr>';
//                echo '<th>#</th>';
//                echo '<th>Salary Name</th>';
//                echo '<th>Salary Amount</th>';
//                echo '</tr></thead>';
                echo '<tbody>';
                $total_salary=0;
                if(count($test) > 0)
                {
                    
                    $i=1;
                    foreach ($test as $data)
                    {
                        $total_salary +=$data->salary_amount;
                        echo '<tr id="tr_row_salary_'.$i.'">';
                        echo '<td><a href="'.$this->createAbsoluteUrl('AjaxDeleteItem',array('id'=>$data->lb_record_primary_key,'employee_id'=>$model->lb_record_primary_key)).'"><i class="icon-trash"></i></a></td>';
                    //    echo '<td>'.'<select name="salary_name[]" id="salary_name">'.$data->salary_name.$option_salary.'</select>'.'</td>';
                        echo '<td>'.$form->dropDownList($data,'salary_name',$option_salary_update,array('empty'=>$data->salary_name,'name'=>'salary_name[]')).'</td>';
                        echo '<td>'.$form->textField($data,'salary_amount',array('name'=>'salary_amount[]'),array('style'=>"margin-left:29px;placeholder:test")).'</td>';
                        echo '<td hidden="true">'.$form->textField($data,'lb_record_primary_key',array('name'=>'lb_record_primary_key[]')).'</td>';

                        echo '</tr>';
                        $i++;
                    }
                }
                else
                {
                    echo '<tr id="tr_row_salary_1">';
                    echo '<td></td>';
                   
                  //  echo '<td>'.$form->dropDownList($salaryModel, 'salary_name', $option_salary,array('empty'=>'Choose salary','name'=>'salary_name[]')).'</td>';
                    echo '<td>'.'<select name="salary_name[]" id="salary_name" >'.$option_salary.'</select>'.'</td>';
//          
                    //echo '<td>'.$form->dropDownList($salaryModel, 'salary_name', CHtml::listData(LbEmployeeSalary::model()->findAll(), 'lb_record_primary_key', 'salary_name'));
                    //echo '<td>'.$form->textField($salaryModel,'salary_name',array('name'=>'salary_name[]')).'</td>';
                    echo '<td>'.$form->textField($salaryModel,'salary_amount',array('name'=>'salary_amount[]')).'</td>';
                    echo '<td hidden="true">'.$form->textField($salaryModel,'lb_record_primary_key',array('name'=>'lb_record_primary_key[]')).'</td>';

                    echo '</tr>';
                }
               
                echo '</tbody>';
                
                echo '</table>';
		// body
                echo '<span><a href="#" onclick="addSalary();return false;"><i class="icon-plus"></i>New salary</a></span>';
		
		echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END CONTACT **/
        ?>
                
         <?php
     
                
                echo '<div class="accordion-group">';
		
		// heading
		echo '<div class="accordion-heading" id="new_benefit">
                      <a class="accordion-toggle" data-toggle="collapse"  href="#form_view_benefit">
                      <i></i>
                      <span style="color: #fff;font-size: 14px; font-weight: bold">Benefits</span>
                      </a>
                    </div>';
                echo '<div class="accordion-heading">';
               
                echo '</div>'; 
                echo '<div id="form_view_benefit" class="accordion-body collapse in">
      		<div class="accordion-inner">';
                echo '<table id="table_benefits" class="items table" >';
//                echo '<thead><tr>';
//                
//                echo '<th></th>';
//                echo '<th>Benefits Name</th>';
//                echo '<th>Benefits Amount</th>';
//                echo '</tr></thead>';
                echo '<tbody>';
                $total_benefit = 0;
                if(count($benefit) > 0)
                {
                    $tax_id=count($benefit);
                    $i=1;
                    foreach ($benefit as $data)
                    {
                        
                        $total_benefit +=$data->benefit_amount;
                        echo '<tr id="tr_row_benefits_'.$i.'">';
                    //    echo '<td><a href="#" onclick="delete_item_benefit_update('.$data->lb_record_primary_key.');return false"><i class="icon-trash"></a></td>';
                        echo '<td><a href="'.$this->createAbsoluteUrl('AjaxDeleteBenefit',array('id'=>$data->lb_record_primary_key,'employee_id'=>$model->lb_record_primary_key)).'"><i class="icon-trash"></i></a></td>';
                        echo '<td>'.$form->dropDownList($data,'benefit_name',$option_benefit_update,array("empty"=>$data->benefit_name,'name'=>'benefit_name[]')).'</td>';
                      //  echo '<td>'.'<select name="benefit_name[]" id="benefit_name">'.$option_benefit.'</select>'.'</td>';
                    
                       // echo '<td>'.$form->textField($data,'benefit_name',array('name'=>'benefit_name[]')).'</td>';
//                        echo '<td>';
//                        echo '<td>'.$form->dropDownListRow($data, 'benefit_tax', array("0"=>"")+
//                                CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
//                                        function($tax){return "$tax->lb_record_primary_key";},
//                                        function($tax){return "$tax->lb_tax_value";}),array('name'=>'benefit_tax[]','onchange'=>'changeTax('.$i.');','id'=>'benefit_tax_"'.$i.'"'));
                        echo '<td>'.$form->textField($data,'benefit_amount',array('name'=>'benefit_amount[]')).'</td>';
                        echo '<td hidden="true">'.$form->textField($data,'lb_record_primary_key',array('name'=>'key_benefits[]')).'</td>';

                        echo '</tr>';
                        $i++;
                    }
                }
                else
                {
                    $tax_id=1;
                    echo '<tr id="tr_row_benefits_1">';
                    echo '<td><a href="#" onclick="delete_item_benefit(1);return false;"><i class="icon-trash"></i></a></td>';
                    echo '<td>'.'<select name="benefit_name[]" id="benefit_name" >'.$option_benefit.'</select>'.'</td>';
                    
                    //echo '<td>'.$form->dropDownList($benefitModel, 'benefit_name',$option_benefit,array('empty'=>'Choose benefit')).'</td>';
                    //echo '<td>'.$form->textField($benefitModel,'benefit_name',array('name'=>'benefit_name[]')).'</td>';
                    
//                    echo '<td>'.$form->dropDownListRow($benefitModel, 'benefit_tax', array("0"=>"")+
//                                CHtml::listData(LbTax::model()->getTaxes("",LbTax::LB_QUERY_RETURN_TYPE_MODELS_ARRAY),
//                                        function($tax){return "$tax->lb_record_primary_key";},
//                                        function($tax){return "$tax->lb_tax_value";}),array('name'=>'benefit_tax[]','onchange'=>'changeTax(1);','id'=>'benefit_tax_1'));
                    echo '<td>'.$form->textField($benefitModel,'benefit_amount',array('name'=>'benefit_amount[]','id'=>'benefit_amount_1')).'</td>';
                    echo '<td hidden="true">'.$form->textField($benefitModel,'lb_record_primary_key',array('name'=>'key_benefits[]')).'</td>';

                    echo '</tr>';
                }
                echo '<input type="hidden"  value='.$tax_id.' id="tax_id"/>';
                echo '</tbody>';
                
                echo '</table>';
		// body
                echo '<span><a href="#" onclick="addBenefit();return false;"><i class="icon-plus"></i>New Benefit</a></span>';
		
		
		echo '</div></div>'; // end body
		echo '</div>';// end accordion-group
		/** END CONTACT **/
               $info='<br/><div>'
                
                . '<div style="float:right; width:30%; border: 1px solid buttonshadow">'
                    . '<table style="text-align:right;width:100%;">'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Salary:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($total_salary,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Benefit:</b></td>'
                            . '<td style="text-align:right;padding:6px;"><b>$'.number_format($total_benefit,2).'</b></td>'
                        . '</tr>'
                        . '<tr>'
                            . '<td style="text-align:left;padding:6px;"><b>Total Salary:</b></td>'
                            . '<td style="text-align:right;padding:6px;border-top: 1px solid #CCC"><b>$'.number_format($total_salary-$total_benefit,2).'</b></td>'
                        . '</tr>'
                       

                    . '</table>'
                . '</div>'
            . '</div><br>';
               echo $info;
        ?>
</fieldset>
<div class="form-actions">
		<?php
		echo '<button class="btn btn-success" >Save</button>&nbsp&nbsp';
            //    echo ' <button style="border-radius:4px;border-width:1px;padding:4px 12px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="printPDF_SalaryEmployee(); return false;">Print PDF</button>';
                //echo ' <button style="border-radius:4px;border-width:1px;padding:4px 12px;" class="ui-button ui-state-default ui-corner-all" target="_blank" onclick="Make_Payment(); return false;">New Payment</button>';
                
		?>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
$model = LbComment::model()->getComment("lbEmployee", $employee_id, 0);
echo '<div style="overflow:hidden; border-top: 1px solid #333;margin-top: 5px; padding-bottom:5px;margin-bottom:5px;"></div>';
echo '<div id = "view_comment"></div>' ;
echo '<br />';
 ?>
<style>
.left-form
{
    width:40%;float:left;
}

.right-form
{
    width:40%;float:right;
}
.accordion-heading
{
    background-color: rgb(91,183,91);
}
</style>

<script>
    var tax_id = $('#tax_id').val();
    $('#new_payment i').addClass('icon-minus-sign');
    $('#view_payment i').addClass('icon-plus-sign');
    $('#form_new_payment').on('show', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-minus-sign');
    });
    $('#form_new_payment').on('hidden', function () {
        $('#new_payment i').removeClass();
        $('#new_payment i').addClass('icon-plus-sign');
    });
    
    $('#new_salary i').addClass('icon-minus-sign');
    $('#new_salary i').addClass('icon-plus-sign');
    $('#form_view_salary').on('show', function () {
        $('#new_salary i').removeClass();
        $('#new_salary i').addClass('icon-minus-sign');
    });
    $('#form_view_salary').on('hidden', function () {
        $('#new_salary i').removeClass();
        $('#new_salary i').addClass('icon-plus-sign');
    });
    
    $('#new_benefit i').addClass('icon-minus-sign');
    $('#new_benefit i').addClass('icon-plus-sign');
    $('#form_view_benefit').on('show', function () {
        $('#new_benefit i').removeClass();
        $('#new_benefit i').addClass('icon-minus-sign');
    });
    $('#form_view_benefit').on('hidden', function () {
        $('#new_benefit i').removeClass();
        $('#new_benefit i').addClass('icon-plus-sign');
    });

    
    $("#view_comment").load("<?php echo LbComment::model()->getActionURLNormalized('index',array('id_item'=>$employee_id,'model_name'=>'lbEmployee'));?>");

    $(document).ready(function(){
        var from_date = $("#LbEmployee_employee_birthday").datepicker({
            format: 'dd-mm-yyyy'
        }).on('changeDate', function(ev) {
            from_date.hide();
        }).data('datepicker');	
        
        
        
    });

    function addSalary()
    {
         

            var html='<tr id="tr_row_salarys_'+tax_id+'">'
                html +='<td><a href="#" onclick="delete_item_salary('+(tax_id)+');return false;"><i class="icon-trash"></i></a></td>';
                html +='<td><select name="salary_name[]" id="salary_name" ><?php echo $option_salary; ?></select></td>';
               
                html += '<td><?php echo $form->textField($salaryModel,'salary_amount',array('name'=>'salary_amount[]','id'=>'salary_amount_1'));?></td>';          
                html += '<td  hidden="true"><?php echo $form->textField($salaryModel,'lb_record_primary_key',array('name'=>'lb_record_primary_key[]'));?></td>';                               
                html += '</tr>';
        $('#table_salary tr:last').after(html);
          
        
      
    }
    function addBenefit()
    {
       
        
        var html='<tr id="tr_row_benefits_'+tax_id+'">'
                html +='<td><a href="#" onclick="delete_item_benefit('+(tax_id)+');return false;"><i class="icon-trash"></i></a></td>';
                html +='<td><select name="benefit_name[]" id="benefit_name" ><?php echo $option_benefit; ?></select></td>';              
                html += '<td><?php echo $form->textField($benefitModel,'benefit_amount',array('name'=>'benefit_amount[]','id'=>'benefit_amount_1'));?></td>';          
                html += '<td  hidden="true"><?php echo $form->textField($benefitModel,'lb_record_primary_key',array('name'=>'key_benefits[]'));?></td>';                               
                html += '</tr>';
        $('#table_benefits tr:last').after(html);
        
      
    }
    
    function delete_item_salary(id)
    {       
        $('#tr_row_salarys_'+id).remove();
    
    }
    function delete_item_benefit(id)
    {
        
        $('#tr_row_benefits_'+id).remove();
    
    }

    function printPDF_SalaryEmployee(){
        window.open('printPDF_DetailSalaryEmployee?employee_id=<?php echo $employee_id; ?>','_target');
    }
    function Make_Payment(){
        $.post("<?php echo LbEmployee::model()->getActionURLNormalized('EnterPayment', array('employee_id'=>$employee_id))?>");
    }
    function deleteComment(comment_id)
    {
    $.post("<?php echo LbComment::model()->getActionURLNormalized('deleteComment', array())?>",
                {id:comment_id},
                function(response){
                    var responseJSON = jQuery.parseJSON(response);
                    if(responseJSON.success === 1)
                    {
                        $('#comment-root'+comment_id).remove();
                    }
                  
                }
            );
    }

    function EditComment(comment_id)
    {
            var descript = $('#description'+comment_id).text();

            html='<textarea type="text" style="width:100%;height:100px" id="description_comment'+comment_id+'">'+descript+'</textarea>\n\
            <div id=""><input type="submit" id="yt0" value="Save" onclick = updateComment('+comment_id+');> <input type="submit" id="yt0" value="Cancel" name="yt0" onclick=cancelCommentUpdate('+comment_id+',"'+descript+'")><br />';
            $("#description"+comment_id).html(html);

    }

    function updateComment(comment_id)
    {
        var description = $("#description_comment"+comment_id).val();
        $.post("<?php echo LbComment::model()->getActionURLNormalized('updateComment', array())?>",
                    {description:description,model_name:'lbPaymentVoucher',id_comment:comment_id},
                    function(response){
                        var responseJSON = jQuery.parseJSON(response);
                        if(responseJSON.success === 1)
                        {
                           $('#description_comment'+comment_id).hide();
                           $('#description'+comment_id).html(responseJSON.lb_comment_description);
                           $('#fotter'+comment_id).html(responseJSON.lb_comment_date);

    //                        $('#comment-root'+comment_id).remove();
                        }

                    }
         );
    }

    function cancelCommentUpdate(comment_id,descript)
    {
    
  
        $('#description_comment'+comment_id).hide();
        $('#description'+comment_id).html(descript);

    }
   
    </script>