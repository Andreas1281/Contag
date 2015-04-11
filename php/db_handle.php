<?php
 
// Load DB object for all functions
try { $db = new PDO("sqlite:../db/db.sqlite"); 
    } catch(PDOException $e) die("DB error: ".$e);

// Function: 	Create new DB from template file
// Call: 	db_init()
function db_init(){

	$db_template = file('../db/db_template.txt');
	foreach ($db_template as $handle){

        	$db = $GLOBALS["db"];
        	$db->exec($handle);
	}
	return 0;
}

// Function: 	Create new DB address entry
// Call : 	db_add("de_de", $array)
function db_add($locale, $values){

	$keys = implode(",",array_keys($values));
	$vals = implode(",",array_values($values));
	$handle = "INSERT INTO '$locale' ($keys) VALUES ($vals)";

	$db = $GLOBALS["db"];
   	$db_request = $db->prepare($handle);
	try { $db_request->execute();
    	} catch(PDOException $e) die("DB writing error: ".$e);
	echo "Executed Query: ".$handle;
	return 0;
}

// Function: 	Get all data for a certain address entry
//		(DB needs better id system!)
// Call: 	db_get("de_de",user_id,id)
// Return:	Array
function db_get($locale, $user_id, $id){

	$handle = "SELECT * FROM '$locale' 
		   where user_id='$user_id' AND id='$id'";
	
	$db = $GLOBALS["db"];
	$db_request = $db->prepare($handle); 
	$db_request->execute();
	$db_output = $db_request->fetchAll(); 
	return $db_output[0]; // Array
}

function db_set($locale, $user_id, $id, $values) {

	$db = $GLOBALS["db"];
	foreach($values as $key => $val){
		$handle = "UPDATE '$locale' SET $key='$val' WHERE user_id='$user_id' AND id='$id'";
		$db_request = $db->prepare($handle);
		$db_request->execute();
	}
}

//Function:	Example calls
//Called:	on init
function main(){

	//db_init(): // Create new db if missing
	echo db_get("de_de",1,1)["last_name"]; // String (Single Field)
	print_r( db_get("de_de",1,1) ); // Array (All entry data)

	// Aw shit... phone number formatting, 
	// TODO: Change field type
	db_add("de_de", [
		user_id => "\"5\"",
		type => "\"1\"",
		organisation => "\"Wessolly Mobile Marketing\"",
		first_name => "\"Andreas\"",
		last_name => "\"Wessolly\"",
		title_1 => "\"Prof. Dr.\"",
		title_2 => "\"Allgemeinmediziner\"",
		description_1 => "\"c/o Office-Factory\"",
		description_2 => "\"Erste Etage\"",
		street_name => "\"Am Rosengarten\"",
		street_number => "\"20\"",
		postal_code => "\"36037\"",
		city => "\"Fulda\"",
		region => "\"Hessen\"",
		email_address => "\"email@address.com\"",
		phone_number => "\"1234567\"",
		mobile_number => "\"1234567\"",
		fax_number => "\"1234568\""
	]);
	return 0;
}

main();
?>
