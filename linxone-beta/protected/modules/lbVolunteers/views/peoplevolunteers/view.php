<?php
/* @var $this PeoplevolunteersController */
/* @var $model LbPeopleVolunteers */

$this->breadcrumbs=array(
	'Lb People Volunteers'=>array('index'),
	$model->lb_record_primary_key,
);

$this->menu=array(
	array('label'=>'List LbPeopleVolunteers', 'url'=>array('index')),
	array('label'=>'Create LbPeopleVolunteers', 'url'=>array('create')),
	array('label'=>'Update LbPeopleVolunteers', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Delete LbPeopleVolunteers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbPeopleVolunteers', 'url'=>array('admin')),
);
?>
<style type="text/css" media="screen">
	.row{
		margin-left: 0px !important;
	}
</style>
<!-- <h1>View LbPeopleVolunteers #<?php echo $model->lb_record_primary_key; ?></h1> -->

<?php 
	// $this->widget('zii.widgets.CDetailView', array(
	// 	'data'=>$model,
	// 	'attributes'=>array(
	// 	'lb_record_primary_key',
	// 	'lb_people_id',
	// 	'lb_volunteers_type',
	// 	'lb_volunteers_position',
	// 	'lb_volunteers_active',
	// 	'lb_volunteers_start_date',
	// 	'lb_volunteers_end_date',
	// 	'lb_entity_id',
	// 	'lb_entity_type',
	// 	),
	// )); 
?>
<?php 
$people_member=LbPeople::model()->findByPk($model->lb_people_id);
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3 style="margin-top: 4px;">'.Yii::t("lang","Volunteer Info").'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" style="margin-top:2px;" >';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbVolunteers/peoplevolunteers/create').'"><i style="margin-top: -12px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	// echo $volunteers_id;
 ?>

<!-- Modal -->
<div id="assign_members_volunteer" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Volunteer</h4>
      </div>
      <div class="modal-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'lb-assign_members_small_group',
			'enableAjaxValidation'=>false,
		)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>
		
		<input type="hidden" name="volunteers_id" value="<?php echo $model->lb_volunteers_id; ?>">
		<input type="hidden" name="people_id" value="<?php echo $model->lb_people_id; ?>">

		<!-- select Ministry -->
		<?php echo $form->labelEx($model,'lb_volunteers_type'); ?>
		<?php 
			$volunteers_ministry = UserList::model()->getItemsListCodeById('volunteers_ministry', true);
            echo $form->dropDownList($model,'lb_volunteers_type',$volunteers_ministry,array('rows'=>6)); 
		?>
		<?php echo $form->error($model,'lb_volunteers_type'); ?>
		<!-- end select Ministry -->

		<!-- select Position -->
		<?php echo $form->labelEx($model,'lb_volunteers_position'); ?>
		<?php 
			$volunteers_position = UserList::model()->getItemsListCodeById('volunteers_position', true);
            echo $form->dropDownList($model,'lb_volunteers_position',$volunteers_position,array('rows'=>6)); 
		?>
		<?php echo $form->error($model,'lb_volunteers_position'); ?>
		<!-- end select Position -->
		
		<div class="row" id="choose_start_date">
			<!-- choose start date -->
			<?php echo $form->labelEx($model,'lb_volunteers_start_date'); ?>
			<?php echo $form->textField($model,'lb_volunteers_start_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'lb_volunteers_start_date'); ?>
			<!-- end choose start date -->
		</div>

		<div class="row" id="choose_start_date">
			<!-- choose end date -->
			<?php echo $form->labelEx($model,'lb_volunteers_end_date'); ?>
			<?php echo $form->textField($model,'lb_volunteers_end_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'lb_volunteers_end_date'); ?>
			<!-- end choose end date -->
		</div>
		
		<br />
		<?php echo CHtml::submitButton('Save' , array('class' => 'btn btn-success')); ?>

		<?php $this->endWidget(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<div style="padding: 10px;">
				<img id="picture_user_comment" style="width: 50px;" src="<?php echo Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png"; ?>" class="img-circle" alt="Cinque Terre">
				<?php echo $people_member->lb_given_name; ?> (<a href="<?php echo $this->createUrl('/lbPeople/default/detailPeople/id/'.$people_member->lb_record_primary_key); ?>">Complete profile</a>)
			</div>
		</td>
		<td style="text-align: right;">
			<a href="#"><i class="icon-pencil"></i></a>
		</td>
	</tr>
</table>
    <?php
        // $this->widget('editable.EditableField', array(
        //     'type'      => 'select',
        //     'model'     => $model,
        //     'attribute' => 'lb_people_id',
        //     'url'       => $this->createUrl('site/updateUser'), 
        //     'source'    => Editable::source(LbPeople::model()->findAll(), 'lb_record_primary_key', 'lb_given_name'),
        //     //or you can use plain arrays:
        //     // 'source'    => Editable::source(array(1 => 'Status1', 2 => 'Status2')),
        //     'placement' => 'right',
        // ));
    ?>
<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Name</td>
					<td>: <?php 
						$this->widget('editable.EditableField', array(
				            'type'      => 'select',
				            'model'     => $model,
				            'attribute' => 'lb_people_id',
				            'url'         => $this->createUrl('peoplevolunteers/updateVolunteerPeople'),
				            'source'    => Editable::source(LbPeople::model()->findAll(), 'lb_record_primary_key', 'lb_given_name'),
				            //or you can use plain arrays:
				            // 'source'    => Editable::source(array(1 => 'Status1', 2 => 'Status2')),
				            'placement' => 'right',
				        ));
					 ?></td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td>: <?php echo $people_member->lb_local_address_mobile; ?></td>
				</tr>
				<tr>
					<td>Address 1</td>
					<td>: <?php echo $people_member->lb_local_address_street; ?></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td>: <?php echo $people_member->lb_local_address_street2; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Regular Service</td>
					<td>: BPJ 10am</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>: <?php echo $people_member->lb_local_address_email; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

 <table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Volunteer</h3>
		</td>
		<td style="text-align: right;">
			<a href="#" data-toggle="modal" data-target="#assign_members_volunteer"><i class="icon-plus"></i></a>
		</td>
	</tr>
</table>
<?php // echo $model->lb_volunteers_id; ?>
<div id="load_volunteer">
	<input type="hidden" id="volunteers_id" value="<?php echo $model->lb_volunteers_id; ?>">
	
</div>

<script type="text/javascript">
	var volunteers_id = $("#volunteers_id").val();
	$("#load_volunteer").load("<?php echo $this->createUrl('/lbVolunteers/Peoplevolunteers/load_volunteer'); ?>",{volunteers_id:volunteers_id});

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
