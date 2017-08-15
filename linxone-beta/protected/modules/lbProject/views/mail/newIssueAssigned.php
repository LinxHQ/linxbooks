<?php
/* @var $model IssueAssignee */
/* @var $issue Issue */
/* @var $project Project */

?>
<p>Hello</p>
<p>You've been assigned to a new Issue on <?php echo Yii::app()->name; ?>. Details are below:</p>

<p>Project: <?php echo $project->project_name;?><br/>
Issue: <?php echo $issue->issue_name; ?><br/>
Reported by: <?php echo AccountProfile::model()->getFullName($issue->issue_reported_by); ?><br/>
</p>

<p>Description:<br/><?php echo $issue->issue_description; ?></p>

<p><a href="<?php echo Yii::app()->getBaseUrl(true) . CHtml::normalizeUrl($issue->getIssueURL()); ?>">See this issue on LinxCircle.</a></p>

<p><?php echo Yii::app()->params['emailSignature'] ?></p>

<p>
Please DO NOT reply to this email.<br/>
LinxCircle.com (c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd.
</p>