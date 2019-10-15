<?php
/* @var $this SmallgroupsController */
/* @var $model LbSmallGroups */

$this->breadcrumbs=array(
	'Lb Small Groups'=>array('index'),
	$model->lb_record_primary_key,
);

$this->menu=array(
	array('label'=>'List LbSmallGroups', 'url'=>array('index')),
	array('label'=>'Create LbSmallGroups', 'url'=>array('create')),
	array('label'=>'Update LbSmallGroups', 'url'=>array('update', 'id'=>$model->lb_record_primary_key)),
	array('label'=>'Delete LbSmallGroups', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->lb_record_primary_key),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LbSmallGroups', 'url'=>array('admin')),
);
?>

<?php 
	echo '<div id="lb-container-header">';
        echo '<div class="lb-header-right"><h3>'.Yii::t("lang","Small Groups Info - ".$model->lb_group_name).'</h3></div>';
        echo '<div class="lb-header-left">';
	        echo '<div id="lb_invoice" class="btn-toolbar" >';
	        	echo '<a live="false" data-workspace="1" href="'.$this->createUrl('/lbSmallgroups/smallgroups/create').'"><i style="margin-top: -9px;margin-right: 10px;" class="icon-plus"></i> </a>';
	            echo ' <input type="text" placeholder="Enter leader\'s name..." value="" style="border-radius: 15px; width: 250px;" onKeyup="search_name_invoice(this.value);">';
	        echo '</div>';
        echo '</div>';
	echo '</div>';
 ?>

<table style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td>
			<h3>Infomation</h3>
		</td>
		<td style="text-align: right;">
			<a href="<?php echo $this->createUrl('/lbSmallgroups/smallgroups/update/id/'.$model->lb_record_primary_key) ?>"><i class="icon-pencil"></i></a>
		</td>
	</tr>
</table>

<div style="width: 100%; margin-top: 10px; display: inline-flex;">
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr">
					<td>Name</td>
					<td>: <?php echo $model->lb_group_name ?></td>
				</tr>
				<tr>
					<td>Type</td>
					<td>: <?php 
						$small_group_type = UserList::model()->getTermName('small_group_type', $model->lb_group_type);
      					echo $small_group_type[0]['system_list_item_name']; ?>
					</td>
				</tr>
				<tr>
					<td>Since</td>
					<td>: <?php 
						echo date('j F Y', strtotime($model->lb_group_since));
					?></td>
				</tr>
				<tr>
					<td>Meeting Time</td>
					<td>: <?php 
						echo date('D g:i a', strtotime($model->lb_group_meeting_time));
					?></td>
				</tr>
				<tr>
					<td>Frequency</td>
					<td>: <?php 
						$small_group_frequency = UserList::model()->getTermName('small_group_frequency', $model->lb_group_frequency);
      					echo $small_group_frequency[0]['system_list_item_name']; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="width: 50%;">
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td>Status</td>
					<td>: <?php 
						$small_group_active = UserList::model()->getTermName('small_group_active', $model->lb_group_active);
      					echo $small_group_active[0]['system_list_item_name']; ?>
					</td>
				</tr>
				<tr>
					<td>Location</td>
					<td>: <?php echo $model->lb_group_location ?></td>
				</tr>
				<tr>
					<td>District</td>
					<td>: <?php echo $model->lb_group_district ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div id="modal_members_small_groups" class="modal hide fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Assign Member - Small Group : <?php echo $model->lb_group_name; ?></h4>
      </div>
      <div class="modal-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'lb-assign_members_small_group',
			'enableAjaxValidation'=>false,
		)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>
		
		<!-- select people -->
		<?php echo $form->labelEx($model_small_group_people,'lb_people_id'); ?>
		<!-- <?php echo $form->textField($model_small_group_people,'lb_people_id',array('size'=>60,'maxlength'=>255)); ?> -->
		<?php 
			$people_object = LbPeople::model()->findAll();
			$people_arr = array();
            foreach($people_object as $result_people_object){
                $people_arr[$result_people_object['lb_record_primary_key']] = $result_people_object['lb_given_name'];
            }
            echo $form->dropDownList($model_small_group_people,'lb_people_id',$people_arr,array('rows'=>6));
		?>
		<?php echo $form->error($model_small_group_people,'lb_people_id'); ?>
		<!-- end select people -->

		<!-- select position -->
		<?php echo $form->labelEx($model_small_group_people,'lb_position_id'); ?>
		<!-- <?php echo $form->textField($model_small_group_people,'lb_position_id',array('size'=>60,'maxlength'=>255)); ?> -->
		<?php 
            $small_group_member_position = UserList::model()->getItemsListCodeById('small_group_member_position', true);
            $small_group_member_position[1] = "Leader";
            $small_group_member_position[2] = "Assistant";
            echo $form->dropDownList($model_small_group_people,'lb_position_id',$small_group_member_position,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model_small_group_people,'lb_position_id'); ?>
		<!-- end select position -->

		<!-- select active -->
		<?php echo $form->labelEx($model_small_group_people,'lb_mem_small_active'); ?>
		<!-- <?php echo $form->textField($model_small_group_people,'lb_mem_small_active',array('size'=>60,'maxlength'=>255)); ?> -->
		<?php 
            $small_group_member_active = UserList::model()->getItemsListCodeById('small_group_member_active', true);
            echo $form->dropDownList($model_small_group_people,'lb_mem_small_active',$small_group_member_active,array('rows'=>6)); 
        ?>
		<?php echo $form->error($model_small_group_people,'lb_mem_small_active'); ?>
		<!-- end select active -->
		
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
			<h3>Members</h3>
		</td>
		<td style="text-align: right;">
			<a href="#" data-toggle="modal" data-target="#modal_members_small_groups"><i class="icon-plus"></i></a>
		</td>
	</tr>
