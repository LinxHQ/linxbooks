<?php
/* @var $this SmallgroupsController */
/* @var $model LbSmallGroups */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/jquery.datetimepicker.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.datetimepicker.full.min.js"></script>
<style type="text/css" media="screen">
	.row{
		margin-left: 0px !important;
	}
</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-small-groups-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<!-- <?php echo $form->errorSummary($model); ?> -->

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_name'); ?>
		<?php echo $form->textField($model,'lb_group_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lb_group_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_type'); ?>
		<!-- <?php echo $form->textField($model,'lb_group_type',array('size'=>50,'maxlength'=>50)); ?> -->
		<?php 
            $small_group_type_arr = UserList::model()->getItemsListCodeById('small_group_type', true);
            echo $form->dropDownList($model,'lb_group_type',$small_group_type_arr,array('prompt'=>'Select small group type', 'rows'=>6)); 
        ?>
		<?php echo $form->error($model,'lb_group_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_district'); ?>
		<?php echo $form->textField($model,'lb_group_district',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'lb_group_district'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_frequency'); ?>
		<!-- <?php echo $form->textField($model,'lb_group_frequency'); ?> -->
		<?php 
            $small_group_frequency_arr = UserList::model()->getItemsListCodeById('small_group_frequency', true);
            echo $form->dropDownList($model,'lb_group_frequency',$small_group_frequency_arr,array('prompt'=>'Select Frequency', 'rows'=>6)); 
        ?>
		<?php echo $form->error($model,'lb_group_frequency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_meeting_time'); ?>
		<?php echo $form->textField($model,'lb_group_meeting_time'); ?>
		<?php echo $form->error($model,'lb_group_meeting_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_since'); ?>
		<!-- <?php echo $form->textField($model,'lb_group_since'); ?> -->
		<?php echo $form->textField($model,'lb_group_since',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lb_group_since'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_location'); ?>
		<?php echo $form->textField($model,'lb_group_location',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lb_group_location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_group_active'); ?>
		<!-- <?php echo $form->textField($model,'lb_group_active'); ?> -->
		<?php 
            $small_group_active_arr = UserList::model()->getItemsListCodeById('small_group_active', true);
            echo $form->dropDownList($model,'lb_group_active',$small_group_active_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model,'lb_group_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$( document ).ready(function() {
	    $('#LbSmallGroups_lb_group_meeting_time').datetimepicker();

	    var LbSmallGroups_lb_group_since = $("#LbSmallGroups_lb_group_since").datepicker({
	        format: 'dd-mm-yyyy',
	    }).on('changeDate', function(ev) {
	        LbSmallGroups_lb_group_since.hide();
	    }).data('datepicker');
	});
</script>