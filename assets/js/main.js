function ScrollAjax($el){
	var self          = this,
		$appendEl     = $el,
		$win          = $(window),
		$doc          = $(document),
		baseURL       = '/ajax/media.php?page=',
		page          = 1,
		isLoading     = false;

	this.baseURL = baseURL;

	this.getPage = function(){
		return page;
	}
	this.nextPage = function(){
		page++;
		return this;
	}

	getNextPageContent = function(callback){
		isLoading = true;

		console.log('fetching content');

		self.nextPage();

		$.ajax({
			url: self.baseURL + page,
		})
		.done(function(data) {

			if(data.length){
				for (var i = 0; i < data.length; i++) {

					$appendEl.append( data[i]['html'] );
				}

			}else{
				$win.unbind('scroll');
				$appendEl.append('NO MORE CONTENT');
			}
		
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			isLoading = false;
			//console.log('done fetching content');
		});
	}

	$win.on('scroll', function(){
		if(isLoading === false && ($win.scrollTop()/$doc.height() > 0.75) ){
				getNextPageContent();
    	}
	})

	return this;
}


$(function(){

	var infiniteScroll = new ScrollAjax($('#content-stream'));

	// Bubbling Header

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

	// Viewing Videos

	$('.play-button').click(function(){
		$('img[data-video-url]').trigger('click');
		$('.media-play').hide();
	});

	$('img[data-video-url]').click(function(){
		var $self = $(this),
			$video = $('<video></video>'),
			$source = $('<source></source'),
			url = $self.data('video-url');

		$source.attr('src', url).attr('type', 'video/mp4');

		$video.html($source).hide();
		$self.after($video);
		$self.hide();
		$video.show();

		$video.get(0).play();

		$video.on('click', function (e) {
		    if (this.paused) {
		        this.play();
		        $('.media-play').hide();
		    }
		    else {
		        this.pause();
		        $('.media-play').show();
		    }
		    e.preventDefault();
		});

		$video.on('ended', function(){
			$video.hide();
			$self.show();
			$('.media-play').show();
			$video.remove();
		})
	});
})