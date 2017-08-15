<style type="text/css" media="screen">
     /* Dropdown Button */
.dropbtn {
    background-color: rgb(91, 183, 91);
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
    background-color: rgb(91, 183, 91);
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 145px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;} 
</style>
<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $peer_pages array of models WikiPage */
/* @var $subpages array of models WikiPage */
/* @var $attachments array of attached documents */

Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );

if ($model->project_id > 0) 
{
	$project = Project::model()->findByPk($model->project_id);
	
	// print header
	// Utilities::renderPartial($this, "//project/_project_header",
	// 	array('project_id' => $model->project_id, 'return_tab' => $model->wiki_page_is_home ? 'wikihome': 'wiki'));
	
	// echo '<br/><br/>';
}

$creator_profile = AccountProfile::model()->find('account_id = ?', array($model->wiki_page_creator_id));
$last_updater = AccountProfile::model()->find('account_id = ?', array($model->wiki_page_updated_by));
echo '<div id="lb-container-header">
            <div class="lb-header-right" style="margin-left:-11px;"><h3>Dự án</h3></div>
            <div class="lb-header-left">
                &nbsp;
                 <div class="dropdown">
                  <button onclick="myFunction()" class="dropbtn"><i class="icon-plus icon-white"></i></button>
                  <div id="myDropdown" class="dropdown-content">
                    <a href="create">Create Project</a>
                    <a href="'.Yii::app()->getBaseUrl().'/index.php/lbProject/wikiPage/create">Create Wiki Page</a>
                  </div>
                </div> 
                
                <input placeholder="Search" value="" style="border-radius: 15px; margin-top: 3px;" onkeyup="search_name_invoice(this.value);" type="text">
            </div>
</div><br>';
$count_project = " <span class='badge'>".count(Project::model()->findAll())."</span>";
    $count_task = " <span class='badge badge badge-warning'>".count(Task::model()->findAll())."</span>";
    $count_document = " <span class='badge badge badge-success'>".count(Documents::model()->findAll())."</span>";
    $count_wiki = " <span class='badge badge badge-success'>".count(WikiPage::model()->findAll())."</span>";
    $count_project = " <span class='badge'>".count(Project::model()->findAll())."</span>";
    $count_task = " <span class='badge badge badge-warning'>".count(Task::model()->findAll('project_id IN ('.$model->project_id.')'))."</span>";
    $count_document = " <span class='badge badge badge-success'>".count(Documents::model()->findAll('   document_parent_id IN ('.$model->project_id.')'))."</span>";
    $count_wiki_name = strlen($model->wiki_page_title);
if($count_wiki_name > 20){
    $result_wiki_name = mb_substr($model->wiki_page_title,  0, 20);
    $wiki_name = $result_wiki_name."...";
} else {
    $wiki_name = $model->wiki_page_title;
}
$taskModel = new Task('search');
$taskModel->unsetAttributes();
if(isset($_GET['Task'])) 
{
    $taskModel->attributes=$_GET['Task'];
}
$taskModel->project_id = $model->project_id;
$taskModel->task_status = TASK_STATUS_ACTIVE;
// print_r($taskModel);

