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
 
    public function getId()
    {
        return $this->_id;
    }
}