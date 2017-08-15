<?php
/* @var $model TaskComment model */

echo '<b>' . AccountProfile::model()->getShortFullName($model->task_comment_owner_id);
echo ' commented on ' . $model->task_comment_last_update .':</b><br/>';
echo Utilities::getSummary($model->task_comment_content, true, 300);