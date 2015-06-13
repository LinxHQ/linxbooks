<?php 
class WebUser extends CWebUser
{
	private $model = null;

	public function getModel()
	{
		if(!isset($this->id)) $this->model = new Account;
		if($this->model === null)
			$this->model = Account::model()->findByPk($this->id);
		return $this->model;
	}

	public function __get($name) {
		try {
			return parent::__get($name);
		} catch (CException $e) {
			$m = $this->getModel();
			if($m->__isset($name))
				return $m->{$name};
			else throw $e;
		}
	}

	public function __set($name, $value) {
		try {
			return parent::__set($name, $value);
		} catch (CException $e) {
			$m = $this->getModel();
			$m->{$name} = $value;
		}
	}

	public function __call($name, $parameters) {
		try {
			return parent::__call($name, $parameters);
		} catch (CException $e) {
			$m = $this->getModel();
			return call_user_func_array(array($m,$name), $parameters);
		}
	}
}