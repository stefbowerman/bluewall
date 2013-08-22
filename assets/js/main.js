(function($){

	// Infinite Scroller

	function ScrollAjax($el){
		var self           = this,
			$appendEl      = $el,
			$loader        = $('#loader'),
			$win           = $(window),
			$doc           = $(document),
			baseURL        = '/ajax/media.php?page=',
			page           = 1,
			scrollDistance = 0.65,
			isLoading      = false;

		this.baseURL = baseURL;

		this.getPage = function(){
			return page;
		}
		this.nextPage = function(){
			page++;
			return this;
		}

		appendMedia = function(html, index){

			$appendEl.append( $(html) );

		}

		getNextPageContent = function(callback){
			// Set Lock variable
			isLoading = true;

			// Go to the next page
			self.nextPage();

			// Show loading animation
			$loader.show();

			$.ajax({

				url: self.baseURL + page,

			})
			.done(function(data) {

				if(data.length){

					for (var i = 0; i < data.length; i++) {

						appendMedia( data[i]['html'], i);
					}


				}else{
					// Remove the scroll handler
					$win.unbind('scroll');

					// Replace the loader?  Remove it?

					$loader.remove();

				}
			
			})
			.fail(function() {

				console.log("error");

			})
			.always(function() {

				isLoading = false;

				$loader.hide();
			
			});
		}

		$win.on('scroll', function(){
			if( isLoading === false && ($win.scrollTop()/$doc.height() > scrollDistance) ){
					getNextPageContent();
	    	}
		})

		return this;
	}

	// Bubbling Header

	function bubblingTitle(circleClass){
		var bubblingList = {} /* Object to store state of each circle */ ,
			circles = $(circleClass) /* Cache the circles */;

		getRandomInt = function(min, max) {
		    return Math.floor(Math.random() * (max - min + 1)) + min;
		}
		
		randomBubble = function(){
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
	}

	$(function() {
		
		new ScrollAjax($('#content-stream'));

		new bubblingTitle('.circle');

		

		

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
	});

}(jQuery));
