<?php 

require('../bootstrap.php');

if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
{
	if( !array_key_exists( 'page', $_GET ) ){
		die();
	}
	else{
		$page = (int)$_GET['page'];
		$offset = 10 * ($page - 1);
	}

	header('Content-Type: application/json');

	// Move this back into bootstrap once the DB is set up on the live site

	$db = new Mysqlidb(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	/* check connection */
	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	// Return 10
	$dbData = new stdClass();
	$dbData->data = array();

	$results = $db->query("SELECT data FROM instagram_media ORDER BY created_at DESC LIMIT 10 OFFSET $offset");
	
	$json = array();
	if(count($results)){
		foreach($results as $r){
			$dbData->data[] = unserialize(stripslashes($r['data']));
		}
		$mediaCollection = New Instagram\Collection\MediaCollection();
		$mediaCollection->setData($dbData);		


		foreach($mediaCollection as $k => $media){
			ob_start();
			include( '../views/location.php' );
			$htmlSnippet = ob_get_clean();

			$json[] = array('html' => $htmlSnippet);
		}

	}		

	$json = json_encode($json);
	echo $json;
}
else{
	echo 'Only AJAX requests are accepted at this URL';
}
