<div class="post">
	<div class="post-meta clearfix">
		<div class="post-author">
			<i class="icon-heart"></i>
			<?php echo $media->getLikesCount()?>
		</div>
		<div class="post-time">
			<?php echo $media->getCreatedTimeAgo() ?>
			<i class="icon-globe"></i>
		</div>
	</div>

	<?php include(__DIR__.'/location-media-image.php') ?>

	<?php if($media->getCaption()):?>
		<div class="post-caption">
			<?php echo \Instagram\Helper::parseMentions( $media->getCaption(), $mentionsClosure ) ?>
		</div>
	<?php endif?>
</div>