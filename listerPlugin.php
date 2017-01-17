<?php

/*
Ce fichier php renvoit le fichier de configuration de 
WYMeditor (javascript) et avant, remplace le tage
"CssPath}" par l'url demandé dans le lien ($_GET['url']).


*/
if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
	define('BASE_URL','');
}else{
	define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
}
define('INTERSTITIUM_CONF', 'conf/config.ini') ;
define('BASE_PATH',realpath('.'));						// for server side inclusions.
//define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
define('ROOT_PATH',BASE_PATH);
define('ROOT_URL',BASE_URL);


$config = parse_ini_file(INTERSTITIUM_CONF, true);	

$path = ROOT_PATH.$config['path']['lib'].'/wymeditor/config.js';



$pluginList = array();
$tag = '';


$pluginClassDir = ROOT_PATH.$config['path']['plugin'];
$dossier = opendir($pluginClassDir);

while ($fichier = readdir($dossier)) {
	if($fichier != "." && $fichier != ".." && !is_dir($pluginClassDir.$fichier)) {
		$className = substr($fichier, 0, -4);
		$classPath = $pluginClassDir.$fichier;
		require($classPath);
		if(class_exists($className)){	// si la classe existe, on tente d'intancier un objet...	
			$myPlugin = new $className;
			$pluginList[$className] = $myPlugin -> listPlug();
			
			$tag .= '<p class="plugGroup"><strong>'.$className.'</strong><br/>';
			foreach($pluginList[$className]  as $key => $val){
				foreach($val as $ke => $va){
					if(is_array($va)){
						$tag .=$ke.' : ';
						foreach($va as $k => $v){
							$tag .= '<a class="plug" href="#" title="'.$v.'">'.$k.'</a>  &nbsp; ';
							
						}
						$tag .= '<br/>';
					}else{
					$tag .='<a class="plug" href="#" title="'.$va.'">'.$ke.'</a>'.'<br/>';
					//echo $va.'<br/>';
					}
					
				}
			}
			$tag .= '</p>';
			//$ouputMaFonction['%%% PLUGIN '.$mat[1].':'.$mat[2].' %%%'] = $maFonction -> output($mat[2]);
		}
		
  }
}
closedir($dossier);

header("Content-Type: text/html; charset=UTF-8");
echo $tag;


?>


