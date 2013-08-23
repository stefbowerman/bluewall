<?php 

/*
*  Task for adding missing instagram media to the DB
*
*  Must be included in a file that has already included the bootstrap file.
*
*/

if( !isset($instagram)){

	// Don't override this if it's already set

	$instagram = new Instagram\Instagram;
	$instagram->setAccessToken( $accessToken );
}

$foundCount 	= 0;
$insertedCount  = 0;
$duplicateCount = 0;

$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$count = $db->rawQuery("SELECT COUNT(*) FROM instagram_media");
$count = $count[0]['COUNT(*)'];

if(!$count){

	$location = $instagram->getLocation( $target['id'] );

	// Grab initial set of media
	$pullMediaCollection = $location->getMedia();
	$maxId = $pullMediaCollection->getNextMaxId();

	// Go back page by page to add more until we've gotten everything
	while ( !is_null($maxId) ){
		$moreMedia = $location->getMedia( array( 'max_id' => $maxId ) );
		$pullMediaCollection->addData( $moreMedia );

		$maxId = $moreMedia->getNextMaxId();
	} 

	$foundCount = 0;

	// Insert each object in the collection 
	foreach($pullMediaCollection as $mediaObj){
		$instagramId = $mediaObj->getId();
		$createdAt = $mediaObj->getCreatedTime('U');
		$data = $db->escape( serialize($mediaObj) );

		$insertion = array('instagram_id' => $instagramId, 'data' => $data, 'created_at' => $createdAt );

		$insertSuccess = $db->insert('instagram_media', $insertion );

		$insertSuccess ? $insertedCount++ : $duplicateCount++;
			
	}

}
else{
	$row = $db->query('SELECT instagram_id FROM instagram_media ORDER BY created_at DESC LIMIT 1');
	$minId = $row[0]['instagram_id'];

	$location = $instagram->getLocation( $target['id'] );
	$pullMediaCollection = $location->getMedia( array( 'min_id' => $minId ) );
	foreach($pullMediaCollection as $mediaObj){
		$instagramId = $mediaObj->getId();
		$createdAt = $mediaObj->getCreatedTime('U');
		$data = $db->escape( serialize($mediaObj) );

		$insertion = array('instagram_id' => $instagramId, 'data' => $data, 'created_at' => $createdAt );

		$insertSuccess = $db->insert('instagram_media', $insertion );

		$insertSuccess ? $insertedCount++ : $duplicateCount++;

	}
}