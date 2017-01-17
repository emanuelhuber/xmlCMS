<?php


class ModuleGallerie extends ModuleSquelette{
	
	public $_dataFolderPath = '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		$this -> _dataFolderPath = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].'/00-';
		if(isset($urlArray[3])){	// si un article est demandé
			$this -> _dataFilePath = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].'/'.$urlArray[3].$this->_config['ext']['data'];
		}else{
			$this -> _dataFilePath = $this -> _dataFolderPath.'index'.$this->_config['ext']['data'];
			
		}
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

	public function setData(){
		$dom = $this -> _domData;
		
		$domPageInfo = $dom-> getElementsByTagName('info')-> item(0);
		self::$arrayToParse['TITRE'] 				=	$domPageInfo-> getElementsByTagName('titre')-> item(0) -> nodeValue;
		self::$arrayToParse['CHAPEAU'] 				=	$dom -> getElementsByTagName('chapeau') -> item(0) -> nodeValue;
		self::$arrayToParse['CONTENU_SECONDAIRE'] 	=	$dom -> getElementsByTagName('secondaire') -> item(0) -> nodeValue;
		self::$arrayToParse['LIEN_TOUS_LES_ARTICLES']=	$this -> _idPage.$this->_config['ext']['web'];
		
		if(isset($this -> _urlQuery['sort'])){
			//self::$expireHtml = 0;	// pas de cache navigateur
			self::$cacheTime = 0;	// pas de cache HTML
			
			$this->_templateNameModule = 'index';
			if($this -> _urlQuery['sort']=='annee' or $this -> _urlQuery['sort']=='mois'){
				$ficherIndex = 'date';
			}elseif($this -> _urlQuery['sort']=='auteur' or $this -> _urlQuery['sort']=='motclef'){
				$ficherIndex = $this -> _urlQuery['sort'];
			}else{
				self::$multiArrayToParse[]=array('article',array('TITRE' 		=> 'Recherche impossible, désolé!!!'));
			}
			
			$pathIndex = $this -> _dataFolderPath.$ficherIndex.$this->_config['ext']['data'];
			
			if($domIndex=self::openDomXml($pathIndex)){
				//self::openDomXml($pathIndex)
				$index = $domIndex -> getElementById($this -> _urlQuery['article']);
				if(isset($index) && $index!= null){
					$critere = $index -> getAttribute('nom');
					// Affichage de la liste d'article
					$this->articlesListe($index,$this -> _idPage);
					self::$arrayToParse['MESSAGE'] 	=  'Critères de recherche : '.$this -> _urlQuery['sort'].' = '.$critere;
				}else{
					self::$arrayToParse['MESSAGE'] 	=  'Pas d\'articles correspondant aux critères de recherche.';
				}
			}else{
				echo 'J arrive pas à ouvrir le fichier...  '.$pathIndex.'<br/>';
			}

			/*
			
			
			*/
		
		// si aucun article spécifique n'est demandé
		}elseif(!isset($this -> _urlArray[3])){	
			$this->_templateNameModule = 'index';
			// Affichage de la liste d'article
			$domPrincipal = $dom -> getElementsByTagName('principal') -> item(0);
			$this->articlesListe($domPrincipal,$this -> _idPage);
		
		// AFFICHAGE DE L'ARTICLE (gallerie)
		}else{
			$nb_miniature = $dom -> getElementsByTagName('configuration') -> item(0) -> getAttribute('nb_miniature');
			define('NB_MINIATURE', $nb_miniature);
	
	
			$this->_templateNameModule = 'gallerie';
			
			$domPageInfo = $dom-> getElementsByTagName('info')-> item(0);
			self::$arrayToParse['TITRE'] 				=	$domPageInfo-> getElementsByTagName('titre')-> item(0) -> nodeValue;
			self::$arrayToParse['CHAPEAU'] 				=	$dom -> getElementsByTagName('chapeau') -> item(0) -> nodeValue;
			self::$arrayToParse['CONTENU_SECONDAIRE'] 	=	$dom -> getElementsByTagName('secondaire') -> item(0) -> nodeValue;
			
			$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);
			$galleriePhoto = $domPageContenu -> getElementsByTagName('photo');
			
			$nbPhoto = $galleriePhoto -> length;
			
			// DETERMINATION DE LA PHOTO ACTIVE
			if(isset($this -> _urlArray[4]) && $this -> _urlArray[4]!=null){
				$photoActive = $dom -> getElementById($this -> _urlArray[4]);
				if($photoActive == null){
					$photoActive = $galleriePhoto->item(0);
				}
			}else{
				$photoActive = $galleriePhoto->item(0);	
			}

			// INDEX DU NOEUD ACTIF
			$i=0;
			foreach($galleriePhoto as $photo){
				if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
					$itemPhotoActive = $i;
				}
				$i++;
			}

			// LA MINIATURE CORRESPONDANT A LA PHOTO AFFICHEE VOIT SA CLASSE DEVENIR "actif"
			// AFFICHAGE DES MINIATURES
			if($nbPhoto<=NB_MINIATURE){
				for($i=0;$i < $nbPhoto; $i++) {
					$photo = $galleriePhoto->item($i);
					if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
						$classeMiniature = 'actif';
					}else{
						$classeMiniature = 'passif';
					}
					$this -> setGallerie($photo,$classeMiniature);
				}
			}else{
				if($itemPhotoActive >= NB_MINIATURE && $itemPhotoActive-1< $nbPhoto-NB_MINIATURE){
					for($i=$itemPhotoActive;$i < $itemPhotoActive+NB_MINIATURE; $i++) {
						$photo = $galleriePhoto->item($i);
						if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
							$classeMiniature = 'actif';
						}else{
							$classeMiniature = 'passif';
						}
					$this -> setGallerie($photo,$classeMiniature);
					}
				
				
				}elseif($itemPhotoActive < NB_MINIATURE){
					for($i=0;$i < NB_MINIATURE; $i++) {
						$photo = $galleriePhoto->item($i);
						if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
							$classeMiniature = 'actif';
						}else{
							$classeMiniature = 'passif';
						}
					$this -> setGallerie($photo,$classeMiniature);
					}
				}elseif($itemPhotoActive-1>=$nbPhoto-NB_MINIATURE){
					for($i=$nbPhoto-NB_MINIATURE;$i < $nbPhoto; $i++) {
						$photo = $galleriePhoto->item($i);
						if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
							$classeMiniature = 'actif';
						}else{
							$classeMiniature = 'passif';
						}
					$this -> setGallerie($photo,$classeMiniature);
						
					}
				}
			}
			
			
			
			
			// FLECHES DE NAVIGATION
			if($itemPhotoActive == 0){
				$photoPrecedante = $galleriePhoto->item(0);
				$photoSuivante 	 = $galleriePhoto->item(1);
				$classePrecedante = 'passif';
				$classeSuivante = 'actif';
			}elseif($itemPhotoActive == $nbPhoto-1){
				$photoPrecedante = $galleriePhoto->item($nbPhoto-2);
				$photoSuivante 	 = $galleriePhoto->item($nbPhoto-1);			
				$classePrecedante = 'actif';
				$classeSuivante = 'passif';
			}else{
				$photoPrecedante = $galleriePhoto->item($itemPhotoActive-1);
				$photoSuivante 	 = $galleriePhoto->item($itemPhotoActive+1);				
				$classePrecedante = 'actif';
				$classeSuivante = 'actif';
			}


			
			
			self::$arrayToParse['PHOTO_TITRE']				=	$photoActive->getAttribute('titre');
			self::$arrayToParse['PHOTO_LIEN']				=	BASE_URL.$this->_config['path']['data'].$this -> _urlArray[1].'/'.$this -> _urlArray[2].'/'.$this -> _urlArray[3].'/'.$photoActive->getAttribute('file');
			self::$arrayToParse['PHOTO_PRECEDANTE']			=	 $this->_idPage.','.$this -> _urlArray[3].','.$photoPrecedante->getAttribute('id').$this->_config['ext']['web'];
			self::$arrayToParse['PHOTO_SUIVANTE']			=	 $this->_idPage.','.$this -> _urlArray[3].','.$photoSuivante->getAttribute('id').$this->_config['ext']['web'];
			self::$arrayToParse['CLASSE_PHOTO_PRECEDANTE']	=	$classePrecedante;
			self::$arrayToParse['CLASSE_PHOTO_SUIVANTE']		=	$classeSuivante;
				
		
		}
		
		// index --> panneau latéral
		$categorie = array('auteur','motclef');
		foreach($categorie as $cat){
			$this -> indexCategorie($cat, $this -> _dataFolderPath,$this -> _idPage);
		}
		$categorie = array('date');
		foreach($categorie as $cat){
			$this -> indexCategorieSpecial($cat, $this -> _dataFolderPath,$this -> _idPage);
		}
		
	}
	
	private function setGallerie($photo,$classeMiniature){
		self::$multiArrayToParse[]=array('miniature'=>array('TITRE' 	=> $photo->getAttribute('titre'),
															'LIEN'  	=> $this->_idPage.','.$this -> _urlArray[3].','.$photo->getAttribute('id').$this->_config['ext']['web'],
															'CLASSE'  	=> $classeMiniature,
															'MINIATURE_LIEN'	=> BASE_URL.$this->_config['path']['data'].$this -> _urlArray[1].'/'.$this -> _urlArray[2].'/'.$this -> _urlArray[3].'/miniature/'.$photo->getAttribute('file')
			));
	}
	
	
	
	function retournerArticleComplet($domArticle){
		$domArticleInfo = $domArticle -> getElementsByTagName('info') -> item(0);
		$dateArt = $domArticleInfo -> getElementsByTagName('date') -> item(0) -> nodeValue;
		$maDate = $this->afficherDate($dateArt,$_SESSION['langue'],$nomJour=1,$moisAbrev=1);
		
		self::$arrayToParse['TITRE'] = $domArticleInfo -> getElementsByTagName('titre') -> item(0) -> nodeValue;
		self::$arrayToParse['AUTEUR'] = $domArticleInfo -> getElementsByTagName('auteur') -> item(0) -> nodeValue;
		self::$arrayToParse['CHAPEAU'] = $domArticle -> getElementsByTagName('chapeau') -> item(0) -> nodeValue;
		self::$arrayToParse['CONT'] = $domArticle -> getElementsByTagName('principal') -> item(0) -> nodeValue;
		self::$arrayToParse['NOM_JOUR'] = $maDate[0];
		self::$arrayToParse['JOUR'] = $maDate[1];
		self::$arrayToParse['MOIS'] = $maDate[2];
		self::$arrayToParse['ANNEE'] = $maDate[3];
		self::$arrayToParse['DATE'] = $dateArt;

	}
	
	function articlesListe($noeud,$namePage){
		$articles = $noeud -> getElementsByTagName('article')  ;
		foreach($articles as $elt){
			$lien = '<a href="'.$namePage.',';
			$lien .= $elt -> getAttribute('id');
			$lien .= $this->_config['ext']['web'].'">Suite</a>';
			$dateArt = $elt -> getAttribute('date');
			$maDate = $this->afficherDate($dateArt,$_SESSION['langue'],$nomJour=1,$moisAbrev=1);
			self::$multiArrayToParse[]=array('article'=>array('TITRE' 		=> $elt -> getAttribute('titre'),
															'AUTEUR'  		=> $elt -> getAttribute('auteurnom'),
															'NOM_JOUR'  	=> 	$maDate[0],
															'JOUR'			=>  $maDate[1],
															'MOIS'			=> 	$maDate[2],
															'ANNEE' 		=> 	$maDate[3],
															'DATE'  		=> $elt -> getAttribute('date'),
															'DESCRIPTION'  	=> $elt -> getElementsByTagName('description') -> item(0) -> nodeValue,
															'LIEN'			=> $lien
															));
		}
	}
	
	
	function indexCategorie($cat, $cheminDossierArticle,$namePage){
		//$domCategories = new DomDocument();
		$cheminFichier[$cat] = $cheminDossierArticle.$cat.$this->_config['ext']['data'];
		$domCategories=self::openDomXml($cheminFichier[$cat]);		//chargement du fichier
		
		$categories = $domCategories -> getElementsByTagName('contenu') -> item(0);	// DomElement
		$categories = $categories -> getElementsByTagName($cat)  ;
		
		self::$multiArrayToParse[]= array('categorie' => array('TIT' => $domCategories-> getElementsByTagName('titre') -> item(0) -> nodeValue));
		
		foreach($categories as $aut){
			self::$multiArrayToParse[]= array('categorie.element' => array('NOM' 	=> $aut -> getAttribute('nom'),
																		'LIEN'	=>	$namePage.$this->_config['ext']['web'].'?sort='.$aut ->nodeName.'&article='.$aut -> getAttribute('id'),
																		'NOMBRE'  => $aut -> getElementsByTagName('article') -> length
																		));
		}
	}
	
	// pour les dates
 	function indexCategorieSpecial($cat, $cheminDossierArticle,$namePage){
		//$domCategories = new DomDocument();
		$cheminFichier[$cat] = $cheminDossierArticle.$cat.$this->_config['ext']['data'];
		$domCategories=self::openDomXml($cheminFichier[$cat]);		//chargement du fichier
		
		$categories = $domCategories -> getElementsByTagName('contenu') -> item(0);	// DomElement
		$domAnnees = $categories -> getElementsByTagName('annee')  ;
		
		self::$multiArrayToParse[]= array('categorie'=>array('TIT' => $domCategories-> getElementsByTagName('titre') -> item(0) -> nodeValue));
		
		foreach($domAnnees as $annee){
			self::$multiArrayToParse[]= array('categorie.element' => array('NOM' 	=> $annee -> getAttribute('nom'),
																	'LIEN'		=>	$namePage.$this->_config['ext']['web'].'?sort='.$annee ->nodeName.'&article='.$annee -> getAttribute('id'),
																	'NOMBRE'  	=> $annee -> getElementsByTagName('article') -> length
																	));
			if($annee->hasChildNodes()){
				foreach($annee->childNodes as $month){
					if($month->nodeName != '#text'){
						self::$multiArrayToParse[]= array('categorie.element.fils' => array('NOM' 		=> $month -> getAttribute('nom'),
																						'LIEN'		=>	$namePage.$this->_config['ext']['web'].'?sort='.$month ->nodeName.'&article='.$month -> getAttribute('id'),
																						'NOMBRE'  	=> $month -> getElementsByTagName('article') -> length
																						)); 
					
					}
				}
			}
		}
	} 
	
	
		
}

