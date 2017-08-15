<?php
/* @var $this ResourceController */
/* @var $dataProvider CActiveDataProvider */

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

$this->widget('bootstrap.widgets.TbMenu', array(
		'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		'stacked'=>false, // whether this is a stacked menu
		'items'=>array(
				array('label'=>'Pages', 
						'url'=>array(Utilities::getCurrentlySelectedSubscription().'/wiki'),
						'linkOptions'=>array('data-workspace'=>1)),
				array('label'=>'Links', 
						'url'=>'#',
						'active'=>true),
		),
));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
