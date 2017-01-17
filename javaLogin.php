<?php
session_start();
define('INTERSTITIUM_CONF', 'conf/config.ini') ;
define('BASE_PATH',realpath('.'));						// for server side inclusions.
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
define('ROOT_PATH',BASE_PATH);
define('ROOT_URL',BASE_URL);
			if(isset($_SESSION['login_visiteur']['connection']) 		// Si l'utilisateur s'est loggé
				&& $_SESSION['login_visiteur']['connection']){			// Si la connection est ok
				echo '<p>Bienvenue <em>'.$_SESSION['login_visiteur']['username'].'</em>&nbsp;!';
				echo '&nbsp;&nbsp;<a href="fr,login,users.html?action=out">Logout</p>';
			}else{
				echo '<p><a href="fr,login,users.html">Login</a></p>';
			}
			
?>