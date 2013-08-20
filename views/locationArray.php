<?php foreach($mediaCollection as $media):?>
	<div class="post" data-id="<?php echo $media->getId()?>" data-created-at="<?php echo $media->getCreatedTime('U') ?>">
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
<?php endforeach;?>
