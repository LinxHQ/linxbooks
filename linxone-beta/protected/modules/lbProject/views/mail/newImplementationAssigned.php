<?php
/* @var $model ImplementationAssignee */
/* @var $implementation Implementation */
/* @var $project Project */

?>
<p>Hello</p>
<p>You've been assigned to a new Implementation on <?php echo Yii::app()->name; ?>. Details are below:</p>

<p>Project: <?php echo $project->project_name;?><br/>
Implementation: <?php echo $implementation->implementation_title; ?><br/>
Implementation Date: <?php echo $implementation->implementation_start_date;?><br/>
Implementation Time: <?php echo $implementation->implementation_start_time;?><br/>
</p>

<p>Description:<br/><?php echo $implementation->implementation_description; ?></p>

<p><a href="<?php echo Yii::app()->getBaseUrl(true) . CHtml::normalizeUrl($implementation->getImplementationURL()); ?>">See this implementation on LinxCircle.</a></p>

<p><?php echo Yii::app()->params['emailSignature'] ?></p>

<p>
Please DO NOT reply to this email.<br/>
LinxCircle.com (c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd.
</p>