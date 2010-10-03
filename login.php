<?php
	
	require_once ("includes/master.inc.php");
	
	$auth = Auth::getAuth()->init(); //init auth class and try to authorize from existing session
	$req = HttpRequest::getHttpRequest(); //get http request object
	$error = Error::getError();

	if ($req->getMethod() === 'GET' && !is_null($req->getParam('logout'))) {		
		$auth->logout();
	}
	
	if ($req->getMethod() === 'POST' && (!is_null($req->getParam('username')) || $req->getParam('username') !== '')) {
		//try login		
		$bool = $auth->login($req->getParam('username'),$req->getParam('password'));
		if (!$bool) {
			$error->add("login","Wrong username or password");
		}			
	}	
?>
<html>
<head>
	<title>Simple login form</title>
	<?php $error->css();?>
</head>
<body>
<?php if ($auth->loggedIn()) { //user authorized.. show logout link?>
	Utente loggato <a href="login.php?logout=true">Logout</a>
<?php } 
else { // show login form
	echo $error;	//show errors
	?>

	<form action="login.php" method="post">
		<label>Uid: </label><input type="text" name="username"/><br></br>
		<label>Pwd: </label><input type="text" name="password"/>
		<input type="submit" value="Login"/>
	</form>
	
<?php }?>
</body>
</html>

	