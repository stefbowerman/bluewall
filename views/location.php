
<div id="content">

	<?php if( isset( $error ) ): ?><p id="error"><?php echo htmlspecialchars( $error ) ?></p><?php endif; ?>

	<?php $m = $media[0];?>

	<div style="text-align:right; margin-bottom:10px; font-size:13px">
		<?php echo $m->getCreatedTime('n.j.Y') ?>
	</div>
	<img src="<?php echo $m->getStandardRes()->url ?>">
	<div style="text-align:center"><?php echo $m->getCaption() ?></div>


	<?php if(false):?>
		<h2>Location</h2>

		<h3><?php echo $location ?></h3>

		<h4>Recent Media<?php if( $media->getNextMaxId() ): ?> <a href="?example=location.php&location=<?php echo $location->getId() ?>&max_id=<?php echo $media->getNextMaxId() ?>" class="next_page">Next page</a><?php endif; ?></h4>

		<ul class="media_list">
		<?php foreach( $media as $m ): ?>
		<a href="?example=media.php&media=<?php echo $m->getId() ?>"><img src="<?php echo $m->getThumbnail()->url ?>"></a>
		<?php endforeach; ?>
	<?php endif?>
</div>