<?php

/*
Ce fichier php renvoit le fichier de configuration de 
WYMeditor (javascript) et avant, remplace le tage
"CssPath}" par l'url demandé dans le lien ($_GET['url']).


*/

define('INTERSTITIUM_CONF', 'conf/config.ini') ;
define('BASE_PATH',realpath('.'));						// for server side inclusions (wamp/www/interstitium/admin).
define('ROOT_PATH',dirname(BASE_PATH));				// for server side inclusions (wamp/www/interstitium).
if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
	define('BASE_URL','');
}else{
	define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
}
if(dirname(BASE_URL) == '/'){
	define('ROOT_URL','');
}else{
	define('ROOT_URL', dirname(BASE_URL));	// for client side inclusions (scripts, css files, images etc.)
}

$config = parse_ini_file(INTERSTITIUM_CONF, true);	

$path = ROOT_PATH.$config['path']['lib'].'/wymeditor/config.js';

$content = file_get_contents($path);

if(isset($_GET['url']) && !empty($_GET['url'])){
	 $urlCss = $_GET['url'];
	$content = preg_replace( '#{CssPath}#', $urlCss, $content );
	$content = preg_replace( '#{LIB_PATH}#', ROOT_URL.$config['path']['lib'], $content );
	header('Content-Type: text/css; charset=UTF-8');
	echo $content ;
}


?>


