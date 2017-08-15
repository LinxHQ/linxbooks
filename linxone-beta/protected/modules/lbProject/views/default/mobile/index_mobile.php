<?php
/* @var active_project CActiveDataProvider */
/* @var archived_projects array */
?>
<div class="ui-grid-a">
    <div class="ui-block-a">
	    <?php echo CHtml::link('New Project', 
	    		Project::model()->getCreateURL(), 
	    		array('data-role'=>'button', 'data-icon'=>'plus', 'data-mini'=>'true'));?>
    </div>
    <div class="ui-block-b">
    	<?php echo CHtml::link('Invite', 
	    		array('accountInvitation/create'), 
	    		array('data-role'=>'button', 'data-icon'=>'star', 'data-mini'=>'true'));?>
    </div>
</div><!-- /grid-a -->
<br/>
<ul data-role="listview" data-filter="true" 
	data-filter-placeholder="Search projects..." data-inset="true">
	<?php 
	$dataProvider->setPagination(false);
	$active_projects = $dataProvider->getData();
	if (count($active_projects))
	{
		foreach ($active_projects as $project)
		{
			//print_r($project);echo $project['project_id'] .'<br/>';
			echo "<li>";
			echo CHtml::link($project['project_name'], Project::model()->getProjectURL($project['project_id']));
			echo "</li>";
		}
	}
	
	?>
</ul>