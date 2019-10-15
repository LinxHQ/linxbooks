<?php 
/*
	$people_id
*/
$people_info = LbPeople::model()->findAll('lb_record_primary_key IN ('.$people_id.')');
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"">
        	
        	<h3><img id="picture_user_comment" style="width: 50px; margin-top: -3px;" src="'.Yii::app()->baseUrl.'/images/lincoln-default-profile-pic.png" class="img-circle" alt="Cinque Terre" /> '.$people_info[0]['lb_given_name'].'</h3>
        </div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar">';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbPeople/default/create').'"><i style="margin-top: -12px;" class="icon-plus"></i> </a>';
	            // echo ' <input type="text" placeholder="Enter name, email, mobile or NRIC..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
	$picture = Yii::app()->baseUrl."/images/lincoln-default-profile-pic.png";
 ?>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Personal Info</h3>
		</td>
		<td style="text-align: right;">
			<?php
				echo '<a href="'.$this->createUrl('/lbPeople/default/update/id')."/".$people_id.'"><i class="icon-pencil"></i></a>';
			 ?>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Given name</td>
					<td>: <?php echo $people_info[0]['lb_given_name']; ?></td>
				</tr>
				<tr>
					<td>Title</td>
					<td>: <?php 
						if($people_info[0]['lb_title'] != ""){
							$people_title = UserList::model()->getTermName('people_title', $people_info[0]['lb_title']);
							echo ($people_title ? $people_title[0]['system_list_item_name'] : '');
						}
					 ?></td>
				</tr>
				<tr>
					<td>Birthday</td>
					<td>: <?php 
						if($people_info[0]['lb_birthday'] != "1970-01-01"){
							echo date('j F Y', strtotime($people_info[0]['lb_birthday'])); 
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Marital Status</td>
					<td>: Married</td>
				</tr>
				<tr>
					<td>NRIC</td>
					<td>: <?php echo $people_info[0]['lb_nric']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Family name</td>
					<td>: <?php 
						if($people_info[0]['lb_family_name'] != ""){
							echo $people_info[0]['lb_family_name']; 
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Gender</td>

                    <td>: <?php
                        if($people_info[0]['lb_gender'] != ""){
                            $people_title = UserList::model()->getTermName('people_gender', $people_info[0]['lb_gender']);
                            echo ($people_title ? $people_title[0]['system_list_item_name'] : '');
                        }
                        ?></td>
				</tr>
				<tr>
					<td>Nationality</td>
					<td>: <?php 
						if($people_info[0]['lb_nationality'] != ""){
							$nationality = UserList::model()->getTermName('people_nationality', $people_info[0]['lb_nationality']);
							if ($nationality) echo $nationality[0]['system_list_item_name'];
						}
					 ?></td>
				</tr>
				<tr>
					<td>Ethnic</td>
					<td>: <?php 
						if($people_info[0]['lb_ethnic'] != ""){
							$ethnic = UserList::model()->getTermName('people_ethnic', $people_info[0]['lb_ethnic']);
							if ($ethnic) echo $ethnic[0]['system_list_item_name'];
						}
					 ?></td>
				</tr>
				<tr>
					<td>Religion</td>
					<td>: <?php 
						if($people_info[0]['lb_religion'] != ""){
							$religion = UserList::model()->getTermName('people_religion', $people_info[0]['lb_religion']);
							if ($religion) echo $religion[0]['system_list_item_name'];
						}
					 ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Local Contact</h3>
		</td>
		<td style="text-align: right;">
			<?php
				echo '<a href="'.$this->createUrl('/lbPeople/default/update/id')."/".$people_id.'"><i class="icon-pencil"></i></a>';
			 ?>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Street Address 1</td>
					<td>: <?php echo $people_info[0]['lb_local_address_street']; ?></td>
				</tr>
				<tr>
					<td>Street Address 2</td>
					<td>: <?php echo $people_info[0]['lb_local_address_street2']; ?></td>
				</tr>
				<tr>
					<td>Level</td>
					<td>: <?php echo $people_info[0]['lb_local_address_level'] ?></td>
				</tr>
				<tr>
					<td>Unit</td>
					<td>: <?php echo $people_info[0]['lb_local_address_unit'] ?></td>
				</tr>
				<tr>
					<td>Postal Code</td>
					<td>: <?php echo $people_info[0]['lb_local_address_postal_code'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Mobile</td>
					<td>: <?php echo $people_info[0]['lb_local_address_mobile'] ?></td>
				</tr>
				<tr>
					<td>Phone 1</td>
					<td>: <?php echo $people_info[0]['lb_local_address_phone'] ?></td>
				</tr>
				<tr>
					<td>Phone 2</td>
					<td>: <?php echo $people_info[0]['lb_local_address_phone_2'] ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>: <?php echo $people_info[0]['lb_local_address_email'] ?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td>: <?php 
						if($people_info[0]['lb_local_address_country'] != ""){
							$country_local = UserList::model()->getTermName('people_country', $people_info[0]['lb_local_address_country']);
							if ($country_local) echo $country_local[0]['system_list_item_name'];
						}
					 ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Overseas Contact</h3>
		</td>
		<td style="text-align: right;">
			<?php
				echo '<a href="'.$this->createUrl('/lbPeople/default/update/id')."/".$people_id.'"><i class="icon-pencil"></i></a>';
			 ?>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Street Address 1</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_street'] ?></td>
				</tr>
				<tr>
					<td>Street Address 2</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_street2'] ?></td>
				</tr>
				<tr>
					<td>Level</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_level'] ?></td>
				</tr>
				<tr>
					<td>Unit</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_unit'] ?></td>
				</tr>
				<tr>
					<td>Postal Code</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_postal_code'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Mobile</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_mobile'] ?></td>
				</tr>
				<tr>
					<td>Phone 1</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_phone'] ?></td>
				</tr>
				<tr>
					<td>Phone 2</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_phone2'] ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td>: <?php echo $people_info[0]['lb_overseas_address_email'] ?></td>
				</tr>
				<tr>
					<td>Country</td>
					<td>: <?php 
						if($people_info[0]['lb_overseas_address_country'] != ""){
							$country_overseas = UserList::model()->getTermName('people_country', $people_info[0]['lb_overseas_address_country']);
							if ($country_overseas) echo $country_overseas[0]['system_list_item_name'];
						}
					 ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Work Info</h3>
		</td>
		<td style="text-align: right;">
			<?php
				echo '<a href="'.$this->createUrl('/lbPeople/default/update/id')."/".$people_id.'"><i class="icon-pencil"></i></a>';
			 ?>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Company</td>
					<td>: <?php echo $people_info[0]['lb_company_name'] ?></td>
				</tr>
				<tr>
					<td>Position</td>
					<td>: <?php echo $people_info[0]['lb_company_position'] ?></td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td>: <?php echo $people_info[0]['lb_company_occupation'] ?></td>
				</tr>
				<!-- <tr>
					<td>Baptism Info</td>
					<td>: </td>
				</tr> -->
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Baptism Info</h3>
		</td>
		<td style="text-align: right;">
			<?php
				echo '<a href="'.$this->createUrl('/lbPeople/default/update/id')."/".$people_id.'"><i class="icon-pencil"></i></a>';
			 ?>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Baptism church</td>
					<td>: <?php echo $people_info[0]['lb_baptism_church'] ?></td>
				</tr>
				<tr>
					<td>Baptism No.</td>
					<td>: <?php echo $people_info[0]['lb_baptism_no'] ?></td>
				</tr>
				<tr>
					<td>Baptism Date</td>
					<td>: <?php 
						if($people_info[0]['lb_baptism_date'] != "1970-01-01"){
							echo date('d-m-Y', strtotime($people_info[0]['lb_baptism_date']));
						} else {
							echo "";
						}
					?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 50%;">
			<tbody>
				<tr>
					<td>Baptised by</td>
					<td>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Peter K.</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Membership</h3>
		</td>
		<td style="text-align: right;">
			<i style="cursor: pointer;" onclick="show_modal_membership();" class="icon-plus"></i>
		</td>
	</tr>
</table>
<!-- Popup modal membership -->
<div id="modal_membership" class="modal hide" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Memberships</h4>
      </div>
      <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'lb-pastoral-care-create-form',
			'enableAjaxValidation'=>false,
		)); ?>
      <div class="modal-body">

        <?php echo $form->labelEx($model_membership,'lb_membership_type'); ?>
		<?php 
            $people_membership_type_arr = UserList::model()->getItemsListCodeById('people_membership_type', true);
            echo $form->dropDownList($model_membership,'lb_membership_type',$people_membership_type_arr,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model_membership,'lb_membership_type'); ?>


		<?php echo $form->labelEx($model_membership,'lb_membership_start_date'); ?>
		<?php echo $form->textField($model_membership,'lb_membership_start_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model_membership,'lb_membership_start_date'); ?>


		<?php echo $form->labelEx($model_membership,'lb_membership_end_date'); ?>
		<?php echo $form->textField($model_membership,'lb_membership_end_date',array('data-format'=>"dd-mm-yyyy", 'size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model_membership,'lb_membership_end_date'); ?>

		<?php echo $form->labelEx($model_membership,'lb_membership_confirm'); ?>
		<?php 
			$people_object = LbPeople::model()->findAll();
			$people_arr = array();
            foreach($people_object as $result_people_object){
            	if($result_people_object['lb_record_primary_key'] != $people_id){
            		// không cho tự mình confirm mình là memberships
                	$people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
                }
            }
            echo $form->dropDownList($model_membership,'lb_membership_confirm',$people_arr,array('rows'=>6));
		?>
		<?php echo $form->error($model_membership,'lb_membership_confirm'); ?>


		<?php echo $form->labelEx($model_membership,'lb_membership_remark'); ?>
		<?php echo $form->textArea($model_membership, 'lb_membership_remark', array('rows' => 4, 'cols' => 50)); ?>
		<?php echo $form->error($model_membership,'lb_membership_remark'); ?>

      </div>
      <div class="modal-footer">
        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <?php $this->endWidget(); ?>
    </div>

  </div>
</div>
<!-- End Popup modal membership -->
<table class="table">
	<thead>
		<tr>
			<th>Type</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Confirmed by</th>
			<th>Remark</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$memberships_arr = LbPeopleMemberships::model()->findAll('lb_people_id IN ('.$people_id.')');
			foreach ($memberships_arr as $result_memberships_arr) {
				$model_get_people=LbPeople::model()->findByPk($result_memberships_arr['lb_membership_confirm']);
				$people_membership_type = UserList::model()->getTermName('people_membership_type', $result_memberships_arr['lb_membership_type']);
				echo '
				<tr>
					<td>'.$people_membership_type[0]['system_list_item_name'].'</td>
					<td>'.date('d-m-Y', strtotime($result_memberships_arr['lb_membership_start_date'])).'</td>
					<td>'.date('d-m-Y', strtotime($result_memberships_arr['lb_membership_end_date'])).'</td>
					<td>'.$model_get_people->lb_given_name.'</td>
					<td>'.$result_memberships_arr['lb_membership_remark'].'</td>
					<td><a class="delete" title="Delete" rel="tooltip" href="'.$this->createUrl('/lbPeople/default/delete_membership/id_membership')."/".$result_memberships_arr['lb_record_primary_key'].'/id_people/'.$people_id.'"><i class="icon-trash"></i></a></td>
				</tr>';
			}
		?>
	</tbody>
</table>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Relationships</h3>
		</td>
		<td style="text-align: right;">
			<i style="cursor: pointer;" onclick="show_modal_relationships();" class="icon-plus"></i>
		</td>
	</tr>
</table>
<!-- Popup modal_relationships -->
<div id="modal_relationships" class="modal hide" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Relationships</h4>
      </div>
      <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'lb-pastoral-care-create-form',
			'enableAjaxValidation'=>false,
		)); ?>
      <div class="modal-body">
        <div class="row" style="margin-left: 0px !important;">
			<?php echo $form->labelEx($model_relationships,'lb_people_id'); ?>
			<?php 
				$people_object = LbPeople::model()->findAll();
				$people_arr = array();
	            foreach($people_object as $result_people_object){
	                $people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
	            }
	            echo $form->dropDownList($model_relationships,'lb_people_id',$people_arr,array('rows'=>6));
			?>
			<?php echo $form->error($model_relationships,'lb_people_id'); ?>
		</div>

		<div class="row" style="margin-left: 0px !important;">
			<?php echo $form->labelEx($model_relationships,'lb_people_relationship_id'); ?>
			<?php 
	            $pastoralcare_type_arr = UserList::model()->getItemsListCodeById('people_relationships', true);
	            echo $form->dropDownList($model_relationships,'lb_people_relationship_id',$pastoralcare_type_arr,array('rows'=>6)); 
	        ?>
			<?php echo $form->error($model_relationships,'lb_people_relationship_id'); ?>
		</div>

      </div>
      <div class="modal-footer">
        <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-success')); ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      <?php $this->endWidget(); ?>
    </div>

  </div>
</div>
<!-- End Popup modal_relationships -->
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Relationship</th>
			<th>Membership</th>
			<th>Believer</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$relationships_arr = LbPeopleRelationships::model()->findAll('lb_people_id IN ('.$people_id.')');
			foreach ($relationships_arr as $result_relationships_arr) {
				$people_relationships = UserList::model()->getTermName('people_relationships', $result_relationships_arr['lb_people_relationship_type']);
				$model_get_people=LbPeople::model()->findByPk($result_relationships_arr['lb_people_relationship_id']);
				$p_believer = "";
				if($model_get_people->lb_people_believer != ""){
					$people_believer = UserList::model()->getTermName('people_believer', $model_get_people->lb_people_believer);
					$p_believer = $people_believer[0]['system_list_item_name'];
				}
				$member_s = "";

				$memberships_arrs = LbPeopleMemberships::model()->findAll('lb_people_id IN ('.$result_relationships_arr['lb_people_relationship_id'].')');
				foreach ($memberships_arrs as $result_memberships_arrs) {
					$member_s .= $result_memberships_arrs['lb_people_id'];
				}
				
				if($member_s != "") {
					$check_membership = "Yes";
				} else {
					$check_membership = "No";
				}
				echo '
				<tr>
					<td>'.$model_get_people->lb_given_name.'</td>
					<td>'.$people_relationships[0]['system_list_item_name'].'</td>
					<td>'.$check_membership.'</td>
					<td>'.$p_believer.'</td>
					<td><a class="delete" title="Delete" rel="tooltip" href="'.$this->createUrl('/lbPeople/default/delete_relationship/id_relation')."/".$result_relationships_arr['lb_record_primary_key'].'/id_people/'.$people_id.'"><i class="icon-trash"></i></a></td>
				</tr>';
			}
		 ?>
	</tbody>
</table>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Small Groups</h3>
		</td>
		<td style="text-align: right;">
			<!-- <a href="#"><i class="icon-pencil"></i></a> -->
		</td>
	</tr>
</table>
<?php 
	$small_group_of_member = LbSmallGroupPeople::model()->findAll('lb_people_id IN ('.$people_id.')');
?>
<table class="table">
	<thead>
		<tr>
			<th>Group Name</th>
			<th>Location</th>
			<th>Leader</th>
			<th>Role</th>
			<th>Since</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($small_group_of_member as $result_small_group_of_member) {
				$small_group_info = LbSmallGroups::model()->findAll('lb_record_primary_key IN ('.$result_small_group_of_member['lb_small_group_id'].')');
				foreach ($small_group_info as $result_small_group_info) {
					$people_name = "";
					if($result_small_group_of_member['lb_position_id'] == 1){
						$people_id = $result_small_group_of_member['lb_people_id'];
						$people_member=LbPeople::model()->findByPk($people_id);
            			$people_name = $people_member->lb_given_name;
					}
					echo '
					<tr>
						<td><a href="'.$this->createUrl('/lbSmallgroups/smallgroups/view/id')."/".$result_small_group_info['lb_record_primary_key'].'">'.$result_small_group_info['lb_group_name'].'</a></td>
						<td>'.$result_small_group_info['lb_group_location'].'</td>
						<td>'.$people_name.'</td>
						<td></td>
						<td>'.date('j F Y', strtotime($result_small_group_info['lb_group_since'])).'</td>
					</tr>';
				}
			}
		 ?>
	</tbody>
</table>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Volunteers</h3>
		</td>
		<td style="text-align: right;">
			<!-- <a href="#"><i class="icon-pencil"></i></a> -->
		</td>
	</tr>
</table>
<?php 
	$volunteers_people = LbPeopleVolunteersStage::model()->findAll('lb_people_id IN ('.$people_id.')');
?>
<table class="table">
	<thead>
		<tr>
			<th>Ministry</th>
			<th>Position</th>
			<th>Active</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($volunteers_people as $result_volunteers_people) {
				$volunteers_people_info = LbPeopleVolunteers::model()->findAll('lb_record_primary_key IN ('.$result_volunteers_people['lb_volunteers_id'].')');
				$volunteers_ministry = UserList::model()->getTermName('volunteers_ministry', $result_volunteers_people['lb_volunteers_type']);
				$volunteers_position = UserList::model()->getTermName('volunteers_position', $result_volunteers_people['lb_volunteers_position']);

				foreach ($volunteers_people_info as $result_volunteers_people_info) {

					$volunteers_active = UserList::model()->getTermName('volunteers_active', $result_volunteers_people_info['lb_volunteers_active']);
					
					echo '
					<tr>
						<td>'.($volunteers_ministry ? $volunteers_ministry[0]['system_list_item_name'] : '').'</td>
						<td>'.($volunteers_ministry ? $volunteers_position[0]['system_list_item_name'] : '') . '</td>
						<td>'.($volunteers_active ? $volunteers_active[0]['system_list_item_name'] : '') .'</td>
					</tr>';
				}
			}
		 ?>
	</tbody>
</table>

<br />

<div class="view_document_people">
<!--    <form action="" method="post" enctype="multipart/form-data">-->
<!--        <input type="file" name="fileUpload" value="">-->
<!--        <input type="submit" name="up" value="Upload">-->
<!--    </form>-->
    <?php $this->renderPartial('lbDocument.views.default.view',array('id'=>$people_info[0]['lb_record_primary_key'],'module_name'=>'lbPeople')); ?>
</div>


<script type="text/javascript">
	var LbPeopleMemberships_lb_membership_start_date = $("#LbPeopleMemberships_lb_membership_start_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeopleMemberships_lb_membership_start_date.hide();
    }).data('datepicker');

    var LbPeopleMemberships_lb_membership_end_date = $("#LbPeopleMemberships_lb_membership_end_date").datepicker({
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(ev) {
        LbPeopleMemberships_lb_membership_end_date.hide();
    }).data('datepicker');

	function show_modal_relationships() {
		$('#modal_relationships').modal('toggle');
	}
	function show_modal_membership() {
		$('#modal_membership').modal('toggle');
	}
</script>