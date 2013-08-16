<?php // Pull to update DB with most recent media

require( __DIR__ . '/bootstrap.php');

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $accessToken );

$location = $instagram->getLocation( $target['id'] );

// Remove this at some point
$dbLink->query("TRUNCATE TABLE instagram_media");

$result = $dbLink->query("SELECT COUNT(*) FROM instagram_media");
$count = (int)$result->fetch_row()[0];

if(!$count){
	echo 'Nothing found in DB <br/>';

	$mediaCollection = $location->getMedia();
	$maxId = $mediaCollection->getNextMaxId();

	while ( !is_null($maxId) ){
		$moreMedia = $location->getMedia( array( 'max_id' => $maxId ) );
		$mediaCollection->addData( $moreMedia );

		$maxId = $moreMedia->getNextMaxId();
	} 

	echo 'Found '.$mediaCollection->count().' media items';
	echo '<br/>';

	// Insert all the media
	$sqlValues = "";
	foreach($mediaCollection as $k => $media){
		$instagramID = $media->getId();
		$createdAt = $media->getCreatedTime('U');
		$media = serialize($media);
		$media = $dbLink->real_escape_string( $media );

		$sqlValues .= "('$instagramID', '$media', '$createdAt')";

		$sqlValues .= $k+1 == $mediaCollection->count() ? ';' : ', ';

		echo "Inserting media with ID = ".$instagramID."<br/>";
	}

	$sql = "INSERT INTO instagram_media (instagram_id, data, created_at) VALUES $sqlValues " ;

	$dbLink->query($sql);

	if (mysqli_warning_count($dbLink)) { 
	   $e = mysqli_get_warnings($dbLink); 
	   do { 
	       echo "Warning: $e->errno: $e->message\n"; 
	   } while ($e->next()); 
	} 

	$dbLink->close();
}
else {
	// $result = $dbLink->query("SELECT instagram_id FROM instagram_media ORDER BY created_at DESC LIMIT 1");
	// $minId  = $result->fetch_row()[0];
	// $mediaCollection = $location->getMedia( array( 'min_id' => $minId ) );

	// if( $mediaCollection->count() == 1 ){
	// 	echo 'Database is up to date';
	// }else{
	// 	echo 'MinID = '.$minId."\n";
	// 	$maxId = $mediaCollection->getNextMaxId();
	// 	while ( $maxId > $minId ){
	// 		echo 'MaxID = '.$maxId."\n";
	// 		$moreMedia = $location->getMedia( array( 'max_id' => $maxId ) );
	// 		$mediaCollection->addData( $moreMedia );

	// 		$maxId = $moreMedia->getNextMaxId();
	// 	} 

	// 	echo 'Found '.$mediaCollection->count().' media items';
	// 	echo '<br/>';

	// 	foreach($mediaCollection as $k => $media){var_dump($media->getId());}

	// 	// Insert all the media
	// 	$sqlValues = "";
	// 	foreach($mediaCollection as $k => $media){
	// 		// Make this check because otherwise it'll pull back the last image as the last image in this set
	// 		if($k+1 != $mediaCollection->count()){
	// 			$instagramID = $media->getId();
	// 			$createdAt = $media->getCreatedTime('U');
	// 			$media = serialize($media);
	// 			$media = $dbLink->real_escape_string( $media );

	// 			$sqlValues .= "('$instagramID', '$media', '$createdAt')";

	// 			$sqlValues .= $k+1 == $mediaCollection->count() ? ';' : ', ';
	// 		}
	// 	}

	// 	$sql = "INSERT INTO instagram_media (instagram_id, data, created_at) VALUES $sqlValues " ;

	// 	$dbLink->query($sql);

	// 	if (mysqli_warning_count($dbLink)) { 
	// 	   $e = mysqli_get_warnings($dbLink); 
	// 	   do { 
	// 	       echo "Warning: $e->errno: $e->message\n"; 
	// 	   } while ($e->next()); 
	// 	} 

	// 	$dbLink->close();

	// }
}
