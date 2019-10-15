<?php
/* @var $this LbPastoralCareController */
/* @var $model LbPastoralCare */
/* @var $form CActiveForm */
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css_theme2018/jquery.datetimepicker.css">
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.datetimepicker.full.min.js"></script>


<style type="text/css" media="screen">
	.row{
		margin-left: 0px !important;
	}
</style>
<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Pastoral Care - Create").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbPastoralcare/default/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	        	echo '<a live="false" data-workspace="1" href=""><i style="margin-top: -12px;margin-right: 10px;" class="icon-calendar"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name to search..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-pastoral-care-create-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_people_id'); ?>
		<!-- <?php echo $form->textField($model,'lb_people_id'); ?> -->
		<?php 
			$people_object = LbPeople::model()->findAll();
			$people_arr = array();
            foreach($people_object as $result_people_object){
                $people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
            }
            echo $form->dropDownList($model,'lb_people_id',$people_arr,array('rows'=>6));
		?>
		<?php echo $form->error($model,'lb_people_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_pastoral_care_type'); ?>
		<!-- <?php echo $form->textField($model,'lb_pastoral_care_type'); ?> -->
		<?php 
            $pastoralcare_type_arr = UserList::model()->getItemsListCodeById('pastoralcare_type', true);
            echo $form->dropDownList($model,'lb_pastoral_care_type',$pastoralcare_type_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model,'lb_pastoral_care_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_pastoral_care_pastor_id'); ?>
		<!-- <?php echo $form->textField($model,'lb_pastoral_care_pastor_id'); ?> -->
		<?php
			$people_object = LbPeople::model()->findAll();
			$people_arr = array();
            foreach($people_object as $result_people_object){
                $people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
            }
            echo $form->dropDownList($model,'lb_pastoral_care_pastor_id',$people_arr,array('rows'=>6));
		 ?>
		<?php echo $form->error($model,'lb_pastoral_care_pastor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_pastoral_care_date'); ?>
		<?php echo $form->textField($model,'lb_pastoral_care_date'); ?>
		<?php echo $form->error($model,'lb_pastoral_care_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lb_pastoral_care_remark'); ?>
		<?php echo $form->textArea($model, 'lb_pastoral_care_remark', array('rows' => 6, 'cols' => 50)); ?>
		<?php echo $form->error($model,'lb_pastoral_care_remark'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	$('#LbPastoralCare_lb_pastoral_care_date').datetimepicker();
</script>

