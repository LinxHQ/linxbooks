<?php
/* @var $this WikiPageController */
/* @var $dataProviderLinks CActiveDataProvider */
/* @var $project_id */
/* @var $project_name */

$menu_items = array();

$menu_items[] = array('label'=>'Home',
		'url'=>CHtml::normalizeUrl(Utilities::getAppLinkiWikiLinks()). "&project_id=$project_id",
		'linkOptions' => array('data-workspace'=>1));
$menu_items[] = array('label'=>'New Link',
		'url'=>array('resource/create', 'project_id' => $project_id, 'project_name' => $project_name),
		'linkOptions' => array());

// ONLY IN NON-PROJECT VIEW
if (!isset($_GET['project_id']) || $_GET['project_id'] <= 0)
{
	$menu_items[] = array('label'=>'New List',
			'url'=>array('resourceUserList/create', 'project_id' => $project_id, 'project_name' => $project_name),
			'linkOptions' => array());
}
$menu_items[] = array('label'=>'Manage Links',
		'url'=>array('resource/admin', 'project_id' => $project_id),
		'linkOptions' => array('data-workspace'=>1));

// ONLY IN NON-PROJECT VIEW
if (!isset($_GET['project_id']) || $_GET['project_id'] <= 0)
{
	$menu_items[] = array('label'=>'Manage Lists',
			'url'=>array('resourceUserList/admin'),
			'linkOptions' => array('data-workspace'=>1));
}
$this->menu = $menu_items;
?>

<div id="link-list-container" class="span-19" style="float: left; width: 850px;">
	<?php 
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProviderLinks,
		'itemView'=>'_view_link',
		'ajaxUpdate' => 'link-list-container',
		'afterAjaxUpdate' => 'function(id, data){resetWorkspaceClickEvent(null);}',
		'id' => 'links-index-list-' . (isset($_GET['_']) ? $_GET['_'] : 0), // add unique ajax call id
	));
	?>
</div>
<div class="span-5 last" style="float: right; width: 220px;">
	
	<?php
	echo '<h5>Actions</h5>';
		$this->widget('ext.ajaxmenu.AjaxMenu',array(
			'items' => $this->menu,
			'optionalIndex' => true,
			'randomID' => true,
		));

	// ONLY AVAILABLE IN NON-PROJECT SPECIFIC VIEW
	// LISTS
	if (!isset($_GET['project_id']) || $_GET['project_id'] <= 0)
	{
		echo '<h5>Lists</h5>';
		$this->widget('bootstrap.widgets.TbGridView', array(
				'type' => 'striped',
				'dataProvider' => ResourceUserList::model()->getLists(Utilities::getCurrentlySelectedSubscription()),
				'template' => "{items}{pager}",
				'hideHeader'=>true,
				'blankDisplay'=>'No lists yet.',
				'columns' => array(
					array(
						'header'=>'',
						//'name'=>'resource_user_list_name',
						'type'=>'raw',
						'sortable'=>false,
						'value'=>'Utilities::workspaceLink($data->resource_user_list_name,
							CHtml::normalizeUrl(Utilities::getAppLinkiWikiLinks()) . 
								"&list={$data->resource_user_list_name}&list_id={$data->resource_user_list_id}")'
					),
				)
		));
	}
	?>
</div>
