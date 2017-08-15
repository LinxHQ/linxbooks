<?php 
	$list_document = Documents::model()->findAll();

 ?>

 <table class="items table table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Uploaded By</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach($list_document as $result_document){
				$url = CHtml::link($result_document['document_real_name'],array('document/download', 'id' => $result_document['document_id']), array('target'=>'_blank'));
				$uploaded_by = AccountProfile::model()->getProfilePhoto($result_document['document_owner_id']);
				echo "
					<tr>
						<td>".$url."</td>
						<td>".$uploaded_by."</td>
						<td>".Utilities::displayFriendlyDateTime($result_document['document_date'])."</td>
					</tr>";
			}

		 ?>
		
	</tbody>
</table>