<?php

	//sample session settings
	//ini_set('session.gc_maxlifetime',3600);
	//ini_set('session.save_path',"sessions/");
	
	//start session
	Session::getInstance()->start();
		
	$authParms = require_once "conf.auth.php";	
	
	Auth::configure($authParms);