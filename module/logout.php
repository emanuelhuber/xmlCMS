<?php



/*
*********************************************
*************  IDEES ************************
*********************************************

Quand l'utilisateur est connecté, on peut
transmettre un identifiant aléatoire dans
l'url (ou bien cookie) qui sera en plus
testé!

*/




















class ModuleLogout extends ModuleSquelette{

	private static $traitement	= '';
	
	public function __construct($url, $query, $urlArray, $conf){
		$this -> _config = $conf;
		$this -> _dataFilePath = $this->_config['path']['data'].'login/'.$urlArray[2].$this->_config['ext']['data'];
	}
	
	public function launchAction(){
		require($this->_config['librairie']['template']);	// classe de template
		
		//--MODULE--//
		$this->setParameter();						// ouvre le fichier de données de la page
		// $rights = $this->getRights();
		
	
		//--MODULE-DATA--//
		// $this->setMetaData($this -> _domData);		// Meta data - modifie self::$arrayToParse
		// $this->setCSS($this -> _domData);			// CSS - modifie self::$multiArrayToParse
		$this->setData();		// Data page
		// $this->setTranslation();
		
		//--ARBORESCENCE--//
		// $this -> _domArborescence = self::openDomXml($this -> _arboFilePath);
		// $this -> _XPathArborescence = new DOMXPath($this -> _domArborescence);

		// $this->setActivNode();						// Source: _domArborescence
		// 	$this->setLangue();							// Source: _domArborescence, Langue ...
		// 	$this->setMenu();
		
		/* $this->setBreadCrumbs(); */
		
		//--TEMPLATE--//
		// $this -> _template = new Template('./');
		// $this->setTemplate($this -> _domData, 'squelette');				// Template squelette
		// $this->setTemplate($this -> _domData, $this->_templateNameModule);	// Template module
		

		
		
		
		//--PARSAGE & RECUPERATION DU CONTENU--//
		// $this->parseTemplate(self::$arrayToParse,self::$multiArrayToParse);	// parsage des blocs
		// $this -> combineTemplate($this->_templateNameModule);			// inclusion du template module dans le template squelette
		// $this -> _template -> pparse('squelette'); 				// affichage
		 $this->_content = ob_get_contents();					// recuperation du contenu bufferisé
		 ob_end_clean();		 // nettoyage du buffer
		
		echo $this->_content;
		
		//--AFFICHAGE--//											// possible modification de l'expiration
		//self::$expireHtml = 60*60*24*40;							// du cache HTML
		//self::printOut($this->_content,self::$outputFormat,$this -> _url);		// affichage en mode HTML
		
		//--CACHE--//
		//self::$cacheTime = 60*60*24;											// possible modification de la validité du cache HTML
		// if(self::$cacheTime > 0){
		// 	self::htmlCache($this->_content,$this -> _url,self::$cacheTime);		// mise en cache html
		// }
		//--POST-ACTION--//
		//$this->postAction($content);
	}
	
	public function setData(){
		$dom = $this -> _domData;
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
		
		$this->_templateNameModule = 'page';

		

		
		
		
		// On détruit les variables de notre session
		
		
		/*
		*********************************************
		*************  IDEES ************************
		*********************************************

		Ecrire dans le fichier xml
		si l'utilisateur s'est
		déloggé !

		*/
		
		// chemin du fichier contenant les données sur les utilisateurs
	/* 	$usersPath = $domPageContenu -> getElementsByTagName('data') -> item(0) -> getAttribute('file');
		$usersDom = self::openDomXml($usersPath);	// ouvre le fichier
		$usersXPath = new DOMXPath($usersDom); */
		$query = '//user[@login="'.$_SESSION['login']['username'].'"]';		// requête
		$user = $this -> _XPathDomData  -> query($query);
		
		echo '<h1>DECONNECTION</h1>';
		
		if($user->length !=0){		// si un user avec ce nom d'utilisateur a été trouvé
			$user->item(0)->setAttribute('logout','1');
			$this->saveMyXML($this -> _domData,$this -> _dataFilePath);
/* 			echo '<br/>';
			echo $user->item(0)->getAttribute('login');
			echo '<br/>';
			echo '<br/>';
			echo $user->item(0)->getAttribute('logout');
			echo '<br/>'; */
		}
		
		session_destroy();
		session_unset ();
		

		$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
		header('location: http://'.$host.'/'); 
		exit();  
		
	}


}

?>