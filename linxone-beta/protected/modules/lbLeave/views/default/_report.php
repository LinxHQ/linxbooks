<?php



$LeaveType = array();
$inlieu = array();
foreach ($LeaveAssignment as $value) {
	if($value->assignment_leave_name=='Package'){
		$itemParkage = LeavePackageItem::model()->findAll('item_leave_package_id='.$value->assignment_leave_type_id);
		foreach ($itemParkage as $value_package) {
			
			if(array_key_exists($value_package->item_leave_type_id, $LeaveType))
				$LeaveType[$value_package->item_leave_type_id] += $value_package->item_total_days;
			else
				$LeaveType[$value_package->item_leave_type_id] = $value_package->item_total_days;
		}

	}

	if($value->assignment_leave_name=='Leave Type'){
		
			
			if(array_key_exists($value->assignment_leave_type_id, $LeaveType))
				$LeaveType[$value->assignment_leave_type_id] += $value->assignment_total_days;
			else
				$LeaveType[$value->assignment_leave_type_id] = $value->assignment_total_days;

	}

	if($value->assignment_leave_name=='In Lieu'){
		$itemInLieu = LeaveInLieu::model()->findAll('leave_in_lieu_id='.$value->assignment_leave_type_id);
		foreach ($itemInLieu as $value) {
				$inlieu[$value->leave_in_lieu_id] = $value->leave_in_lieu_totaldays;
		}

	}

}


?>
<table class="table table-bordered items">
	<thead>
		<tr>
			<th style="color: rgb(91, 183, 91);"><?php echo Yii::t('lang','Type Leave'); ?></th>
			<th style="color: rgb(91, 183, 91);"><?php echo Yii::t('lang','Total of Days'); ?></th>
			<th style="color: rgb(91, 183, 91);"><?php echo Yii::t('lang','Left'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($LeaveType as $key => $value) {?>
			<tr>
				<td>
					<?php 
						$leaveType=UserList::model()->getItemsListCodeById('leave_type',true);
                    	echo $leaveType[$key];

						
					?>
				</td>
				<td><?php echo $value; ?></td>
				<td><?php echo $value; ?></td>
			</tr>
		<?php } ?>
		<?php foreach ($inlieu as $key => $value) {?>
			<tr>
				<td>
					<?php 
						$leaveInLieu=CHtml::listData(LeaveInLieu::model()->findAll(), 'leave_in_lieu_id', 'leave_in_lieu_name');
						echo $leaveInLieu[$key];
						
					?>
				</td>
				<td><?php echo $value; ?></td>
				<td><?php echo $value; ?></td>
			</tr>
		<?php } ?>

	</tbody>
</table>