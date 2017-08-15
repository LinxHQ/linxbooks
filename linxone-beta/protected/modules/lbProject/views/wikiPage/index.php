<?php
/* @var $this WikiPageController */
/* @var $dataProvider CActiveDataProvider */
/* @var $project_id */
/* @var $project_name */
/* @var $wiki_categories */
/* @var $wiki_tree */

// show project's name and some other headings
// only if it's simple view (such as embeded in project's view as a tab
if (!isset($_GET['simple']) || $_GET['simple'] == NO)
{
	echo '<h4>iWiki</h4>';
}

//active tab
$active_tab_wiki = false;
$active_tab_lists = false;
$active_tab_home = false;
if (isset($_GET['tab']))
{
	if ($_GET['tab'] == 'lists')
		$active_tab_lists = true;
	else if ($_GET['tab'] == 'wiki')
		$active_tab_wiki = true;
    else {
        if ($project_id)
           $active_tab_home = true;
        else
            $active_tab_wiki = true;
    }
} else {
    if ($project_id)
        $active_tab_home = true;
    else
        $active_tab_wiki = true;
}
?>
<div id="iwiki-content-container" style="">
	<?php 
	
	// tabs
	$wiki_tabs = array();
	// pages
    if (isset($project_id) && $project_id > 0)
    {
        // LOAD TAB wiki home only if viewing project
        $wikiHome = WikiPage::model()->getProjectWikiHome($project_id);

        // load only if wiki home is found
        if ($wikiHome !== null) {
            $wiki_tabs[] = array(
                'label'=>'Home',
                'content'=>'<div id="wiki-home-project-'.$project_id.'"></div>',
                'active'=>$active_tab_home,
            );

            Yii::app()->clientScript->registerScript('wiki-home-project-load-'.$project_id,
                '$.get("'.CHtml::normalizeUrl(array('/wikiPage/viewProjectHome', 'id'=>$wikiHome->wiki_page_id, 'ajax'=>1)).'", function(data){
                    $("#wiki-home-project-'.$project_id.'").html(data);
                })',
                CClientScript::POS_READY);
        }
    }

	$wiki_tabs[] = array(
					'label'=>'Pages', 
					'content'=> $this->renderPartial('_index_wiki', array(
						'dataProvider' => $dataProvider,
						'project_id' => $project_id,
						'project_name'=>$project_name,
						'wiki_categories'=>$wiki_categories,
						'wiki_tree'=>$wiki_tree,
					), true),
					'active'=>$active_tab_wiki);
	
	// pages
	$wiki_tabs[] = array(
			'label'=>'Links',
			'content'=> $this->renderPartial('_index_links', array(
					'dataProviderLinks' => $dataProviderLinks,
					'project_id' => $project_id,
					'project_name'=>$project_name,
			), true),
			'active'=>$active_tab_lists);
	
	$this->widget('bootstrap.widgets.TbTabs', array(
		'type'=>'pills', // 'tabs' or 'pills'
		'encodeLabel' => false,
		'tabs'=>$wiki_tabs));
	?>
</div> <!--  end #wiki-content -->