<!-- <?php 
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
</table> -->
<?php 
	// $doc_grid_id = 'recent-dccuments-grid-' . $model->project_id;
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped',
        'dataProvider' => $documentModel->search(5),
        // 'filter' => $documentModel,
        'template' => "{items}{pager}",
        // 'id' => $doc_grid_id,
        'ajaxUpdate' => true,
        'htmlOptions' => array('style' => 'padding-top: 5px;'),
        'columns' => array(
            //array('name'=>'id', 'header'=>'#'),
            array(
                //'name' => 'task_name',
                'name' => 'document_real_name',
                'header' => YII::t('core','Name'),
                'type' => 'raw',
                'value' => 'CHtml::image($data->getDocumentIcon()) 
                            . CHtml::link(
                            $data->document_real_name,
                            array("document/download", "id" => $data->document_id),
                            array(
                                                        "target" => "_blank",
                                                    ) // end array
                                        ) . "<br/>"
                            . CHtml::link(
                                            $data->getDocumentEntityName(), 
                                            $data->getDocumentEntityURL(),
                                            array("class"=>"blur")
                                        )            
                            ', // end chtml::link
                /**
                'value' => 'CHtml::link(
                            $data->document_real_name,
                            "#",
                            array(
                                                        "onClick" => " {". CHtml::ajax(
                                    array(
                                            "url" => array("document/download", "id" => $data->document_id)),
                                    array("live" => false, "id"=> "ajax-id-" . uniqid())

                                                                    ) . " return false; }",
                                                        "id" => "ajax-id-" . uniqid(),
                                                        "target" => "_blank",
                                                    ) // end array
                                        )', // end chtml::link
                 * 
                 */
            ),
            array(
                'header'=>YII::t('core','Uploaded by'),
                'type'=>'raw',
                'value'=>'AccountProfile::model()->getProfilePhoto($data->document_owner_id)',
            ),
            array(
                //'name' => '',
                'header' => YII::t('core','Date'),
                'type' => 'html',
                'htmlOptions' => array('width' => '200px'),
                'value' => 'Utilities::displayFriendlyDateTime($data->document_date)', // format time
                'sortable' => false),
        ),
    ));
 ?>