</table>

<?php 
echo '<div id="show_small_groups">';
$this->Widget('bootstrap.widgets.TbGridView',array(
    'id'=>'lb_show_small_groups',
    'dataProvider'=>  $model_small_group_people->search($model->lb_record_primary_key),
    // 'itemsCssClass' => 'table-bordered items',
    'template' => "{items}\n{pager}\n{summary}", 
    'columns'=>array(
      array(
          'header'=>Yii::t('lang','Name'),
          'type'=>'raw',
          'value'=>function($data){
          	if($data->lb_people_id != ""){
          		$people_member=LbPeople::model()->findByPk($data->lb_people_id);
            	return $people_member->lb_given_name;
            }
          },
          'htmlOptions'=>array('width'=>'200'),
      ),
      array(
          'header'=>Yii::t('lang','Postion'),
          'type'=>'raw',
          'value'=>function($data){
          	// return $data->lb_position_id;
          	if($data->lb_position_id != ""){
          		if($data->lb_position_id == 1) {
          			return "Leader";
          		} else if ($data->lb_position_id == 2) {
          			return "Assistant";
          		} else {
	  				$group_member_position = UserList::model()->getTermName('small_group_member_position', $data->lb_position_id);
	  				return $group_member_position[0]['system_list_item_name'];
	  			}
  			}
          },
          'htmlOptions'=>array('width'=>'250'),
      ),
      array(
          'header'=>Yii::t('lang','Mobile'),
          'type'=>'raw',
          'value'=>function($data){
          	if($data->lb_people_id != ""){
          		$people_member=LbPeople::model()->findByPk($data->lb_people_id);
            	return $people_member->lb_local_address_mobile;
            }
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      array(
          'header'=>Yii::t('lang','Active'),
          'type'=>'raw',
          'value'=> function($data){
          	// return $data->lb_mem_small_active;
          	if($data->lb_mem_small_active != ""){
  				$group_member_active = UserList::model()->getTermName('small_group_member_active', $data->lb_mem_small_active);
  				return $group_member_active[0]['system_list_item_name'];
  			}
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
      	array(
          'header'=>Yii::t('lang','Delete'),
          'type'=>'raw',
          'value'=> function($data){
          	return "<a href='#' onclick='delete_people_small_group(".$data->lb_record_primary_key.");'><i class='icon-trash'></i></a>";
          },
          'htmlOptions'=>array('width'=>'100'),
      ),
    )
));
echo '</div>';
?>

<?php 
	// $this->widget('zii.widgets.CDetailView', array(
	// 	'data'=>$model,
	// 	'attributes'=>array(
	// 		'lb_record_primary_key',
	// 		'lb_group_name',
	// 		'lb_group_type',
	// 		'lb_group_district',
	// 		'lb_group_frequency',
	// 		'lb_group_meeting_time',
	// 		'lb_group_since',
	// 		'lb_group_location',
	// 		'lb_group_active',
	// 	),
	// )); 
?>

<script type="text/javascript">
	function delete_people_small_group(small_group_people_id) {
		if (confirm('Are you sure to delete this record?')) {
                $.ajax({
                'url': "<?php echo $this->createUrl('/lbSmallgroups/smallgroups/deletePeopleSmallGroup'); ?>",
                data: {small_group_people_id:small_group_people_id},
                'success':function(data)
                {
                    window.location.assign("<?php echo $this->createUrl('/lbSmallgroups/smallgroups/view/id/'.$model->lb_record_primary_key); ?>");
                    // alert('success');
                }
            });
        }
	}
</script>
