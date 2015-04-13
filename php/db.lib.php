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
// Return: JSON STRING
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
// Call: 	db_check_permission(session,hash)
// Return	CHAR permission(N/R/W)
function db_check_permission($session,$hash){

	$meta = json_decode(db_get_index($hash));
	$owner = ($session["id"] == $meta->user_id) ? TRUE : FALSE;
	
	if($owner){ return "W"; }
	switch($meta->access) {
	
		case 1: return "N";
		case 2: return "R";
	}

}

// Function: 	Generate unique hash
// Call: 	db_hash_gen()
// Return	STRING hash
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

// Function: 	Create new DB user entry
// Needed:	type & access values, others are optional
// Call: 	db_add_user()
// Return:	INTEGER id
function db_add_user($values){

	$values["password"] = hash('sha256', $values['password']);
	$keys = '"'.implode('", "',array_keys($values)).'"';
	$vals = '"'.implode('", "',array_values($values)).'"';
	db_exec("INSERT INTO Users ($keys) VALUES ($vals)");
}

// Function: 	Create new DB address entry
// Needed:	type & access values, others are optional
// Call: 	db_add_address(session,"de_de",array)
// Return:	STRING hash
function db_add_address($session, $locale, $values){

	$user_id = $session["id"];
	$type = $values["type"]; unset($values["type"]);
	$access = $values["access"]; unset($values["access"]);
	$keys = '"'.implode('", "',array_keys($values)).'"';
	$vals = '"'.implode('", "',array_values($values)).'"';
	
	$hash = db_hash_gen();
	db_exec("INSERT INTO '$locale' ($keys) VALUES ($vals)");
	db_exec("INSERT INTO 'Index' (locale,table_id,user_id,hash,type,access) VALUES ('$locale',last_insert_rowid(),'$user_id','$hash','$type','$access')");
	return $hash;
}

function db_get_user($id){

	$db_request = db_exec("SELECT * FROM 'Users' WHERE id='$id'");
	return db_json($db_request->fetchAll(PDO::FETCH_ASSOC)[0]);
}

function db_get_all_user(){

        $db_request = db_exec("SELECT * FROM 'Users'");
        return db_json($db_request->fetchAll(PDO::FETCH_ASSOC));
}

// Function: 	Get all data for a certain address entry
//		(DB needs better id system!)
// Call: 	db_get_address(hash)
// Return:	ARRAY
function db_get_address($hash){

	$db_request = db_exec("SELECT * FROM 'Index' WHERE hash='$hash'");
	$index = $db_request->fetchAll(PDO::FETCH_ASSOC)[0];
	$locale = $index["locale"];
	$id = $index["table_id"];
	$db_request = db_exec("SELECT * FROM '$locale' WHERE id='$id'");
	$db_return = $db_request->fetchAll(PDO::FETCH_ASSOC)[0];
	unset($db_return["id"]);
	return db_json($db_return);
}

// Function: 	Get all entries for a certain user ID
// Call: 	db_get_all_by_user(user_id)
// Return:	2D-ARRAY
function db_get_all_by_user($user_id){

	$db_request = db_exec("SELECT hash,locale,table_id FROM 'Index' where user_id='$user_id'");
	$entries = $db_request->fetchAll(PDO::FETCH_ASSOC);
	foreach($entries as $entry){
	
		$locale = $entry["locale"];
		$id = $entry["table_id"];
		
		$db_request = db_exec("SELECT * FROM '$locale' WHERE id='$id'");
		$db_return = $db_request->fetchAll(PDO::FETCH_ASSOC)[0];
		
		unset($db_return["id"]);
		$db_return["hash(DEBUG)"] = $entry["hash"];
		$entries_query[] = $db_return;
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
	$SESSION["id"] = 1; // For debugging
	db_init(); // Create new db if missing
	
	echo "<h2>Index for: vzwnsugd</h2>";
	echo db_get_index("vzwnsugd");
	
	echo "<h2>Address for: vzwnsugd</h2>";
	echo db_get_address("vzwnsugd");
	
	// Check user permission for entry
	echo "<h2>Access Level for User ".$SESSION["id"]." & Hash: vzwnsugd</h2>";
	switch(db_check_permission($SESSION,"vzwnsugd")){
	
		case "N": echo "<b style='color:red'>No access allowed</b>"; break;
		case "R": echo "<b style='color:BADA55'>Read only access</b>"; break;
		case "W": echo "<b style='color:green'>Full write access</b>"; break;
		
	}
	
	echo "<h2>Current User</h2>";
	print_r(db_get_user($SESSION["id"]));
	
	/*
	db_add_user([
		name => "testuser",
		password => "testpw",
		email => "test@email.de"
	]);
	*/

        echo "<h2>All Users</h2>";
        print_r(db_get_all_user());

	$new_entry = db_add_address($SESSION, "de_de", [
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
	
	echo "<h2>New Entry</h2><p>Created new entry $new_entry for user ".$SESSION["id"]."!</p>";
	
	echo "<h2>Index of All Entries</h2>";
	echo db_get_all_index();
	
	echo "<h2>All Entries by Current User</h2>";
	echo db_get_all_by_user($SESSION["id"]);

	return 1;
}

main();
?>
</pre>
