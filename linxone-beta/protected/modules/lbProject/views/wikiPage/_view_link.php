<?php
/* @var $this WikiPageController */
/* @var $data Resource */
?>

<div>
	<?php 
	// title
	echo '<h5><i class="icon-globe"></i> ' . CHtml::link(
			 CHtml::encode($data->resource_title ? $data->resource_title : $data->resource_url),
			$data->getGoURL(),
			array('target'=>'_new')); 
	
	// creator
	echo ' <span style="color: #777777;font-size:12px;font-weight: normal">(added by ' . 
		AccountProfile::model()->getShortFullName($data->resource_created_by);
	echo ')</span>';
	
	// url print
	echo '<br/><span class="blur-summary">&nbsp;&nbsp;&nbsp;&nbsp;'.
	 	"<a href='http://{$data->resource_url}' style='color: #777777;font-size:12px;font-weight: normal' 
			target='_new'>{$data->resource_url}</a>" .
		'</span>';
	echo '</h5>';
	
	if ($data->resource_description)
	{
		echo '<span class="blur-summary">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;'. $data->resource_description; 
		echo '</span>';
	}
	?>
	<div style="float: right">
	<?php 
	/**
	echo '<i class="icon-pencil"></i> ';
	echo CHtml::link('Edit', array('resource/update', 
		'id'=>$data->resource_id,
		'project_id'=>$data->project_id),
		array('style'=>'color: #777777; font-size: 9pt;'));
		**/
	?>
	</div>
</div>