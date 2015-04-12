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

function db_entry_exists($table,$key,$val){

   	$IDq = db_exec("SELECT * FROM '$table' WHERE $key='$val'");
   	$IDf = $IDq->fetch();
   	
  	if($IDf[$key]){ return true; } 
   	else{ return false; }
}

function db_hash_gen(){

	while(true){

		$hash = "";
		for ($i = 0; $i < 8; $i++) {
			$hash .= chr(rand(ord('a'), ord('z'))); 
		}
		if (!db_entry_exists("Hashes","hash","$hash")) {
			echo "<b>$hash</b> doesn't exist yet. <br />";
			return $hash;
		}
	}
}

// Function: 	Create new DB address entry
// Call : 	db_add_address("de_de", $array)
function db_add_address($locale, $values){

	$keys = '"'.implode('", "',array_keys($values)).'"';
	$vals = '"'.implode('", "',array_values($values)).'"';
	db_exec("INSERT INTO '$locale' ($keys) VALUES ($vals)");
}

// Function: 	Get all data for a certain address entry
//		(DB needs better id system!)
// Call: 	db_get_address("de_de",user_id,id)
// Return:	Array
function db_get_address($locale, $user_id, $id){

	$db_request = db_exec("SELECT * FROM '$locale' where user_id='$user_id' AND id='$id'");
	return json_encode($db_request->fetchAll(PDO::FETCH_ASSOC)[0], JSON_PRETTY_PRINT);
}

// Function: 	Get all entries for a certain user ID
// Call: 	db_get_all_address(user_id)
// Return:	2D-Array
function db_get_all_address($user_id){

	$db_request = db_exec("SELECT * FROM 'de_de' where user_id='$user_id'");
	return json_encode($db_request->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT); 
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

	db_init(); // Create new db if missing
	// echo db_get_address("de_de",1,1)["last_name"]; // String (Single Field)
	// print_r( db_get_address("de_de",1,1) ); // Array (All entry data)
	db_hash_gen();
	print_r(db_get_all_address(5)); // 2D-Array (All entries from user)

	// Forgot to add city field...
	db_add_address("de_de", [
		user_id => "5",
		type => "1",
		visibility => "3",
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
