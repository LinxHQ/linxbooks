<?php
/* @var $this WikiPageRevisionController */
/* @var $model WikiPageRevision */
/* @var $latest WikiPage ie latest revision */
/* @var $revisions Array list of revisions */
/* @var $diff_with_bf Diff object containing diff with version before this model */

if ($latest->project_id > 0) 
{
	$project = Project::model()->findByPk($latest->project_id);
	
	echo '<div id="project-name-container" class="container-header">';
	echo '<h3>';
	echo Utilities::workspaceLink(
			$project->project_name, 
			'',
			array('href'=>CHtml::normalizeUrl($project->getProjectURL()).'?tab=wiki'));
			//array('project/view',
			//		'id' => $project->project_id,
			//		'tab' => 'wiki') );
	echo '</h3>'; 
	echo '</div><br/><br/>';
}

?>
<div class="wiki-header-container">
	<h4 class="wiki-title" style="clear: both">
	<?php 
	echo $latest->wiki_page_title; 
	
	echo '&nbsp;<span class="blur-summary">';
	echo ($model->wiki_page_revision_id >0 ? 
			' on ' . $model->wiki_page_revision_date : 'Latest');
	echo '&nbsp;by&nbsp;' . 
		($model->wiki_page_revision_id >0 ? 
			AccountProfile::model()->getShortFullName($model->wiki_page_revision_updated_by)
				: AccountProfile::model()->getShortFullName($latest->wiki_page_creator_id));
	echo '</span>';
	?></h4>
</div>

<?php
// RESTORE LINK
echo '<div style="display: table; clear: both;">';
if ($model->wiki_page_revision_id >0) {
	echo CHtml::link(
			'Restore this revision',
			array('wikiPageRevision/restore',
					'id' => $model->wiki_page_revision_id));
	
} else {
	echo '&nbsp;'; // empty line
}
echo '</div>';

// REVISION CONTENT
echo '<div style="display: table; clear: both; margin-top: 20px;">';

// MAIN CONTENT
echo '<div class="span-19" style="float: left; width: 850px;">';
echo '<div id="wiki-page-content" style="width: 100%">' 
		. ($model->wiki_page_revision_id >0 ? $model->wiki_page_revision_content : $latest->wiki_page_content)
		. '<hr/>';
//echo CHtml::link('Differences', '#', array('onclick' => 'js: $("#revision-diff-details").toggle(); return false;')) 
//		.  '<div id="revision-diff-details" style="display: none;">' . $diff_with_bf . '</div>';
echo '</div><br/>';
echo '</div>';

// SIDE BAR
echo '<div class="span-5 last rounded-container" style="float: right; width: 220px; max-height: 400px; overflow: auto;">';
$this->renderPartial('index_revisions', array('revisions' => $revisions, 'latest' => $latest, 'selected' => $model));
echo '</div>';

echo '</div>';
?>
