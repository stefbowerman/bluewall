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
			isLoading      = false,
			isComplete     = false;

		this.baseURL = baseURL;

		this.getPage = function(){
			return page;
		}
		this.nextPage = function(){
			page++;
			return this;
		}

		appendMedia = function(html, index, collection){
			
				$html = $(html)
				$appendEl.append( $html );

				if(index+1 == collection.length){

					// Unlock it now that all items have been appended
					isLoading = false;
			
				}

		}

		getNextPageContent = function(callback){

			// Set Lock variable
			isLoading = true;

			// Go to the next page
			self.nextPage();

			// Show loading animation
			$loader.fadeIn('fast');

			$.ajax({

				url: self.baseURL + page,

			})
			.done(function(data) {

				if(data.length){
					$loader.fadeOut('600', function() {
						for (var i = 0; i < data.length; i++) {

							appendMedia( data[i]['html'], i, data );
						}
					});

					if(data.length < 10){
						// If we pull back less than 10 items, we are done
						isComplete = true;
					}

				}else{

					isComplete = true;

					$loader.fadeOut('600');

				}
			
			})
			.fail(function() {

				console.log("error");

			})
			.always(function() {
			
			});
		}

		$win.on('scroll', function(){
			if( isLoading === false && isComplete === false && ($win.scrollTop()/$doc.height() > scrollDistance) ){
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

	function stickyHeader(){

		var $win   = $(window),
			$doc   = $(document),
			$title = $('.header-content'),
			$stickyEl = $('.sticky-header'),
			opacity;

			titleTopDistance    = $title.offset()['top'],
			titleHeight         = $title.height()
			titleBottomDistance = titleHeight + titleTopDistance ;

		$win.on('scroll', function(){
			var scrolledDown = $win.scrollTop()
			
			if( scrolledDown <= titleTopDistance ){
				$stickyEl.css('opacity', 0);
			}
			else if ( scrolledDown >= titleBottomDistance ){
				$stickyEl.css('opacity', 1);
			}
			else if( (scrolledDown > titleTopDistance) && (scrolledDown < titleBottomDistance) ){
				opacity = 1 - (titleBottomDistance - scrolledDown) / titleTopDistance;
				$stickyEl.css('opacity', opacity);
			}
			else{

			}
		});

	}

	$(function() {
		
		window.scrollAjax = new ScrollAjax($('#content-stream'));

		//new bubblingTitle('.circle');

		//new stickyHeader();

		// $('.sticky-header').css('margin-left', 350);
		// setTimeout(function(){
		// 	$('.sticky-header').animate({'margin-left' : 10})
		// 	.css('margin-right', 10);
		// }, 2000)


		$('#content-stream').css({opacity: 0});

		setTimeout(function(){
			$('#content-stream').animate({opacity:1}, 1200);
		}, 300);
		
		

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
