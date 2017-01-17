<?php

define('INTERSTITIUM_CONF', 'conf/config.ini') ;
if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
	define('BASE_URL','');
}else{
	define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
}
define('BASE_PATH',realpath('.'));						// for server side inclusions.
//define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
//define('ROOT_URL', dirname(BASE_URL));	// for client side inclusions (scripts, css files, images etc.)


	$folder = BASE_PATH.'/data/upload/autre';
	$dossier = opendir($folder);
	$listMisc = '';
	while ($filename = readdir($dossier)) {
		//$pathCss = $folder.$style;
		if($filename != "." && $filename != "..") { 
			$url = 'http://'.$_SERVER['SERVER_NAME'].BASE_URL.'/data/upload/autre/'.$filename;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$icones = 'http://'.$_SERVER['SERVER_NAME'].BASE_URL.'/admin/design/defaut/icones/'.$ext.'.png';
			$listMisc .= '<a class="lister" href="'.$url.'" title="'.$ext.'"><img src="'.$icones.'" alt="'.$ext.'" />'.$filename.'</a><br/>';	
		}
	}
	closedir($dossier);
	header("Content-Type: text/html; charset=UTF-8");
	echo $listMisc;
	
	
?>