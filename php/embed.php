<?php

if (isset($_GET["id"])) {

	$db_return = file_get_contents("./db/data.db");
	$db_entries = explode("\n",$db_return);
	foreach ($db_entries as $i => $entry_json) {

		$entry = json_decode($entry_json);
		if ( $entry->id == $_GET["id"] ) { $found = $entry; }	
	}

	// Found Shoptag in database
	if ($found) { 

		$e = $found; ?>

		<!-- HTML Layout here, you can use the php snippets down below -->
		<!-- ####################################################### -->

		<!-- Using header from index.php -->
		<body>
		  <div>

			<h4>Contag</h4>
			<hr>
			<?php echo $e->first_name;?>
			<?php echo $e->last_name;?>
			<br>
			<?php echo $e->address_line_1;?>
			<br>
			<?php echo $e->address_line_2;?>
			<br>
			<?php echo $e->zip;?>
			<?php echo $e->city;?>
			<br>
			<?php echo $e->state;?>
			<br>
			<?php echo $e->country;?>
			<br>
			<?php echo $e->phone;?>
			<hr>
		  </div>
		</body>

		</html>
	
		<!-- END OF HTML -->
		<!-- ######################################################### -->

	<?php }
	else echo "Error: Can't find a Shoptag with ID ".$_GET["id"].".";

}
