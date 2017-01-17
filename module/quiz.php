<?php


class ModuleQuiz extends ModuleSquelette{
	
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
				$template->assign_block_vars('article',array('TITRE' 		=> 'Recherche impossible, désolé!!!'));
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
						
		}else{
			self::$expireHtml = 0;	// pas de cache navigateur
			self::$cacheTime = 0;	// pas de cache HTML

			
			
			$titre = $this -> _domData->getElementsByTagName('titre')  -> item(0) -> nodeValue;
			
			if($this->_config['urlRewriting']['type']==1){
				self::$arrayToParse['FICHIER_CIBLE'] = $this->_config['urlRewriting']['cible'] ;				// nom_fichier().'.php?quiz='.$_GET['quiz'];
				$_SESSION['cible']=	$this -> _url.'.html' ;
			}else{
				self::$arrayToParse['FICHIER_CIBLE'] = $this -> _url.'.html' ;				// nom_fichier().'.php?quiz='.$_GET['quiz'];
			}
			

			if(!isset($_SESSION['no_question']) Or !isset($_SESSION['quiz'])){
				$_SESSION['no_question']=0;
				$_SESSION['nb_bonne_reponse']=0;
				$_SESSION['quiz']=$this -> _url ;
			}elseif($_SESSION['quiz']!=$this -> _url ){
				$_SESSION['no_question']=0;
				$_SESSION['quiz']=$this -> _url ;
				$_SESSION['nb_bonne_reponse']=0;
			}
			
			$listQuiz = $this -> _domData->getElementsByTagName('quiz');			// DomNodeList
			$nbQuestion = $listQuiz ->  length;
		
		// RESULTAT GENERAL DU QUIZ
			if($_SESSION['no_question']>=$nbQuestion){		
				// Template page
				$this->_templateNameModule='resultat';
				self::$arrayToParse['NB_BONNE_REPONSE']	=	$_SESSION['nb_bonne_reponse'];
				self::$arrayToParse['NB_QUESTION']		=	$nbQuestion;
				self::$arrayToParse['TITRE']			=	$titre;
				
				$_SESSION['no_question']=0;
				$_SESSION['nb_bonne_reponse']=0;
				
		// LECTURE DU FICHIER POUR LE QUIZ
			}else{
				$quiz = $listQuiz -> item($_SESSION['no_question']);					// DomElement	
				if($quiz->hasChildNodes() == true){
					$list_fils = $quiz -> childNodes;				// DomNodeList
					$question = $quiz -> getElementsByTagName('question') -> item(0) -> firstChild -> data;
					$reponses = $quiz -> getElementsByTagName('reponses') -> item(0);
					$reponses = $reponses -> getElementsByTagName('item');
					$explication = $quiz->getElementsByTagName('explication') -> item(0) -> firstChild -> data;	// DomNodeList
				}else{
					echo 'le noeud n\'a pas d\'enfants!!!';
				}	
				// AFFICHAGE DE LA SOLUTION + COMPTAGE DES POINTS
				if(isset($_POST['answer'])){
					//echo '<img class="quiz" alt="Résultat" src="design/images/fleche_droite_rouge.gif"/> ';
					if($_POST['answer']==1){
						$resultat = 'Bonne réponse!';
						$_SESSION['nb_bonne_reponse']++;
					}elseif($_POST['answer']==0){
						$resultat = 'Mauvaise réponse!';
					}
					// echo 'Yep!!!';
					// On assigne a un alias "test" le nom du fichier .tpl qu'on compte utiliser
				
					$this->_templateNameModule='reponse';
					self::$arrayToParse['QUESTION_NO']	=	$_SESSION['no_question']+1;
					self::$arrayToParse['QUESTION_NB']	=	$nbQuestion;
					self::$arrayToParse['RESULTAT']		=	$resultat;
					self::$arrayToParse['EXPLICATION']	=	$explication;
					self::$arrayToParse['TITRE'] 		=	$titre;
				
					$_SESSION['no_question']++;

				// AFFICHAGE DU QUESTIONNAIRE
				}elseif(!isset($_POST['answer'])){	
					// Template page
					
					$this->_templateNameModule='question';
					self::$arrayToParse['QUESTION_NO']=	$_SESSION['no_question']+1;
					self::$arrayToParse['QUESTION_NB']=	$nbQuestion;
					self::$arrayToParse['QUESTION']=	$question;
					self::$arrayToParse['TITRE']=	$titre;
					$i=0;
					$reponseArray = array();
					foreach($reponses as $reponse){
						if($reponse->getAttribute('ok')=='1'){
							$vrai_ou_faux=1;	//bonne réponse
						}else{
							$vrai_ou_faux=0;	// mauvaise réponse!
						}
						self::$multiArrayToParse[]=array('reponses'=> array('NO' 	=> $vrai_ou_faux,
																		'ID'  		=> 'answer'.$i,
																		'REPONSE' 	=> $reponse -> nodeValue
																		));
						$i++;
					}
				}
			}
			
			$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
			$domPageContenuPrincipal = $domPageContenu -> getElementsByTagName('principal') -> item(0) -> textContent;	// DomElement
			$domPageContenuSecondaire = $domPageContenu -> getElementsByTagName('secondaire') -> item(0) -> textContent;	// DomElement
			self::$arrayToParse['CONTENU'] = $this->parseContenu($domPageContenuPrincipal);
			self::$arrayToParse['CONTENU_SECONDAIRE'] = $this->parseContenu($domPageContenuSecondaire);	
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
		
		/* 
		 */
			
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

	
	
?>