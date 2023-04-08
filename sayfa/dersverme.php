 <?php
$dersler = $vt->sorhepsini("SELECT * FROM ders");
$hocalar = $vt->sorhepsini("SELECT tc,ad FROM ogretimelemani");
 ?>

 <form action="?yap=dersekle" method="POST">
 <table><tr>
<td  width="500px"> <h2>Öğretim Elemanı</h2>
<?php	
foreach ($hocalar as $hoca) {
	echo '<div class="radio">	
	  <label>
	    <input type="radio" name="hoca" value="'.$hoca['tc'].'" checked>
	    '.$hoca['ad'].'
	  </label>
	</div>';
}
?>
</td>

<td width="500px"> <h2>Ders</h2>
<?php	
foreach ($dersler as $ders) {
	echo '<div class="radio">	
	  <label>
	    <input type="radio" name="ders" value="'.$ders['ders_kodu'].'" checked>'.$ders['ders_kodu'].'  -
	    '.$ders['ders_ad'].'
	  </label>
	</div>';
}
?>
</td>

 </tr> </table>	
  <button type="submit" class="btn btn-primary btn-lg">Ders Ekle</button>
 </form>
<table class="table table-striped">
	<tr><th>#</th><th>ders_id</th><th>Ders</th><th>Hoca</th><?php
		$degerler = $vt->sorhepsini("SELECT v.ders_id,d.ders_ad,p.ad FROM verilenders as v INNER JOIN ders as d ON v.ders_kodu=d.ders_kodu INNER JOIN ogretimelemani as p ON v.tc=p.tc"); //,p.ad
	?></tr>

	<?php
	foreach ($degerler as $satir) {
		$m=array_values($satir);
		$n=array_keys($satir);
		echo "<tr><td>".deletelink("?yap=vtsil&from=verilenders&id=".$m[0]."&sutun=".$n[0])."</td>";
		foreach ($satir as $sutun) {
			echo "<td>$sutun</td>";
		}
		echo "</tr>";
	}
	?>
</table>