<?php
/* @var $this AccountTeamMemberController */
/* @var $model AccountTeamMember */

?>

<h3>Update Team Member <?php echo AccountProfile::model()->getShortFullName($model->member_account_id); ?></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>