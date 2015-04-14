<?php

// TODO: Generate forms via algorithm 
//	 instead of including html files

function sanitize($string) { return preg_replace('/[^A-Za-z0-9_\-]/', '', $string); }

if (!$_GET["locale"]) { die("No region specified."); }

$form = glob("../pages/forms/".sanitize($_GET["locale"]).".html")[0];
if($form) { include($form); }
else { die("Can't find region form."); }

?>
