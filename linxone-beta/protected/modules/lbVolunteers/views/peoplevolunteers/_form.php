<?php
/* @var $this PeoplevolunteersController */
/* @var $model LbPeopleVolunteers */
/* @var $form CActiveForm */
?>
<style type="text/css" media="screen">
	.row{
		margin-left: 0px !important;
	}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-people-volunteers-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<!-- <?php echo $form->errorSummary($model); ?> -->

	<div class="row">
		<?php echo $form->labelEx($model_state,'lb_people_id'); ?>
		<!-- <?php echo $form->textField($model_state,'lb_people_id'); ?> -->
		<?php 
			$people_object = LbPeople::model()->findAll();
			$people_arr = array();
            foreach($people_object as $result_people_object){
                $people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
            }
            echo $form->dropDownList($model_state,'lb_people_id',$people_arr,array('rows'=>6));
		?>
		<?php echo $form->error($model_state,'lb_people_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_state,'lb_volunteers_type'); ?>
		<!-- <?php echo $form->textField($model_state,'lb_volunteers_type'); ?> -->
		<?php 
            $volunteers_ministry_arr = UserList::model()->getItemsListCodeById('volunteers_ministry', true);
            echo $form->dropDownList($model_state,'lb_volunteers_type',$volunteers_ministry_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model_state,'lb_volunteers_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_state,'lb_volunteers_position'); ?>
		<!-- <?php echo $form->textField($model_state,'lb_volunteers_position',array('size'=>30,'maxlength'=>30)); ?> -->
		<?php 
            $volunteers_position_arr = UserList::model()->getItemsListCodeById('volunteers_position', true);
            // echo $form->dropDownList($model_state,'lb_volunteers_position',$volunteers_position_arr,array('prompt'=>'Select Position','rows'=>6)); 
            echo $form->dropDownList($model_state,'lb_volunteers_position',$volunteers_position_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model_state,'lb_volunteers_position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_volunteers_active'); ?>
		<!-- <?php echo $form->textField($model,'lb_volunteers_active'); ?> -->
		<?php 
            $volunteers_active_arr = UserList::model()->getItemsListCodeById('volunteers_active', true);
            echo $form->dropDownList($model,'lb_volunteers_active',$volunteers_active_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model,'lb_volunteers_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_state,'lb_volunteers_start_date'); ?>
		<!-- <?php echo $form->textField($model_state,'lb_volunteers_start_date'); ?> -->
		<?php echo $form->textField($model_state,'lb_volunteers_start_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model_state,'lb_volunteers_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model_state,'lb_volunteers_end_date'); ?>
		<!-- <?php echo $form->textField($model_state,'lb_volunteers_end_date'); ?> -->
		<?php echo $form->textField($model_state,'lb_volunteers_end_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model_state,'lb_volunteers_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_entity_id'); ?>
		<!-- <?php echo $form->textField($model,'lb_entity_id'); ?> -->
		<?php 
			$small_group_object = LbSmallGroups::model()->findAll();
			$small_group_arr = array();
            foreach($small_group_object as $result_small_group_object){
                $small_group_arr[$result_small_group_object['lb_record_primary_key']] = $result_small_group_object['lb_group_name'];
            }
            echo $form->dropDownList($model,'lb_entity_id',$small_group_arr,array('prompt'=>'Select Assign Small Group','rows'=>6));
		?>
		<?php echo $form->error($model,'lb_entity_id'); ?>
	</div>

	<!-- <div class="row">
		<?php echo $form->labelEx($model,'lb_entity_type'); ?>
		<?php echo $form->textField($model,'lb_entity_type',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'lb_entity_type'); ?>
	</div> -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

	var LbPeopleVolunteersStage_lb_volunteers_start_date = $("#LbPeopleVolunteersStage_lb_volunteers_start_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeopleVolunteersStage_lb_volunteers_start_date.hide();
    }).data('datepicker');

    var LbPeopleVolunteersStage_lb_volunteers_end_date = $("#LbPeopleVolunteersStage_lb_volunteers_end_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeopleVolunteersStage_lb_volunteers_end_date.hide();
    }).data('datepicker');
	
</script>