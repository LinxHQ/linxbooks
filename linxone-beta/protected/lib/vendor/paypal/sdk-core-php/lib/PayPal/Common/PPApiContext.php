<?php
namespace PayPal\Common;
use PayPal\Core\PPConfigManager;
/**
 * 
 * Container for Call level parameters such as
 * SDK configuration 
 */
class PPApiContext {
	
	/**
	 * 
	 * @var array Dynamic SDK configuration
	 */
	protected $config;
	
	public function setConfig($config) {
		$this->config = $config;
	}
	
	public function getConfig() {
		if(!isset($this->config)) {
			$this->config = PPConfigManager::getInstance()->getConfigHashmap();
		}
		return $this->config;
	}
	
	public function __construct($config=null) {
		if(!is_null($config)) {
			$this->config = $config;
		}
	}
}