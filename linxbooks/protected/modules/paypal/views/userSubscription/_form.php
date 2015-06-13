<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-subscription-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'user_id'); ?>
                <?php echo $form->dropDownList($model, 'user_id',
                    CHtml::listData(AccountProfile::model()->findAll(), 'account_id', function($loc){ return $loc->account_profile_given_name . ", " . $loc->account_profile_surname; }), array('empty' => '--Select--')); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'subscription_id'); ?>
                <?php echo $form->dropDownList($model, 'subscription_id',
                    CHtml::listData(Subscription::model()->findAll(), 'subscription_id','subscription_name'), array('empty' => '--Select--')); ?>
		<?php echo $form->error($model,'subscription_id'); ?>
	</div>

	<div class="control-group ">
		<?php echo $form->labelEx($model,'date_from'); ?>
                <?php
                    $this->widget('ext.rezvan.RDatePicker',array(
                        'name'=>'UserSubscription[date_from]',
                        'value'=>($model->date_from) ? $model->date_from : date('Y-m-d'),
                        'options' => array(
                            'format' => 'yyyy-mm-dd',
                            'viewformat' => 'yyyy-mm-dd',
                            'placement' => 'right',
                            'todayBtn'=>true,
                        )
                    ));
                ?>
		<?php echo $form->error($model,'date_from'); ?>
	</div>

	<div class="control-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->