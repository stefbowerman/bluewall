<?php 

if(apc_clear_cache()){
	echo 'Cache Cleared';
}
else{
	echo 'try again';
	die();
}