$documentModel = new Documents('getDocuments');
$documentModel->unsetAttributes();
if(isset($_GET['Documents'])) 
{
    $documentModel->attributes=$_GET['Documents'];
    //echo $documentModel->document_real_name; return;
}
$this->widget('bootstrap.widgets.TbTabs', array(
                    'type'=>'tabs', // 'tabs' or 'pills'
                    'encodeLabel'=>false,
                    'tabs'=> 
                    array(
                               array('id'=>'tab1','label'=>Yii::t('lang','Dự án'). ' <span class="badge">'.count(Project::model()->findAll()).'</span>',
                                    'content'=>$this->renderPartial('application.modules.lbProject.views.default.project_all',array(

                                    ),true),'active'=>false,
                                ),
                                array('id'=>'tab2','label'=>Yii::t('lang','Công việc'). ' <span class="badge badge-warning">'.count(Task::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>',
                                    'content'=>$this->renderPartial('application.modules.lbProject.views.default._index_tasks',array(
                                            'model' => $model,
                                            'taskModel' => $taskModel
                                    ),true),'active'=>false,
                                ),
                                array('id'=>'tab3','label'=>Yii::t('lang','Văn bản'). ' <span class="badge badge-success">'.count(Documents::model()->findAll('document_parent_id IN ('.$model->project_id.')')).'</span>',
                                    'content'=>$this->renderPartial('application.modules.lbProject.views.default._index_documents',array(
                                        'model' => $model,
                                        'documentModel'=>$documentModel,
                                    ),true),'active'=>false,
                                ),
                                array('id'=>'tab4','label'=>Yii::t('lang','Wiki'). ' <span class="badge badge-info">'.count(WikiPage::model()->findAll('project_id IN ('.$model->project_id.')')).'</span>',
                                    'content'=>$this->renderPartial('application.modules.lbProject.views.default.wiki_all',array(
                                            'model' => $model,
                                            'documentModel' => $documentModel,
                                    ),true),'active'=>false,
                                ),
                                array('id'=>'tab5','label'=>$wiki_name, 
                                                'active'=>true),
                            )
    ));
?>
<div class="wiki-header-container">
	<h4 class="wiki-title"><?php echo $model->wiki_page_title; ?></h4>
	<div class="wiki-action-submenu">
	<?php 
	echo Utilities::workspaceLink(
			'<i class="icon-road"></i>History',
			array('wikiPageRevision/view', 'id' => 0, 'page' => $model->wiki_page_id)
	) . '&nbsp;';
	
	echo Utilities::workspaceLink(
		'<i class="icon-pencil"></i>Edit', 
		array('wikiPage/update',
			'id' => $model->wiki_page_id ,
			'project_id' => $model->project_id,
			'is_category' => $model->wiki_page_is_category) );
	/*
	echo CHtml::ajaxLink(
			'<i class="icon-pencil"></i>',
			array('wikiPage/update', 
				'id' => $model->wiki_page_id ,
				'project_id' => $model->project_id,
				'is_category' => $model->wiki_page_is_category), // Yii URL
			array('update' => '#wiki-content'), // jQuery selector
			array('id' => 'ajax-id-'.uniqid())
	);**/

	echo '&nbsp;';
	
	if (Permission::checkPermission($model, PERMISSION_WIKI_PAGE_DELETE))
	{
		echo CHtml::ajaxLink(
				'<i class="icon-trash"></i>Delete',
				array('wikiPage/delete', 'id' => $model->wiki_page_id), // Yii URL
				array('success' => 
                                        $model->project_id > 0 ? 
                                        'function(data){
						if (data == "success")
						{
							var url = "' . Yii::app()->createUrl('project/view', array('id' => $model->project_id, 'tab' => 'wiki')) . '";
							workspaceLoadContent(url);
							workspacePushState(url);
						}
					}' : 
                                        'function(data){
						if (data == "success")
						{
							var url = "' . CHtml::normalizeUrl(Utilities::getAppLinkiWiki()) . '";
							workspaceLoadContent(url);
							workspacePushState(url);
						}
					}', // end success param 
					'type' => 'POST'), // jQuery selector
				array('id' => 'ajax-id-'.uniqid(), 'confirm' => 'Are you sure to delete this wiki page and its sub page(s)?')
		);
	}
	?>
	</div>
</div>
<div class="wiki-editing-info">
	Created by <?php echo $creator_profile->account_profile_preferred_display_name; ?>. Last updated by <?php echo $last_updater->account_profile_preferred_display_name; ?> on <?php echo $model->wiki_page_date; ?>
</div>
<?php
/** $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'wiki_page_id',
		'account_subscription_id',
		'project_id',
		'wiki_page_title',
		'wiki_page_parent_id',
		'wiki_page_content',
		'wiki_page_tags',
		'wiki_page_date',
		'wiki_page_updated_by',
	),
));**/

echo "<hr/>";

// MAIN CONTENT
echo '<div style="display: table">';

echo '<div class="span-19" style="float: left; width: 850px;" id="linxcircle-wiki-view">';

// generate table of content
// and reformat content to include anchors with existing headers
$formated_cotnent = Utilities::createTOC($model->wiki_page_content);
echo '<div id="wiki-page-content">' 
				. $formated_cotnent['toc']
				. $formated_cotnent['content']
				. '</div><br/>';
