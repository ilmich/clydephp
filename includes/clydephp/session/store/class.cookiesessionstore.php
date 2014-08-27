<?php if (!defined('CLYDEPHP'))  { header ('HTTP/1.1 404 Not Found'); exit(1); }

	class CookieSessionStore implements SessionStore {
		
		public function open($savePath,$sessionName) {}
		
		public function close() {}
		
		public function read($id) {
			return $_COOKIE['_st'];
		}
		
		public function write($id,$sessData) {
			setcookie('_st', $sessData);
		}
		
		public function destroy($id) {
			
		}
		
		public function gc($maxLifeTime) {}
		
	}