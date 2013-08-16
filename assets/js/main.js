
$(function(){

	var bubblingList = {} /* Object to store state of each circle */ ,
		circles = $('.circle') /* Cache the circles */;

	function getRandomInt (min, max) {
	    return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	
	function randomBubble(){
		var index = getRandomInt(0, circles.length);

		if(typeof(bubblingList[index]) != "undefined"){
			return false;
		}
		
		var $circle = $(circles[index]);

		$circle.addClass('hover');

		bubblingList[index] = setTimeout( function(){
												// Remove the hover class
												$circle.removeClass('hover');
												// Then delete the property under this index key
												delete bubblingList[index];
										  }, 300);
	}

	setInterval(randomBubble, 200);
})