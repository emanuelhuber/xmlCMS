<?php


class ModuleListeDeMariage extends ModuleSquelette{

	public $_traitement = false;
	public $_confLangue = false;
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);
		
		$this -> _dataFilePath = $this->_config['path']['data'].$urlArray[1].'/bettina-mikael'.$this->_config['ext']['data'];
		if(isset($urlArray[3])){
			$this -> _traitement = 	$urlArray[3];
		}
		
	}
	
	public function launchAction(){
		parent::launchAction();

		if(isset($this -> _templateNameModule) && $this -> _templateNameModule=='facture'){
			$headers  ='From: "Webmaster "<emanuel.huber@gmail.com>'."\n";
			$headers .='Reply-To: emanuel.huber@gmail.com'."\n";
			$headers .='CC: emanuel.huber@gmail.com'."\n";
			$headers .='BCC: emanuel.huber@gmail.com'."\n";
			$headers .='Content-Type: text/html; charset=utf-8"'."\n";
			$headers .='Content-Transfer-Encoding: 8bit';
			
			// objet
			$objet =  'Geschenkliste/Liste de mariage - Bettina & Mikael';
			
			// Le message contenant d'abord le message personnel du membre suivit du message officiel de demande d'inscription
			$message = $this->_content;
		//	mail($_SESSION['mail'], $objet, $message, $headers);
			

			if(mail($_SESSION['valeur_mail'], $objet, $message, $headers)){
			//	echo 'Mail envoyé!';
			}else{
				echo 'Mail non-envoyé!<br/>Mail nicht geschickt';
			} 
		}
		
	
	}

	
	
	public function setData(){
		$dom = $this -> _domData;
		
		$this -> _confLangue = parse_ini_file($this->_config['path']['data'].$this -> _module.'/conf-'.$_SESSION['langue'].'.ini', true);					// config data
	
		self::$expireHtml = 0;	// pas de cache navigateur
		self::$cacheTime = 0;	// pas de cache HTML
			
		if((isset($_POST['cadeau']) or isset($_POST['name']) or isset($_SESSION['reservation'])) && $this -> _traitement=='reservation'){
			
			if(isset($_POST['name']) 	and isset($_POST['mail']) 
													/* and !empty($_POST['mail']) 
													and !empty($_POST['name']) */
													) {
				$formulaire_valide=true;
				$name=trim($_POST['name']); // supprime les champs vides après et avant
				$mail=trim($_POST['mail']);	// idem
				// Test si l'adresse email donnée est bien une adresse mail:
				//"^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$"
				if(!ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $mail)){
					$formulaire_valide=false;
					$_SESSION['message_mail'] ='Format du mail est invalide';
				}
				// Test si le nom et le prénom sont bien des nom et prénom (tous les caractères alpha sont autorisé ainsi que les espaces)
				if(!eregi("^[-a-z_\\x27\xC0-\xFF-]|[:blank:]*$", $name)){
					$formulaire_valide=false;
					$_SESSION['message_nom'] ='Format du texte est invalide';
				}
				$_SESSION['valeur_nom']=$name;
				$_SESSION['valeur_mail']=$mail;
				
				if($formulaire_valide){
					$_SESSION['message_mail']='';
					$_SESSION['message_nom']='';
					$_SESSION['commandeok'] = true;
					FrontController::redirect($this -> _idPage.',commande.html', $permanent = false);
				}else{
					$_SESSION['reservation'] = true;
					FrontController::redirect($this -> _idPage.',reservation.html', $permanent = false);
					// echo 'liste-de-mariage,'.$this -> _para.',reservation.html';
					 
				}
			}else{
				$this -> _templateNameModule='reservation';
				
					
				if($this->_config['urlRewriting']['type']==1){
					self::$arrayToParse['FICHIER_CIBLE'] = $this->_config['urlRewriting']['cible'] ;				// fichier "cible.php"
					$_SESSION['cible']=	$this -> _idPage.',reservation'.$this->_config['ext']['web'];
				}else{
					self::$arrayToParse['FICHIER_CIBLE'] =	$this -> _idPage.',reservation'.$this->_config['ext']['web'];
				}
			
				(isset($_POST['cadeau'])) ? $_SESSION['commande']=$_POST['cadeau']: $commande = $_SESSION['commande'];
				
				$prixTotal=0;
				foreach($_SESSION['commande'] as $cad){
					$cadom = $this->findNode($dom,$cad);
					self::$multiArrayToParse[]=array('com'=> array('IMG' => $cadom->getAttribute('image'),
																'NOM' => $cadom->getAttribute('nom-'.$_SESSION['langue']),
																'PRIX' => $cadom->getAttribute('prix')));
					if($cadom->getAttribute('etoile')>0){
						self::$multiArrayToParse[]=array('com.etoile'=> array('ESPACE' 		=> '&nbsp;'));
					}
					$prixTotal = $prixTotal + $cadom->getAttribute('prix');
				}
				
				self::$arrayToParse['PRIX_TOTAL'] =	$prixTotal;
				self::$arrayToParse['REF'] =	$this -> _idPage.$this->_config['ext']['web'];
				(isset($_SESSION['valeur_nom'])) ? self::$arrayToParse['VALEUR_NOM'] = $_SESSION['valeur_nom'] : self::$arrayToParse['VALEUR_NOM'] = '';
				(isset($_SESSION['valeur_mail'])) ? self::$arrayToParse['VALEUR_MAIL'] = $_SESSION['valeur_mail'] : self::$arrayToParse['VALEUR_NOM'] = '';
				/* (isset($_SESSION['message_nom'])) ? self::$arrayToParse['MESSAGE_NOM'] = $_SESSION['message_nom'] : self::$arrayToParse['MESSAGE_NOM'] = '';
				(isset($_SESSION['message_mail'])) ? self::$arrayToParse['MESSAGE_MAIL'] = $_SESSION['message_mail'] : self::$arrayToParse['MESSAGE_MAIL'] = ''; 
				 */
				
				if(isset($_SESSION['message_mail'])){
					self::$arrayToParse['MESSAGE_MAIL'] = $_SESSION['message_mail'];
					unset($_SESSION['message_mail']);
				}
				if(isset($_SESSION['message_nom'])){
					self::$arrayToParse['MESSAGE_NOM'] = $_SESSION['message_nom'];
					unset($_SESSION['message_nom']);
				}
				
				
				$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
				foreach($dataLangue as $clef=>$value){
					self::$arrayToParse[$clef] =	$value;
				}
			}
			
		 	 
		
		}elseif(isset($_SESSION['commandeok'] )  && $this -> _traitement=='commande'){
			$this -> _templateNameModule='commande';
			$commande = $_SESSION['commande'];
			$prixTotal=0;
			foreach($commande as $cad){
				$cadom = $this->findNode($dom,$cad);
				self::$multiArrayToParse[]=array('com'=> array('IMG' => $cadom->getAttribute('image'),
															'NOM' => $cadom->getAttribute('nom-'.$_SESSION['langue']),
															'PRIX' => $cadom->getAttribute('prix')));
				if($cadom->getAttribute('etoile')>0){
					self::$multiArrayToParse[]=array('com.etoile'=> array('ESPACE' 		=> '&nbsp;'));
				}
				$prixTotal = $prixTotal + $cadom->getAttribute('prix');
			}
	
			self::$arrayToParse['PRIX_TOTAL'] =	$prixTotal;
			self::$arrayToParse['REF'] =	$this -> _idPage.$this->_config['ext']['web'];
			self::$arrayToParse['REF_MOD'] =	$this -> _idPage.',reservation'.$this->_config['ext']['web'];
			self::$arrayToParse['FICHIER_CIBLE'] =	$this -> _idPage.',facture'.$this->_config['ext']['web'];
			
			self::$arrayToParse['VALEUR_NOM'] = $_SESSION['valeur_nom'];
			self::$arrayToParse['VALEUR_MAIL'] = $_SESSION['valeur_mail'];
			
			$_SESSION['reservation'] = true;
			
			$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
			foreach($dataLangue as $clef=>$value){
				self::$arrayToParse[$clef] =	$value;
			}
			
		}elseif(isset( $_SESSION['commande'])  && $this -> _traitement=='facture'){
			$this -> _templateNameModule='facture';
			//$this -> _templateNameModule='commande';
			$commande = $_SESSION['commande'];
			$prixTotal=0;
			foreach($commande as $cad){
				$cadom = $this->findNode($dom,$cad);
				self::$multiArrayToParse[]=array('com'=> array('IMG' => $cadom->getAttribute('image'),
															'NOM' => $cadom->getAttribute('nom-'.$_SESSION['langue']),
															'PRIX' => $cadom->getAttribute('prix')));
				$prixTotal = $prixTotal + $cadom->getAttribute('prix');
				$cadom -> setAttribute('reserve', '1');
				
				if($cadom->getAttribute('etoile')>0){
					self::$multiArrayToParse[]=array('com.etoile'=> array('ESPACE' 		=> '*'));
				}
				
			}
	
			self::$arrayToParse['PRIX_TOTAL'] =	$prixTotal;
			self::$arrayToParse['VALEUR_NOM'] = $_SESSION['valeur_nom'];
			self::$arrayToParse['VALEUR_MAIL'] = $_SESSION['valeur_mail'];
			self::$arrayToParse['FICHIER_CIBLE'] =	$this -> _idPage.',pdf'.$this->_config['ext']['web'];
			self::$arrayToParse['REF'] =	$this -> _idPage.$this->_config['ext']['web'];
			$_SESSION['reservation'] = true;
			
			
			$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
			foreach($dataLangue as $clef=>$value){
				self::$arrayToParse[$clef] =	$value;
			}
			
			$_SESSION['pdf'] = $_SESSION['commande'];
			unset($_SESSION['commande']);
			unset($_SESSION['commandeok']);
			
			/* if(isset($_POST['pdf'])){
				self::$outputFormat = 'pdf';
				echo 'YES!!! PDF!!!';
			}else{
				echo 'YES! HTML!!!';
				print_r($_POST);
			} */
			self::saveMyXML($dom,$this -> _dataFilePath);
			//header('location: liste-de-mariage,mikael-et-bettina.html');
			
		}elseif(isset( $_SESSION['pdf'])  && $this -> _traitement=='pdf'){
			$this -> _templateNameModule='facture';
			//$this -> _templateNameModule='commande';
			$commande = $_SESSION['pdf'];
			$prixTotal=0;
			foreach($commande as $cad){
				$cadom = $this->findNode($dom,$cad);
				self::$multiArrayToParse[]=array('com'=> array('IMG' => $cadom->getAttribute('image'),
															'NOM' => $cadom->getAttribute('nom-'.$_SESSION['langue']),
															'PRIX' => $cadom->getAttribute('prix')));
				$prixTotal = $prixTotal + $cadom->getAttribute('prix');
				$cadom -> setAttribute('reserve', '1');
				
				if($cadom->getAttribute('etoile')>0){
					self::$multiArrayToParse[]=array('com.etoile'=> array('ESPACE' 		=> '*'));
				}
				
			}
	
			self::$arrayToParse['PRIX_TOTAL'] =	$prixTotal;
			self::$arrayToParse['VALEUR_NOM'] = $_SESSION['valeur_nom'];
			self::$arrayToParse['VALEUR_MAIL'] = $_SESSION['valeur_mail'];
			self::$arrayToParse['FICHIER_CIBLE'] =	$this -> _idPage.',facture'.$this->_config['ext']['web'];
			self::$arrayToParse['REF'] =	$this -> _idPage.$this->_config['ext']['web'];
			/* $_SESSION['reservation'] = true; */
			
			
			$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
			foreach($dataLangue as $clef=>$value){
				self::$arrayToParse[$clef] =	$value;
			}
			
				self::$outputFormat = 'pdf';
				unset($_SESSION['pdf']);
			
			/* if(isset($_POST['pdf'])){
				echo 'YES!!! PDF!!!';
			}else{
				echo 'YES! HTML!!!';
				print_r($_POST);
			} */
			self::saveMyXML($dom,$this -> _dataFilePath);
			//header('location: liste-de-mariage,mikael-et-bettina.html');
		
		}else{
			
			if(isset($_SESSION['commande'])){
				unset($_SESSION['commande']);
			}
			
			$this -> _templateNameModule='liste';
			
			if($this->_config['urlRewriting']['type']==1){
				self::$arrayToParse['FICHIER_CIBLE'] = $this->_config['urlRewriting']['cible'] ;				// fichier "cible.php"
				$_SESSION['cible']=	$this -> _idPage.',reservation'.$this->_config['ext']['web'];
			}else{
				self::$arrayToParse['FICHIER_CIBLE'] = $this -> _idPage.',reservation'.$this->_config['ext']['web'];
			}
			
			$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
			$domPageContenuPrincipal = $domPageContenu -> getElementsByTagName('principal') -> item(0);	// DomElement
			$categorie = $domPageContenuPrincipal -> getElementsByTagName('categorie');
			//echo '<strong>YES! </strong>';
			foreach($categorie as $cat){
				$reponse = $cat->getAttribute('nom-'.$_SESSION['langue']);
				self::$multiArrayToParse[]=array('cat'=> array('TIT' => $reponse));
				
				$cadeaux = $cat-> getElementsByTagName('cadeau');
				foreach($cadeaux as $cad){
					if($cad->getAttribute('reserve')<1){
						self::$multiArrayToParse[]=array('cat.dispo'=> array('IMG' 		=> $cad->getAttribute('image'),
																		'NOM' 		=> $cad->getAttribute('nom-'.$_SESSION['langue']),
																		'PRIX' 		=> $cad->getAttribute('prix'),
																		'RESERVE' 	=> $cad->getAttribute('reserve'),
																		'ID'		=> $cad->getAttribute('id')));
						if($cad->getAttribute('etoile')>0){
							self::$multiArrayToParse[]=array('cat.dispo.etoile'=> array('ESPACE' 		=> '&nbsp;'));
						}
					}else{
						self::$multiArrayToParse[]=array('cat.reserve'=> array('IMG' 		=> $cad->getAttribute('image'),
																		'NOM' 		=> $cad->getAttribute('nom-'.$_SESSION['langue']),
																		'PRIX' 		=> $cad->getAttribute('prix'),
																		'RESERVE' 	=> $cad->getAttribute('reserve'),
																		'ID'		=> $cad->getAttribute('id')));
					}
				}
			}	
			
			$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
			foreach($dataLangue as $clef=>$value){
				self::$arrayToParse[$clef] =	$value;
			}
			
/* 			$dataLangue = $this -> _confLangue[$this -> _templateNameModule];
			foreach($dataLangue as $clef=>$value){
				self::$arrayToParse[$clef] =	$value;
			} */
		}	
