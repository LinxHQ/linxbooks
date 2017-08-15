<?php
/* @var $this AccountController */
/* @var $model Account */
/* @var $profile AccountProfile */

/**
$this->breadcrumbs=array(
	'Accounts'=>array('index'),
	$model->account_id,
);**/
$checkUser = false;
// Neu cung user hoac user dang login la admin thi cho phep update
if(YII::app()->user->id == $model->account_id || Yii::app()->user->id == Yii::app()->params['adminID'])
    $checkUser=true;

$onwSubcriptAccount = AccountSubscription::model()->getSubscriptionOwnerID(LBApplication::getCurrentlySelectedSubscription());
$onwSubcrip = false;
if($onwSubcriptAccount==Yii::app()->user->id)
    $onwSubcrip=true;
$this->menu=array(
	//array('label'=>'List Account', 'url'=>array('index')),
	//array('label'=>'Create Account', 'url'=>array('create')),
	array('label'=>'Invite Team Member', 'url'=>array('/accountInvitation/create')),
	array('label'=>'List Invitations', 'url'=>array('/accountInvitation/admin')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->account_id)),
	array('label'=>'Delete Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->account_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
	array('label'=>'Manage Team Members', 'url'=>array('admin')),
);
?>

<h3>Account Information <?php //echo $model->account_id; ?></h3>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'account_id',
		'account_email',
		//'account_password',
		//'account_master_account_id',
		'account_created_date',
		'account_timezone',
		'account_language',
		//'account_status',
	),
)); 

//if (Permission::checkPermission($model, PERMISSION_ACCOUNT_UPDATE))
//{
    if($checkUser && Yii::app()->params['isDemoApp'] != true) // don't allow update password if in demo mode or if not passed $checkUser param
    {
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Change Password',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url' => array('account/updatePassword', 'id' => $model->account_id),
	));
	
	echo '&nbsp;';
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Account',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('account/update', 'id' => $model->account_id)
	));
        echo '<br /><br />';
        // form connected account to social
        $config_social = LbConfigLoginSocial::model()->findAll();
        if($config_social[0]['action'] == 1){
            echo Yii::t('lang','Choose a social network below to connect your account with');
            if (Yii::app()->user->hasFlash('error')) {
    //          echo '<div class="error">'.Yii::app()->user->getFlash('error').'</div>';
            } else if(Yii::app()->user->hasFlash('sucs')){
                    echo '<div style="background-color: #99FF33; padding: 5px; border-radius: 5px; width: 33%;" class="success">'.Yii::app()->user->getFlash('sucs').'</div>';
            }
            echo "<div id='login_social' style='margin-left: -299px;'>";
            echo '<br />';
            $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/assignaccountsocial'));

            echo "</div>";
        }
        $account=Account::model()->findByPk($model->account_id);
        // status account social login
        if($account->account_check_email_social_google == "" && $account->account_check_social_login_id_google == "") {
        	echo Yii::t('lang','Your account is not connected to Google login')."<br />";
        } else {
        	echo Yii::t('lang','Your account is connected to Google login')."<br />";
        }

        if($account->account_check_email_social_facebook == "" && $account->account_check_social_login_id_facebook == "") {
        	echo Yii::t('lang','Your account is not connected to Facebook login');
        } else {
        	echo Yii::t('lang','Your account is connected to Facebook login');
        }
        echo "<br />";
        // end status account social login
        // end form connected account to social

		if(Yii::app()->user->hasFlash('sucs_disconnect')){
                echo '<div style="background-color: #99FF33; padding: 5px; border-radius: 5px; width: 33%;" class="success">'.Yii::app()->user->getFlash('sucs_disconnect').'</div>';
        }
        echo "<br />";
        // disconnect account to social
        $this->widget('bootstrap.widgets.TbButton', array(
			'label'=> Yii::t('lang','Disconnect from Google'),
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url' => array('site/disconnectaccountsocial', 'id' => $model->account_id, 'server' => 'google'),
		));
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$this->widget('bootstrap.widgets.TbButton', array(
			'label'=> Yii::t('lang','Disconnect from Facebook'),
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url' => array('site/disconnectaccountsocial', 'id' => $model->account_id, 'server' => 'facebook'),
		));
        // end disconnect account to social
    }
//}
?>

<h3>Profile Information</h3>
<?php 
echo $profile->getProfilePhoto(0, true); // printbig size

$this->widget('bootstrap.widgets.TbDetailView', array(
		'data'=>$profile,
		'attributes'=>array(
				//'account_id',
				'account_profile_surname',
				'account_profile_given_name',
				'account_profile_preferred_display_name',
				'account_profile_company_name',
		),
));

//if (Permission::checkPermission($profile, PERMISSION_ACCOUNT_PROFILE_UPDATE))
//{
    if($checkUser && Yii::app()->params['isDemoApp'] != true)
    {
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Profile',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('accountProfile/update', 'id' => $profile->account_profile_id),
	));
	echo '&nbsp;';
	$this->widget('bootstrap.widgets.TbButton', array(
			'label'=>'Update Photo',
			'type'=>'', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small', // null, 'large', 'small' or 'mini'
			'url'=>array('accountProfile/updatePhoto', 'id' => $profile->account_profile_id),
	));
    }
//}
        
?>
<?php if($onwSubcrip) {?>
<div id="permission-account" style="margin-top: 40px;">
    <h4>Company: <?php echo AccountSubscription::model()->getSubscriptionName(Yii::app()->user->linx_app_selected_subscription); ?></h4>
    <?php $this->renderPartial('permission.views.account.index',array('model'=>$model)); ?>
    
</div>
<?php } ?>
