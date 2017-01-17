


var $j = jQuery.noConflict();

$j(function() {
	//set up your AJAX call
	$.ajax({ 
	  type: "POST", 
	  url: "../listerPlugin.php", 		//path to your PHP function
	  // url: "http://localhost/www/interstitium/lib/jcarousel/dynamic_ajax_php.php", 		//path to your PHP function
	  data: "img=test&stamp=now", 					//not required for this example, but you can POST data to your PHP function like this
	  success: function(msg){ 						//trigger this code if the PHP function successfully returns data
		
		//inject the image list into the target div with ID of "gallery"
		$("div#list_plugin").html(msg);
		
		//assign behaviors to the jCarousel thumbnails, triggered when they are clicked upon.
		$("a.plug").click(function(e) {
			e.preventDefault();

			//$(this) is a reference to the thumbnail that got clicked
			//$("input.wym_txt").val($(this).text());		//inject the thumb's src attribute into the wym_src input
			$("input.wym_txt").val($(this).attr('title'));
	
	
		})
	  }  
	});
	});