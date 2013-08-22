<div class="post">
	<div class="post-meta clearfix">
		<div class="post-author"></div>
		<div class="post-time">
			<?php echo $media->getCreatedTimeAgo() ?>
		</div>
	</div>

	<?php include(__DIR__.'/location-media-image.php') ?>

	<div class="post-caption">
		<?php echo \Instagram\Helper::parseMentions( $media->getCaption(), $mentionsClosure ) ?>
	</div>
</div>