<?php
/* @var $this WikiPageController */
/* @var $data WikiPage */
?>

<div class="view">

	<?php 
	/**
	echo CHtml::ajaxLink(CHtml::encode($data->wiki_page_title), 
			array('view', 'id' => $data->wiki_page_id),
			array('update' => '#wiki-content'),
			array('id' => 'ajax-id-'.uniqid(), 'live' => true)); 
	**/
	echo CHtml::link(
			'<h5>' . CHtml::encode($data->wiki_page_title) . '</h5>',
			'#',
			array('onClick'=>' {'. CHtml::ajax(
					array(
							'url' => array('wikiPage/view', 'id' => $data->wiki_page_id),
							'update' => '#wiki-content',
							//'data' => array('id' => $data->wiki_page_id),
							'type' => 'get'),
					array('live'=>false, 'id'=>'ajax-id-' . uniqid())
	
			) . ' return false; }') 
	);
	?>
	
	<?php //echo $data->wiki_page_summary ?>...
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('wiki_page_tags')); ?>:</b>
	<?php echo CHtml::encode($data->wiki_page_tags); ?>
	<br />
</div>