<?php
class ModuleLoginConnection extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'users.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_User($path);
	}
	
	
	public function setData(){
		
		$this->_templateNameModule = 'page';
		
		/* NO CACHE */
		self::$cacheTime = 0;
		self::$expireHtml = 0;
		
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		
		if($this -> _urlQuery['action'] == 'out'){
			// indiquer que l'utilisateur s'est bien déconnecté et quand!
			self::$myPage -> logOutUser($_SESSION['login_admin']['username']);
			
			unset($_SESSION['login_admin']);
			/* session_destroy();
			session_unset (); */
			
			$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
			header('location: http://'.$host.'/'); 
			exit();
		
		}else{
			self::$arrayToParse['MESSAGE'] = '';
			// pas de droit d'accès, redirection vers login avec un message d'explication.
			if(isset($_SESSION['error']) && isset($_SESSION['error']['message'])){
				self::$arrayToParse['MESSAGE'] = $_SESSION['error']['message'] .'<br/>'.$_SESSION['error']['request'].'<br/>'.$_SESSION['error']['referer'].'<br/>';
				unset($_SESSION['error']);
			}/* elseif(isset($_SESSION[self::$loginType]['page_unauthorized'])){
				self::$arrayToParse['MESSAGE'] = $_SESSION[self::$loginType]['page_unauthorized'].'<br/>';
			} */
			
			if(isset($_POST['token']) 					// si le token (jeton) est envoyé avec le formulaire
			// on pourrait aussi vérifier le http_referer (mais pas forcément fiable)
				&& !empty($_POST['username']) 			// si l'username et le
				&& !empty($_POST['password'])			// password sont envoyés avec le formulaire
				&& $_POST['token'] == $_SESSION['token'] 	// si le token correspond au token de la Session
				&& isset($_SERVER['HTTP_USER_AGENT'])){		// si on sait quel navigateur est utilisé
				
				$formulaire_valide=false;					// valeur par défaut
				
				if((time() - $_SESSION['token_time']) <60*5){	// si le temps pour remplir le formulaire n'excède pas 5 min
					// echo $_POST['username'];
					if($user = self::$myPage -> getUser($_POST['username'])){	// si l'utilisateur a été trouvé
						// echo '<br/> user find!<br/>';
						// si le mot de passe est juste
						if($user['username'] == $_POST['username'] && $user['password'] == $_POST['password']){
							// echo '<br/> Salut '.$user['username'].'! Et bienvenu!!<br/>';
							$formulaire_valide=true;
							
							if(self::$myPage -> logInUser($_POST['username'])){
							
								// ON REGÉNÈRE LA SESSION
								session_regenerate_id(true);
								
								$_SESSION['login_admin']=array();
								//$_SESSION['login_admin']['password']=$userPassword;
								$_SESSION['login_admin']['username']=$user['username'];
								$_SESSION['login_admin']['droits']=$user['droits'];
								
								// Utilisant l'adresse IP n'est pas vraiment la meilleure idée dans mon expérience. 
								// Par exemple, mon bureau a deux adresses IP qui s'habitue selon la charge 
								// et nous courons sans cesse dans les questions en utilisant les adresses IP. 
								//$_SESSION['login_admin']['IP']= $_SERVER['REMOTE_ADDR'];
								$_SESSION['login_admin']['nav']= $_SERVER['HTTP_USER_AGENT'];
								$_SESSION['login_admin']['connection']= true;
								$_SESSION['login_admin']['initiated']= true;
								
								// SI $_SESSION['login_admin']['logout']==0
								// ATTENTION L'UTILISATEUR NE S'EST PAS DECONNECTE
								// LORS DE SA SESSION PRECEDANTE !
								$_SESSION['login_admin']['logout'] = $user['logout'];
								
								$_SESSION['login_admin']['group'] = $user['group'];
								$_SESSION['login_admin']['groupname'] = $user['groupname'];
								$_SESSION['login_admin']['date'] = $user['date'];
								$_SESSION['login_admin']['timestamp'] = $user['timestamp'];
								//$_SESSION['login_admin']['nom']=$donnees['nom'];
								//$_SESSION['first_login']=$donnees['first_login'];
								
								//$this -> echo_r($user);
								
								// Action --> Connecter!
								$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
								
								/* if(isset($_SESSION[self::$loginType]['page_unauthorized'])){
									$host.='/'.$_SESSION['page_unauthorized'];
									unset($_SESSION[self::$loginType]['page_unauthorized']);
								} */
								
								header('location: http://'.$host, 401); 
								exit();
							}else{
								self::$arrayToParse['MESSAGE'] .=  'Erreur interne : problème d\'écriture de fichiers...';
							}
							
						}else{
							self::$arrayToParse['MESSAGE'] .= 'Erreur : votre login/mot de passe est/sont erronné(s)';
						}
					}else{
						self::$arrayToParse['MESSAGE'] .=  'Erreur : votre login/mot de passe est/sont erronné(s)';
					}
				}else{			// alors on regénère le formulaire avec un nouveau token
					$formulaire_valide=false;
					self::$arrayToParse['MESSAGE'] .=  'Le temps est écoulé ! Faites une nouvelle tentative...';
				}
				
				if(isset($formulaire_valide) && $formulaire_valide==false){
					// echo '<br/>wait!!!<br/>';
					sleep(2);
				}
			}else{
				$this-> setRandomToken();
				self::$arrayToParse['MESSAGE'] .=  'Remplissez les champs...';
			}
				
		
		
		}
	}
	
	private function setRandomToken(){
		if(isset($_SERVER['HTTP_USER_AGENT'])){ $userAgent = $_SERVER['HTTP_USER_AGENT'];}
		$token = md5(uniqid(mt_rand()).'-'.$userAgent);
		$_SESSION['token'] = $token;
		$_SESSION['token_time'] = time();
		self::$arrayToParse['TOKEN'] = $token;
	}
	

/*
*********************************************
*************  IDEES ************************
*********************************************

Quand l'utilisateur est connecté, on peut
transmettre un identifiant aléatoire dans
l'url (ou bien cookie) qui sera en plus
testé!

*/




/*
==========================
Remplacer time() par $_SERVER['time']
==========================

*/

}
?>