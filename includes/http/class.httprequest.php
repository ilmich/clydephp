<?php

class HttpRequest extends DynaBean {

	// Singleton object. Leave $me alone.
	private static $me;
	 
	private $headers = array();
	private $body;
	private $method;
	private $protocol;
	private $requestMethod;
	private $pathInfo;
	private $params = array();
	 
	/** additional HTTP headers not prefixed with HTTP_ in $_SERVER superglobal */
	var $add_headers = array('CONTENT_TYPE', 'CONTENT_LENGTH','QUERY_STRING','REQUEST_URI','PATH_INFO');

	/**
		* Construtor
		* Retrieve HTTP Body
		* @param Array Additional Headers to retrieve
		*/
	public function HttpRequest($add_headers = false) {

		$this->retrieveHeaders($add_headers);
			
		//populate request input
		$this->retrieveParams();
			
		//raw body
		$this->body = @file_get_contents('php://input');
	}

	/**
		* Retrieve the HTTP request headers from the $_SERVER superglobal
		* @param Array Additional Headers to retrieve
		*/
	protected function retrieveHeaders($add_headers = false) {
			
		if ($add_headers) {
			$this->add_headers = array_merge($this->add_headers, $add_headers);
		}

		if (isset($_SERVER['HTTP_METHOD'])) {
			$this->method = $_SERVER['HTTP_METHOD'];
			unset($_SERVER['HTTP_METHOD']);
		} else {
			$this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : false;
		}
		$this->protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : false;
		$this->requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : false;
			
		$this->pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : false;

		foreach($_SERVER as $i=>$val) {
			if (strpos($i, 'HTTP_') === 0 || in_array($i, $this->add_headers)) {
				$name = str_replace(array('HTTP_', '_'), array('', '-'), $i);
				$this->headers[$name] = $val;
			}
		}
	}

	protected function retrieveParams() {
			
		$this->params = array_merge($this->params,$_GET,$_POST);
			
	}

	public function getParam($name) {
			
		if (isset($this->params[$name])) {
			return $this->params[$name];
		}
			
		return null;
	}

	public function setParam($name,$value) {
		$this->params[$name] = $value;
	}

	public static function getHttpRequest()
	{
		if(is_null(self::$me))
			self::$me = new HttpRequest();
		return self::$me;
	}
	 
	/**
		* Retrieve HTTP Method
		*/
	function getMethod() {
		return $this->method;
	}

	function getPathInfo() {
		return $this->pathInfo;
	}

	/**
		* Retrieve HTTP Body
		*/
	function getBody() {
		return $this->body;
	}

	/**
		* Retrieve an HTTP Header
		* @param string Case-Insensitive HTTP Header Name (eg: "User-Agent")
		*/
	function getHeader($name) {
		$name = strtoupper($name);
		return isset($this->headers[$name]) ? $this->headers[$name] : false;
	}

	/**
		* Retrieve all HTTP Headers
		* @return array HTTP Headers
		*/
	function getHeaders() {
		return $this->headers;
	}

	/**
		* Return Raw HTTP Request (note: This is incomplete)
		* @param bool ReBuild the Raw HTTP Request
		*/
	function raw($refresh = false) {

		if (isset($this->raw) && !$refresh) {
			return $this->raw; // return cached
		}

		$headers = $this->getHeaders();
		$this->raw = "{$this->method}\r\n";
			
		foreach($headers as $i=>$header) {
			$this->raw .= "$i: $header\r\n";
		}
			
		$this->raw .= "\r\nBody:{$this->body}";
			
		return $this->raw;
	}

	public function redirect($url) {
		redirect($url);
	}
}


?>