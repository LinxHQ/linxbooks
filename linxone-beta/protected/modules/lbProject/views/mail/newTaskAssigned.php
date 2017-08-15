<?php
/* @var $model TaskAssignee */
/* @var $task Task */
/* @var $project Project */

?>
<p><?php echo Yii::t('mail','Hello'); ?></p>
<p><?php echo Yii::t('mail',"You've been assigned to a new Task on") . " " . Yii::app()->name . ".";
    echo Yii::t('mail','Details are below') . ":";?></p>

<p><?php echo Yii::t('mail','Project') . ": " . $project->project_name;?><br/>
<?php echo Yii::t('mail','Task') . ": " . $task->task_name; ?><br/>
Type: <?php echo $task->getTaskTypeLabel(); ?><br/>
<?php echo Yii::t('mail','By') . ": " . AccountProfile::model()->getShortFullName($task->task_owner_id, true); ?>
</p>

<p><?php echo Yii::t('mail','Description');?>:<br/><?php echo $task->task_description; ?></p>

<p><a href="<?php echo Yii::app()->getBaseUrl(true) . CHtml::normalizeUrl($task->getTaskURL()); ?>">
        <?php echo Yii::t('mail','See this task on LinxCircle');?>.</a>
</p>

<p><?php echo Yii::app()->params['emailSignature'] ?></p>

<p>
Please DO NOT reply to this email.<br/>
LinxCircle.com (c) <?php echo date('Y'); ?>, LinxHQ Pte Ltd.
</p>