 <table width="100%"><tr>
<td  width="50%"> <h2>Raporlar</h2>
<?php
	$ch = $vt->sorhepsini("SELECT v.ders_id,d.ders_ad,p.ad FROM verilenders as v INNER JOIN ders as d ON v.ders_kodu=d.ders_kodu INNER JOIN ogretimelemani as p ON v.tc=p.tc"); //,p.ad
	$dersler=array();
	foreach ($ch as $v) {
		$dersler[$v['ders_id']] = array("ders"=>$v['ders_ad'],"hoca"=>$v['ad']);
	}
	$get = $vt->sorhepsini("SELECT * FROM rapor INNER JOIN ogrenci ON rapor.ogrenci_id=ogrenci.ogrenci_id WHERE kabul=0 ORDER BY tarih DESC;");
	raporisle($get);
	$get = $vt->sorhepsini("SELECT * FROM rapor INNER JOIN ogrenci ON rapor.ogrenci_id=ogrenci.ogrenci_id WHERE kabul<>0 ORDER BY tarih DESC LIMIT 10;");
	raporisle($get);
?>
</td>
<td width="50%"> <h2>Mazeretler</h2>
<?php
	$get = $vt->sorhepsini("SELECT * FROM mazeret INNER JOIN ogrenci ON mazeret.ogrenci_id=ogrenci.ogrenci_id WHERE kabul=0 ORDER BY tarih DESC;");
	mazeretisle($get);
	$get = $vt->sorhepsini("SELECT * FROM mazeret INNER JOIN ogrenci ON mazeret.ogrenci_id=ogrenci.ogrenci_id WHERE kabul<>0 ORDER BY tarih DESC LIMIT 10;");
	mazeretisle($get);
?>
</td>

<?php
function raporisle($g)
{
	global $vt,$dersler;
	foreach ($g as $a) {
		echo "<blockquote><b>Öğrenci</b> : ".$a["ad_soyad"]." (".$a["okul_no"]." - ".$a["sinif"].".sınıf)<br><b>Tarih</b> : ".$a["tarih"]." ( ".$a["kac_gun"]." gün)<br><b>Resim</b> : ".xml(xml($a["resim"],'samp'),"a"," href='".$a["resim"]."'");
		$dr=$vt->sorhepsini('SELECT ders_id FROM raporalma WHERE rapor_id='.$a['rapor_id']);
		echo "<ol>";
		foreach ($dr as $d) {
			echo "<li><b>".$dersler[$d['ders_id']]['ders'].'</b> - <i>'.$dersler[$d['ders_id']]['hoca']."</i></li>";
		}
		echo "</ol>";
		if($a["kabul"]==0){
			echo '<br><a href="?yap=r_onayla&id='.$a['rapor_id'].'" class="btn btn-success">Onayla</a><a href="?yap=r_reddet&id='.$a['rapor_id'].'" class="btn btn-danger">Reddet</a> ONAY BEKLİYOR ';
		}
		elseif ($a["kabul"]==1) {
			echo '<br><a href="?yap=r_reddet&id='.$a['rapor_id'].'" class="btn btn-warning">Reddet</a>';
		}
		elseif ($a["kabul"]==-1) {
			echo '<br><a href="?yap=r_onayla&id='.$a['rapor_id'].'" class="btn btn-default">Onayla</a>';
		}

		echo "</blockquote>";
	}
	
}
function mazeretisle($g)
{
	global $vt,$dersler;
	foreach ($g as $a) {
		echo "<blockquote><b>Öğrenci</b> : ".$a["ad_soyad"]." (".$a["okul_no"]." - ".$a["sinif"].".sınıf)<br><b>Tarih</b> : ".$a["tarih"]." (1 gün)<br><b>Açıklama</b> : <i>".$a["aciklama"];
		$dr=$vt->sorhepsini('SELECT ders_id FROM mazeretalma WHERE mazeret_id='.$a['mazeret_id']);
		echo "</i><ol>";
		foreach ($dr as $d) {
			echo "<li><b>".$dersler[$d['ders_id']]['ders'].'</b> - <i>'.$dersler[$d['ders_id']]['hoca']."</i></li>";
		}
		echo "</ol>";		
		if($a["kabul"]==0){
			echo '<br><a href="?yap=m_onayla&id='.$a['mazeret_id'].'" class="btn btn-success">Onayla</a><a href="?yap=m_reddet&id='.$a['mazeret_id'].'" class="btn btn-danger">Reddet</a> ONAY BEKLİYOR ';
		}
		elseif ($a["kabul"]==1) {
			echo '<br><a href="?yap=m_reddet&id='.$a['mazeret_id'].'" class="btn btn-warning">Reddet</a>';
		}
		elseif ($a["kabul"]==-1) {
			echo '<br><a href="?yap=m_onayla&id='.$a['mazeret_id'].'" class="btn btn-default">Onayla</a>';
		}
		echo "</blockquote>";
	}
	
}



?>

