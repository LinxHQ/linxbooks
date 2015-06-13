<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property integer $account_id
 * @property string $account_email
 * @property string $account_password
 * @property string $account_created_date
 * @property string $account_timezone
 * @property string $account_language
 * @property integer $account_status
 */
define('ACCOUNT_STATUS_ACTIVATED', 1);
define('ACCOUNT_STATUS_NOT_ACTIVATED', 0);
define('ACCOUNT_STATUS_DEACTIVIATED', -1);
define('ACCOUNT_ERROR_WRONG_CURRENT_PASSWORD', -1);
define('ACCOUNT_ERROR_PASSWORD_RETYPE_NOT_MATCHED', -2);
define('ACCOUNT_ERROR_PASSWORD_NOT_SAFE', -3);

class Account extends CActiveRecord
{
	public $account_current_password;
	public $account_new_password;
	public $account_new_password_retype;
    public $account_profile_id;
	
	/**
	 * params that don't belong to accounts table:
	 */
	/**
	public $account_company_name;
	public $account_contact_surname;
	public $account_contact_given_name;
	public $account_subscription_package_id;
	**/
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lb_sys_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_email', 'unique', 'message' => 'This email is already used by an existing Account. Please login to subscribe if you were invited by someone previously.'),
			array('account_email, account_password, account_status', 'required'),
			array('account_status', 'numerical', 'integerOnly'=>true),
			array('account_email, account_password, account_timezone, account_language', 'length', 'max'=>255),
			array('account_current_password, account_new_password, account_new_password_retype, account_profile_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_id, account_email, account_password, account_created_date, account_timezone, account_language, account_status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'account_member' => array(self::HAS_MANY, 'AccountTeamMember', 'account_id'),
			'account_profile' => array(self::HAS_ONE, 'AccountProfile', 'account_id'),
			//'account_project_member' => array(self::HAS_MANY, 'ProjectMember', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_id' => 'Account',
			'account_email' => 'Email',
			'account_password' => 'Password',
			//'account_master_account_id' => 'Account Master Account',
			'account_created_date' => 'Account Created Date',
			'account_timezone' => 'Timezone',
			'account_language' => 'Language',
			'account_status' => 'Account Status',
			'account_company' => 'Company',
			'account_contact_surname' => 'Surname',
			'account_contact_given_name' => 'Given Name',
			'account_current_password' => 'Current Password',
			'account_new_password' => 'New Password',
			'account_new_password_retype' => 'Retype New Password',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_email',$this->account_email,true);
		$criteria->compare('account_password',$this->account_password,true);
		//$criteria->compare('account_master_account_id',$this->account_master_account_id);
		$criteria->compare('account_created_date',$this->account_created_date,true);
		$criteria->compare('account_timezone',$this->account_timezone,true);
		$criteria->compare('account_language',$this->account_language,true);
		$criteria->compare('account_status',$this->account_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * This method update password based on user's input
	 * from change password form.
	 */
	public function updatePassword()
	{
		// first, check if the entered current password is correct
		if ($this->validateCurrentPassword())
		{
			// check if new password and its retype matched
			// and if it's strong 
			if ($this->account_new_password == $this->account_new_password_retype)
			{
				if ($this->evalPasswordStrength($this->account_new_password) === true)
				{
					$this->account_password = $this->account_new_password;
					$this->save();
					return true;
				}
				else
					return ACCOUNT_ERROR_PASSWORD_NOT_SAFE;
			} else {
				$this->addError('account_new_password_retype', 'Retyped password is not matched.');
				return ACCOUNT_ERROR_PASSWORD_RETYPE_NOT_MATCHED;
			}
		} else {			
			$this->addError('account_password', 'Wrong password enter for field Current Password.');
			return ACCOUNT_ERROR_WRONG_CURRENT_PASSWORD;
		}
	}
	
	/**
	 * check if a password is strong enough
	 * 
	 * @param unknown $password
	 * @return boolean
	 */
	public function evalPasswordStrength($password)
	{
		// TODO
		if (strlen($password) < 8 || preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/',$password) <= 0)
		{
			$this->addError('account_new_password_retype', 'Password is not safe. Your password should have at least 8 characters, and include digits, letters, and special characters (such as &, *, $, [, ], etc.'); 
			return ACCOUNT_ERROR_PASSWORD_NOT_SAFE;
		}
		
		return true;
	}
	
	/**
	 * 
	 * @param unknown $password
	 * @return boolean
	 */
	public function passwordIsSafe($password)
	{
		if (strlen($password) < 8 || preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/',$password) <= 0)
			return false;
		
		return true;
	}
	
	/**
	 * Validate if password typed in by user is correct
	 * This is just a wrapper for validatePassword
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public function validateCurrentPassword($password = '')
	{
		if ($password == '')
			$password = $this->account_current_password;
		
		return $this->validatePassword($this->account_current_password);
	}
	
	public function sendSuccessfulSignupEmailNotification() {
		$message = new YiiMailMessage();
		$activation_key = $this->getActivationKey();
		$activation_url = $this->getActivationURL($activation_key);
			
		/**
		$body = '<p>Hello.</p>';
		$body .= "<p>Welcome to " . Yii::app()->name . "</p>";
		$body .= '<p>Your registration is successful. In order to start enjoying our amazing stuff, please activate your account by clicking the link below: </p>';
		$body .= '<p><a href="' . $activation_url . '">Activate my account now.</a></p>';
		//$body .= '<p>DEBUG: ' . $account->account_email . $account->account_created_date . '</p>';
		$body .= "<p>" . Yii::app()->params['emailSignature'] . "</p>";
		**/
		
		$message->view = "successfulSignupEmail";
		//userModel is passed to the view
		$message->setBody(array('activation_url' => $activation_url), 'text/html');
		
		$message->setSubject('Account Activation');
		//$message->setBody($body, 'text/html');
		$message->addTo($this->account_email);
		//$message->from = Yii::app()->params['adminEmail'];
		$message->setFrom(array(Yii::app()->params['adminEmail'] => "LinxCircle Admin"));
		Yii::app()->mail->send($message);
	}
	
	/**
	 * Override the save() method to handle signup process: Create user account, subscription, company, contact
	 * 
	 */
	public function save($runValidation=true, $attributes=NULL) {
		// create user account, check password
		if ($this->isNewRecord) {
			// eval password strength
			if (!$this->evalPasswordStrength($this->account_password))
			{
				return false;
			}
			
			$this->account_password = $this->hashPassword($this->account_password);
		}
		// only for new account
		if ($this->account_id == null) {
			$this->account_created_date = date('Y-m-d H:i');
		} else {
			// updating account. check permission
			if (Yii::app()->user->id != $this->account_id
					&& Yii::app()->user->id != 1) {
				$this->addError('account_email', 'This account doesn\'t have permission to perform this feature.');
				return false;
			}
		}
		
		if ($this->validateEmail() === false)
		{
			$this->addError('account_email', 'This email is invalid.');
			return false;
		}
		
		return parent::save($runValidation, $attributes);
	}
	
	/**
	 * This reset is NOT by updating password feature.
	 * This reset is used under Forgot Password feature
	 * 
	 * @param unknown $password
	 */
	public function resetPassword($password)
	{
		if ($this->passwordIsSafe($password))
		{
			$this->account_password = $this->hashPassword($password);
			return parent::save();
		}
		
		return false;
	}
	
	/**
	public function save() {
		// create/update user account
		if ($this->account_password) { // only if set
			$this->account_password = $this->hashPassword($this->account_password);
		}
		//$account->account_master_account_id = 0; // signup account is always master account by itself.
		
		// only for new account
		if ($this->account_id == null) {
			$this->account_created_date = date('Y-m-d H:i');
		}
		
		// only if set
		if ($this->account_status) {
			$this->account_status = ACCOUNT_STATUS_NOT_ACTIVATED;
		}
		
		$save_result = '';
		// save user account record to database
		$save_result = $this->parent->save();
	
		if ($save_result) {
			// create/update subscription record
			$accountSubscriptionModel = new AccountSubscription();
			$accountSubscriptionModel->account_subscription_package_id = $this->account_subscription_package_id;
			$accountSubscriptionModel->account_id = $this->account_id;
			$accountSubscriptionModel->account_subscription_start_date = date('Y-m-d H:i');
			$accountSubscriptionModel->account_subscription_status_id = 1;
			$accountSubscriptionModel->save();
				
			// create company record
			$companyModel = new Company();
			$companyModel->company_name = $this->account_company_name;
			$companyModel->company_master_account_id = $this->account_id;
				
			// save company record to database,
			// if successful, create contact record
			if ($companyModel->save()) {
					
				// create contact record
				$companyContactModel = new CompanyContact();
				$companyContactModel->contact_surname = $this->account_contact_surname;
				$companyContactModel->contact_given_name = $this->account_contact_given_name;
				$companyContactModel->contact_email1 = $this->account_email;
				$companyContactModel->company_id = $companyModel->company_id;
				$companyContactModel->account_id = $this->account_id;
				// save contact record to database
				$companyContactModel->save();
			}
				
			// notify user through email
			$message = new YiiMailMessage();
			$activation_key = $this->getActivationKey();
			$activation_url = $this->getActivationURL($activation_key);
				
			$body = '<p>Hello.</p>';
			$body .= "<p>Welcome to " . Yii::app()->name . "</p>";
			$body .= '<p>Your registration is successful. In order to start enjoying our amazing stuff, please activate your account by clicking the link below: </p>';
			$body .= '<p><a href="' . $activation_url . '">Activate my account now.</a></p>';
			//$body .= '<p>DEBUG: ' . $account->account_email . $account->account_created_date . '</p>';
			$body .= "<p>" . Yii::app()->params['emailSignature'] . "</p>";
				
			$message->setSubject('Account Activation');
			$message->setBody($body, 'text/html');
			$message->addTo($this->account_email);
			$message->from = Yii::app()->params['adminEmail'];
			Yii::app()->mail->send($message);
		}
	
		return $save_result;
	} // end signup
	**/
	
	/**
	 * Check if given password is correct, against user's password
	 * 
	 * @param unknown $password
	 * @return boolean
	 */
	public function validatePassword($password)
	{
		return crypt($password, $this->account_password) === $this->account_password;
	}
	
	public function hashPassword($password)
	{
		return crypt($password, $this->generateSalt());
	}
	
	/**
	 * Generate a random salt in the crypt(3) standard Blowfish format.
	 *
	 * @param int $cost Cost parameter from 4 to 31.
	 *
	 * @throws Exception on invalid cost parameter.
	 * @return string A Blowfish hash salt for use in PHP's crypt()
	 */
	public function generateSalt($cost = 13)
	{
		if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
			throw new Exception("cost parameter must be between 4 and 31");
		}
		
		$rand = array();
		for ($i = 0; $i < 8; $i += 1) {
			$rand[] = pack('S', mt_rand(0, 0xffff));
		}
		
		$rand[] = substr(microtime(), 2, 6);
		$rand = sha1(implode('', $rand), true);
		$salt = '$2a$' . str_pad((int) $cost, 2, '0', STR_PAD_RIGHT) . '$';
		$salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
		
		return $salt;
	}
	
	/**
	 * Get account record associated to this email address
	 * 
	 * @param unknown $email
	 * @return CActiveRecord or NULL
	 */
	public function getAccountByEmail($email)
	{
		$account = Account::model()->find('account_email = :account_email', 
				array(':account_email' => $email));
		
		if ($account != null && $account->account_id > 0)
			return $account;
		
		return null;
	}
	
	/**
	 * This key is used during account registration process
	 * @return string
	 */
	public function getActivationKey() {
		$string = trim($this->account_email) . trim(date('Y-m-d H:i', strtotime($this->account_created_date)));
		
		return md5($string);
	}
	
	/**
	 * Get URL for activation. This URL is used in welcome email.
	 * @return string
	 */
	public function getActivationURL($activation_key) {
		$url = Yii::app()->createAbsoluteUrl('account/activate', 
				array('id' => $this->account_id,'key' => $activation_key));
		return $url;
	}
	
	/**
	 * Perform account activation
	 * @param string $activation_key
	 * @return boolean
	 */
	public function activateAccount($activation_key) {
		if (trim($activation_key) == trim($this->getActivationKey())) {
			// update account status
			$this->account_status = 1;//ACCOUNT_STATUS_ACTIVATED;
			$this->save();
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * check if an account is already activated
	 * @return boolean
	 */
	public function isActivated() {
		return ($this->account_status == ACCOUNT_STATUS_ACTIVATED);
	}
	
	/**
	 * Check if current user account is a master account of this subscription
	 */
	public function isMasterAccount($subscription_id, $account_id = 0)
	{
		if ($account_id == 0) $account_id = Yii::app()->user->id;
		
		$subscription = AccountSubscription::model()->find('account_subscription_id = :account_subscription_id AND
				account_id = :account_id', 
				array(
						':account_subscription_id' => $subscription_id,
						':account_id' => $account_id
						));
		
		if ($subscription && $subscription->account_subscription_id > 0)
			return true;
		
		/**$subscriptions = AccountSubscription::model()->findSubscriptions($account_id, true);
		foreach ($subscriptions as $subsc) 
		{
			if ($subsc->account_subscription_id == $subscription_id 
					&& $subsc->account_id == $account_id)
				return true;
		}**/
		
		return false;
	}
	
	public function isAdmin()
	{
		if (Yii::app()->user->id == 1)
			return true;
	}
	
	public function validateEmail()
	{
		if (LBApplication::isValidEmail($this->account_email) !== false)
		{
			// find if this email is used by other account already or not
			$account = Account::model()->find('account_id != :account_id AND account_email = :account_email', array(
					':account_id' => $this->account_id, ':account_email' => $this->account_email
					));
			
			if ($account != null && $account->account_id > 0)
			{
				$this->addError('account_email', 'This email is already used.');
			} else {
				return true;
			}
		} else {
			$this->addError('account_email', 'This email is not a valid email: ' . $this->account_email);
		}
		
		return false;
	}
	
	////////////////////////////// API /////////////////////////////
	
	/**
	 * Specify whether this model allows Service API for action List
	 * @return boolean
	 */
	public static function apiAllowsList() {
		return true;
	}
	
	public static function apiAllowsView() {
		return true;
	}
	
	public static function apiAllowsCreate() {
		return true;
	}
	
	/**
	 * the List API
	 */
	public static function apiList() {
		$conditions_array = array();
		$condition = '';
		$params_array = array();
		
		if (isset($_GET['account_status'])) {
			$condition = 'account_status =:account_status';
			$params_array[':account_status'] = $_GET['account_status'];
		}
		
		return self::model()->findAll($condition, $params_array);
	}
	
	/**
	 * the email notification api, only called by ApiController
	 * available commands: create, update, delete
	 * 
	 * @param string $command
	 */
	public function apiEmailNotification($command = '') {
		
		if ($command == 'create') {
			$this->sendSuccessfulSignupEmailNotification();
		} else if ($command == 'update') {
			
		} else if ($command == 'delete') {
			
		}
	}
	
	//////////////////////// END OF API //////////////////////////////
}