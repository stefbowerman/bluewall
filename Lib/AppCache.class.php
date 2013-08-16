<?php

/**
 * Application Cache
 *
 * Manages the JSON cache
 */
class AppCache {

	protected $file;

	public function __construct($path){
		$this->file = $path;
	}

	public function fileExists(){
		return file_exists($this->file);
	}

	public function isFresh($hours = 1){
		return filemtime($this->file) > time() - (60 * 60 * $hours) ;
	}

	public function read(){
		return json_decode( file_get_contents($this->file), false) ;
	}

	public function write($contents){
		if($contents){
			return file_put_contents( $this->file, json_encode($contents) );
		}else{
			// ERROR
		}
	}

	public function writeWithMediaCollection($mediaCollection){
		if($mediaCollection instanceof Instagram\Collection\MediaCollection){
			$contents = array();
			foreach($mediaCollection->getData() as $mediaInstance){
			 	$contents[] = serialize( $mediaInstance );
			}
			$this->write($contents);
			return true;
		}
		else{
			// ERROR
		}
	}

	public function getMediaCollectionData(){
		$arrayOfSerials = $this->read();
		$collection = array();
		foreach ($arrayOfSerials as $serial)
			$collection[] = unserialize($serial);

		$mediaCollectionData = new stdClass();
		$mediaCollectionData->data = $collection; // setData needs the $arg to respond to $arg->data
		return $mediaCollectionData;
	}

}