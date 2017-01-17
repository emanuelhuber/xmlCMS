

/* var $j = jQuery.noConflict();

$j(function() { */
	//set up your AJAX call
	$.ajax({ 
	  type: "POST", 
	  url: "http://localhost/www/interstitium/module/javaLogin.php", 		//path to your PHP function
	  // url: "http://localhost/www/interstitium/lib/jcarousel/dynamic_ajax_php.php", 		//path to your PHP function
	  data: "img=test&stamp=now", 					//not required for this example, but you can POST data to your PHP function like this
	  error:function(msg){
		alert( "Error !: " + msg );
		},
	  success: function(msg){ 						//trigger this code if the PHP function successfully returns data
		
		//inject the image list into the target div with ID of "gallery"
		/* msg = "<h3>" + msg + "</h3>"; */
		alert(msg);
		$("div#myLogin").html(msg);
	  }

	});
/* });
 */