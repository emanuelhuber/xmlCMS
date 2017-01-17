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




















class ModuleLogIn extends ModuleSquelette{

/* 	private static $traitement	= '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);
		
		//$this -> _dataFilePath = $this->_config['path']['data'].$urlArray[1].'/bettina-mikael'.$this->_config['ext']['data'];
		if(isset($urlArray[3])){
			self::$traitement = 	$urlArray[3];
		}
		
	} */
	
	public function setData(){
		$dom = $this -> _domData;
		
		$this->_templateNameModule = 'page';
		
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
		$message = null;
		if($this -> _urlQuery['action'] == 'out'){
			$query = '//user[@username="'.$_SESSION['login']['username'].'"]';		// requête
			$user = $this -> _XPathDomData  -> query($query);
		
			echo '<h1>DECONNECTION</h1>';
			
			if($user->length !=0){		// si un user avec ce nom d'utilisateur a été trouvé
				$user->item(0)->setAttribute('logout','1');
				$this->saveMyXML($this -> _domData,$this -> _dataFilePath);
			}
			session_destroy();
			session_unset ();
			
			$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
			header('location: http://'.$host.'/'); 
			exit();  
		
		}else{
			if(isset($_POST['token']) 					// si le token (jeton) est envoyé avec le formulaire
			// on pourrait aussi vérifier le http_referer (mais pas forcément fiable)
				&& !empty($_POST['username']) 			// si l'username et le
				&& !empty($_POST['password'])			// password sont envoyés avec le formulaire
				&& $_POST['token'] == $_SESSION['token'] 	// si le token correspond au token de la Session
				&& isset($_SERVER['HTTP_USER_AGENT'])){		// si on sait quel navigateur est utilisé
				
				$formulaire_valide=false;					// valeur par défaut
				/*
				==========================
				Remplacer time() par $_SERVER['time']
				==========================
				
				*/
				
				if((time() - $_SESSION['token_time']) <60*5){	// si le temps pour remplir le formulaire n'excède pas 5 min
					// chemin du fichier contenant les données sur les utilisateurs
					$query = '//user[@username="'.$_POST['username'].'"]';		// requête
					$user = $this -> _XPathDomData -> query($query);
					
					if($user->length !=0){		// si un user avec ce nom d'utilisateur a été trouvé
						$userLogin = $user->item(0)->getAttribute('username');
						$userPassword = $user->item(0)->textContent;
						// si le nom d'utilisateur & le password sont bon!
						if($userLogin == $_POST['username'] && $userPassword == $_POST['password']){
							$formulaire_valide=true;
							
							// on regénère la session
							session_regenerate_id(true);
							
							$_SESSION['login']=array();
							//$_SESSION['login']['password']=$userPassword;
							$_SESSION['login']['username']=$userLogin;
							$_SESSION['login']['droits']=$user->item(0)->getAttribute('droits');
							
							// Utilisant l'adresse IP n'est pas vraiment la meilleure idée dans mon expérience. 
							// Par exemple, mon bureau a deux adresses IP qui s'habitue selon la charge 
							// et nous courons sans cesse dans les questions en utilisant les adresses IP. 
							//$_SESSION['login']['IP']= $_SERVER['REMOTE_ADDR'];
							$_SESSION['login']['nav']= $_SERVER['HTTP_USER_AGENT'];
							$_SESSION['login']['connection']= true;
							$_SESSION['login']['initiated']= true;
							
							// SI $_SESSION['login']['logout']==0
							// ATTENTION L'UTILISATEUR NE S'EST PAS DECONNECTE
							// LORS DE SA SESSION PRECEDANTE !
							$_SESSION['login']['logout'] = $user->item(0)->getAttribute('logout');
							
							$_SESSION['login']['type'] = $user->item(0)->getAttribute('type');
							$_SESSION['login']['date'] = $user->item(0)->getAttribute('date');
							//$_SESSION['login']['nom']=$donnees['nom'];
							//$_SESSION['first_login']=$donnees['first_login'];
								
							$message ='Bienvenue à bord <em>'.$_SESSION['login']['username'].'</em>!! <br/>Tu es <em>'.$_SESSION['login']['type'].'</em><br/> logout = '.$_SESSION['login']['logout'];
							echo $message;
							
							$user->item(0)->setAttribute('logout','0');
							$user->item(0)->setAttribute('date',$_SERVER['REQUEST_TIME']);
							$this->saveMyXML($this -> _domData,$this -> _dataFilePath);	
							// Action --> Connecter!
							$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
							header('location: http://'.$host.'/'.$url, 401); 
							exit();
							
						}else{	// sinon
							$message = 'Accés refusé!';
							$formulaire_valide=false;
						}
					}else{	// sinon
						$message = 'Accés refusé!';
						$formulaire_valide=false;
					}
					
				// si le temps pour remplir le formulaire excède 5 min	
				}else{			// alors on regénère le formulaire avec un nouveau token
					$formulaire_valide=false;
					$message = 'Time out! try again!!';
				}
				
				
				//$formulaire_valide=true;
				
				
				
	/* 
				echo '<br/> token time = '.$_SESSION['token_time'];
				echo '<br/>  time = '.time();
				echo '<br/>  time = '.(time()-$_SESSION['token_time']);
				echo '<br/> token  = '.$_SESSION['token'].'  '.$_POST['token'];
				echo '<br/> http referer  = '.$_SERVER['HTTP_REFERER'];
				echo '<br/> username  = '.$_POST['username'];
				echo '<br/> password  = '.$_POST['password']; */
				 
				
			
			}else{
				$message = 'remplissez correctement le formulaire!';
			
			}
			
			// si le formulaire n'a pas pu être validé, on lance un temps d'attente de 2 secondes
			// pour la sécurité
			if(isset($formulaire_valide) && $formulaire_valide==false){
				//echo 'wait!!!';
				sleep(2);
			}
		
			$this-> setRandomToken();
			
			$domPageContenuPrincipal = $domPageContenu -> getElementsByTagName('principal') -> item(0) -> textContent;	// DomElement
			$domPageContenuSecondaire = $domPageContenu -> getElementsByTagName('secondaire') -> item(0) -> textContent;	// DomElement
			self::$arrayToParse['CONTENU'] = $this->parseContenu($domPageContenuPrincipal);
			self::$arrayToParse['CONTENU_SECONDAIRE'] = $this->parseContenu($domPageContenuSecondaire);					
			self::$arrayToParse['USERNAME'] = 'Identifiant';					
			self::$arrayToParse['PASSWORD'] = 'Mot de passe';					
			self::$arrayToParse['TOKEN'] = $_SESSION['token'];	
			self::$arrayToParse['MESSAGE'] = $message;	
			
			if(isset($_SESSION['error'])){
				//print_r($_SESSION['error']);
				self::$arrayToParse['MESSAGE'] .= '<br/>'.$_SESSION['error']['message'].' ('.$_SESSION['error']['request'].').';
				unset($_SESSION['error']);
			}
			
			
			if($this->_config['urlRewriting']['type']==1){
				self::$arrayToParse['FICHIER_CIBLE'] = $this->_config['urlRewriting']['cible'] ;				// fichier "cible.php"
				$_SESSION['cible']=	$this -> _idPage.$this->_config['ext']['web'];
			}else{
				self::$arrayToParse['FICHIER_CIBLE'] = $this -> _idPage.$this->_config['ext']['web'];
			}
		
			//	File "users.xml"	=	$domPageContenu -> getElementsByTagName('data') -> item(0) -> getAttribute('file');					
		}
	}
	
