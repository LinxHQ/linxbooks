<?php
namespace PayPal\Core;
use PayPal\Core\PPAPIService;
class PPBaseService {

    // SDK Name
	protected  static $SDK_NAME = "paypal-php-sdk";
	// SDK Version
	protected static $SDK_VERSION = "2.1.96";
	
	private $serviceName;
	private $serviceBinding;
	private $handlers;
	
   /*
    * Setters and getters for Third party authentication (Permission Services)
    */
	protected $accessToken;
	protected $tokenSecret;
	
	protected $lastRequest;
	protected $lastResponse;
	
	
	
	// config hash map
	public $config;

	/**
	 * Compute the value that needs to sent for the PAYPAL_REQUEST_SOURCE
	 * parameter when making API calls
	 */
	public static function getRequestSource()
	{
		return str_replace(" ", "-", self::$SDK_NAME) . "-" . self::$SDK_VERSION;
	}
	

    public function getLastRequest() {
		return $this->lastRequest;
	}
    public function setLastRequest($lastRqst) {
		$this->lastRequest = $lastRqst;
	}
    public function getLastResponse() {
		return $this->lastResponse;
	}
    public function setLastResponse($lastRspns) {
		$this->lastResponse = $lastRspns;
	}

	public function __construct($serviceName, $serviceBinding, $handlers=array(), $config = null) {
		$this->serviceName = $serviceName;
		$this->serviceBinding = $serviceBinding;
		$this->handlers = $handlers;
		if($config == null)
		{
			$configFile = PPConfigManager::getInstance();
			$this->config = $configFile->getConfigHashmap();
		}
		else 
		{
			$this->config = PPConfigManager::mergrDefaults($config);
		}
	}

	public function getServiceName() {
		return $this->serviceName;
	}

	/**
	 * 
	 * @param string $method - API method to call
	 * @param object $requestObject Request object 
	 * @param mixed $apiCredential - Optional API credential - can either be
	 * 		a username configured in sdk_config.ini or a ICredential object
	 *      created dynamically 		
	 */
	public function call($port, $method, $requestObject, $apiUserName = NULL) {		
		$service = new PPAPIService($port, $this->serviceName, 
				$this->serviceBinding, $this->handlers,$this->config);		
		$ret = $service->makeRequest($method, $requestObject, $apiUserName);
		$this->lastRequest = $ret['request'];
		$this->lastResponse = $ret['response'];
		return $this->lastResponse;
	}
}