echo "<span class='blur-summary'><b>Tags:</b> {$model->wiki_page_tags}</span>";
// Attachments
if (isset($attachments))
{
	echo '<br/><span class="blur-summary"><b>Attachments:</b></span><br/>';
	foreach ($attachments as $doc)
	{
		// generate ajax delete link
		// document delete ajax link
		
		$doc_delete_ajax_link = CHtml::ajaxLink(
				'<i class="icon-remove"></i>',
				array('document/ajaxDelete', 'id' => $doc->document_id), // Yii URL
				array('success' => 'function(data){
						if (data == "success") {
						$("#container-document-' . $doc->document_id . '").remove(); // remove doc div container
				}
				}'),
				array('id' => 'ajax-id-'.uniqid())
		);

		echo '<div id="container-document-' . $doc->document_id . '">';
		echo CHtml::link($doc->document_real_name,
				Yii::app()->createUrl("document/download", array('id' => $doc->document_id)));
		echo '<div class="blur-summary" style="display: inline"> - ' . Utilities::formatDisplayDate($doc->document_date) . '</div>';
		echo '&nbsp;' . $doc_delete_ajax_link;
		echo '</div>';
		//echo '<br/>';
	}
}

//
// sub pages
//
echo '<hr/>';
echo '<center>';
	// Up link if any
	if ($model->wiki_page_parent_id > 0)
	{
		$ajax_link = Utilities::workspaceLink(
			'Up to parent page', 
			array('wikiPage/view', 'id' => $model->wiki_page_parent_id) );
		
		$ajax_link = CHtml::ajaxLink(
			'Up to parent page',
			array('wikiPage/view', 'id' => $model->wiki_page_parent_id), // Yii URL
			array('update' => '#wiki-content'), // jQuery selector
			array('id' => 'ajax-id-'.uniqid())
		);
		echo "$ajax_link <br/>";
	}
	
	echo CHtml::link(
			'Add Sub Page',
			array('create',
					'project_id' => (isset($model->project_id) && $model->project_id > 0) ? $model->project_id : 0,
					//'project_name' => $project_name,
					'wiki_page_parent_id' => $model->wiki_page_id),
			array('data-workspace' => '1'));

echo '</center>'; // end add sub page link

echo '<div style="clear: both"></div>';
	if (count($subpages) > 0) 
	{
		echo '<h5>Sub Pages</h5>';
		echo '<ul class="nav nav-tabs nav-stacked">';
	
		foreach($subpages as $page)
		{
			$ajax_link = Utilities::workspaceLink(
				$page->wiki_page_title, 
				array('wikiPage/view', 'id' => $page->wiki_page_id) );
			
			$ajax_link = CHtml::ajaxLink(
				$page->wiki_page_title,
				array('wikiPage/view', 'id' => $page->wiki_page_id), // Yii URL
				array('update' => '#wiki-content'), // jQuery selector
				array('id' => 'ajax-id-'.uniqid())
			);
			echo "<li>$ajax_link</li>\n";
		}
		
		echo '</ul>';
		
		echo Utilities::workspaceLink("Re-order Sub Pages", array("wikiPage/reorderSubPages", "id" => $model->wiki_page_id));
	}// end sub pages
echo '</div>'; // end div for span-19 linxcircle-wiki-view

///
// SIDE BAR
///
echo '<div class="span-5 last" style="float: right; width: 220px;">';

// echo '<h4>Links</h4>';
// echo '<ul>';

// // Parent page
// if ($model->wiki_page_parent_id > 0)
// {
// 	$ajax_link = Utilities::workspaceLink(
// 			'... Parent page',
// 			WikiPage::model()->getWikiPageURL($model->wiki_page_parent_id));
// 			//array('wikiPage/view', 'id' => $model->wiki_page_parent_id) );

// 	echo "<li>$ajax_link</li>";
// }

// // print peer pages
// if (isset($peer_pages))
// {
	
// 	foreach ($peer_pages as $peer)
// 	{
// 		if (!Permission::checkPermission($peer, PERMISSION_WIKI_PAGE_VIEW))
// 			continue;
// 		echo '<li>';
// 		echo Utilities::workspaceLink(
// 				Utilities::getShortName($peer->wiki_page_title, true, 20),
// 				$peer->getWikiPageURL(),
// 				array('title'=>$peer->wiki_page_title));
// 				//array('wikiPage/view', 'id' => $peer->wiki_page_id) );
// 		echo '</li>';
// 	}
// }
// echo '</ul>';
echo '</div>'; // end div for side bar
// End SIDE BAR

echo '</div>'; // end div for MAIN CONTENT
?>
<script type="text/javascript">
	function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
} 
</script>