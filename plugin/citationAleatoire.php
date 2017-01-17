<?php
// Fonction qui chaque jour lit et retourne une nouvelle ligne d'un fichier texte.
// chaque ligne est constitué de deux éléments (le verset et sa référence), séparé par le signe #
// EXEMPLE D'UTILISATION:
/*
		$filename='./txt/verset.txt';
		$verset_du_jour=afficher_verset_du_jour($filename);
		echo '<p class="cit_bibl">'.$verset_du_jour[0].'</p><p class="ref_bibl">'.$verset_du_jour[1].'</p>';
*/

class citationAleatoire{
	private $_folder 	= 	'/data/plugin/citationaleatoire/';
	private $_nbJour	=	false;
	private $_data		= array();
	public static $name = 'Citations Aléatoires';
	public static $desc = "A partir d'une liste de versets et référence, affiche le verset du jour 
						ainsi que sa référence là où vous voulez.";
	
	function __construct(){
		$this -> _nbJour = @date('z')+1;
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
				//echo substr($fichier, 0, -4).'<br/>';
				$name = substr($fichier, 0, -4);
				$data[] = array($name => array('citation' => '%%% PLUGIN citationAleatoire:'.$name.';1 %%%',
												 'reference' => '%%% PLUGIN citationAleatoire:'.$name.';2 %%%'));
		  }
		}
		closedir($dossier);
		return $data;
	}
	
	function output($string){
		$ar = explode(';',$string);
		if(count($ar>1)){
			$fileName = $ar[0];
			$id = $ar[1]-1;

			
			$filePath = $this->_folder.$fileName.'.txt';
			if (is_file($filePath)){
		
				//charge le fichier dans un tableau, dont chaque ligne correspond aux lignes du fichier texte
				if ($tab_file = file($filePath)){
					// nombre de lignes du fichier
					$nb_lignes=count($tab_file);
					// calcule la ligne du jour!
					$ligne_du_jour=$this -> _nbJour - $nb_lignes * intval($this -> _nbJour/$nb_lignes);
					$citation= explode('#', $tab_file[$ligne_du_jour]);
					if(isset($citation[$id])){
						return $citation[$id];
					}
				}
			}
		}

		return null;
		
	}
}
?>