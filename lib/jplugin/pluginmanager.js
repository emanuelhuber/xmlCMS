function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}


var xhr = getXMLHttpRequest();

// GET
/* xhr.open("GET", "handlingData.php?variable1=truc&variable2=bidule", true);
xhr.send(null); */


// POST
xhr.open("POST", "../image_list.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.send("variable1=truc&variable2=bidule");


/* open s'utilise de cette façon : open(sMethod, sUrl, bAsync)

    * sMethod : la méthode de transfert : GET ou POST;
    * sUrl : la page qui donnera suite à la requête. Ça peut être une page dynamique (PHP, CFM, ASP) ou une page statique (TXT, XML...);
    * bAsync : définit si le mode de transfert est asynchrone ou non (synchrone). Dans ce cas, mettez true . Ce paramètre est optionnel et vaut true par défaut, mais il est courant de le définir quand même (je le fais par habitude). */

$j(function() {
	//set up your AJAX call
	$.ajax({ 
	  type: "POST", 
	  url: "../image_list.php", 		//path to your PHP function
	  // url: "http://localhost/www/interstitium/lib/jcarousel/dynamic_ajax_php.php", 		//path to your PHP function
	  data: "img=test&stamp=now", 					//not required for this example, but you can POST data to your PHP function like this
	  success: function(msg){ 						//trigger this code if the PHP function successfully returns data
		//inject the image list into the target div with ID of "gallery"
		$("div#manu").html(msg);
	  }
	  /* //assign behaviors to the jCarousel thumbnails, triggered when they are clicked upon.
		$(".jcarousel-skin-tango img").click(function() {
			//$(this) is a reference to the thumbnail that got clicked
			$("input.wym_src").val($(this).attr('src'));		//inject the thumb's src attribute into the wym_src input
			$("input.wym_alt").val($(this).attr('alt'));		//inject the thumb's alt attribute into the wym_alt input
			$("input.wym_title").val($(this).attr('title'));	//inject the thumb's title attribute into the wym_title input

			//loop through all the images and remove their "on" states if it exists		
			$(".jcarousel-skin-tango img").each(function(i){ 
			  $(this).removeClass("on"); 
			});
			//add "on" state to the selected image
			$(this).addClass("on").fadeIn('slow');
		}) */
	});
});
	  
	  