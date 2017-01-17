<?php

define('INTERSTITIUM_CONF', 'conf/config.ini') ;
if(dirname($_SERVER["SCRIPT_NAME"]) == '/'){
	define('BASE_URL','');
}else{
	define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)
}
define('BASE_PATH',realpath('.'));						// for server side inclusions.
//define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)

	
	$filePath = BASE_PATH.'/data/upload/index.xml';
	$dataDom = new DomDocument();
	$dataDom -> formatOutput = true;
	$dataDom -> preserveWhiteSpace = true; 
	if(is_file($filePath)){
		if($dataDom -> load($filePath)){
			
			
			$dataXPath = new DOMXPath($dataDom);
			$query = '//item[@categorie="image"]';	
			$items = $dataXPath -> query($query);
			
			
			
			
			
		/* 	$images = $dataDom -> getElementsByTagName('image')->item(0);
			$items = $images -> getElementsByTagName('item'); */
		
			$listeimg='';

			//XXX $listeimg .= '<ul id="mycarousel" class="jcarousel-skin-tango">';
			 $i=1; 
			
			
			foreach($items as $item){
				$fileId  = $item -> getAttribute('id');
				$fileExt = $item -> getAttribute('ext');
				$fileTitle = $item -> getAttribute('title');
				//$fileCat = $item -> getAttribute('categorie');
				if(is_file(BASE_PATH.'/data/upload/image/miniatures/'.$fileId.'.jpg') 
				&& is_file( BASE_PATH.'/data/upload/image/'.$fileId.'.'.$fileExt)){ 
					$url = 'http://'.$_SERVER['SERVER_NAME'].BASE_URL.'/data/upload/image/miniatures/'.$fileId.'.'.$fileExt;
					$shortUrl = BASE_URL.'/data/upload/image/'.$fileId.'.'.$fileExt;
					//XXX $listeimg .= '<li class="jcarousel-item-'.$i.'"><img src="' . $url . '" width="96px" height="96px" alt="'.$item -> textContent.'" title="'.$fileTitle.'" /></li>';
					$listeimg .= '<a class="lister" href="'.$shortUrl.'" title="'.$item -> textContent.'"><img class="lister" src="' . $url . '" width="96px" height="96px" alt="'.$item -> textContent.'" title="'.$fileTitle.'" /></a>';
					$i++;
				} 
			}
			//XXX $listeimg .= '</ul>';
			
			header("Content-Type: text/html; charset=UTF-8");
			echo $listeimg;
		}else{
			return false;
		}
		
	}else{
		return false;
	}

// Array indexes are 0-based, jCarousel positions are 1-based.
/* $first = max(0, intval($_GET['first']) - 1);
$last  = max($first + 1, intval($_GET['last']) - 1);

$length = $last - $first + 1;
 */
// ---

$images = array(
    'http://static.flickr.com/66/199481236_dc98b5abb3_s.jpg',
    'http://static.flickr.com/75/199481072_b4a0d09597_s.jpg',
    'http://static.flickr.com/57/199481087_33ae73a8de_s.jpg',
    'http://static.flickr.com/77/199481108_4359e6b971_s.jpg',
    'http://static.flickr.com/58/199481143_3c148d9dd3_s.jpg',
    'http://static.flickr.com/72/199481203_ad4cdcf109_s.jpg',
    'http://static.flickr.com/58/199481218_264ce20da0_s.jpg',
    'http://static.flickr.com/69/199481255_fdfe885f87_s.jpg',
    'http://static.flickr.com/60/199480111_87d4cb3e38_s.jpg',
    'http://static.flickr.com/70/229228324_08223b70fa_s.jpg',
);


/* $listeimg='';

$listeimg .= '<ul id="mycarousel" class="jcarousel-skin-tango">';
$i=1; */
/* foreach ($images as $img) {
    $listeimg .= '<li class="jcarousel-item-'.$i.'"><img src="' . $img . '" width="75px" height="75px" alt="yep" title="titan" /></li>';
	$i++;
} 
$listeimg .= '</ul>';

echo $listeimg;

*/
?>