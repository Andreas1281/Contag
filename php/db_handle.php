<pre>
<?php
 
// Load DB object for all functions
try { $db = new PDO("sqlite:../db/db.sqlite"); 
    } catch(PDOException $e) { die("DB error: ".$e); }

// Function: 	Create new DB from template file
// Call: 	db_init()
function db_init(){

	$db_template = file('../db/db_template.txt');
	foreach ($db_template as $handle){

        	$db = $GLOBALS["db"];
        	$db->exec($handle);
	}
	return 1;
}

// Function: 	Execute safe SQL command
// Call: 	db_exec(SQL_string)
// Return:	Object
function db_exec($handle){

	$db = $GLOBALS["db"];
   	$db_request = $db->prepare($handle);
	try { $db_request->execute();
    	} catch(PDOException $e) { die("DB error: ".$e); }
	return $db_request;
}

// Function: 	Convert array to JSON
// Call: 	db_json(array)
// Return: JSON object
function db_json($array){ 

	return json_encode($array,JSON_PRETTY_PRINT);
}

// Function: 	Check if entry exists
// Call: 	db_entry_exists(table,key,value)
// Return:	BOOL
function db_entry_exists($table,$key,$val){

   	$IDq = db_exec("SELECT * FROM '$table' WHERE $key='$val'");
   	$IDf = $IDq->fetch();
   	
  	if($IDf[$key]){ return true; } 
   	else{ return false; }
}

// Function: 	Check permission for session
// Call: 	db_check_permission()
// Return	STRING
function db_check_permission($session,$hash){

	$meta = json_decode(db_get_index($hash));
	$owner = ($session["id"] == $meta->user_id) ? TRUE : FALSE;
	
	if($owner){ return "W"; }
	switch($meta->access) {
	
		case 1: return 0;
		case 2: return "R";
	}

}

// Function: 	Generate unique hash
// Call: 	db_hash_gen()
// Return	STRING
function db_hash_gen(){

	while(true){

		$hash = "";
		for ($i = 0; $i < 8; $i++) {
			$hash .= chr(rand(ord('a'), ord('z'))); 
		}
		if (!db_entry_exists("Index","hash","$hash")) {
			return $hash;
		}
	}
}

// Function: 	Create new DB address entry
// Call : 	db_add_address(session,"de_de",array)
function db_add_address($session, $locale, $values){

	$user_id = $session["id"];
	$type = $values["type"]; unset($values["type"]);
	$access = $values["access"]; unset($values["access"]);
	$keys = '"'.implode('", "',array_keys($values)).'"';
	$vals = '"'.implode('", "',array_values($values)).'"';
	
	$hash = db_hash_gen();
	db_exec("INSERT INTO '$locale' ($keys) VALUES ($vals)");
	db_exec("INSERT INTO 'Index' (locale,table_id,user_id,hash,type,access) VALUES ('$locale',last_insert_rowid(),'$user_id','$hash','$type','$access')");
	return 1;
}

// Function: 	Get all data for a certain address entry
//		(DB needs better id system!)
// Call: 	db_get_address(hash)
// Return:	Array
function db_get_address($hash){

	$db_request = db_exec("SELECT * FROM 'Index' WHERE hash='$hash'");
	$index = $db_request->fetchAll(PDO::FETCH_ASSOC)[0];
	$locale = $index["locale"];
	$id = $index["table_id"];
	$db_request = db_exec("SELECT * FROM '$locale' WHERE id='$id'");
	return db_json($db_request->fetchAll(PDO::FETCH_ASSOC));
}

// Function: 	Get all entries for a certain user ID
// Call: 	db_get_all_by_user(user_id)
// Return:	2D-Array
function db_get_all_by_user($user_id){

	$db_request = db_exec("SELECT hash,locale,table_id FROM 'Index' where user_id='$user_id'");
	$entries = $db_request->fetchAll(PDO::FETCH_ASSOC);
	foreach($entries as $entry){
		$locale = $entry["locale"];
		$id = $entry["table_id"];
		$db_request = db_exec("SELECT * FROM '$locale' WHERE id='$id'");
		$entries_query[] = $db_request->fetchAll(PDO::FETCH_ASSOC);
	}
	return db_json($entries_query);
}

// Function:	Get index of all addresses
// Call: 	db_get_all_index()
function db_get_all_index(){

	$db_request = db_exec("SELECT * FROM 'Index'");
	return db_json($db_request->fetchAll(PDO::FETCH_ASSOC)); 
}

// Function:	Get index of certain hash
// Call: 	db_get_index(hash)
function db_get_index($hash){

	$db_request = db_exec("SELECT * FROM 'Index' WHERE hash='$hash'");
	return db_json($db_request->fetchAll(PDO::FETCH_ASSOC)[0]); 
}

// Function: 	Modify values of an address entry
// Call: 	db_set_address("de_de",user_id,id,array)
function db_set_address($locale, $user_id, $id, $values){

	foreach($values as $key => $val){
		db_exec("UPDATE '$locale' SET $key='$val' WHERE id='$userID'");
	}
	return 1;
}

// Function:	Example calls
// Called:	on init
function main(){

	session_start();
	$SESSION["id"] = 4; // For debugging
	db_init(); // Create new db if missing
	
	echo "<h2>Single entry by hash: siatdaye</h2>";
	echo db_get_address("siatdaye");
	
	echo "<h2>Single index by hash: siatdaye</h2>";
	echo db_get_index("siatdaye");

	// Check user permission for entry
	echo "<h2>Access level for hash: siatdaye</h2>";
	switch(db_check_permission($SESSION,"siatdaye")){
	
		case "0": echo "No access allowed"; break;
		case "R": echo "Read only access"; break;
		case "W": echo "Full write access"; break;
		
	}

	echo "<h2>Index of all entries</h2>";
	echo db_get_all_index();
	
	echo "<h2>All entries by current user</h2>";
	echo db_get_all_by_user($SESSION["id"]);

	db_add_address($SESSION, "de_de", [
		type => 1, access => 2,
		organisation => "Wessolly Mobile Marketing",
		first_name => "Andreas",
		last_name => "Wessolly",
		title_1 => "Prof. Dr.",
		title_2 => "Allgemeinmediziner",
		description_1 => "c/o Office-Factory",
		description_2 => "Erste Etage",
		street_name => "Am Rosengarten",
		street_number => "20",
		postal_code => "36037",
		city => "Fulda",
		region => "Hessen",
		country => "Deutschland",
		email_address => "email@address.com",
		web_address => "www.wessolly-mobile.de",
		phone_number => "1234567",
		mobile_number => "1234567",
		fax_number => "1234568"
	]);
	return 1;
}

main();
?>
</pre>
