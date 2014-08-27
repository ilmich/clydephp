<?php namespace clydephp\cache; 

	if (!defined('CLYDEPHP'))  { header ('HTTP/1.1 404 Not Found'); exit(1); }

	class Cache {
		
		public static function factory($params=array()) {			
			if (is_null($params) || !is_array($params) || empty($params)) {
				throw new ClydePhpException('You must pass a valid array of parameters');
			}
			
			if (!isset($params['type'])) {
				throw new ClydePhpException('You must pass a non empty type');
			}
			
			$adapterName = ucfirst($params['type'].'Cache');
	
			return new $adapterName($params);				
		}		
	}
	
	
	