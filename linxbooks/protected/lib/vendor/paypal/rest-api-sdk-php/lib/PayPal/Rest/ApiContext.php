<?php
namespace PayPal\Rest;

use PayPal\Common\PPApiContext;
/**
 * 
 * Call level parameters such as
 * request id, credentials etc
 */
class ApiContext extends PPApiContext {
	
	/**
	 * OAuth Credentials to use for this call
	 * @var PayPal/Api/OAuthTokenCredential
	 */
	private $credential;
	
	/**
	 * Unique request id to be used for this call
	 * The user can either generate one as per application
	 * needs or let the SDK generate one
	 * @var string
	 */
	private $requestId;
	
	/**
	 * 
	 */
	public function getCredential() {
		return $this->credential;		
	}
	
	public function getrequestId() {
		if($this->requestId == null) {
			$this->requestId = $this->generateRequestId();
		}
		return $this->requestId;
	}
	
	
	/**
	 * 
	 * @param PayPal/Api/OAuthTokenCredential $credential
	 * @param string $requestId
	 */
	public function __construct($credential, $requestId=null) {
		$this->credential = $credential;
		$this->requestId = $requestId;
	}
	
	/**
	 * Generates a unique per request id that
	 * can be used to set the PayPal-Request-Id header
	 * that is used for idemptency
	 * @return string
	 */
	private function generateRequestId() {
		
		static $pid = -1;
		static $addr = -1;
		
		if ($pid == -1) {
			$pid = getmypid();
		}
		if ($addr == -1) {
			if(array_key_exists('SERVER_ADDR', $_SERVER)) {
				$addr = ip2long($_SERVER['SERVER_ADDR']);
			} else {
				$addr  = php_uname('n');
			}
		}
		
		return $addr . $pid . $_SERVER['REQUEST_TIME'] . mt_rand(0, 0xffff);
	}
}
