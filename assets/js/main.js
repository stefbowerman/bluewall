(function($){

	// Infinite Scroller

	function ScrollAjax($el){
		var self           = this,
			$appendEl      = $el,
			$loader        = $('#loader'),
			$streamEnd     = $('#stream-end'),
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

					$loader.fadeOut('600', function(){
						$streamEnd.fadeIn();
					});

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

	// Scroll to Top

	function topScroller(){

		var $win     = $(window),
			$el      = $('.scroll-me-up'),
			checking = false; // Lock for scroll event throttling

		checkPosition = function(){
			checking = true;

			$win.scrollTop() > 5000 ? $el.removeClass('off-stage') : $el.addClass('off-stage');
				
			setTimeout(function(){checking=false}, 100);
		};

		$win.on('scroll', function(){
			if(checking === false){
				checkPosition();				
			}
			return false;
			
		});

		$('.scroll-me-up').find('a').click(function(){
			checking = true
			$el.addClass('off-stage');
			$("body").animate({ scrollTop: 0 }, "slow", function(){checking = false});
			
		})

	}

	$(function() {
		
		// Create infinite scroll
		window.scrollAjax = new ScrollAjax($('#content-stream'));

		// Create a top scroller
		new topScroller();

		
		// Fade in Content
		$('#content-stream, header').addClass('opacity-hide');

		if($('html').hasClass('csstransitions')){ // Use CSS3 if supported	
			
			setTimeout(function(){
					$('#content-stream, header')
					.addClass('opacity-trans-show');
			}, 300);
			

		}else{ // Fallback to jquery animation

			$('#content-stream, header').css({opacity: 0});

			setTimeout(function(){
				$('#content-stream, header').animate({opacity:1}, 1200, function(){
					$('#content-stream, header').removeClass('opacity-hide');
				});
			}, 300);
		}
		
		

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
