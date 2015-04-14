<!-- Include DB Library -->
<?php require_once("db.lib.php"); ?>

<!-- Shoptag erstellen -->
<h5 id="h5_home">Shoptag admin</h5>
<br>

<table class="striped bordered">
  <thead>
    <tr></tr>
  </thead>
<tbody>

<?php
db_check_session();

$index = json_decode(db_get_all_index_by_user($session_id));

foreach ($index as $i => $entry) {

	// Contag ID
	echo "<tr><td id='address_td'>".$entry->hash."</td>";

	// Button: Copy
	echo "<td style='white-space: nowrap;'>
	      <button data-clipboard-text='$entry->hash'
	       title='Contag ID: $entry->hash'
	       class='copy btn waves-effect 
	       cyan darken-2 waves-light'>Copy</button>";

	// Button: Edit
	echo "<button onclick='edit_list(\"$entry->hash\")'  
	  class='btn waves-effect cyan darken-3 waves-light' type='submit'
name='submit'>Edit</button>";

	// Button: Embed
	echo "<button onclick='embed(\"$entry->hash\")' 
class='btn waves-effect cyan darken-4 waves-light' type='submit'
name='submit'>Embed</button></td>";

}
	echo "<script>copy_init();</script>";
?>

</tr>
</tbody>
</table>
