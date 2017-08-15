<?php
/* @var $this DefaultController */
/* @var $task_id */
/* @var $account_id */
?>
<?php require_once (YII::app()->modulePath.'/task_progress/css/style.php'); ?>
<?php require_once (YII::app()->modulePath.'/task_progress/js/jquery.sglide.2.1.2.min.js.php'); ?>
<?php 

$this->renderPartial('task_progress.views.default.popup_task_progress',array('task_id'=>$task_id,''));

$this->renderPartial('task_progress.views.default.task_progress',array('task_id'=>$task_id,''));
?>


