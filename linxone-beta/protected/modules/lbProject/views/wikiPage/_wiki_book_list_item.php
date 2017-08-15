<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<div style="" class="linxcircle-wiki-book">';

echo '<h5>' . Utilities::workspaceLink($data->wiki_page_title, $data->getWikiPageURL());
echo '</h5>';

echo '<div class="book-excerpt"><span class="blur-summary">';
echo Utilities::getSummary($data->wiki_page_content, true, 500) . '...';
//echo $data->wiki_page_content;
echo '</span></div>';

echo '</div>';
