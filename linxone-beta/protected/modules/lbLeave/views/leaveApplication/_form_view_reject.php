<label for="">ID : <?php echo $model->leave_id; ?></label>

<label><?php echo Yii::t('lang','Employee :') ?>
<?php echo AccountProfile::model() -> getFullName($model->account_id); ?>
</label>
<label><?php echo Yii::t('lang','Reason') ?> * :</label>
<textarea id="confirm-reject" cols="40" rows="5"></textarea>