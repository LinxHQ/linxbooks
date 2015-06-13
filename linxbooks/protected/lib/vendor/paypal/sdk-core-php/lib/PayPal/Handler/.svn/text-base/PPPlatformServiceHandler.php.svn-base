<?php
namespace PayPal\Handler;
use PayPal\Core\PPConstants;
use PayPal\Handler\PPGenericServiceHandler;
use PayPal\Exception\PPConfigurationException;


class PPPlatformServiceHandler extends PPGenericServiceHandler {
	private $endpoint;
	private $config;
	public function handle($httpConfig, $request, $options) {
		parent::handle($httpConfig, $request, $options);
		$this->config = $options['config'];
		$credential = $request->getCredential();
		//TODO: Assuming existence of getApplicationId
		if($credential && $credential->getApplicationId() != NULL) {
			$httpConfig->addHeader('X-PAYPAL-APPLICATION-ID', $credential->getApplicationId());
		}
		if($options['port'] != null && isset($this->config['service.EndPoint.'.$options['port']]))
		{
			$endpnt = 'service.EndPoint.'.$options['port']; 
			$this->endpoint = $this->config[$endpnt];
		}
		// for backward compatibilty (for those who are using old config files with 'service.EndPoint')
		else if (isset($this->config['service.EndPoint']))
		{
			$this->endpoint = $this->config['service.EndPoint'];
		}
		else if (isset($this->config['mode']))
		{
			if(strtoupper($this->config['mode']) == 'SANDBOX')
			{
				$this->endpoint = PPConstants::PLATFORM_SANDBOX_ENDPOINT;
			}
			else if(strtoupper($this->config['mode']) == 'LIVE')
			{
				$this->endpoint = PPConstants::PLATFORM_LIVE_ENDPOINT;
			}
		}
		else
		{
			throw new PPConfigurationException('endpoint Not Set');
		}
		$httpConfig->setUrl($this->endpoint . $options['serviceName'] . '/' .  $options['apiMethod']);
	
	}
}