<?php

//extends ModuleSquelette
class ModulePluginInclureencart extends ModuleAdmin{
protected $_plugin = '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		$path = BASE_PATH.$this->_config['path']['data'].$urlArray[1].'/'.$urlArray[2].$this->_config['ext']['data'];
		self::$myPage = new Xml_Page($path);
		$this->_plugin = $urlArray[2];
	}
	
	public function setData(){
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		$folder =  ROOT_PATH.$this -> _config['path']['data'].'plugin/'.$this->_plugin.'/';
		// Creation d'un nouvel encart (via formulaire)
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$fileName = self::removeAccents(urldecode($_POST['title']), $charset='utf-8',$del=false);
			$fileName = strtolower($fileName);
			$filePath = $folder.$fileName.'.html';
			file_put_contents($filePath, '<h1>'.$_POST['title'].'</h1>');
		}
	
	
		// LISTE DES FICHIERS
		$dossier = opendir($folder);
		while ($fichier = readdir($dossier)) {
			// STYLE - fichier CSS
			if($fichier != "." && $fichier != "..") {
				//$nom = explode('.',$fichier);
				//$nom[0]
				self::$multiArrayToParse[] = array('liste' => array('ID' => $fichier,
																 'EDIT_LINK' => $this->urlAddQuery(array('id'=>$fichier, 'action'=>'edit'),true),
																 'DELETE_LINK' => $this->urlAddQuery(array('id'=>$fichier, 'action'=>'delete'),true)
												
																));

			}
		}
		
		$this->_templateNameModule = 'page';

		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])
			&& isset($this -> _urlQuery['action']) && !empty($this -> _urlQuery['action'])){
			$id = $this -> _urlQuery['id'];
			$path = $folder.$id;
			
			self::$arrayToParse['ID'] = 	$id;
			
			if(is_file($path)){
			
				$content = file_get_contents($path);
				$content=trim($content);

				if($this -> _urlQuery['action']=='edit'){
				//	$this -> editContent();
					if(isset($_POST['content']) and !empty($_POST['content'])){
						$content = trim($_POST['content']);
						
						// pour bien formater le code html
						$old = array (
							'/(?<=<\/h\d>)(?=<)/',                  //01. headings
							'/(?<=<\/div>)(?=<)/',                  //02. div
							'/(?<=<\/p>)(?=<[^\/])/',               //03. paragraph (/noscript exclusion)
							'/(<li>[^<]+)?(<[uo]l>)(?=<li>)/',      //04. nested or opening list  (<li>text)?<uol><li>
							'/(?<=<\/li>)(<\/[uo]l>)(?=<\/li>)/',   //05. nested list  </li></uol></li>
							'/(?<=<\/li>)(<\/[uo]l>)(?!<\/li>)/',   //06. list ending  </li></uol>(not</li>)
							'/(?<=<\/li>)(?=<li>)/',                //07. li
							'/(?<=<br \/>)(?=\S)/',                 //08. br
							'/(?<!br)(?<= \/>)(?=\S)/',             //09. img
							'/(?<=script>)(?=<)/',                  //10. script/noscript
							'/(?<=> \n)(?=<table)/',                //11. table opening [with extra space bug]
							'/(?<=>)(<caption>[^<]*)(?=<\/capt)/',  //12. caption
							'/(<tbody>)(<tr>)/',                    //13. tbody, tr [tbody is always added by wymeditor]
							'/(?<=<\/td>)(?=<td>)/',                //14. td
							'/<\/tr>(<tr>)/',                       //15. tr
							'/(<\/tr>)(<\/tbody>)(<\/table>)/'      //16. table ending
							);
						$new  = array (
							" \n",                                  //01. extra space
							" \n",                                  //02. extra space
							" \n",                                  //03. extra space
							"$1\n $2\n   ",                         //04.
							"\n $1\n   ",                           //05.
							"\n $1 \n\n",                           //06.
							"\n   ",                                //07. 3 spaces (li after li)
							"\n",                                   //08. new textline after a br
							" \n",                                  //09. extra space
							" \n",                                  //10. extra space
							"\n",                                   //11.
							" \n$1",                                //12.
							"\n $1\n $2 \n   ",                     //13.
							"\n   ",                                //14.
							"\n </tr>\n $1 \n   ",                  //15.
							"\n $1\n $2 \n$3 \n\n"                  //16.
							);
						$content = preg_replace($old, $new, $content);
						// DATA UPDATE
						$handle = fopen($path,"w+"); 
						if($handle){		// If successful
							// $content = preg_replace( '#{CssPath}#', $ulrCSS, $content );
							fwrite($handle,$content);
							fclose($handle); 
						}
						// date of modification (warning : modification are saved!)
						self::$multiArrayToParse[]=array('info'=>array( 'DATE'	=> date('l j  F Y H:i:s'))); 
					}
					
					self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $this->urlAddQuery(array(),true),
															'NAME' 	=> self::$arrayToParse['INFO_TITRE'],
															'TITLE' 	=> self::$arrayToParse['INFO_TITRE'],
															'IS_LINK' 	=> true
										));
					self::$arrayToParse['CURRENT_CRUMB'] = $id;
				
					$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
					self::$arrayToParse['CONTENT'] = 	$content;
					
					$this->_templateNameModule = 'edit';
				//	$urlCss = BASE_URL.$this->_config['path']['design'].$design['theme'].'/'.$design['style'].'/'.$this->_config['css']['all'];
					$this -> wyMeditor('df.css');
					//$this -> wyMeditor('');
				}elseif($this -> _urlQuery['action']=='delete'){
					// si le formulaire est activé
					if(isset($_POST) and !empty($_POST)){
						// si on veut supprimer l'encart, on le supprime
						if(isset($_POST['ok']) && $_POST['ok'] == 'ok'){	
							// On supprime la page
							unlink($path);
							 FrontController::redirect(basename($this->urlAddQuery('',true)));
						}else{
							$this->_templateNameModule = 'page';
							$redirectPaht = basename(parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH ));
							$redirectPaht  = $_SERVER['SERVER_NAME'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
							 FrontController::redirect(basename($this->urlAddQuery(array(),true)));
							// echo basename($this->urlAddQuery('',true));
							
						}
					}
					self::$arrayToParse['LIGHT_CONTENT'] = $content;

					$this->_templateNameModule = 'delete';
				}
			}else{
				FrontController::redirect(basename($this->urlAddQuery('',true)));
			}
			
		}		
	}
}

?>