<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class Links extends PPModel {
	/**
	 * 
	 * @param string $href
	 */
	public function setHref($href) {
		$this->href = $href;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getHref() {
		return $this->href;
	}


	/**
	 * 
	 * @param string $rel
	 */
	public function setRel($rel) {
		$this->rel = $rel;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getRel() {
		return $this->rel;
	}


	/**
	 * 
	 * @param PayPal\Api\HyperSchema $targetSchema
	 */
	public function setTargetSchema($targetSchema) {
		$this->targetSchema = $targetSchema;
		return $this;
	}

	/**
	 * 
	 * @return PayPal\Api\HyperSchema
	 */
	public function getTargetSchema() {
		return $this->targetSchema;
	}


	/**
	 * 
	 * @param string $method
	 */
	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}


	/**
	 * 
	 * @param string $enctype
	 */
	public function setEnctype($enctype) {
		$this->enctype = $enctype;
		return $this;
	}

	/**
	 * 
	 * @return string
	 */
	public function getEnctype() {
		return $this->enctype;
	}


	/**
	 * 
	 * @param PayPal\Api\HyperSchema $schema
	 */
	public function setSchema($schema) {
		$this->schema = $schema;
		return $this;
	}

	/**
	 * 
	 * @return PayPal\Api\HyperSchema
	 */
	public function getSchema() {
		return $this->schema;
	}


}
