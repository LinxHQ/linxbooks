<div id="lb-container-header">
    <div class="lb-header-right"><h3>Create Training Need</h3></div>
    <div class="lb-header-left lb-header-left-create-talent">
        <a href="<?php echo $this->createUrl('/lbTalent/default/index'); ?>" class="btn"><i class="icon-arrow-left"></i> Back</a>
    </div>
</div><br>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'leave-assignment-form',
    'enableAjaxValidation'=>false,
)); ?>

<!-- <?php echo $form->errorSummary($model); ?> -->
<table class="table table-bordered table-striped table-hover">
    <tbody>
        <tr class="odd">
            <th><?php echo $form->labelEx($model,'lb_talent_name'); ?></th>
            <td>
                <?php echo $form->textField($model,'lb_talent_name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'lb_talent_name'); ?>
            </td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model,'lb_talent_start_date'); ?></th>
            <td id="chose_start_date">
                <?php echo $form->textField($model,'lb_talent_start_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'lb_talent_start_date'); ?>
            </td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->labelEx($model,'lb_talent_end_date'); ?></th>
            <td id="chose_end_date">
                <?php echo $form->textField($model,'lb_talent_end_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'lb_talent_end_date'); ?>
            </td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model,'lb_talent_description'); ?></th>
            <td>
                <?php echo $form->textArea($model,'lb_talent_description',array('rows'=>6)); ?>
                <?php echo $form->error($model,'lb_talent_description'); ?>
            </td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->labelEx($model,'lb_department_id'); ?></th>
            <td>
            	<?php 
                    $departments_arr = LbDepartments::model()->findAll();
                    $dpm_arr = array();
                    foreach($departments_arr as $result_departments_arr){
                        $dpm_arr[$result_departments_arr['lb_record_primary_key']] = $result_departments_arr['lb_department_name'];
                    }
                    echo $form->dropDownList($model,'lb_department_id',$dpm_arr,array('rows'=>6)); 
                ?>
                <?php echo $form->error($model,'lb_department_id'); ?>
            </td>
        </tr>
    </tbody>
</table>
<br />
<?php
    LBApplicationUI::submitButton('Save', array(
        'htmlOptions'=>array(
            'onclick'=>'return validation()',
            'style'=>'margin-left: auto; margin-right: auto; background:#fff,',
        ),
    ));
?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    // $(document).ready(function(){
    //     // $("#course_user").select2(); 
    //     $("#skills").select2(); 
    //     $("#course_user").select2(); 
    // });
    
	var LbTalentNeed_lb_talent_start_date = $("#LbTalentNeed_lb_talent_start_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbTalentNeed_lb_talent_start_date.hide();
    }).data('datepicker');

    var LbTalentNeed_lb_talent_end_date = $("#LbTalentNeed_lb_talent_end_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbTalentNeed_lb_talent_end_date.hide();
    }).data('datepicker');
	
</script>