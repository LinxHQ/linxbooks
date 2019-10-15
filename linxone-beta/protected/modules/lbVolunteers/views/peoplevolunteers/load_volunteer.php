<table class="table">
	<thead>
		<tr>
			<th>Ministry</th>
			<th>Position</th>
			<th>Start</th>
			<th>End</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<input type="hidden" id="volunteers_id" value="<?php echo $volunteers_id; ?>">
		<?php
			$list_volunteers_stage = LbPeopleVolunteersStage::model()->findAll('lb_volunteers_id IN ('.$volunteers_id.')');
			foreach ($list_volunteers_stage as $result_list_volunteers_stage) {
				$volunteers_position = UserList::model()->getTermName('volunteers_position', $result_list_volunteers_stage['lb_volunteers_position']);
				$volunteers_ministry = UserList::model()->getTermName('volunteers_ministry', $result_list_volunteers_stage['lb_volunteers_type']);
				echo '
				<tr>
					<td>'.$volunteers_ministry[0]['system_list_item_name'].'</td>
					<td>'.$volunteers_position[0]['system_list_item_name'].'</td>
					<td>'.date("d-m-Y", strtotime($result_list_volunteers_stage['lb_volunteers_start_date'])).'</td>
					<td>'.date("d-m-Y", strtotime($result_list_volunteers_stage['lb_volunteers_end_date'])).'</td>
					<td><a href="#" onclick="delete_volunteer('.$result_list_volunteers_stage['lb_record_primary_key'].')"><i class="icon-trash"></i></a></td>
				</tr>';
			}
		 ?>
	</tbody>
</table>

<script type="text/javascript">
	function delete_volunteer(id_volunteers_stage) {
	    if (confirm('Are you sure to delete this record?')) {
                $.ajax({
                'url': "<?php echo $this->createUrl('/lbVolunteers/Peoplevolunteers/deletevolunteer'); ?>",
                data: {id_volunteers_stage:id_volunteers_stage},
                'success':function(data)
                {
                	var volunteers_id = $("#volunteers_id").val();
                    $("#load_volunteer").load("<?php echo $this->createUrl('/lbVolunteers/Peoplevolunteers/load_volunteer'); ?>",{volunteers_id:volunteers_id});
                }
            });
        }
	}
</script>