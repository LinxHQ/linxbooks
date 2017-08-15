<?php
/* @var $this WikiPageController */
/* @var $dataProvider CActiveDataProvider */
/* @var $project_id */
/* @var $project_name */
/* @var $wiki_categories */
/* @var $wiki_tree */

$menu_items = array();
// fixed items

// only show wiki home link if we're not viewing from within project as a tab
if (!isset($_GET['simple']) || $_GET['simple'] == NO)
{
	$menu_items[] = array('label'=>'Wiki Home',
				'url'=>array('index', 'project_id' => $project_id, 'project_name' => $project_name),
				'linkOptions' => array('data-workspace' => '1'));
}

// get permission for adding category
$subscriptions = AccountSubscription::model()->findSubscriptions(Yii::app()->user->id, true);
reset($subscriptions); // need in order to get first key below
$wikiTemp = new WikiPage();
if (count($subscriptions)) $wikiTemp->account_subscription_id = key($subscriptions);
// New CAtegory link
if (Permission::checkPermission($wikiTemp, PERMISSION_WIKI_CATEGORY_CREATE))
{
	$menu_items[] = array('label'=>'New Category',
			'url'=>array('create', 'project_id' => $project_id, 'project_name' => $project_name, 'is_category' => YES),
			'linkOptions' => array('data-workspace' => '1'));
}

$menu_items[] = array('label'=>'New Page', 
		'url'=>array('create', 'project_id' => $project_id, 'project_name' => $project_name),
		'linkOptions' => array('data-workspace' => '1'));
$menu_items[] = array('label'=>'New Template',
		'url'=>array('create', 'project_id' => $project_id, 'project_name' => $project_name, 'is_template' => YES),
		'linkOptions' => array('data-workspace' => '1'));
$menu_items[] = array('label'=>'Templates',
		'url'=>array('adminTemplate'),
		'linkOptions' => array('data-workspace' => '1'));

// categories
foreach ($wiki_categories as $cat)
{
	$menu_items[] = array('label'=> $cat->wiki_page_title,
			'url'=> $cat->getWikiPageURL(),// array('view', 'id' => $cat->wiki_page_id),
			'linkOptions' => array('data-workspace' => '1'));
}
$this->menu = $menu_items;

// show project's name and some other headings 
// only if it's simple view (such as embeded in project's view as a tab
if (!isset($_GET['simple']) || $_GET['simple'] == NO)
{
	/**
	echo '<h3>';
	echo Utilities::workspaceLink(
			$project_name, array('project/view', 'id' => $project_id) );
	echo '</h3>';
	*/
	
	echo '<h4>iWiki</h4>';
}
?>

<div id="wiki-content" class="span-19" style="float: left; width: 850px;">
	<?php 
	foreach ($wiki_tree as $id => $page)
	{
		//
		// formate page name
		// - each '--' replaced with 2 empty spaces.
		// - include icon in front of a page.
		//
		$pageObj = new WikiPage;
		$pageObj->wiki_page_title = $page;
		$formattedTitle = $pageObj->formatTitleForWikiTree();
		
		// if root page, give a different icon
		// UPDATE: we only print root page to avoid too many sqls being executed due to permission check.
		$link_name = $formattedTitle[1];
		if (strlen($formattedTitle[0]) == 0) // root page
		{
			$link_name = '<i class="icon-book"></i>&nbsp;' . $link_name;
		} else {
				continue; // code below this block won't be exec for now. but don't delete it.
				$link_name = '<i class="icon-file"></i>&nbsp;' . $link_name;
		}
		// End formatting page name
	
		//
		// check permission
		// overall, only customer cannot see any wiki
		//
		$thisWikiPage = WikiPage::model()->findByPk($id);
		$master_account_id = 0;
		if ($thisWikiPage->project_id > 0)
		{	
			// WIKI belongs to a project
			$master_account_id = AccountTeamMember::model()->getMasterAccountIDs(Yii::app()->user->id, $thisWikiPage->project_id);
			
			// if user is not assigned to this project and not PM or master account, skip
			if (!ProjectMember::model()->isValidMember($thisWikiPage->project_id, Yii::app()->user->id))
			{
				if (!Account::model()->isMasterAccount($thisWikiPage->account_subscription_id))
					continue;
			}
		} else 
		{
			// WIKI doesnt belong to a project
			$thisSubscription = AccountSubscription::model()->findByPk($thisWikiPage->account_subscription_id);
			$master_account_id = $thisSubscription->account_id;
			
			// if user is a deactivated account team member of the master account of this wiki
			// deny
			if (!AccountTeamMember::model()->isActive($master_account_id, Yii::app()->user->id)
					&& $master_account_id != Yii::app()->user->id)
				continue; //skip
		}
		if (AccountTeamMember::model()->isCustomer($master_account_id, Yii::app()->user->id))
			continue;
		// end check permission
		
		// PRINT
		echo $formattedTitle[0];
		echo Utilities::workspaceLink($link_name, $thisWikiPage->getWikiPageURL());
		// show project name if any
		if ($project_id == 0)
		{
			$pageObj = WikiPage::model()->findByPk($id);
			if ($pageObj->project_id > 0)
			{
				$pageProject = Project::model()->findByPk($pageObj->project_id);
				if ($pageProject)
				{
					echo '&nbsp<span class="blur-summary">- ' . $pageProject->project_name . '</span>';
				}
			}
		}
		echo '<br/>';
	}
	/**
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'ajaxUpdate' => 'wiki-content',
		'afterAjaxUpdate' => 'function(id, data){alert("resetting"); resetWorkspaceClickEvent(null);}',
		'id' => 'wiki-index-list-' . $_GET['_'], // add unique ajax call id
	));**/ 
	?>
</div>
<div class="span-5 last" style="float: right; width: 220px;">
	<?php
		$this->widget('ext.ajaxmenu.AjaxMenu',array(
			'items' => $this->menu,
			'optionalIndex' => true,
			'randomID' => true,
		));
	?>
</div>
