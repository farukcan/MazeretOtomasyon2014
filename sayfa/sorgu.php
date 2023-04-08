
<blockquote><?php echo $_POST["sql"];?></blockquote>
<table class="table table-striped">
	<tr><?php
	$degerler = $vt->sorhepsini($_POST["sql"]);
	if(is_array($degerler) && isset($degerler[0])){
		$sutunlar = array_keys($degerler[0]);
		foreach ($sutunlar as $sutun) {
			echo "<th>$sutun</th>";
		}
		echo "</tr>";

		foreach ($degerler as $satir) {
			echo "<tr>";
			foreach ($satir as $sutun) {
				echo "<td>$sutun</td>";
			}
			
		}	
	}
	else
	{
		var_dump($degerler);
	}
	echo "</tr>";
	?>
</table>

