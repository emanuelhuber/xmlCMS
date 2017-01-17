<?php

class ModuleLivre extends ModuleSquelette{
	
	public $_indexFilePath = '';
	private $_version = '';
	private $_livre = '';
	private $_chapitre = '';
	
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);
		$this -> _dataFilePath = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].'/';
		$this->_indexFilePath  = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].'/index'.$this->_config['ext']['data'];
	}
	
	public function setBreadCrumbs(){
		parent::setBreadCrumbs();
		if(isset($this -> _urlArray[3])){
			self::$multiArrayToParse[]= array('crumbs' => array('REF' 	=> $this -> _idPage.$this->_config['ext']['web'],
																'NAME' 	=> $this -> _activNode -> getAttribute('nom'),
																'TITLE' => $this -> _activNode -> getAttribute('nom'),
																'T_LINK'=> true
															));
			if(isset(self::$arrayToParse['TITRE'] )) self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['TITRE'] ;
		}else{
			self::$arrayToParse['CURRENT_CRUMB'] = $this -> _activNode -> getAttribute('nom');
		}		
	}
	

	public function setParameter(){
		// OUVERTURE DU FICHIER XML PROPRE A LA VERSION (p.ex. segond.xml)
		$domIndex = self::openDomXml($this -> _indexFilePath);
		
		$versionIndex = $domIndex-> getElementsByTagName('version');
		
		// si la version (p.ex. Segond) n'a pas été choisie
		if(!isset($this -> _urlArray[3])){					
			$XPathIndex =  new DOMXPath($domIndex);
			$query = '/page//langue[@id="'.$this -> _langue.'"]';		// We starts from the root element
			$langues = $XPathIndex -> query($query);
			// si y'a une version disponible dans la langue actuelle
			if($langues->length > 0){
				$langues = $langues -> item(0);
				$firstVersion = $langues -> getElementsByTagName('version') -> item(0);
			}
			// Sinon on prend la première version
			else{																		
				$firstVersion = $versionIndex -> item(0);	
			}
			$this -> _version = $firstVersion -> getAttribute('file');
			$this -> _livre = $firstVersion -> getAttribute('livre');
			$this -> _chapitre = $firstVersion -> getAttribute('chapitre');
		}else{																// si une version a été choisie
			$this -> _version = $this -> _urlArray[3];
		}
		if(!$this -> _domData = self::openDomXml($this -> _dataFilePath.$this -> _version.$this->_config['ext']['data'])){
			FrontController::errorMessage('<strong>Page introuvable</strong>');
			FrontController::redirect($_SESSION['langue'].',erreur,404.html');
		}
		$this -> _XPathDomData = new DOMXPath($this -> _domData);
		$this -> _templateNameSquelette = 'squelette';
		
		/* $this -> _domData = self::openDomXml($this -> _dataFilePath.$this -> _version.$this->_config['ext']['data']);
		$this -> _XPathDomData = new DOMXPath($this -> _domData); */
		$dom = $this -> _domData;
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
		
		(isset($this -> _urlArray[4]) && empty($this -> _livre)) ? $this -> _livre = $this -> _urlArray[4] : $this -> _livre = $domPageContenu -> getElementsByTagName('defaut') -> item(0) -> getAttribute('livre') ;
		(isset($this -> _urlArray[5]) && empty($this -> _chapitre)) ? $this -> _chapitre = $this -> _urlArray[5] : $this -> _chapitre = $domPageContenu -> getElementsByTagName('defaut') -> item(0) -> getAttribute('chapitre') ;
		
		// SOMMAIRE DES VERSIONS DISPONIBLES
		 foreach($versionIndex as $version){
			self::$multiArrayToParse[]=array('listeversion'=>array('REF' 	=> $this -> _idPage.','.$version-> getAttribute('file').','.$this -> _livre.','.$this -> _chapitre.$this->_config['ext']['web'],
																	'NOM' 	=> $version-> getAttribute('nom'),
																	'LANGUE' 	=> $version-> getAttribute('lg'),
																	'TITLE' => $version-> getAttribute('nom')));
		}
	}
	
	
	
	public function setData(){
		
		$this->_templateNameModule = 'page';
	
		$this -> _domData = self::openDomXml($this -> _dataFilePath.$this -> _version.$this->_config['ext']['data']);
		$dom = $this -> _domData;
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
	
		//	VARIABLES
		$lienBible = $domPageContenu -> getElementsByTagName('bible') -> item(0) -> getAttribute('chemin');	// DomElement
		$abrBible = $domPageContenu -> getElementsByTagName('bible') -> item(0) -> getAttribute('abr');	// DomElement
		$extBible = $domPageContenu -> getElementsByTagName('bible') -> item(0) -> getAttribute('ext');	// DomElement
		$testamentBible = $domPageContenu -> getElementsByTagName('testament');	// DomElement
		$domPageInfo = $dom-> getElementsByTagName('info')-> item(0);
		
		$myBook = $dom ->getElementById($this -> _livre);
		
		// SOMMAIRE DES LIVRES DE LA BIBLE
		foreach($testamentBible as $testament){
			self::$multiArrayToParse[]=array('testament'=>array('NOM_TESTAMENT' 	=> $testament -> getAttribute('nom')));
			$sectionBible = $testament -> getElementsByTagName('section');
			foreach($sectionBible as $section){
				self::$multiArrayToParse[]=array('testament.section'=>array('NOM_SECTION' 	=> $section  -> getAttribute('nom')));
				$livreBible = $section -> getElementsByTagName('book');
				foreach($livreBible as $livre){
					self::$multiArrayToParse[]=array('testament.section.livre'=>array('NOM_LIVRE' 	=> $livre -> nodeValue,
																					'LIEN_LIVRE'  => $this -> _idPage.','.$this -> _version.','.$livre -> getAttribute('id').',1'.$this->_config['ext']['web']));
				}
			}
		}
		
		self::$arrayToParse['TITLE'] 			.= ', '.$myBook -> textContent.', '.$this -> _chapitre.'';	// Modifie Meta-données
		self::$arrayToParse['TITRE'] 		= $domPageInfo-> getElementsByTagName('titre')-> item(0) -> textContent;
		//self::$arrayToParse['DESCRIPTION'] 	= $domPageInfo-> getElementsByTagName('description')-> item(0) -> textContent;
		self::$arrayToParse['LIVRE'] 		= $myBook -> textContent;
		self::$arrayToParse['CHAPITRE'] 		=  $this -> _chapitre;


		$url_du_fichier=$this -> _dataFilePath.$lienBible.'/'.$abrBible.'-'.$myBook -> getAttribute('bshort').$extBible;
		
		// SOMMAIRE DES CHAPITRES DU LIVRE ACTUEL
		if($handle = @fopen($url_du_fichier, "r")){
			$ligne = fgets($handle, 4096);
			$ligne = explode('#',$ligne,4); // la première ligne contient le nombre de chapitre!!
			for($i=1; $i<=$ligne[3]; $i++){
				if($i==$this -> _chapitre){
					$lienActif='actif';
				}else{
					$lienActif='passif';
				}
				self::$multiArrayToParse[]=array('listechapitre'=>array('ACTIF'		=> 	$lienActif,
																		'LIEN_CHAPITRE' => $this -> _idPage.','.$this -> _version.','.$myBook -> getAttribute('id').','.$i.$this->_config['ext']['web'],
																		'NO_CHAPITRE' 	=> 	$i)); 
			} 
			while (!feof($handle)) {
				$ligne = fgets($handle, 4096);
				$ligne = explode('#',$ligne,4);
				if(isset($ligne[1])){
					if($ligne[1]==$this -> _chapitre){
						self::$multiArrayToParse[]=array('chapitre'=>array('NOVERSET' 	=> $ligne[2],
																			'VERSET' 	=> $ligne[3]));
					}
				}
			 }
		}
		
	}
}


?>