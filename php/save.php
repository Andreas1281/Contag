<?php

	$_POST["id"] = uniqid();  
	$form_json = json_encode($_POST);
	if ( ! file_put_contents ("../db/data.db", $form_json."\n", FILE_APPEND) ) {
		echo 1;	
	}
	else {
		echo 0;
	}
?>


