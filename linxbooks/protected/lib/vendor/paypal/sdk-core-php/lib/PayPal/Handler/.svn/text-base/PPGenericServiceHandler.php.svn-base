<?php
namespace PayPal\Handler;
use PayPal\Handler\IPPHandler;
use PayPal\Core\PPUtils;
use PayPal\Core\PPBaseService;
class PPGenericServiceHandler implements IPPHandler {

	public function handle($httpConfig, $request, $options) {
		$httpConfig->addHeader('X-PAYPAL-REQUEST-DATA-FORMAT', $request->getBindingType());
		$httpConfig->addHeader('X-PAYPAL-RESPONSE-DATA-FORMAT', $request->getBindingType());
		$httpConfig->addHeader('X-PAYPAL-DEVICE-IPADDRESS', PPUtils::getLocalIPAddress());
		$httpConfig->addHeader('X-PAYPAL-REQUEST-SOURCE', PPBaseService::getRequestSource());
			if(isset($options['config']['service.SandboxEmailAddress']))
			{
				$httpConfig->addHeader('X-PAYPAL-SANDBOX-EMAIL-ADDRESS', $options['config']['service.SandboxEmailAddress']);
			}
	}
}