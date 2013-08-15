<?php $media = $media->getSlice( 0, 10 )?>

<div id="content">

	<?php if( isset( $error ) ): ?><p id="error"><?php echo htmlspecialchars( $error ) ?></p><?php endif; ?>

	<?php foreach ($media as $k => $m):?>
		
		<?php if( !$k ): ?>

			<div style="margin-bottom:50px">
				<div style="text-align:right; margin-bottom:10px; font-size:13px">
					<?php echo $m->getCreatedTime( $timeFormat ) ?>
					<?php echo Utils::time_ago( $m->getCreatedTime() ) ?>
				</div>
				<a href="<?php echo $m->getLink() ?>">
					<img src="<?php echo $m->getStandardRes()->url ?>">
				</a>
				<div style="text-align:center">
					<?php echo \Instagram\Helper::parseMentions( $m->getCaption(), $mentionsClosure ) ?>
				</div>
			</div>

		<?php else: ?>

			<div style="width:200px; height:400px;float:left; margin-bottom:30px;">
				<div style="text-align:right; margin-bottom:10px; font-size:13px">
					<?php echo $m->getCreatedTime( $timeFormat ) ?>
					<?php echo Utils::time_ago($m->getCreatedTime()) ?>
				</div>
				<a href="<?php echo $m->getLink() ?>">
					<img src="<?php echo $m->getLowRes()->url ?>" style="max-width:100%">
				</a>
				<div style="text-align:center">
					<?php echo \Instagram\Helper::parseMentions( $m->getCaption(), $mentionsClosure ) ?>
				</div>
			</div>
			
		<?php endif ?>

	<?php endforeach ?>

</div>

<?php if(false):?>
	<h2>Location</h2>

	<h3><?php echo $location ?></h3>

	<h4>Recent Media<?php if( $media->getNextMaxId() ): ?> <a href="?example=location.php&location=<?php echo $location->getId() ?>&max_id=<?php echo $media->getNextMaxId() ?>" class="next_page">Next page</a><?php endif; ?></h4>

	<ul class="media_list">
	<?php foreach( $media as $m ): ?>
	<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
	<?php endforeach; ?>
<?php endif?>