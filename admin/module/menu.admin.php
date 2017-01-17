<?php

//extends ModuleSquelette
class ModuleAdminMenu extends ModuleAdmin{
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		self::$myPage = new Xml_Page($urlArray);
	}
	
	public function setData(){
		$this->_templateNameModule = 'page';
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'module.class.php');
		
		switch($this -> _action){
			case 'index':
				$this -> showIndex();
				break;
			case 'creer':
				$this -> createContent();
				//break;
			case 'langue':
				$this -> createLanguage();
				//break;
			default:
				self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> 'fr,menu,index.html',
																	'NAME' 	=> 'Menu',
																	'TITLE' 	=> 'Menu',
																	'IS_LINK' 	=> true
												));
				break;
		} 
	}

	public function createLanguage(){
		// Ajouter une langue !
		if(isset($_POST['langue']['name']) && !empty($_POST['langue']['name'])
			&& isset($_POST['langue']['id']) && !empty($_POST['langue']['id'])){
			$data = $_POST['langue'];
			$this -> _menu  -> addLanguage($_POST['langue']['name'], $_POST['langue']['id']);
			
			FrontController::redirect('');
		}
	}
	
	public function createContent(){
		// liste des modules
		$modulesId = array();
		$myModule = new Xml_Module();
		$modules = $myModule -> getModulesList();
		foreach($modules as $mod){
			if($mod['actif'] === '1'){
				self::$multiArrayToParse[] = array('module' => array('NOM' => $mod['nom'],
																	 'ID' => $mod['id']
																	));
				$modulesId[] =  $mod['id'];
			}
		}
		// liste des langues
		$langueId = array();
		$langueMenu = $this -> _menu  -> getLanguages();
		foreach($langueMenu as $lg){
			self::$multiArrayToParse[] = array('langue' => array('NOM' => $lg['name'],
																	'ID' => $lg['id']
																	));
			$langueId[] = $lg['id'];
		}
		// liste des designs
		$designId = array();
		$folderDesign = ROOT_PATH.$this->_config['path']['design'];
		$dossierTheme = opendir($folderDesign);
		while ($theme = readdir($dossierTheme)) {
			// on parcourt les thèmes = dossier "/design/monTheme/"
			if(is_dir($folderDesign."/".$theme) && $theme != "." && $theme != ".."
			    && is_dir($folder = $folderDesign.$theme.$this->_config['path']['css'])) {
				// dossier contenant les fichiers css
				$dossier = opendir($folder);
				while ($style = readdir($dossier)) {
					$pathCss = $folder.$style;
					if($style != "." && $style != ".." && !is_dir($pathCss)) { 
						$styleName =  substr($style,0,strlen($style)-4);
						if($styleName != 'base' && substr($styleName,-3,3)!='min'){
							$th = strpos($style, 'css' );
							if($th!==false){
							$designId[] =  $theme.'/'.$styleName;
							self::$multiArrayToParse[]=array('themestyle'=>array('NOM' 	=> $theme.'/'.$styleName,
																				'ID'	=> $theme.'/'.$styleName
																				)); 
							}
						}
					}
				}
				closedir($dossier);
			}
		}
		closedir($dossierTheme);
		// analyse du formulaire
		if(isset($_POST) && !empty($_POST)){
			$data = $_POST['page'];
			if(in_array($data['module'],$modulesId) && in_array($data['langue'],$langueId) && in_array($data['themestyle'],$designId) && !empty($data['titre']) && isset($data['fileId'])){
				
				// id-formating
				if(empty($data['fileId'])){
					$idFile = self::removeAccents(urldecode($data['titre']), $charset='utf-8',$del=false);
				}else{
					$idFile = self::removeAccents(urldecode($data['fileId']), $charset='utf-8',$del=false);
				}
				$idFile = strtolower($idFile);
				//$idFile = self::removeShortWords($idFile,1);	// supprime les mots d'une lettre
				
				
				// Créé un nouveau contenu et si tout marche, renvoi l'id du fichier
				// sinon renvoi FALSE
				require_once(ROOT_PATH.$this->_config['librairie']['interstitium'].$data['module'].'.class.php');
				$className = 'Xml_'.ucfirst($data['module']);
				
				
				$urlArray = array($data['langue'],$data['module'], $idFile );

				$newPage = new $className($urlArray,$root='root', $create=TRUE);
				
				// si le fichier est créé
				if($newPage != false){
					
					// on créé une instance de cette page et on modifie les métadonnées
					//$newPage = new $className(array('',$data['module'],$idFileNew), 'root');
					$infos = array();
					$infos['titre'] = urldecode($data['titre']);
					$infos['date'] = date('j.m.Y');
					if(isset($_SESSION['login_admin']['username']))	$infos['auteur'] = $_SESSION['login_admin']['username'];
					$newPage -> setInfo($infos);
					
					// ajouter les infos dans le menu
					$publication = '0';
					$doublon = '';
					$idPage = $newPage -> idPage;
					if($data['module']=='chapter' or $data['module']=='rubrique'){
						$publication = '1';
						$nameItem = $data['module'];
					//	$itemMenu = $this -> _menu -> getMenuItem($idPage);
						$i=0;
						while($this -> _menu -> getMenuItem($idPage) != FALSE){
							$idPage = $idPage.'-'.$i;
							$i++;
						}
						if($i>0) $doublon = ' ('.$i.')';
						//return $filePathMod;
					
					}else{
						$nameItem = 'page';
					}
					
					//$idPage = $lg.','.$data['module'].','.$idFile;
					$array = array('nom' => $infos['titre'].$doublon,
								   'module' => $data['module'],
								   'soeur' => '',
								   'menu' => '1',
								   'publication' => $publication,
								   'droits' => '-1'
									);
					
					$this -> _menu -> addMenuItem($data['langue'], $array, $idPage,$name = $nameItem);
					// redirection vers la page d'édition
					FrontController::redirect('fr,'.$data['module'].',editer.html?id='.$idPage);
					
				}else{
					echo 'Pas créer!!!';
				}  
				
				
				// redirection vers :
				// admin/lg,module,create.html?title=xxxx&lg=xx
			/* 	$host  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
				$linkRedirect = $this->urlAddQuery(array('title'=>$data['titre'], 'lg' => $data['langue']),true,'fr,'.$data['module'].',create.html');
				FrontController::redirect($linkRedirect);
				exit();  */
			}
		}
	}
	
	
	public function showIndex(){
		self::$arrayToParse['LIEN_CREER_PAGE'] = 'fr,menu,creer.html';
		self::$arrayToParse['LIEN_LANGUE'] = 'fr,menu,langue.html';
		// ---------------------------
		// MOVE THE MENU ITEMS!!
		if(isset($this -> _urlQuery['move']) && !empty($this -> _urlQuery['move'])
			&& isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$move = $this -> _urlQuery['move'];
			$id = $this -> _urlQuery['id'];
			//echo $move;
			$this -> _menu  -> moveNodeId($id,$move);
			FrontController::redirect('');
		// DELETE ONE LANGUAGE!!
		}elseif(isset($this -> _urlQuery['action']) && ($this -> _urlQuery['action']=='delete')
			&& isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			if($this -> _menu  -> deleteLanguage($id)){
				FrontController::redirect('');
			}
		}
		// ---------------------------
		// show the menu!
		/* $languages = $this -> _menu  -> getLanguages();
		foreach($languages as $lg){
			$menu = $this -> _menu  -> getMenu('',$lg['id']);
			self::$multiArrayToParse[] = array('arbo1' => array('NAME' => $lg['name'],
																'ID' => $lg['id'],
																'LINK_DELETE' => $this->urlAddQuery(array('id'=>$lg['id'], 'action' => 'delete'),true)));
			$block=0;
			$depth=0;
			foreach($menu as $elt){
				$toLeft = true;
				$toRight = true;
				if($elt['depth']<1){
					$toLeft = false;
					// pour la coloration des blocs
					$block++;
					$block = $block%2; 	// si pair => 1 
					
				}

				if($elt['type']=='chapter'){
					$toLeft = false;
					$toRight = false;
				}
				$droit_name = '';
				if($elt['rights'] < 0){
					$droit_name = '-';
				}else{
					$rights = $this -> _groups -> rightsList();
					foreach($rights as $right){
						if(intval($elt['rights']) == intval($right['right'])){
							$droit_name = $right['name'];
						}
					}
				}
				
				$name = 'menu';
				$index = $name.'1';
				
				$elt['depth']++;
				if($elt['depth']>2){
					for($i = 2; $i <= $elt['depth']; $i++){
						$index .= '.'.$name.$elt['depth'];
					}
				}
				$class='';
				if($elt['active'] and !$elt['hasChild']){
					$class='actifnochild';
				}elseif($elt['active']){
					$class='actif';
				}elseif($elt['childActive']){
					$class='actif';
				}
				$link = $elt['id'].$this->_config['ext']['web'];
				if($elt['type']=='chapter'){
					$link = '#';
				}
				$fix = '.html?id=';
				$indent = self::indent($elt['depth'], '&nbsp&nbsp;', $start = 1);
				$indentmod = self::indentMod($elt['depth']+2, 'arbo', $start = 2);
				if($elt['module']!='erreur'){
				
															
				self::$multiArrayToParse[] = array('arbo1'.$indentmod => 
														array('NOM' => $elt['name'],
															'MODULE' => $elt['module'],
															'INDENT' => $indent,
															'LIEN_REMONTER' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'up'),true),
															'LIEN_DESCENDRE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'down'),true),
															'LIEN_GAUCHE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'left'),true),
															'LIEN_DROITE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'right'),true),
															'GAUCHE' => 'right',
															'LIEN_APERCU' => 'fr,'.$elt['module'].',apercu'.$fix.$elt['id'],
															'LIEN_EDITER' => 'fr,'.$elt['module'].',editer'.$fix.$elt['id'],
															'LIEN_EDITER_MENU' => 'fr,menu,editer'.$fix.$elt['id'],
															'LIEN_EDITER_DESIGN' => 'fr,'.$elt['module'].',editerdesign'.$fix.$elt['id'],
															'LIEN_CREATE' => 'fr,'.$elt['module'].',create'.$fix.$elt['id'],
															'LIEN_SUPPRIMER' => 'fr,'.$elt['module'].',supprimer'.$fix.$elt['id'],
															//'LIEN_PAS_PUBLIER' => 'fr,'.$elt['module'].',publier,'.$fix.$elt['id'],
															'LIEN_PUBLIER' => 'fr,menu,publier'.$fix.$elt['id'],
															'T_PUBLIER' => $elt['publication'],
															'DROITS' => $droit_name, 
															'RUBRIQUE_TRUE' =>true,
															'DEPTH' => $elt['depth'],
															'T_IN_MENU' =>$elt['menu'],
															'T_CHILDREN' => $elt['hasChild'],
															'T_LEFT'	=> $toLeft,
															'T_RIGHT' => $toRight,
															'BLOCK'		=> $block
															));
				}
				
			}
		}
 */
	// ---------------------------
		// show the menu!
		$languages = $this -> _menu  -> getLanguages();
		foreach($languages as $lg){
			$menu = $this -> _menu  -> getMenu('',$lg['id']);
			self::$multiArrayToParse[] = array('lg' => array('NAME' => $lg['name'],
																'ID' => $lg['id'],
																'LINK_DELETE' => $this->urlAddQuery(array('id'=>$lg['id'], 'action' => 'delete'),true)));
			$block=0;
			$depth=0;
			$k=0;
			$n = count($menu);
			foreach($menu as $elt){
				$folder = false;
				if($elt['type']=='chapter' or $elt['type']=='rubrique' or $elt['hasChild']) $folder = true;
				// si la page a le droit d'être déplacé à gauche ou à droite
				$toLeft = true;
				$toRight = true;
				if($elt['depth']<1){	// si premier élément
					$toLeft = false;	// déplacement à gauche interdit
					$block++;	// pour la coloration des blocs
					$block = $block%2; 	// si pair => 1 
				}
				if($elt['type']=='chapter'){	// Si chapitre
					$toLeft = false;		// tout déplacement
					$toRight = false;		// horizontal interdit
				}
				// les droits des pages
				$droit_name = '';
				if($elt['rights'] < 0){
					$droit_name = '-';
				}else{
					$rights = $this -> _userObject -> rightsList();
					foreach($rights as $right){
						if(intval($elt['rights']) == intval($right['right'])){
							$droit_name = $right['name'];
						}
					}
				}
				// pour le menu avec les liste <ul><li>...
				$flat = FALSE;
				$down = FALSE;
				$up = FALSE;
				$nextDepth = FALSE;
				if($k+1 < $n){
					$nextDepth = $menu[$k +1]['depth'];
				}
				$niveau_difference = $depth - $elt['depth'];
				if($niveau_difference < 0){
					$down = TRUE;
				}elseif($niveau_difference == 0 or ($elt['depth']-$nextDepth)<=0){
					$flat = TRUE;
				}
				if($elt['depth'] > $nextDepth){
					$up = TRUE;
				}
				if($up == TRUE and $down == TRUE){
					$up = FALSE;
				}
			
				$depth =$elt['depth'];
				// Classe de l'élément actif
				$class='';
				if($elt['active'] and !$elt['hasChild']){
					$class='actifnochild';
				}elseif($elt['active']){
					$class='actif';
				}elseif($elt['childActive']){
					$class='actif';
				}
				// link
				$link = $elt['id'].$this->_config['ext']['web'];
				if($elt['type']=='chapter'){
					$link = '#';
				}
				$fix = '.html?id=';
				if($elt['module']!='erreur'){
				self::$multiArrayToParse[] = array('lg.mymenu' => 
														array('NAME' => $elt['name'],
															'MOD' => $elt['module'],
															'T_FLAT' => $flat,
															'T_DOWN' => $down,
															'T_UP' => $up,
															'T_IN_MENU' =>$elt['menu'],
															'T_CHILD' => $elt['hasChild'],
															'T_FOLDER' => $folder,
															'T_RUBRIQUE' =>true,
															'T_PUBLIER' => $elt['publication'],
															'GAUCHE' => 'right',
															'T_RIGHT' => $toRight,
															'T_LEFT'	=> $toLeft,
															'LIEN_REMONTER' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'up'),true),
															'LIEN_DESCENDRE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'down'),true),
															'LIEN_GAUCHE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'left'),true),
															'LIEN_DROITE' => $this->urlAddQuery(array('id'=>$elt['id'], 'move' => 'right'),true),
															'LIEN_APERCU' => 'fr,'.$elt['module'].',apercu'.$fix.$elt['id'],
															'LIEN_EDITER' => 'fr,'.$elt['module'].',editer'.$fix.$elt['id'],
															'LIEN_EDITER_MENU' => 'fr,menu,editer'.$fix.$elt['id'],
															'LIEN_EDITER_DESIGN' => 'fr,'.$elt['module'].',editerdesign'.$fix.$elt['id'],
															'LIEN_CREATE' => 'fr,'.$elt['module'].',create'.$fix.$elt['id'],
															'LIEN_SUPPRIMER' => 'fr,'.$elt['module'].',supprimer'.$fix.$elt['id'],
															//'LIEN_PAS_PUBLIER' => 'fr,'.$elt['module'].',publier,'.$fix.$elt['id'],
															'LIEN_PUBLIER' => 'fr,menu,publier'.$fix.$elt['id'],
															'DROITS' => $droit_name, 
															'DEPTH' => $elt['depth'],
															'BLOCK'		=> $block
															/* 'BLOCK'		=> $block */		// pour la coloration des blocs
															)); 	
																
				}
				// pour le menu <ul><li>...
				if($elt['depth'] > $nextDepth){
					$up = TRUE;
					for ($i = 1; $i <= ($elt['depth'] - $nextDepth); $i++) {
						self::$multiArrayToParse[] = array('lg.mymenu.up' => 
																array('UP' => ''
																)
															);
					}
				}
				$k++;
			}
				
		}
	}
				
	
	
	private static function indent($n, $string, $start = 1){
		if($n != $start){
			  for($i = $start; $i < $n; $i++){
				$string .= $string;
			  }
			return $string;
		}else{
			return '';
		}
	}
	private static function indentMod($n, $string, $start = 1){
		if($n != $start){
				//$string2 = $string.$start;
				$string2 = '';
			  for($i = $start; $i < $n; $i++){
				$string2 = $string2.'.'.$string.$i;
			  }
			return $string2;
		}else{
			return '';
		}
	}
	/* public function copyDir($origine, $destination) {
		$test = scandir($origine);

		$file = 0;
		$file_tot = 0;

		foreach($test as $val) {
			if($val!="." && $val!="..") {
				if(is_dir($origine."/".$val)) {
					CopyDir($origine."/".$val, $destination."/".$val);
					$this -> isDir_or_CreateIt($destination."/".$val);
				} else {
					$file_tot++;
					if(copy($origine."/".$val, $destination."/".$val)) {
						$file++;
					} else {
						if(!file_exists($origine."/".$val)) {
							echo $origine."/".$val;
						};
					};
				};
			};
		}
		return true;
	} */
	
	/* public function isDir_or_CreateIt($path) {
		if(is_dir($path)) {
			return true;
		} else {
			if(mkdir($path)) {
				return true;
			} else {
				return false;
			}
		}
	} */

	

}
?>