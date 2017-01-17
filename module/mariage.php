<?php


class ModuleMariage extends ModuleSquelette{
	
	
	public function setData(){
		$dom = $this -> _domData;
		
		$this->_templateNameModule = 'page';
		
		$domPageContenu = $dom -> getElementsByTagName('contenu') -> item(0);	// DomElement
		$domPageContenuPrincipal = $domPageContenu -> getElementsByTagName('principal') -> item(0) -> textContent;	// DomElement
		$domPageContenuSecondaire = $domPageContenu -> getElementsByTagName('secondaire') -> item(0) -> textContent;	// DomElement
		self::$arrayToParse['CONTENU'] = $this->parseContenu($domPageContenuPrincipal);
		self::$arrayToParse['CONTENU_SECONDAIRE'] = $this->parseContenu($domPageContenuSecondaire);					
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