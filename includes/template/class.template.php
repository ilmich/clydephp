<?php

class TemplateException extends ClydePhpException {

}

class Template {
	 
	protected $_data = array();
	protected $_fileName=null;
	 
	public function __construct($template) {
		$this->_fileName = $template;
	}
	
	public function setFileName($file) {
		$this->_fileName = $file;
		return $this;
	}
	
	public function getFileName() {
		return $this->_fileName;		
	}
	 
	public function __get($name) {
		if(isset($this->_data[$name])) {
			return $this->_data[$name];
		}
		return null;
	}
	 
	public function __set($name,$value) {
		$this->_data[$name] = $value;
	}

	public function __isset($name) {
		return isset($this->_data[$name]);
	}

	public function __unset($name)  {
		unset($this->_data[$name]);
	}

	public function fromArray($arr) {
		return BeanUtils::fromArray($this,$arr);
	}

	public function render() {
		 
		extract($this->_data,EXTR_SKIP);

		if (!is_readable($this->_fileName)) {
			throw new TemplateException("Template ".$this->_fileName." not found");
		}

		ob_start();

		include $this->_fileName;
		 
		return ob_get_clean();
		 
	}

	public function __toString() {
		try {
			return $this->render();
		} catch (Exception $e) {
			return "Error rendering template: " . $e->getMessage();
		}
	}
}
 
?>