<?php
namespace PayPal\Handler;

use PayPal\Exception\PPConfigurationException;
use PayPal\Core\PPConstants;
use PayPal\Common\PPUserAgent;

class PPOpenIdHandler implements IPPHandler {
	
	private $apiContext;
	
	private static $sdkName = "openid-sdk-php";	
	private static $sdkVersion = "2.4.3";
	
	public function __construct($apiContext) {
		$this->apiContext = $apiContext;
	}

	public function handle($httpConfig, $request, $options) {

		$config = $this->apiContext->getConfig();
		$httpConfig->setUrl(
			rtrim(trim($this->_getEndpoint($config)), '/') . 
				(isset($options['path']) ? $options['path'] : '')
		);
		
		if(!array_key_exists("Authorization", $httpConfig->getHeaders())) {			
			$auth = base64_encode($config['acct1.ClientId'] . ':' . $config['acct1.ClientSecret']);
			$httpConfig->addHeader("Authorization", "Basic $auth");
		}
		if(!array_key_exists("User-Agent", $httpConfig->getHeaders())) {
			$httpConfig->addHeader("User-Agent", PPUserAgent::getValue(self::$sdkName, self::$sdkVersion));
		}
	}
	
	private function _getEndpoint($config) {
		if (isset($config['openid.EndPoint'])) {
			return $config['openid.EndPoint'];
		} else if (isset($config['service.EndPoint'])) {
			return $config['service.EndPoint'];
		} else if (isset($config['mode'])) {
			switch (strtoupper($config['mode'])) {
				case 'SANDBOX':
					return PPConstants::REST_SANDBOX_ENDPOINT;
				case 'LIVE':
					return PPConstants::REST_LIVE_ENDPOINT;
				default:
					throw new PPConfigurationException('The mode config parameter must be set to either sandbox/live');
			}
		} else {
			throw new PPConfigurationException('You must set one of service.endpoint or mode parameters in your configuration');
		}
	}
}
