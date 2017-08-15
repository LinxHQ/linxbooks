<?php
/* @var $this WikiPageController */
/* @var $model WikiPage */
/* @var $parent WikiPage Parent */
?>

	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-i18n.min.js" type="text/javascript"></script>
<?php 
echo Utilities::workspaceLink('Back to ' 
		. $parent->wiki_page_title, 
		array('wikiPage/view', 'id' => $parent->wiki_page_id));

echo '<h3>Re-order Pages</h3>';

$this->widget('ext.sortable.SortableGridView', array(
		'dataProvider' => $model->search(),
		'columns'=>array(
				'wiki_page_id',
				'wiki_page_title'
		)
));