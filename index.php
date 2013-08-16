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
	$mediaCollection = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

	$cache->writeWithMediaCollection($mediaCollection);
}

$media = $mediaCollection->getFirst();

require( 'Views/_header.php' );
require( 'Views/location.php' );
require( 'Views/_footer.php' );
