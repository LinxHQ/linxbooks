<?php
/* @var $this ResourceUserListController */
/* @var $model ResourceUserList */

?>

<h4>Update List <?php echo $model->resource_user_list_name; ?></h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>