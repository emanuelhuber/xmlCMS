<?php

define('BASE_PATH',realpath('.'));						// for server side inclusions.
define('BASE_URL', dirname($_SERVER["SCRIPT_NAME"]));	// for client side inclusions (scripts, css files, images etc.)

	header("Content-Type: text/plain");
	
	
	echo '/www/interstitium/admin/design/defaut/css-defaut/style.css';
		

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