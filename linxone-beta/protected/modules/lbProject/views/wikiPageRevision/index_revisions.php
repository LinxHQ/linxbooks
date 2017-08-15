<?php
/* @var $revisions Array of WikiPageRevision models */
/* @var $latest WikiPage ie latest revision */
/* @var $selected currently selected revision */

echo '<div style="display: table; width: 100%"><h5 style="float: left">Revision History</h5>
		<div style="float: right; margin: 10px 0;">'.
		 Utilities::workspaceLink(
				"Close",
		 		$latest->getWikiPageURL())
		.'</div>
		</div>';

echo Utilities::workspaceLink(
		"<b>Latest {$latest->wiki_page_date}</b>",
		array(
				"wikiPageRevision/view",
				"id" => "0",
				"page" => $latest->wiki_page_id));
echo '<br/>';
$accountProfile = AccountProfile::model()->getProfile($latest->wiki_page_creator_id);
echo "by " . $accountProfile->getShortFullName();
echo '<br/>';

if (isset($revisions)) 
{
	foreach ($revisions as $rev)
	{
		echo '<div style="width: 100%; background: '
				. ($rev->wiki_page_revision_id == $selected->wiki_page_revision_id ? '#EEEEEE' : 'none' ) .'">';
		echo Utilities::workspaceLink(
				"<b>{$rev->wiki_page_revision_date}</b>",
				array(
						"wikiPageRevision/view", 
						"id" => $rev->wiki_page_revision_id, 
						"page" => $rev->wiki_page_id));
		echo '<br/>';
		
		$accountProfile = AccountProfile::model()->getProfile($rev->wiki_page_revision_updated_by);
		echo "by " . $accountProfile->getShortFullName();
		echo '</div>';
		
		echo '<br/>';
	}
}