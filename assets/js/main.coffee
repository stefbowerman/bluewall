ScrollAjax = ($el) ->
	self 		   = this
	$appendEl      = $el
	$loader        = $('#loader')
	$streamEnd     = $('#stream-end')
	$win           = $(window)
	$doc           = $(document)
	baseURL        = '/ajax/media.php?page='
	page           = 1
	scrollDistance = 0.65
	isLoading      = false
	isComplete     = false

	@baseURL = baseURL

	@getPage = -> page
	@nextPage = ->
		page++
		@

	appendMedia = (html, index, collection) ->
		$html = $ html
		$appendEl.append $html

		isLoading = false if index+1 is collection.length

	getNextPageContent = (callback) ->

		# Set Lock variable
		isLoading = true

		# Go to the next page
		self.nextPage()

		# Show loading animation
		$loader.fadeIn('fast')

		$.ajax( 
			url : self.baseURL + page
		)
		.done( (data) ->
			if data.length
				$loader.fadeOut '600', ->
					for i in [0...data.length] by 1
						appendMedia data[i]['html'], i, data

				if data.length < 10
					isComplete = true  # If we pull back less than 10 items, we are done
					$loader.fadeOut 
						duration: '600'
						always : -> $streamEnd.fadeIn()
			else
				isComplete = true
				$loader.fadeOut 
					duration : '600'
					always :  -> $streamEnd.fadeIn()
		).fail(
			-> console.log "error getting page #{page}"
		)

	$win.on 'scroll', -> # TODO - Change this to load when there are less than X num images remaining
		do getNextPageContent if isLoading is false && isComplete is false && ($win.scrollTop()/$doc.height() > scrollDistance)

	return this

TopScroller = ->

	$win = $ window
	$el = $ '.scroll-me-up'
	checking = false # Lock for scroll event throttling

	checkPosition = ->
		checking = true

		if $win.scrollTop() > 5000 then $el.removeClass('off-stage') else $el.addClass('off-stage');

		setTimeout ->
			checking = false
		, 300

	$win.on 'scroll', ->
		do checkPosition if checking is false
		return false

	$el.on 'click', 'a', ->
		checking = true
		$el.addClass 'off-stage'
		$('body').animate
			scrollTop: 0
		, 300, -> checking = false

attachImageErrorHandler = ->
	$('img').each (i) ->
		img = @
		$img = $(img)
		unless $img.data 'imageErrorHandler:attached'
			img.onerror = ->
				$parentPost = $img.parents('.post')
				$parentPost.remove()

				$img.data('imageErrorHandler:attached', true)
				## Call AJAX to remove the image from the DB and reset the cache

$(window).ajaxComplete -> do attachImageErrorHandler # Attach handler any time an AJAX request returns

$ ->
	# DOM ready

	do attachImageErrorHandler

	@scrollAjax = new ScrollAjax($('#content-stream'))

	new TopScroller()

	$('#content-stream, header').addClass 'opacity-hide'

	if $('html').hasClass('csstransitions') # Use CSS3 if supported	
		setTimeout ->
			$('#content-stream, header').addClass('opacity-trans-show')
		, 300
	else
		$('#content-stream, header').css
			opacity: 0

			setTimeout ->
				$('#content-stream, header').animate
					opacity:1
				, 1200, -> $('#content-stream, header').removeClass 'opacity-hide'
			, 300

