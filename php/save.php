<?php

if (!$_POST) { die("Keine Daten."); }

require_once("db.lib.php");
db_check_session();
$hash = db_add_address($_SESSION,$_POST);
if($hash) { echo $hash; }
else { echo 0; }

?>


