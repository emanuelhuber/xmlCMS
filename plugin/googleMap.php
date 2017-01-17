<?php
// Fonction qui chaque jour lit et retourne une nouvelle ligne d'un fichier texte.
// chaque ligne est constitué de deux éléments (le verset et sa référence), séparé par le signe #
// EXEMPLE D'UTILISATION:
/*
		$filename='./txt/verset.txt';
		$verset_du_jour=afficher_verset_du_jour($filename);
		echo '<p class="cit_bibl">'.$verset_du_jour[0].'</p><p class="ref_bibl">'.$verset_du_jour[1].'</p>';
*/

class googleMap{
	
	private $_folder 	= 	'/data/plugin/googlemap/';
	private $_apiKey = '';

	public static $name = 'Google Map';
	public static $desc = "Affiche une carte googlemap selon un fichier de configuration";
	//public static $classAppelante = '';
	
	function __construct($theClass=''){
		//self::$classAppelante = $theClass;
		//$this->_folder = ROOT_PATH.$this->_folder;
	}
	
	function getInfo(){
		return array('name'=>self::$name,'desc'=>self::$desc);
	}
	
	function listPlug(){
		$folderPath = ROOT_PATH.$this->_folder;
		$dossier = opendir($folderPath);
		$data = array();
		while ($fichier = readdir($dossier)) {
			// On cherche uniquement les dossier
			if($fichier != "." && $fichier != ".." && is_dir($folderPath."/".$fichier)) {
				//echo substr($fichier, 0, -4).'<br/>';
				$data[] = array($fichier => '%%% PLUGIN googleMap:'.$fichier.' %%%');
		  }
		}
		closedir($dossier);
		return $data;
		
	}
	
	
	public function output($string){
		$fileConfig = ROOT_PATH.$this -> _folder.strtolower($string).'/'.strtolower($string).'.js';
		$filePathApiKey = BASE_URL.$this -> _folder.'api.ini';

		$config = @file_get_contents($fileConfig);
		// API GOOGLE
		ModuleSquelette::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> 'http://maps.google.com/maps/api/js?sensor=false'));
		// FICHIER JS
		ModuleSquelette::$multiArrayToParse[]=array('scriptjs'=>array('CONTENU' 	=> $config)); 
	
	
		/* $filePath = BASE_URL.$this -> _folder.strtolower($string).'/'.strtolower($string).'.js';
		$filePathApiKey = BASE_URL.$this -> _folder.'api.ini';
		// API GOOGLE
		ModuleSquelette::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> 'http://maps.google.com/maps/api/js?sensor=false'));
		// FICHIER JS
		ModuleSquelette::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
													   'TYPE'		=> 'text/javascript',
													   'SRC'		=> $filePath));  */
	
	
			
			return '<div id="map"></div>';
		

		

		
	}
}
?>