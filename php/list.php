<!-- Shoptag erstellen -->

<h5>Shoptag Administration</h5>
<table class="striped bordered">
  <thead>
    <tr></tr>
  </thead>
<tbody>

<?php
$db_return = file_get_contents("../db/data.db");
$db_entries = array_filter(explode("\n",$db_return));
foreach ($db_entries as $i => $entry_json) {
$entry = json_decode($entry_json);
$url = "contag.de/".$entry->id;

echo "<tr><td id='address_td'>".$url."</td>";

/* Hier kommen die 3 Buttons die bis jetzt leider alle noch nicht funktionieren :/ */

echo "<td><button onclick='copy(\"$url\")' 
class='btn waves-effect cyan darken-2  waves-light' type='submit'
name='submit'>Copy</button></td>";

echo "<td><button onclick='edit(\"$entry->id\")' 
class='btn waves-effect cyan darken-3 waves-light' type='submit'
name='submit'>Edit</button></td>";

echo "<td><button onclick='embed(\"$url\")' 
class='btn waves-effect cyan darken-4 waves-light' type='submit'
name='submit'>Get Embed Code</button></td>";

}
?>

</tr>
</tbody>
</table>
