<?php

include_once( __DIR__ . '/bootstrap.php');

if( $cache->fileExists() && $cache->isFresh() ){

  	// If a cache file exists, and it is newer than 1 hour, use it
	$mediaCollection = New Instagram\Collection\MediaCollection();
	$mediaCollection->setData( $cache->getMediaCollectionData() );
	
	// Need to update cache to save $location ?

}
else{

	// Create a new Instagram Instance
	$instagram = new Instagram\Instagram;
	$instagram->setAccessToken( $accessToken );

	// Grab the location
	$location = $instagram->getLocation( $target['id'] );

	// Then grab the media from that location
	$mediaCollection = $location->getMedia();

	// Create / Update the JSON cache
	$cache->writeWithMediaCollection($mediaCollection);

	// Write the new media to the DB if there is any
	require( 'tasks/pull.php');
}


require( 'views/_header.php' );

foreach($mediaCollection as $media)
	require( 'views/location-media.php' );

require( 'views/_footer.php' );
