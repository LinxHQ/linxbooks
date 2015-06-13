<?php
namespace PayPal\Core;
use PayPal\Core\PPLoggingManager;
use PayPal\Formatter\FormatterFactory;
use PayPal\Core\PPRequest;
use PayPal\Core\PPHttpConfig;
use PayPal\Handler\PPAuthenticationHandler;
use PayPal\Auth\PPTokenAuthorization;

class PPAPIService {

	public $endpoint;
	public $config;
	public $options = array();
	public $serviceName;
	private $logger;
	private $handlers = array();
	private $serviceBinding;
	private $port;
	private $apiMethod;
	public function __construct($port, $serviceName, $serviceBinding, $handlers=array(), $config) {
		
		$this->config = $config;
		$this->serviceName = $serviceName;
		$this->port = $port;

		$this->logger = new PPLoggingManager(__CLASS__, $this->config);
		$this->handlers = $handlers;
		$this->serviceBinding = $serviceBinding;
		
	}

	public function setServiceName($serviceName) {
		$this->serviceName = $serviceName;
	}

	public function addHandler($handler) {
		$this->handlers[] = $handler;
	}

	public function makeRequest($apiMethod, $params, $apiUsername = null) {
		
		$this->apiMethod = $apiMethod;
		if(is_string($apiUsername) || is_null($apiUsername)) {
			// $apiUsername is optional, if null the default account in config file is taken
			$credMgr = PPCredentialManager::getInstance($this->config);
			$apiCredential = clone($credMgr->getCredentialObject($apiUsername ));
		} else {
			$apiCredential = $apiUsername; //TODO: Aargh
		}
	    if((isset($this->config['accessToken']) && isset($this->config['tokenSecret']))) {
			$apiCredential->setThirdPartyAuthorization(
					new PPTokenAuthorization($this->config['accessToken'], $this->config['tokenSecret']));
		}


		$request = new PPRequest($params, $this->serviceBinding);
		$request->setCredential($apiCredential);
		$httpConfig = new PPHttpConfig(null, PPHttpConfig::HTTP_POST);
		$this->runHandlers($httpConfig, $request);

		$formatter = FormatterFactory::factory($this->serviceBinding);
		$payload = $formatter->toString($request);
		$connection = PPConnectionManager::getInstance()->getConnection($httpConfig, $this->config);
		$this->logger->info("Request: $payload");
		$response = $connection->execute($payload);
		$this->logger->info("Response: $response");

		return array('request' => $payload, 'response' => $response);
	}

	private function runHandlers($httpConfig, $request) {
	
		$this->getOptions();
		
		foreach($this->handlers as $handlerClass) {
			$handler = new $handlerClass();
			$handler->handle($httpConfig, $request, $this->options);
		}
		$handler = new PPAuthenticationHandler();
		$handler->handle($httpConfig, $request, $this->options);
	}
	
	private function getOptions()
	{
		$this->options['port'] = $this->port;
		$this->options['serviceName'] = $this->serviceName;
		$this->options['serviceBinding'] = $this->serviceBinding;
		$this->options['config'] = $this->config;
		$this->options['apiMethod'] = $this->apiMethod;
	}	
}
