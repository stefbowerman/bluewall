<?php

require( __DIR__ . '/bootstrap.php');

$cache = './cache.json';

if( file_exists($cache) && filemtime($cache) > time() - 60*60 ){
  // If a cache file exists, and it is newer than 1 hour, use it
	$arraySerials = json_decode(file_get_contents($cache),false);
	$collection = array();
	foreach ($arraySerials as $key => $serial)
		$collection[] = unserialize($serial);

	$cacheData = new stdClass();
	$cacheData->data = $collection; // setData needs the $arg to respond to $arg->data
	$media = New Instagram\Collection\MediaCollection();
	$media->setData($cacheData);

}
else{

	$instagram = new Instagram\Instagram;
	$instagram->setAccessToken( $accessToken );

	$location = $instagram->getLocation( $target['id'] );
	$media = $location->getMedia( isset( $_GET['max_id'] ) ? array( 'max_id' => $_GET['max_id'] ) : null );

	$file_contents = array();
	foreach($media->getData() as $mediaInstance){
	 	$file_contents[] = serialize( $mediaInstance );
	}
	file_put_contents( $cache, json_encode($file_contents) );
}

require( 'Views/_header.php' );
require( 'Views/location.php' );
require( 'Views/_footer.php' );
