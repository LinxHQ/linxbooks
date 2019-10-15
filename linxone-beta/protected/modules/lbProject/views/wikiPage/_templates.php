<?php
/* @var $this WikiPageController */
/* @var $templates array of WikiPage */

echo '<div style="height: 400px; overflow: true;">';
foreach ($templates as $temp)
{
	echo '<strong>' . $temp->wiki_page_title . '</strong>';
	echo '<div class="well">';
	echo  $temp->wiki_page_content;
	echo '</div>';
	echo CHtml::link('Insert Template', '#',
			array(
					'data-dismiss'=>'modal',
					"onclick"=>'js: templateInsertHTML(\'' . 
						addslashes(str_replace(array("\r","\n"), '', $temp->wiki_page_content)) . ' \'); return false;'));
	echo '<hr/>';
}

echo '</div>';