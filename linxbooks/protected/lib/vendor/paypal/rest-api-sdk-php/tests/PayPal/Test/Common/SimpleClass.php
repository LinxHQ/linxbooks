<?php
namespace PayPal\Test\Common;
use PayPal\Common\PPModel;
class SimpleClass extends PPModel {

	public function setName($name) {
		$this->name = $name;
	}
	public function getName() {
		return $this->name;
	}
	
	public function setDescription($desc) {
		$this->desc = $desc;
	}
	public function getDescription() {
		return $this->desc;
	}
}