<?php 

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
 ?>
 