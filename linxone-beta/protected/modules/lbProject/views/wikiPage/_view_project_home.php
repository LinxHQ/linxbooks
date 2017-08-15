<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $subpages array of models WikiPage */
/* @var $attachments array of attached documents */

Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );

$creator_profile = AccountProfile::model()->find('account_id = ?', array($model->wiki_page_creator_id));
$last_updater = AccountProfile::model()->find('account_id = ?', array($model->wiki_page_updated_by));

?>
<div id='linxcircle-project-wiki-home-container' style='float: left; width: 100%;'>
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
            echo '&nbsp;';
            
            $this->widget('bootstrap.widgets.TbButtonGroup', array(
                'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'small',
                'buttons'=>array(
                    array('label'=>'New', 'items'=>array(
                        array('label'=>'New Page', 
                            'url'=>array('create', 'project_id' => $model->project_id)),
                        array('label'=>'New Template', 
                            'url'=>array('create', 'project_id' => $model->project_id,'is_template' => YES)),
                        /**array('label'=>'New Category', 
                            'url'=>array('create', 'project_id' => $model->project_id, 'is_category' => YES)),**/
                    )),
                ),
            ));
            ?>
        </div>
    </div>
    <div class="wiki-editing-info" style="font-size: 9pt;">
        Last updated by <?php echo $last_updater->account_profile_preferred_display_name; ?> on <?php echo $model->wiki_page_date; ?>
    </div>
<?php

    echo "<hr/>";

    // MAIN CONTENT
    echo '<div style="display: table">';

    echo '<div class="" style="float: left; width: 100%;">';

    // generate table of content
    // and reformat content to include anchors with existing headers
    $formated_cotnent = Utilities::createTOC($model->wiki_page_content);
    echo '<div id="wiki-page-content">'
        //. $formated_cotnent['toc']
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
            /**
            $doc_delete_ajax_link = CHtml::ajaxLink(
            '<i class="icon-remove"></i>',
            array('document/ajaxDelete', 'id' => $doc->document_id), // Yii URL
            array('success' => 'function(data){
            if (data == "success") {
            $("#container-document-' . $doc->document_id . '").remove(); // remove doc div container
            }
            }'),
            array('id' => 'ajax-id-'.uniqid())
            );**/

            echo '<div id="container-document-' . $doc->document_id . '">';
            echo CHtml::link($doc->document_real_name,
                Yii::app()->createUrl("document/download", array('id' => $doc->document_id)));
            echo '<div class="blur-summary" style="display: inline"> - ' . Utilities::formatDisplayDate($doc->document_date) . '</div>';
            //echo '&nbsp;' . $doc_delete_ajax_link;
            echo '</div>';
            //echo '<br/>';
        }
    }
    echo '</div>'; // end div for span-19
    echo '</div>'; // end div for MAIN CONTENT

    echo '<hr/>';

    echo '<div style="clear: both"/>';

    if (count($subpages) > 0)
    {
        echo '<h5>Sub Pages</h5>';
        echo '<ul class="nav nav-tabs nav-stacked">';

        foreach($subpages as $page)
        {
            $ajax_link = Utilities::workspaceLink(
                $page->wiki_page_title,
                array('wikiPage/view', 'id' => $page->wiki_page_id) );
            /*
            $ajax_link = CHtml::ajaxLink(
                $page->wiki_page_title,
                array('wikiPage/view', 'id' => $page->wiki_page_id), // Yii URL
                array('update' => '#wiki-content'), // jQuery selector
                array('id' => 'ajax-id-'.uniqid())
            );*/
            echo "<li>$ajax_link</li>\n";
        }

        echo '</ul>';

        echo Utilities::workspaceLink("Re-order Sub Pages", array("wikiPage/reorderSubPages", "id" => $model->wiki_page_id));
    }
    
    /**
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>WikiPage::model()->getProjectWikiPages($model->project_id),
        'itemView'=>'_wiki_book_list_item',   // refers to the partial view named '_post'
        'template'=>'{pager}{items}{pager}',
    ));**/
?>
</div> <!--end linxcircle-project-wiki-home-container -->
<!--div style="float: right; width: 220px; overflow: hidden" class="span-5 last">
    <?php    
        // get all project pages
    /**
        $this->widget('bootstrap.widgets.TbGridView', array(
                'id'=>'project-wiki-pages-side-grid-'.$model->project_id,
                'template'=>'{items}{pager}',
                'dataProvider'=>WikiPage::model()->getProjectWikiPages($model->project_id),
                'columns'=>array(
                    array(
                        'header'=>'Other Pages', 
                        'type'=>'raw',
                        'value' =>'Utilities::workspaceLink($data->wiki_page_title, $data->getWikiPageURL())',
                    )
                ),
        ));
     * 
     * 
     */
    ?>
</div-->