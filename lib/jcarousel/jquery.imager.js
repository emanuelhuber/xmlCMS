// JavaScript Document

var $j = jQuery.noConflict();

$j(function() {
	//set up your AJAX call
	$.ajax({ 
	  type: "POST", 
	  url: "../image_list.php", 		//path to your PHP function
	  // url: "http://localhost/www/interstitium/lib/jcarousel/dynamic_ajax_php.php", 		//path to your PHP function
	  data: "img=test&stamp=now", 					//not required for this example, but you can POST data to your PHP function like this
	  success: function(msg){ 						//trigger this code if the PHP function successfully returns data
		/*
			The PHP function needs to return an image UL with the following prototype:*/
			/* <ul id="mycarousel" class="jcarousel-skin-tango">
				<li><img src='http://www.test.com/upload/titan.jpg' width='68' height='60' alt='Tennessee Titans Running Back Taken Christmas Eve 2006 At Ralph Wilson Stadium In Buffalo Ny - added  04:05 PM, 07/02/2007' title='titan' /></li>
				<li><img src='http://www.test.com/upload/canyon.jpg' width='68' height='60' alt='Grand Canyon With Storm Clouds Viewed From South Western Edge - added  04:03 PM, 07/02/2007' title='nosebleed' /></li>
				<li><img src='http://www.test.com/upload/img_2_big.jpg' width='68' height='60' alt='Another Chair From Fidm Museum - added  06:19 AM, 06/30/2007' title='chair' /></li>
			</ul>
			 */
			/*The returning HTML is contained in the msg variable.
		*/
		
		//inject the image list into the target div with ID of "gallery"
		$("div#gallery").html(msg);
		 
		 //Once the list is in place we can create a new instance of jCarousel and point it at the image list
		 //which has an ID of 'mycarousel'. For more information on these options see http://sorgalla.com/jcarousel/
		jQuery('#mycarousel').jcarousel({
			easing: 'backinout',
			visible: 3,
			animation: 500
			
		});
		
		//assign behaviors to the jCarousel thumbnails, triggered when they are clicked upon.
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
		})
	  }  
	});
});
