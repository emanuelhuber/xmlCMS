<?php

/* //extends ModuleSquelette
class ModulePluginCitationAleatoire extends ModuleAdmin{
protected $_plugin = '';
	
	public function __construct($url, $query, $urlArray, $conf){
		parent::__construct($url, $query, $urlArray, $conf);		
		require(ROOT_PATH.$this->_config['librairie']['interstitium'].'page.class.php');
		
		self::$myPage = new Xml_Page($urlArray);
		$this->_plugin = $urlArray[2];
	}
	
	public function setData(){ */
		$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
		self::$arrayToParse['CURRENT_CRUMB'] = self::$arrayToParse['INFO_TITRE'];
		
		$folder =  ROOT_PATH.$this -> _config['path']['data'].'plugin/'.$this->_plugin.'/';
		// Creation d'une nouvelle collection de citation (via formulaire)
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$fileName = self::removeAccents(urldecode($_POST['title']), $charset='utf-8',$del=false);
			$fileName = strtolower($fileName);
			$filePath = $folder.$fileName.'.txt';
			file_put_contents($filePath, 'citation1#référence1'.chr(13).' citation2#références2'.chr(13));
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
					if(isset($_POST['content']) and !empty($_POST['content'])){
						$content = trim($_POST['content']);
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
					
				
				
					$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
					self::$arrayToParse['CONTENT'] = 	$content;
					
					$this->_templateNameModule = 'edit';
					// $this -> wyMeditor('');
					
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
							 FrontController::redirect(basename($this->urlAddQuery('',true)));
							// echo basename($this->urlAddQuery('',true));
							
						}
					}
					self::$arrayToParse['LIGHT_CONTENT'] = $content;

					$this->_templateNameModule = 'delete';
				}
			}else{
				FrontController::redirect(basename($this->urlAddQuery('',true)));
			}
			self::$multiArrayToParse[]= array('crumbs' => array('LINK' 	=> $this->urlAddQuery(array(),true),
															'NAME' 	=> self::$arrayToParse['INFO_TITRE'],
															'TITLE' 	=> self::$arrayToParse['INFO_TITRE'],
															'IS_LINK' 	=> true
										));
					self::$arrayToParse['CURRENT_CRUMB'] = $id;
			
		}
		
	/* }

} */













		
			/* $content = file_get_contents($path);
			$content=trim($content);
			
			if(isset($_POST['content']) and !empty($_POST['content'])){
				$content = trim($_POST['content']);
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
			
			
			
			$this -> formTarget($_SERVER['REQUEST_URI'], 'FICHIER_CIBLE');
			self::$arrayToParse['CONTENT'] = 	$content;
			
			$this->_templateNameModule = 'edit';
			//$this -> wyMeditor(''); */
			
		
	
/* 	function compress( $srcFileName, $dstFileName )
{
    // getting file content
    $fp = fopen( $srcFileName, "r" );
    $data = fread ( $fp, filesize( $srcFileName ) );
    fclose( $fp );
   
    // writing compressed file
    $zp = gzopen( $dstFileName, "w9" );
    gzwrite( $zp, $data );
    gzclose( $zp );
}

function uncompress( $srcFileName, $dstFileName, $fileSize )
{
    // getting content of the compressed file
    $zp = gzopen( $srcFileName, "r" );
    $data = fread ( $zp, $fileSize );
    gzclose( $zp );
   
    // writing uncompressed file
    $fp = fopen( $dstFileName, "w" );
    fwrite( $fp, $data );
    fclose( $fp );
}

compress( "tmp/supportkonzept.rtf", "tmp/_supportkonzept.rtf.gz" );
uncompress( "tmp/_supportkonzept.rtf.gz", "tmp/_supportkonzept.rtf", filesize( "tmp/supportkonzept.rtf" ) );
 */
	
	
	
	
	
		//chargement du fichier
		/* $dom = self::openDomXml(BASE_PATH.$this->_config['path']['conf'].$this -> _urlArray[1].$this->_config['ext']['data']);
		$modules = $dom -> getElementsByTagName('item');
		
		foreach($modules as $mod){
			self::$multiArrayToParse[] = array('liste' => array('NOM' => $mod -> getAttribute('nom'),
																'ID' => $mod -> getAttribute('id'),
																'ACTIF' => $mod -> getAttribute('actif'),
																'TYPE' => $mod -> getAttribute('type'),
																'DESCRIPTION' => $mod -> getAttribute('description'),
																// 'LINK' => $this->urlAddQuery(array('id'=>$mod -> getAttribute('id')),true,)
																'LINK' => BASE_URL.'/fr,plugin,'.strtolower($mod -> getAttribute('id')).'.html'
																));
		}
		if(isset($this -> _urlQuery['id']) && !empty($this -> _urlQuery['id'])){
			$id = $this -> _urlQuery['id'];
			$classPath =  ROOT_PATH.'/plugin/'.$id.'.php' ;
			//echo $classPath;
			// on inclut le plugin
			require($classPath);
			$plugin = new $id;
		}else{
		
		
		} */
		
		


?>