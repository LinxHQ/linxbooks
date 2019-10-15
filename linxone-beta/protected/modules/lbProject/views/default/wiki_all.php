<!-- <?php 

	echo "<h4>Links</h4>";
	if(isset($_GET['id'])){
		// $wiki_all = WikiPage::model()->findAll();
		$wiki_all = WikiPage::model()->findAll('project_id IN ('.$_GET['id'].')');
	} else {
		$wiki_all = WikiPage::model()->findAll();
	}
	if(isset($model->project_id)){
		$wiki_all = WikiPage::model()->findAll('project_id IN ('.$model->project_id.')');
	}
	foreach($wiki_all as $result_wiki_all){
		$url_link = Yii::app()->getBaseUrl().'/index.php/lbProject/wikiPage/view/id/'.$result_wiki_all['wiki_page_id'];
		echo "<a href=".$url_link.">".$result_wiki_all['wiki_page_title']."</a><br />";
	}
 ?> -->

<?php
	if(isset($project_id)){
		$wiki_arr = WikiPage::model()->findAll('project_id IN ('.$project_id.')');
		echo '
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="color: rgb(91, 183, 91) !important">Wiki Page Title</th>
						<th style="color: rgb(91, 183, 91) !important">Wiki Page Date</th>
					</tr>
				</thead>';
				foreach($wiki_arr as $result_wiki_arr){
					// ".Yii::app()->getBaseUrl()."/index.php/lbProject/wikiPage/view/id/".$result_wiki_arr['wiki_page_id']."
					echo "
					<tbody>
						<tr>
							<td><a onclick='registerComposeButtonEvent(\"".$result_wiki_arr['wiki_page_title']."\", \"".uniqid()."\", ".$result_wiki_arr['wiki_page_id'].", \"wiki\");' href='#'>".$result_wiki_arr['wiki_page_title']."</a></td>
							<td>".$result_wiki_arr['wiki_page_date']."</td>
						</tr>
					</tbody>";
				}
				
		echo '
			</table>
	
		';
	}
	if(isset($wikiModel)){
		$url_link = Yii::app()->getBaseUrl().'/index.php/lbProject/wikiPage/view/id/';
		// $doc_grid_id = 'recent-dccuments-grid-' . $model->project_id;
	    $this->widget('bootstrap.widgets.TbGridView', array(
	        'type' => 'striped',
	        'dataProvider' => $wikiModel->search(8),
	        // 'filter' => $documentModel,
	        'template' => "{items}{pager}",
	        // 'id' => $doc_grid_id,
	        'ajaxUpdate' => true,
	        'htmlOptions' => array('style' => 'padding-top: 5px;'),
	        'columns' => array(
	            array(
	                'name' => 'wiki_page_title',
	                'header' => YII::t('core','Wiki Page Title'),
	                'type' => 'raw',
	                'value' => '"<a href=\'".Yii::app()->getBaseUrl()."/index.php/lbProject/wikiPage/view/id/".$data->wiki_page_id."/para/wikiall\'>".$data->wiki_page_title."</a>"', // end chtml::link=
	            ),
	            array(
	                'name' => 'wiki_page_date',
	                'header' => YII::t('core','Wiki Page Date'),
	                'type' => 'raw',
	                'value' => $wikiModel->wiki_page_date,
	            ),
	        ),
	    ));
	}
	
 ?>


 