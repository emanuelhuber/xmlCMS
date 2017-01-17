<?php


define('BASE_PATH',realpath('.'));						// for server side inclusions (wamp/www/interstitium/admin).
define('ROOT_PATH',dirname(BASE_PATH));				// for server side inclusions (wamp/www/interstitium).
define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));	// for client side inclusions (scripts, css files, images etc.)
define('ROOT_URL', dirname(BASE_URL));	// for client side inclusions (scripts, css files, images etc.)
define('INTERSTITIUM_CONF', './../admin/conf/config.ini') ;

echo INTERSTITIUM_CONF;
$config = parse_ini_file(INTERSTITIUM_CONF, true);	

$path = ROOT_PATH.$config['path']['lib'].'/wymeditor/config.js';
echo $path;
$content = file_get_contents($path);

if(isset($_GET['url']) && !empty($_GET['url'])){
	$content = preg_replace( '#{CssPath}#', $urlCss, $content );
	echo $content ;
}

?>


