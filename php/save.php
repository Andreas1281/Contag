<?php

require_once("db.lib.php");

db_check_session();

if (!$_POST) { die("Keine Daten."); }

$hash = db_add_address($_SESSION,"de_de",$_POST);
echo "Added Address: $hash";


?>


