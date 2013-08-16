<?php

require( __DIR__ . '/bootstrap.php');

if( $cache->fileExists() && $cache->isFresh() ){
  // If a cache file exists, and it is newer than 1 hour, use it
	$mediaCollection = New Instagram\Collection\MediaCollection();
	$mediaCollection->setData( $cache->getMediaCollectionData() );

}
else{

	$instagram = new Instagram\Instagram;
	$instagram->setAccessToken( $accessToken );

	$location = $instagram->getLocation( $target['id'] );
	$mediaCollection = $location->getMedia();

	$cache->writeWithMediaCollection($mediaCollection);
}

$media = $mediaCollection->getFirst();

require( 'views/_header.php' );
require( 'views/location.php' );
require( 'views/_footer.php' );
