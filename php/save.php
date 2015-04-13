<?php

function contag_id() {

	$id = "";
	for ($i = 0; $i < 8; $i++) {
		$id .= chr(rand(ord('a'), ord('z'))); 
	}
	return $id;
}


	$_POST["id"] = contag_id();  
	$form_json = json_encode($_POST);
	if ( ! file_put_contents ("../db/data.db", $form_json."\n", FILE_APPEND) ) {
		echo 1;	
	}
	else {
		echo 0;
	}
?>


