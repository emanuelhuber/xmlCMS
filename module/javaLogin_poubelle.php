<?php
session_start();
define('INTERSTITIUM_CONF', 'conf/config.ini') ;
define('BASE_PATH',realpath('.'));						// for server side inclusions.
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
define('ROOT_PATH',BASE_PATH);
define('ROOT_URL',BASE_URL);
			if(isset($_SESSION['login_visiteur']['connection']) 		// Si l'utilisateur s'est loggé
				&& $_SESSION['login_visiteur']['connection']){			// Si la connection est ok
				echo '<p>'.$_SESSION['login_visiteur']['username'].'</p>';
				echo '<p><a href="fr,login,out.html">Logout</p>';
			}else{
				echo '<p><a href="fr,login,in.html">Login</a></p>';
			}
			
?>