<?php

class HttpResponse extends DynaBean {

	private $_body;
	private $_headers = array();

	public function send() {
			
		foreach (array_keys($this->_headers) as $header) {
			header($header.": ".$this->_headers[$header]);
		}
			
		echo $this->_body;
			
	}

	public function addHeader($name,$value) {
		$this->_headers[$name] = $value;
	}

	public function setBody($body) {
		$this->_body = $body;
	}

}


?>