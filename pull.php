<?php // Pull to update DB with most recent media

require( __DIR__ . '/bootstrap.php');

$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $accessToken );

$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$count = $db->rawQuery("SELECT COUNT(*) FROM instagram_media");
$count = $count[0]['COUNT(*)'];

if(!$count){

	echo 'Nothing found in DB <br/>';

	$location = $instagram->getLocation( $target['id'] );

	// Grab initial set of media
	$mediaCollection = $location->getMedia();
	$maxId = $mediaCollection->getNextMaxId();

	// Go back page by page to add more until we've gotten everything
	while ( !is_null($maxId) ){
		$moreMedia = $location->getMedia( array( 'max_id' => $maxId ) );
		$mediaCollection->addData( $moreMedia );

		$maxId = $moreMedia->getNextMaxId();
	} 

	echo 'Found '.$mediaCollection->count().' media items';
	echo '<br/>';

	// Insert each object in the collection 
	foreach($mediaCollection as $mediaObj){
		$instagramId = $mediaObj->getId();
		$createdAt = $mediaObj->getCreatedTime('U');
		$data = $db->escape( serialize($mediaObj) );

		$insertion = array('instagram_id' => $instagramId, 'data' => $data, 'created_at' => $createdAt );

		$insertSuccess = $db->insert('instagram_media', $insertion );

		if($insertSuccess){
			echo 'Inserted media with instagram id '.$instagramId.'</br>';
		}else{
			echo 'something went wrong';
		}
	}

}
else{
	$row = $db->query('SELECT instagram_id FROM instagram_media ORDER BY created_at DESC LIMIT 1');
	$minId = $row[0]['instagram_id'];

	$location = $instagram->getLocation( $target['id'] );
	$mediaCollection = $location->getMedia( array( 'min_id' => $minId ) );
	foreach($mediaCollection as $mediaObj){
		$instagramId = $mediaObj->getId();
		$createdAt = $mediaObj->getCreatedTime('U');
		$data = $db->escape( serialize($mediaObj) );

		$insertion = array('instagram_id' => $instagramId, 'data' => $data, 'created_at' => $createdAt );

		$insertSuccess = $db->insert('instagram_media', $insertion );

		if($insertSuccess){
			echo 'Inserted media with instagram id '.$instagramId.'</br>';
		}else{
			echo 'Duplicate entry, could not insert';
		}
	}
}