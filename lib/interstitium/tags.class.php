<?php
class Tags{

	private $tagArray = null;
	private $pathTag = null;
	
	public function __construct($path){					
		//self::$cms = $interstitium;
		$this -> pathTag = $path;
		$this -> tagArray = $this -> openArray($this -> pathTag);
		//$this -> tagArray = $interstitium::openArray($path);
	}
	
	public function getTags($string = false){
		if($string){
			return self::implodeTags(array_keys($this -> tagArray));
		}else{
			if(!is_array($this -> tagArray)){
				$this -> tagArray = array();
			}
			return  ($this -> tagArray);
		}
	}
	
	
	public function updateTags($oldTag,$newTag,$id){
		
			// $newTags = $this -> explodeTags(htmlspecialchars($newTag, ENT_QUOTES, 'UTF-8'));
			$newTags = $this -> explodeTags($newTag);
			// $odlTags = $this -> explodeTags(htmlspecialchars($oldTag, ENT_QUOTES, 'UTF-8'));
			// 1. Delete all the entries with the id of the page!
			$this -> deleteTags($id);
			/* foreach($this -> tagArray as $clef=>$value){
				// if the page-id exists for a tag
				if(in_array($id, $this -> tagArray[$clef])){
					// find the key(s) where the page-id is and delete it/them.
					$keysToDelete = array_keys($this -> tagArray[$clef], $id);
					foreach($keysToDelete as $keyTo){
						if(count($this -> tagArray[$clef]) == 1){	// si il n'y a qu'un id pour le tag,
							unset( $this -> tagArray[$clef]);		// on supprime le tag
						}else{
							unset( $this -> tagArray[$clef][$keyTo]);
						}
					}
				}
			} */
			// 2. add the new tag (if not existing) and add the page id!
			foreach($newTags as $newTag){
				$this -> tagArray[$newTag][] = $id;
			}
			$this -> saveTag();
			
			
	}
	
	public function deleteTags($id){
		foreach($this -> tagArray as $clef=>$value){
			// if the page-id exists for a tag
			if(in_array($id, $this -> tagArray[$clef])){
				// find the key(s) where the page-id is and delete it/them.
				$keysToDelete = array_keys($this -> tagArray[$clef], $id);
				foreach($keysToDelete as $keyTo){
					if(count($this -> tagArray[$clef]) == 1){	// si il n'y a qu'un id pour le tag,
						unset( $this -> tagArray[$clef]);		// on supprime le tag
					}else{
						unset( $this -> tagArray[$clef][$keyTo]);
					}
				}
			}
		}
		$this -> saveTag();
	
	}
	
	public function saveTag(){
		$this -> writeArray($this -> tagArray, $this -> pathTag);
	}
	
	public static function buildStringTag($tag){
		$tags = self::explodeTags($tag);
		return self::implodeTags($tags);
	}
	
	private static function implodeTags($tags){
		$tag = implode(',',$tags);
		$tag = str_replace(',', ', ', $tag);
		return $tag;
	}
	
	private static function sanitizeTag($tag){
		$tag = trim(trim($tag), ","); // supprimer les espaces + virgules en début/fin de taging
		$tag = strip_tags($tag); // supprimer les balises de codes
		$tag = str_replace(array('?','&','#','=','+','<','>'), '', $tag);
		$tag = preg_replace( '#\s+#', ' ', $tag );
		$tag = self::_utf8ToHtml($tag, true);
		/* $tag = utf8_decode($tag);
		$tag = htmlentities($tag, ENT_QUOTES);		//, 'UTF-8');
		$tag = utf8_encode($tag); */
		return $tag;
	}
	
	private static function explodeTags($tag){
		$tags = array();
		$tag = trim(trim($tag), ','); // supprimer les espaces + virgules en début/fin de string
		$tagsToSanitize = explode(',',$tag);
		foreach($tagsToSanitize as $i => $value){
			if ($value = self::sanitizeTag(trim($value)))
				$tags[$i] = $value;
		}
		return array_unique($tags);
	}
	
	// converts a UTF8-string into HTML entities
	//  - $utf8:        the UTF8-string to convert
	//  - $encodeTags:  booloean. TRUE will convert "<" to "&lt;"
	//  - return:       returns the converted HTML-string
	private static function _utf8ToHtml($utf8, $encodeTags) {
		$result = '';
		for ($i = 0; $i < strlen($utf8); $i++) {
			$char = $utf8[$i];
			$ascii = ord($char);
			if ($ascii < 128) {
				// one-byte character
				$result .= ($encodeTags) ? htmlentities($char) : $char;
			} else if ($ascii < 192) {
				// non-utf8 character or not a start byte
			} else if ($ascii < 224) {
				// two-byte character
				$result .= htmlentities(substr($utf8, $i, 2), ENT_QUOTES, 'UTF-8');
				$i++;
			} else if ($ascii < 240) {
				// three-byte character
				$ascii1 = ord($utf8[$i+1]);
				$ascii2 = ord($utf8[$i+2]);
				$unicode = (15 & $ascii) * 4096 +
						   (63 & $ascii1) * 64 +
						   (63 & $ascii2);
				$result .= "&#$unicode;";
				$i += 2;
			} else if ($ascii < 248) {
				// four-byte character
				$ascii1 = ord($utf8[$i+1]);
				$ascii2 = ord($utf8[$i+2]);
				$ascii3 = ord($utf8[$i+3]);
				$unicode = (15 & $ascii) * 262144 +
						   (63 & $ascii1) * 4096 +
						   (63 & $ascii2) * 64 +
						   (63 & $ascii3);
				$result .= "&#$unicode;";
				$i += 3;
			}
		}
		return $result;
	}
	
	public static function writeArray($data, $path){
		file_put_contents($path, serialize($data));

	}
	
	public static function openArray($path){
		if(is_file($path)){
			if(is_array(unserialize(file_get_contents($path)))){
				return unserialize(file_get_contents($path));
			}else{
				return array();
			}
		}else{
			return array();
		}
	}
	
/* 	private static function sanitizeMetaID($str, $keep_slashes=false, $keep_spaces=true){	
		$str = trim(trim($str), ",");
		$str = strip_tags($str);
		$str = str_replace(array('?','&','#','=','+','<','>'), '', $str);
		$str = str_replace("'", '', $str);
		$str = preg_replace('/[\s]+/', ' ', trim($str));

		if (!$keep_slashes) {
			$str = str_replace('/','-',$str);
		}
		
		if (!$keep_spaces) {
			$str = str_replace(' ','-',$str);
		}
		
		$str = preg_replace('/[-]+/','-',$str);
		
		# Remove path changes in URL
		$str = preg_replace('%^/%','',$str);
		$str = preg_replace('%\.+/%','',$str);
	
		return strtolower($str);
	}
	
	private static function splitMetaValues($str)
	{

		$res = array();
		$str = trim(trim($str), ",");
		foreach (explode(',',$str) as $i => $tag)
		{
			if ($tag = tags::sanitizeMetaID(trim($tag)))
				$res[$i] = $tag;
		}
		
		return array_unique($res);
	}
	 */


}



?>