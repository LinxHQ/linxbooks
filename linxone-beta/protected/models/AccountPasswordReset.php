<?php

/**
 * This is the model class for table "account_password_reset".
 *
 * The followings are the available columns in table 'account_password_reset':
 * @property integer $account_password_reset_id
 * @property integer $account_id
 * @property string $account_password_reset_rand_key
 * @property string $account_password_reset_rand_key_expiry
 */
class AccountPasswordReset extends CActiveRecord
{
	public $account_email;
	public $account_new_password;
	public $account_new_password_retype;
	const DAYS_TO_EXPIRY = 1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccountPasswordReset the static model class
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
		return 'lb_sys_account_password_reset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, account_password_reset_rand_key, account_password_reset_rand_key_expiry, account_email', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('account_password_reset_rand_key', 'length', 'max'=>100),
			array('account_email, account_new_password, account_new_password_retype', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('account_password_reset_id, account_id, account_password_reset_rand_key, account_password_reset_rand_key_expiry', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_password_reset_id' => 'Account Password Reset',
			'account_id' => 'Account',
			'account_password_reset_rand_key' => 'Account Password Reset Rand Key',
			'account_password_reset_rand_key_expiry' => 'Account Password Reset Rand Key Expiry',
			'account_email' => 'Email',
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

		$criteria->compare('account_password_reset_id',$this->account_password_reset_id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('account_password_reset_rand_key',$this->account_password_reset_rand_key,true);
		$criteria->compare('account_password_reset_rand_key_expiry',$this->account_password_reset_rand_key_expiry,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function save($runValidation=true, $attributes=null)
	{
		// check if account_email is associated with any account at all
		$account = Account::model()->getAccountByEmail($this->account_email);
		if ($account == null)
		{
			$this->addError('account_email', 'This email is not associated with any account.');
			return false;
		}
		
		// create record
		if ($this->isNewRecord)
		{
			$this->account_id = $account->account_id;
			$this->account_password_reset_rand_key = $this->generateRandomKey($account->account_created_date);
			$this->account_password_reset_rand_key_expiry = $this->getExpiryDate();
		}
		
		$result = parent::save($runValidation, $attributes);
		if ($result)
		{
			// email customer step to reset password
			$message = new YiiMailMessage();
			$message->view = "passwordResetEmail";
			//userModel is passed to the view
			$message->setBody(
					array(
							'reset_url' => $this->generateResetURL(),
					),
					'text/html');
			
			$message->setSubject("[" . Yii::app()->name . "] Password Reset");
			$message->addTo($this->account_email);
			$message->setFrom(array(Yii::app()->params['adminEmail'] => 'Admin (' .Yii::app()->name . ')') );
			Yii::app()->mail->send($message);
		}
		
		return $result;
	}
	
	public function reset()
	{
		// compare password
		if ($this->account_new_password != $this->account_new_password_retype)
		{
			$this->addError('account_new_password', 'Passwords are not matched.');
			return false;
		}
		// validate password
		if (!Account::model()->passwordIsSafe($this->account_new_password))
		{
			$this->addError('account_new_password', 'Password is not safe. Your password should have at least characters, and include digits, letters, and special characters (such as &, *, $, [, ], etc.');
			return false;
		}
		
		// reset
		$account = Account::model()->getAccountByEmail($this->account_email);
		if ($account != null)
		{
			if( $account->resetPassword($this->account_new_password))
			{
				return true;
			}
			else {
				$this->addError('account_new_password', 'Password is not safe. Your password should have at least characters, and include digits, letters, and special characters (such as &, *, $, [, ], etc.');
				return false;
			}
		} else {
			$this->addError('account_new_password', 'Cannot find account.');
			return false;
		}
	}
	
	/**
	 * Find request by random key and email
	 * 
	 * @param string $email
	 * @param string $rand
	 * @return mixed null if found none, $model if found
	 */
	public function findByRandomKey($email, $rand)
	{
		$model = $this->find('account_password_reset_rand_key = :rand', array(':rand' => $rand));
		
		// request with this rand key found
		if ($model && $model->account_password_reset_id > 0)
		{
			// find account associated with this request
			$account = Account::model()->getAccountByEmail($email);
			
			// same account id
			if ($model->account_id == $account->account_id)
				return $model;
		}
		
		return null;
	}
	
	public function generateResetURL()
	{
		$url = Yii::app()->createAbsoluteUrl('accountPasswordReset/reset',
				array('email' => $this->account_email, 'key' => $this->account_password_reset_rand_key ));

		return $url;
	}
	
	public function generateRandomKey($k)
	{
		return md5(md5($this->account_id) . time() . $k);
	}
	
	public function getExpiryDate()
	{
		$exp_date = date('Y-m-d H:i:s');
		$exp_date = date('Y-m-d H:i:s', strtotime( "$exp_date + " . $this::DAYS_TO_EXPIRY . " day" ));
		
		return $exp_date;
	}
	
	public function isExpired()
	{
		$now = time(); // or your date as well
     	$exp_date = strtotime($this->account_password_reset_rand_key_expiry);
     	$datediff = $now - $exp_date;
     	$result = floor($datediff/(60*60*24));
		
     	if ($result >= $this::DAYS_TO_EXPIRY)
     		return true;
     	
     	return false;
	}
}