/* 		print_r($_POST);
		echo '<br/>';
			print_r($_SESSION); */
	}
	

	
	public function setMenu(){
		$query = '//page[@id="'.$this -> _idPage.'"]/ancestor::*';			// We starts from the root element
		$ancestors = $this->_XPathArborescence -> query($query);
		$ancestorsLength = $ancestors->length;
		/* echo $ancestorsLength;
 		foreach($ancestors as $an){
			echo $an->getAttribute('id').'---';
			echo $an->nodeName.'<br/>';
		 }  
		 */
		$query = '//langue[@id="'.$this -> _langue.'"]';			// We starts from the root element
		$langue = $this->_XPathArborescence -> query($query);
		
		$menuDomLangueEnfants = $langue -> item(0) -> childNodes;	
		// boucle
		$nb=0;
		foreach($menuDomLangueEnfants as $elt){			// DomElement
			// si le noeud n'est pas un enfant, si autorisé dans le menu, si publication autorisé, 
			// A FAIRE : si droit d'accès
			if($elt->nodeName != '#text' && $elt->getAttribute('menu')==1 && $elt->getAttribute('publication')==1){
				// si le noeud a des enfants (noeud rubrique)
				if($elt->hasChildNodes() == true){
					
					if($ancestorsLength>2){
						$idActif = $ancestors->item(2)->getAttribute('id');
						if($idActif==$elt->getAttribute('id')){
							$classe = 'actif';
						}else{
							$classe = 'inactif';
						} 
					}else{
						$classe = 'inactif';
					}
					$list_fils = $elt -> childNodes;				// DomNodeList
					self::$multiArrayToParse[]= array('menu' => array('CLASS' 	=> $classe ,
																		'REF' 	=> '#',
																		'NAME'  => $elt->getAttribute('nom'),
																		'UL' 	=> '<ul class="'.$classe.'">',
																		'UL2' 	=> '</ul></li>',
																		'NO'	=> $nb
																	));
					// parcours les enfants...
					$sousFilsActif=false;
					//$sousMenuArray = array();
					foreach($list_fils as $tr){
						if($tr->nodeName != '#text' && $tr->getAttribute('menu')==1  && $tr->getAttribute('publication')==1){
							if($tr->getAttribute('id') == $this -> _idPage){		// si un enfant correspond à la page active
								$sclasse = 'sactif';
							}else{
								$sclasse = 'sinactif';
							}
							self::$multiArrayToParse[] = array('menu.sousmenu' =>array(
									'CLASS2' => $sclasse,
									'REF2' 	=> $tr->getAttribute('id').$this->_config['ext']['web'],
									'NAME2'  => $tr->getAttribute('nom')));
							//$sousMenuArray[] = $sousMenuElt;
						}
					}
					$nb++;
				// si le noeud n'a pas d'enfant
				}else{
					if($elt->getAttribute('id') == $this -> _idPage){	// si le noeud correspond à la page active
						$classe = 'menu';
					}else{		// sinon
						$classe = 'menu';
					}
					self::$multiArrayToParse[]= array('menu'=>array('CLASS' => $classe,
																	'REF' 	=> $elt->getAttribute('id').$this->_config['ext']['web'],
																	'NAME'  => $elt->getAttribute('nom'),
																	'UL' 	=> '<ul>',
																	'UL2' 	=> '</ul></li>',
																	'NO'	=> $nb
																	));
					$nb++;
				}
			}
		}	
	}
}




























?>