<?php

	$form_return = $_POST;
	$db_return = file_get_contents("../db/data.db");
	$db_entries = array_filter(explode("\n",$db_return));

	foreach ($db_entries as $i => $entry_json) {
		$entry = json_decode($entry_json);

		if ( $entry->id == $form_return["id"])
			$db_query .= json_encode($form_return)."\n";
		else
			$db_query .= $entry_json."\n";
	}
	
	if ( ! file_put_contents ("../db/data.db", $db_query, LOCK_EX) ) {
		echo 1;	
	}
	else {
		echo 0;
	}
?>


