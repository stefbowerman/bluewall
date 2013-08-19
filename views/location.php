<?php if( isset( $error ) ): ?><p id="error"><?php echo htmlspecialchars( $error ) ?></p><?php endif; ?>

<div id="content-stream" class="grid_8 push_2">
	<div class="post">
		<div class="post-meta clearfix">
			<div class="post-author"></div>
			<div class="post-time">
				<?php //echo $media->getCreatedTime( $timeFormat ) ?>
				<?php echo $media->getCreatedTimeAgo() ?>
			</div>
		</div>

		<?php include(__DIR__.'/location-image.php') ?>
		<?php //include(__DIR__.'/location-'.$media->getType().'.php') ?>

		<div class="post-caption">
			<?php echo \Instagram\Helper::parseMentions( $media->getCaption(), $mentionsClosure ) ?>
		</div>
	</div>
</div>