/* 



define('NB_MINIATURE',	'4');

// nom du fichier
$cheminFichier['page'] = CHEMIN_DATA.$_GET['module'].'/'.$_GET['id'].'/'.$_GET['id'].EXT;
// nom de la page ou de la page mère (pour le menu)
$namePage = $_GET['module'].'-'.$_GET['id'];
$idPage = $_GET['id'];

include(CHEMIN_SQUELETTE);

	$tplArticle =  $domPageDesign -> getAttribute('gallerie');
	$template->set_filenames(array('page' => CHEMIN_DESIGN.$tplNom.'/'.$tplArticle));	

	
	$template->assign_vars(array(
				'TITRE'		=>	$domPageInfo -> getElementsByTagName('titre') -> item(0) -> nodeValue,
				'CHAPEAU'	=>	$domPage -> getElementsByTagName('chapeau') -> item(0) -> nodeValue,
				'CONTENU_SECONDAIRE' => $domPage -> getElementsByTagName('secondaire') -> item(0) -> textContent
			));

	$domPageContenu = $domPage -> getElementsByTagName('contenu') -> item(0);
	$galleriePhoto = $domPageContenu -> getElementsByTagName('photo');
	
	$nbPhoto = $galleriePhoto -> length;
	echo $nbPhoto;
	
	
	// DETERMINATION DE LA PHOTO ACTIVE
	if(isset($_GET['par1']) && $_GET['par1']!=null){
		$photoActive = $domPage -> getElementById($_GET['par1']);
		if($photoActive == null){
			$photoActive = $galleriePhoto->item(0);
		}
	}else{
		$photoActive = $galleriePhoto->item(0);	
	}

	// INDEX DU NOEUD ACTIF
	$i=0;
	foreach($galleriePhoto as $photo){
		if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
			$itemPhotoActive = $i;
		}
		$i++;
	}

	// LA MINIATURE CORRESPONDANT A LA PHOTO AFFICHEE VOIT SA CLASSE DEVENIR "actif"
	// AFFICHAGE DES MINIATURES
	if($nbPhoto<=NB_MINIATURE){
		for($i=0;$i < $nbPhoto; $i++) {
			$photo = $galleriePhoto->item($i);
			if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
				$classeMiniature = 'actif';
			}else{
				$classeMiniature = 'passif';
			}
			$template->assign_block_vars('miniature',array('TITRE' 	=> $photo->getAttribute('titre'),
														'LIEN'  	=> $_GET['module'].'-'.$_GET['id'].','.$photo->getAttribute('id').EXT_WEB,
														'CLASSE'  	=> $classeMiniature,
														'MINIATURE_LIEN'	=> CHEMIN_GALLERIE.$_GET['id'].'/miniature/'.$photo->getAttribute('file')
			));
		}
	}else{
		if($itemPhotoActive >= NB_MINIATURE && $itemPhotoActive-1< $nbPhoto-NB_MINIATURE){
			for($i=$itemPhotoActive;$i < $itemPhotoActive+NB_MINIATURE; $i++) {
				$photo = $galleriePhoto->item($i);
				if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
					$classeMiniature = 'actif';
				}else{
					$classeMiniature = 'passif';
				}
				$template->assign_block_vars('miniature',array('TITRE' 	=> $photo->getAttribute('titre'),
															'LIEN'  	=> $_GET['module'].'-'.$_GET['id'].','.$photo->getAttribute('id').EXT_WEB,
															'CLASSE'  	=> $classeMiniature,
															'MINIATURE_LIEN'	=> CHEMIN_GALLERIE.$_GET['id'].'/miniature/'.$photo->getAttribute('file')
				));
			}
		
		
		}elseif($itemPhotoActive < NB_MINIATURE){
			for($i=0;$i < NB_MINIATURE; $i++) {
				$photo = $galleriePhoto->item($i);
				if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
					$classeMiniature = 'actif';
				}else{
					$classeMiniature = 'passif';
				}
				$template->assign_block_vars('miniature',array('TITRE' 	=> $photo->getAttribute('titre'),
															'LIEN'  	=> $_GET['module'].'-'.$_GET['id'].','.$photo->getAttribute('id').EXT_WEB,
															'CLASSE'  	=> $classeMiniature,
															'MINIATURE_LIEN'	=> CHEMIN_GALLERIE.$_GET['id'].'/miniature/'.$photo->getAttribute('file')
				));
			}
		}elseif($itemPhotoActive-1>=$nbPhoto-NB_MINIATURE){
			for($i=$nbPhoto-NB_MINIATURE;$i < $nbPhoto; $i++) {
				$photo = $galleriePhoto->item($i);
				if($photo->getAttribute('id') == $photoActive->getAttribute('id')){
					$classeMiniature = 'actif';
				}else{
					$classeMiniature = 'passif';
				}
				$template->assign_block_vars('miniature',array('TITRE' 	=> $photo->getAttribute('titre'),
															'LIEN'  	=> $_GET['module'].'-'.$_GET['id'].','.$photo->getAttribute('id').EXT_WEB,
															'CLASSE'  	=> $classeMiniature,
															'MINIATURE_LIEN'	=> CHEMIN_GALLERIE.$_GET['id'].'/miniature/'.$photo->getAttribute('file')
				));
			}
		}
	
	
	}




	
	
// FLECHES DE NAVIGATION
	if($itemPhotoActive == 0){
		$photoPrecedante = $galleriePhoto->item(0);
		$photoSuivante 	 = $galleriePhoto->item(1);
		$classePrecedante = 'passif';
		$classeSuivante = 'actif';
	}elseif($itemPhotoActive == $nbPhoto-1){
		$photoPrecedante = $galleriePhoto->item($nbPhoto-2);
		$photoSuivante 	 = $galleriePhoto->item($nbPhoto-1);			
		$classePrecedante = 'actif';
		$classeSuivante = 'passif';
	}else{
		$photoPrecedante = $galleriePhoto->item($itemPhotoActive-1);
		$photoSuivante 	 = $galleriePhoto->item($itemPhotoActive+1);				
		$classePrecedante = 'actif';
		$classeSuivante = 'actif';
	}


	
	
	$template->assign_vars(array(
			'PHOTO_TITRE'		=>	$photoActive->getAttribute('titre'),
			'PHOTO_LIEN'	=>	CHEMIN_GALLERIE.$_GET['id'].'/'.$photoActive->getAttribute('file'),
			'PHOTO_PRECEDANTE' => $_GET['module'].'-'.$_GET['id'].','.$photoPrecedante->getAttribute('id').EXT_WEB,
			'PHOTO_SUIVANTE' => $_GET['module'].'-'.$_GET['id'].','.$photoSuivante->getAttribute('id').EXT_WEB,
			'CLASSE_PHOTO_PRECEDANTE' =>  $classePrecedante,
			'CLASSE_PHOTO_SUIVANTE' => $classeSuivante
		));
	
	
 $template->assign_var_from_handle('PAGE', 'page');
	
	 */ 
	
	

?>