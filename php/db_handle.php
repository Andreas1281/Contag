<?php

try { 	$db = new PDO("sqlite:../db/db.sqlite"); 
    }   catch(PDOException $e) { exit("<h1>Datenbank-Fehler</h1>".$e); }


function db_add($locale, $values) {


	$keys = implode(",",array_keys($values));
	$vals = implode(",",array_values($values));
	$handle = "INSERT INTO '$locale' ($keys) VALUES ($vals)";
	$db = $GLOBALS["db"];
        $db_request = $db->prepare($handle);
        $db_request->execute();
	echo "Executed Query: ".$handle;
}

function db_get($locale, $user_id, $id) {

	$db = $GLOBALS["db"];
	$handle = "SELECT * FROM '$locale' where user_id='$user_id' AND id='$id'";
	$db_request = $db->prepare($handle); 
	$db_request->execute();
	$db_output = $db_request->fetchAll(); 
	return $db_output[0];
}

function db_set($locale, $user_id, $id, $set_query) {

	$db = $GLOBALS["db"];
	$handle = "UPDATE '$locale' SET name='$value' WHERE id='$userID'";
	$db_request = $db->prepare($handle);
	$db_request->execute();

}


$data = db_get("de_de",1,1);
echo $data["last_name"];

$add_query = array( 
	user_id => "\"5\"",
	type => "\"1\"",
	organisation => "\"Testorga\"",
	first_name => "\"Andreas\"",
	last_name => "\"Wessolly\"",
	title_1 => "\"Prof. Dr.\"",
	description_1 => "\"c/o Office-Factory\"",
	street_name => "\"Am Rosengarten\"",
	street_number => "\"20\"" );

db_add("de_de",$add_query);








function db_init()
{
	$db_template = file('../db/db_template.txt'); 
	foreach ($db_template as $handle) 
	{
        	$db = $GLOBALS["db"];
        	$db->exec($handle);
	}
}

db_init();


?>
