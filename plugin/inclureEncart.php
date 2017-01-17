<?php
// Fonction qui chaque jour lit et retourne une nouvelle ligne d'un fichier texte.
// chaque ligne est constitué de deux éléments (le verset et sa référence), séparé par le signe #
// EXEMPLE D'UTILISATION:
/*
		$filename='./txt/verset.txt';
		$verset_du_jour=afficher_verset_du_jour($filename);
		echo '<p class="cit_bibl">'.$verset_du_jour[0].'</p><p class="ref_bibl">'.$verset_du_jour[1].'</p>';
*/

class inclureEncart{
	private $_folder 	= 	'/data/plugin/inclureencart/';
	public static $name = 'Inclure un encart';
	public static $desc = "Affiche un encart, par exemple dans la colonne de droite. L'intérêt de ce 
							plugin est que vous pouvez afficher sur plusieurs page le même contenu 
							sans avoir à l'écrire plusieurs fois.";	
	
	function __construct(){
		$this->_folder = ROOT_PATH.$this->_folder;
		
		/* if (is_file($this->_filename)){
			//charge le fichier dans un tableau, dont chaque ligne correspond aux lignes du fichier texte
			if ($tab_file = file($this->_filename)){
				// nombre de lignes du fichier
				$nb_lignes=count($tab_file);
				// calcule la ligne du jour!
				$ligne_du_jour=$this -> _nbJour-$nb_lignes*intval($this -> _nbJour/$nb_lignes);
				$verset_du_jour=explode('#',$tab_file[$ligne_du_jour]);
				
				$this -> _data = array('VERSET_DU_JOUR' 	=>		$verset_du_jour[0],
						'VERSET_DU_JOUR_REF'	=>		$verset_du_jour[1]
				);
			}
		} */
	}
	
	function getInfo(){
		return array('name'=>self::$name,'desc'=>self::$desc);
	}
	
	function listPlug(){
		$dossier = opendir($this->_folder);
		$data = array();
		while ($fichier = readdir($dossier)) {
			// on cherche les fichiers
			if($fichier != "." && $fichier != ".." && !is_dir($this->_folder."/".$fichier)) {
				$name = substr($fichier, 0, -5);
				$data[] = array($name =>  '%%% PLUGIN inclureEncart:'.$name.' %%%');
		  }
		}
		closedir($dossier);
		return $data;
		
	}
	
	function output($string){
		//$argument = explode(',',$string);
		$filePath = $this -> _folder.strtolower($string).'.html';
		if(is_file($filePath)){
			return file_get_contents($filePath);
		}else{
			return null;
		}
		
		

		
	}
}
?>