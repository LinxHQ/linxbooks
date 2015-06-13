<?php
/**
 * @var $model account
 */
?>
<div id="permission-account">
    <?php
        $this->widget('bootstrap.widgets.TbTabs', array(
            'type'=>'tabs',
            'encodeLabel'=>false,
            'placement'=>'above', // 'above', 'right', 'below' or 'left'
            'tabs'=>array(
                array(
                    'label'=>'<b>Permission</b>',
                    'content'=>$this->renderPartial('permission.views.account.form_permission',array('account_id'=>$model->account_id),true),
                    'active'=>true,
                ),
                array(
                    'label'=>'<b>Role</b>',
                    'content'=>$this->renderPartial('permission.views.account.form_role',array('account_id'=>$model->account_id),true), 
                ),
            ),
        ));
    ?>
</div>

