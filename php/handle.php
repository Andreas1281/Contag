<?php
	
if (isset($_GET["id"])) {

	$db_return = file_get_contents("../db/data.db");
	$db_entries = explode("\n",$db_return);

	foreach ($db_entries as $i => $entry_json) {

		$entry = json_decode($entry_json);
		if ( $entry->id == $_GET["id"] ) {

			echo $entry_json;

		}	
	}
}
