<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
 
    public function authenticate()
    {
        $username = strtolower($this->username);
        $user = Account::model()->find('LOWER(account_email)=?',array($username));
        
        if($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if(!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id = $user->account_id;
            
            // get Profile detail
            //$accountContact = CompanyContact::model()->find('account_id=?', array($user->account_id));
            $accountProfile = AccountProfile::model()->find('account_id = ?', array($user->account_id));
            $accountSubscriptions = AccountSubscription::model()->findSubscriptions($user->account_id);
            
            // set currently selected subscription default as first on the list
            reset($accountSubscriptions);
            $this->setState('linx_app_selected_subscription', key($accountSubscriptions));
            
            $this->username = $user->account_email;
            $this->setState('account_email', $user->account_email);
            $this->setState('account_subscriptions', $accountSubscriptions);
            $tz = $user->account_timezone;
            if (trim($tz) == '')
            	$tz = 'Asia/Singapore';
            $this->setState('timezone', $tz);
            //$this->setState('isMasterAccount', Account::model()->isMasterAccount($user->account_id) ? YES : NO);
            
            if ($accountProfile === null) {
            	$this->setState('account_contact_surname', '');
            	$this->setState('account_contact_given_name', '');
            } else {
            	$this->setState('account_profile_surname', $accountProfile->account_profile_surname);
            	$this->setState('account_profile_given_name', $accountProfile->account_profile_given_name);
            	$this->setState('account_profile_preferred_display_name', $accountProfile->account_profile_preferred_display_name);
            	$this->setState('account_profile_short_name', $accountProfile->getShortFullName());
            }
            
            $this->errorCode = self::ERROR_NONE;
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }
    public function authenticateSocialFacebook()
    {
        $username = strtolower($this->username);
        $user = Account::model()->find('LOWER(account_email)=?',array($username));
        
        if($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if($user->account_check_social_login_id_facebook == "")
            $this->errorCode = "errors social login".$user->account_check_social_login;
        else
        {
            $this->_id = $user->account_id;
            
            // get Profile detail
            //$accountContact = CompanyContact::model()->find('account_id=?', array($user->account_id));
            $accountProfile = AccountProfile::model()->find('account_id = ?', array($user->account_id));
            $accountSubscriptions = AccountSubscription::model()->findSubscriptions($user->account_id);
            
            // set currently selected subscription default as first on the list
            reset($accountSubscriptions);
            $this->setState('linx_app_selected_subscription', key($accountSubscriptions));
            
            $this->username = $user->account_email;
            $this->setState('account_email', $user->account_email);
            $this->setState('account_subscriptions', $accountSubscriptions);
            $tz = $user->account_timezone;
            if (trim($tz) == '')
            	$tz = 'Asia/Singapore';
            $this->setState('timezone', $tz);
            //$this->setState('isMasterAccount', Account::model()->isMasterAccount($user->account_id) ? YES : NO);
            
            if ($accountProfile === null) {
            	$this->setState('account_contact_surname', '');
            	$this->setState('account_contact_given_name', '');
            } else {
            	$this->setState('account_profile_surname', $accountProfile->account_profile_surname);
            	$this->setState('account_profile_given_name', $accountProfile->account_profile_given_name);
            	$this->setState('account_profile_preferred_display_name', $accountProfile->account_profile_preferred_display_name);
            	$this->setState('account_profile_short_name', $accountProfile->getShortFullName());
            }
            
            $this->errorCode = self::ERROR_NONE;
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }
    public function authenticateSocialGoogle()
    {
        $username = strtolower($this->username);
        $user = Account::model()->find('LOWER(account_email)=?',array($username));
        
        if($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if($user->account_check_social_login_id_google == "")
            $this->errorCode = "errors social login".$user->account_check_social_login;
        else
        {
            $this->_id = $user->account_id;
            
            // get Profile detail
            //$accountContact = CompanyContact::model()->find('account_id=?', array($user->account_id));
            $accountProfile = AccountProfile::model()->find('account_id = ?', array($user->account_id));
            $accountSubscriptions = AccountSubscription::model()->findSubscriptions($user->account_id);
            
            // set currently selected subscription default as first on the list
            reset($accountSubscriptions);
            $this->setState('linx_app_selected_subscription', key($accountSubscriptions));
            
            $this->username = $user->account_email;
            $this->setState('account_email', $user->account_email);
            $this->setState('account_subscriptions', $accountSubscriptions);
            $tz = $user->account_timezone;
            if (trim($tz) == '')
            	$tz = 'Asia/Singapore';
            $this->setState('timezone', $tz);
            //$this->setState('isMasterAccount', Account::model()->isMasterAccount($user->account_id) ? YES : NO);
            
            if ($accountProfile === null) {
            	$this->setState('account_contact_surname', '');
            	$this->setState('account_contact_given_name', '');
            } else {
            	$this->setState('account_profile_surname', $accountProfile->account_profile_surname);
            	$this->setState('account_profile_given_name', $accountProfile->account_profile_given_name);
            	$this->setState('account_profile_preferred_display_name', $accountProfile->account_profile_preferred_display_name);
            	$this->setState('account_profile_short_name', $accountProfile->getShortFullName());
            }
            
            $this->errorCode = self::ERROR_NONE;
        }
        
        return $this->errorCode == self::ERROR_NONE;
    }
    
    function remoteAuthenticate($remote_data)
           {
              // validate remote data
              // remote data can co structure sau:
              // stdClass{$....}

              // truong hop structure day du:
   //           if (...)
   //           {
                 // update csdl neu can.
                 // sau do ghi data vao session.
                 $this->_id = $remote_data->account_id; ;// user id local.
                 $this->username = $remote_data->account_username; // username.
                 $this->setState('username',$this->username); // Mot so he thong set ca Id. Can phan nay vi da so cac session dung username va id cho viec register tinh trang login. Neu thieu username va/hoac id thi he thong co the ko login duoc.
                 // cac session data khac cua Yii neu muon
                 //$this->setState('account_profile_surname', ....);
                 //...
                 
                // get Profile detail
                //$accountContact = CompanyContact::model()->find('account_id=?', array($user->account_id));
                $user = Account::model()->findByPk($remote_data->account_id);
                $accountProfile = AccountProfile::model()->find('account_id = ?', array($remote_data->account_id));
                $accountSubscriptions = AccountSubscription::model()->findSubscriptions($remote_data->account_id);

                // set currently selected subscription default as first on the list
                reset($accountSubscriptions);
                $this->setState('linx_app_selected_subscription', key($accountSubscriptions));
                
                $this->setState('account_subscriptions', $accountSubscriptions);
                $tz = $user->account_timezone;
                if (trim($tz) == '')
                    $tz = 'Asia/Singapore';
                $this->setState('timezone', $tz);
                //$this->setState('isMasterAccount', Account::model()->isMasterAccount($user->account_id) ? YES : NO);

                if ($accountProfile === null) {
                    $this->setState('account_contact_surname', '');
                    $this->setState('account_contact_given_name', '');
                } else {
                    $this->setState('account_profile_surname', $accountProfile->account_profile_surname);
                    $this->setState('account_profile_given_name', $accountProfile->account_profile_given_name);
                    $this->setState('account_profile_preferred_display_name', $accountProfile->account_profile_preferred_display_name);
                    $this->setState('account_profile_short_name', $accountProfile->getShortFullName());
                }
                 
                 
                 $this->errorCode = self::ERROR_NONE;
   //           }

              return $this->errorCode == self::ERROR_NONE;
           }
 
    public function getId()
    {
        return $this->_id;
    }
}