	private function setRandomToken(){
		if(isset($_SERVER['HTTP_USER_AGENT'])){ $userAgent = $_SERVER['HTTP_USER_AGENT'];}
		$token = md5(uniqid(mt_rand()).'-'.$userAgent);
		$_SESSION['token'] = $token;
		$_SESSION['token_time'] = time();
	
	}
	
	
	
	
	public function launchAction(){
		require(ROOT_PATH.$this->_config['librairie']['template']);	// classe de template
		
		//--MODULE--//
		$this->setParameter();						// ouvre le fichier de données de la page => $this -> _domData
		$rights = $this->getRights();
		
	
		//--MODULE-DATA--//
		$this->setMetaData($this -> _domData);		// Meta data - modifie self::$arrayToParse
		$this->setCSS($this -> _domData);			// CSS - modifie self::$multiArrayToParse
		$this->setData();		// Data page
		
		//--ARBORESCENCE--//
		/* $this -> _domArborescence = self::openDomXml($this -> _arboFilePath);
		$this -> _XPathArborescence = new DOMXPath($this -> _domArborescence);
		$this->setActivNode();						// Source: _domArborescence
		$this->setLangue();							// Source: _domArborescence, Langue ...
		$this->setMenu();							// Source: _domArborescence,Menu ... */
		/* $this->setBreadCrumbs(); */
		
		//--TEMPLATE--//
		// On créé une instance de la classe template, 
		//passez en paramètre le répertoire ou se trouvent tous vos fichiers templates
		$this -> _template = new Template(BASE_PATH.$this->_config['path']['design'],BASE_PATH.$this->_config['path']['cache']);
		$this->setTemplate($this -> _domData, 'squelette');				// Template squelette
		$this->setTemplate($this -> _domData, $this->_templateNameModule);	// Template module
		

		//--PARSAGE & RECUPERATION DU CONTENU--//
		$this->parseTemplate(self::$arrayToParse ,self::$multiArrayToParse);	// parsage des blocs
		$this->setTranslation();											// Variables de langue
		$this -> combineTemplate($this->_templateNameModule);			// inclusion du template module dans le template squelette
		//$this -> _template -> pparse('squelette'); 				// affichage phpBB2
		$this -> _template -> display('squelette'); 				// affichage 
		$this->_content = ob_get_contents();					// recuperation du contenu bufferisé
		ob_end_clean();											// nettoyage du buffer
		
		//--AFFICHAGE--//											// possible modification de l'expiration
		//self::$expireHtml = 60*60*24*40;							// du cache HTML
		self::printOut($this->_content,self::$outputFormat,$this -> _url);		// affichage en mode HTML
		
		//--CACHE--//
		//self::$cacheTime = 60*60*24;											// possible modification de la validité du cache HTML
		if(self::$cacheTime > 0){
			self::htmlCache($this->_content,$this -> _url,BASE_PATH.$this->_config['path']['cache'],self::$cacheTime);		// mise en cache html
		}
		//--POST-ACTION--//
		//$this->postAction($content);
	}


}

?>