<!-- Shoptag erstellen -->

<h5 id="h5_home">Shoptag admin</h5>
<br>

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

echo "<td style='white-space: nowrap;'><button onclick='copy(\"$entry->id\");' class='copy btn waves-effect cyan darken-2  waves-light' type='submit'
name='submit'>Copy</button>";

echo "<button onclick='edit_list(\"$entry->id\")'  
class='btn waves-effect cyan darken-3 waves-light' type='submit'
name='submit'>Edit</button>";

echo "<button onclick='embed(\"$entry->id\")' 
class='btn waves-effect cyan darken-4 waves-light' type='submit'
name='submit'>Embed</button></td>";

}
?>

</tr>
</tbody>
</table>
