<?php
// Fonction qui chaque jour lit et retourne une nouvelle ligne d'un fichier texte.
// chaque ligne est constitué de deux éléments (le verset et sa référence), séparé par le signe #
// source : http://jquery.malsup.com/cycle/

// ATTENTION : pour la taille des images, il prend comme référence la taille de la première image!

class diaporama{
	
	private $_folder 	= 	'/data/plugin/diaporama/';
	private $_apiKey = '';
	public static $name = 'Diaporama JavaScript';
	public static $desc = 'Affiche un diaporama d\'images';
	//public static $classAppelante = '';
	
	function __construct($theClass=''){
		
		
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
				$data[] = array($fichier => '%%% PLUGIN diaporama:'.$fichier.' %%%');
		  }
		}
		closedir($dossier);
		return $data;
		
	}
	
	
	public function output($string){
		
		
		// Contient les liens pour les fichiers javascript suivant:
		// jquery = link
		// dia = slideshow module jquery
		$fileLink = ROOT_PATH.$this -> _folder.'link.ini';
		
		// configuration spécifique 
		$fileConfig = ROOT_PATH.$this -> _folder.strtolower($string).'/config.txt';
		
		
	 	if(is_file($fileLink) && is_file($fileConfig)){		
			$links = parse_ini_file($fileLink);					// config data
			$jquery = $links['jquery'];
			$diapo = $links['dia'];
			// clef pour localhost
			if(strtolower($_SERVER['HTTP_HOST']) == 'localhost'){
				$jquery = ROOT_URL.$this -> _folder.'jquery-1.5.1.min.jszip';
				$diapo = ROOT_URL.$this -> _folder.'jquery.cycle.all.min.jszip';
				// JQUERY JavaScript FILE
				
				
			}
			
			//-----------FICHIERS JAVASCRIPT---------------------------//
			// JQUERY JavaScript FILE
			ModuleSquelette::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
														   'TYPE'		=> 'text/javascript',
														   'SRC'		=> $jquery)); 
			// SLIDE SHOW JavaScript
			ModuleSquelette::$multiArrayToParse[]=array('script'=>array('LANGAGE' 	=> 'javascript',
														   'TYPE'		=> 'text/javascript',
														   'SRC'		=> $diapo));
														   
			
			//-----------FICHIERS CONFIGURATION---------------------------//
			$config = @file_get_contents($fileConfig);
			ModuleSquelette::$multiArrayToParse[]=array('scriptjs'=>array('CONTENU' 	=> $config));
			
			//-----------FICHIERS PHOTOS---------------------------//
			$folderPath = ROOT_PATH.$this->_folder.strtolower($string).'/images/';
			$dossier = opendir($folderPath);
			$data = '<div class="slideshow">';
			while ($fichier = readdir($dossier)) {
				// On cherche uniquement les dossier
				if($fichier != "." && $fichier != ".." && is_file($folderPath."/".$fichier)) {
					if(!isset($size)){
						$size = getimagesize($folderPath."/".$fichier);
					}
					$data.= '<img src="'.ROOT_URL.$this -> _folder.strtolower($string).'/images/'.$fichier.'" width="'.$size[0].'" height="'.$size[1].'" alt="'.$fichier.'" />';
			  }
			}
			
			$data .= '</div>';
			return $data;
		
		
		}
		return '';

		

		
	}
}
?>