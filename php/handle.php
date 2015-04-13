<?php

if (!$_GET["hash"]) { die("No hash"); }

require_once("db.lib.php");
db_check_session();
echo db_get_address($_GET["hash"]);

?>
