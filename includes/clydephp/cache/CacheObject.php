<?php namespace clydephp\cache; 

	if (!defined('CLYDEPHP'))  { header ('HTTP/1.1 404 Not Found'); exit(1); }

	class CacheObject {
	
		public $value= null;
		public $expirationTime = null;
	
		public function __construct($value,$exp) {
			$this->value=$value;
			$this->expirationTime = time()+$exp;
		}
	
		public function isValid() {
			return time() < $this->expirationTime;
		}
	
		public function getValue() {
			return $this->value;
		}
	
		public function setValue($value) {
			$this->value = $value;
		}
	}