<?php
/* @var $this LbPeopleController */
/* @var $model LbPeople */
/* @var $form CActiveForm */
?>
<style type="text/css" media="screen">
	.row{
		margin-left: 0px !important;
	}
</style>

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","People - Create").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" >';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbPeople/default/create').'"><i style="margin-top: -12px;" class="icon-plus"></i> </a>';
	            // echo ' <input type="text" placeholder="Enter name, email, mobile or NRIC..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>
<div class="lb-empty-15"></div>
<!-- <div id="advanced_search" style="width: 100%;height: 30px; display: inline-flex; /*border: 1px solid red;*/">
	<div id="left" style="width: 50%; padding: 5px;">
		<i class="icon-search"></i> Advanced Search
	</div>
	<div id="right" style="width: 50%; padding: 5px;">
		<p style="float: right;"><i class="icon-download-alt"></i> Excel <i class="icon-download-alt"></i> PDF</p>
	</div>
</div> -->

<?php
$form
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lb-people-create-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<!-- <?php echo $form->errorSummary($model); ?> -->

	<table width="100%">
		<tbody>
			<tr>
				<td>
					<div class="row">
						<?php echo $form->labelEx($model,'lb_given_name'); ?>
						<?php echo $form->textField($model,'lb_given_name'); ?>
						<?php echo $form->error($model,'lb_given_name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_family_name'); ?>
						<?php echo $form->textField($model,'lb_family_name'); ?>
						<?php echo $form->error($model,'lb_family_name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_title'); ?>
						<?php 
		                    $title_arr = UserList::model()->getItemsListCodeById('people_title', true);
		                    echo $form->dropDownList($model,'lb_title',$title_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose title'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_title'); ?> -->
						<?php echo $form->error($model,'lb_title'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_people_believer'); ?>
						<?php 
		                    $believer_arr = UserList::model()->getItemsListCodeById('people_believer', true);
		                    echo $form->dropDownList($model,'lb_people_believer',$believer_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Believer'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_people_believer'); ?> -->
						<?php echo $form->error($model,'lb_people_believer'); ?>
					</div>
					
					<div class="row">
						<?php echo $form->labelEx($model,'lb_gender'); ?>
                        <?php
                        $gender_arr = UserList::model()->getItemsListCodeById('people_gender', true);
                        echo $form->dropDownList($model,'lb_gender',$gender_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose gender')));
                        ?>
                        <!--<?php echo $form->textField($model,'lb_gender'); ?>-->
						<?php echo $form->error($model,'lb_gender'); ?>
					</div>

					<div class="row" id="chosse_birthday">
						<?php echo $form->labelEx($model,'lb_birthday'); ?>
						<?php echo $form->textField($model,'lb_birthday',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
						<!-- <?php echo $form->textField($model,'lb_birthday'); ?> -->
						<?php echo $form->error($model,'lb_birthday'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_nationality'); ?>
						<?php 
		                    $nationality_arr = UserList::model()->getItemsListCodeById('people_nationality', true);
		                    echo $form->dropDownList($model,'lb_nationality',$nationality_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Nationality'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_nationality'); ?> -->
						<?php echo $form->error($model,'lb_nationality'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_marital_status'); ?>
						<!-- <?php echo $form->textField($model,'lb_marital_status'); ?> -->
						<?php 
		                    $marital_arr = UserList::model()->getItemsListCodeById('people_marital', true);
		                    echo $form->dropDownList($model,'lb_marital_status',$marital_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Status Marital'))); 
		                ?>
						<?php echo $form->error($model,'lb_marital_status'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_ethnic'); ?>
						<?php 
		                    $ethnic_arr = UserList::model()->getItemsListCodeById('people_ethnic', true);
		                    echo $form->dropDownList($model,'lb_ethnic',$ethnic_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Ethnic'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_ethnic'); ?> -->
						<?php echo $form->error($model,'lb_ethnic'); ?>
					</div>

					
				</td>
				<td>
					

					<div class="row">
						<?php echo $form->labelEx($model,'lb_nric'); ?>
						<?php echo $form->textField($model,'lb_nric'); ?>
						<?php echo $form->error($model,'lb_nric'); ?>
					</div>
					
					<div class="row">
						<?php echo $form->labelEx($model,'lb_company_name'); ?>
						<?php echo $form->textField($model,'lb_company_name'); ?>
						<?php echo $form->error($model,'lb_company_name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_company_position'); ?>
						<?php echo $form->textField($model,'lb_company_position'); ?>
						<?php echo $form->error($model,'lb_company_position'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_company_occupation'); ?>
						<?php echo $form->textField($model,'lb_company_occupation'); ?>
						<?php echo $form->error($model,'lb_company_occupation'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_street'); ?>
						<?php echo $form->textField($model,'lb_local_address_street'); ?>
						<?php echo $form->error($model,'lb_local_address_street'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_street2'); ?>
						<?php echo $form->textField($model,'lb_local_address_street2'); ?>
						<?php echo $form->error($model,'lb_local_address_street2'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_mobile'); ?>
						<?php echo $form->textField($model,'lb_local_address_mobile'); ?>
						<?php echo $form->error($model,'lb_local_address_mobile'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_phone'); ?>
						<?php echo $form->textField($model,'lb_local_address_phone'); ?>
						<?php echo $form->error($model,'lb_local_address_phone'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_phone_2'); ?>
						<?php echo $form->textField($model,'lb_local_address_phone_2'); ?>
						<?php echo $form->error($model,'lb_local_address_phone_2'); ?>
					</div>

				</td>

				<td>
					

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_level'); ?>
						<?php echo $form->textField($model,'lb_local_address_level'); ?>
						<?php echo $form->error($model,'lb_local_address_level'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_postal_code'); ?>
						<?php echo $form->textField($model,'lb_local_address_postal_code'); ?>
						<?php echo $form->error($model,'lb_local_address_postal_code'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_country'); ?>
						<?php 
		                    $country_arr = UserList::model()->getItemsListCodeById('people_country', true);
		                    echo $form->dropDownList($model,'lb_local_address_country',$country_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Country'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_local_address_country'); ?> -->
						<?php echo $form->error($model,'lb_local_address_country'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_unit'); ?>
						<?php echo $form->textField($model,'lb_local_address_unit'); ?>
						<?php echo $form->error($model,'lb_local_address_unit'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_local_address_email'); ?>
						<?php echo $form->textField($model,'lb_local_address_email'); ?>
						<?php echo $form->error($model,'lb_local_address_email'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_street'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_street'); ?>
						<?php echo $form->error($model,'lb_overseas_address_street'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_street2'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_street2'); ?>
						<?php echo $form->error($model,'lb_overseas_address_street2'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_phone'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_phone'); ?>
						<?php echo $form->error($model,'lb_overseas_address_phone'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_phone2'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_phone2'); ?>
						<?php echo $form->error($model,'lb_overseas_address_phone2'); ?>
					</div>

				</td>

				<td>
					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_mobile'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_mobile'); ?>
						<?php echo $form->error($model,'lb_overseas_address_mobile'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_postal_code'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_postal_code'); ?>
						<?php echo $form->error($model,'lb_overseas_address_postal_code'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_country'); ?>
						<?php 
		                    $country_arr = UserList::model()->getItemsListCodeById('people_country', true);
		                    echo $form->dropDownList($model,'lb_overseas_address_country',$country_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Country'))); 
		                ?>
						<!-- <?php echo $form->textField($model,'lb_overseas_address_country'); ?> -->
						<?php echo $form->error($model,'lb_overseas_address_country'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_unit'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_unit'); ?>
						<?php echo $form->error($model,'lb_overseas_address_unit'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_email'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_email'); ?>
						<?php echo $form->error($model,'lb_overseas_address_email'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_overseas_address_level'); ?>
						<?php echo $form->textField($model,'lb_overseas_address_level'); ?>
						<?php echo $form->error($model,'lb_overseas_address_level'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_baptism_church'); ?>
						<?php echo $form->textField($model,'lb_baptism_church'); ?>
						<?php echo $form->error($model,'lb_baptism_church'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'lb_baptism_no'); ?>
						<?php echo $form->textField($model,'lb_baptism_no'); ?>
						<?php echo $form->error($model,'lb_baptism_no'); ?>
					</div>

					<div class="row" id="chosse_baptism_date">
						<?php echo $form->labelEx($model,'lb_baptism_date'); ?>
						<?php echo $form->textField($model,'lb_baptism_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
						<!-- <?php echo $form->textField($model,'lb_baptism_date'); ?> -->
						<?php echo $form->error($model,'lb_baptism_date'); ?>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	
	<div class="row">
		<?php echo $form->labelEx($model,'lb_religion'); ?>
		<?php 
            $religion_arr = UserList::model()->getItemsListCodeById('people_religion', true);
            echo $form->dropDownList($model,'lb_religion',$religion_arr,array('rows'=>6, 'empty' => Yii::t('lang','Choose Religion'))); 
        ?>
		<!-- <?php echo $form->textField($model,'lb_religion'); ?> -->
		<?php echo $form->error($model,'lb_religion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Create', array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

	var LbPeople_lb_birthday = $("#LbPeople_lb_birthday").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeople_lb_birthday.hide();
    }).data('datepicker');

    var LbPeople_lb_baptism_date = $("#LbPeople_lb_baptism_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeople_lb_baptism_date.hide();
    }).data('datepicker');
	
</script>