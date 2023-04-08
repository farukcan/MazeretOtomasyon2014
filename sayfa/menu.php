<p class="text-right">Hesap : <b><?php echo $admin_hesap;?></b>  <a href="#" onClick="sql_sorgu();" class="btn btn-primary">Sorgula</a> <a href="?yap=cikis" class="btn btn-danger">Çıkış</a></p>
<ul class="nav nav-tabs nav-justified"><form id="sqlform" action="?sayfa=sorgu" method="POST"><input type="hidden" id="sql" name="sql" value=""></form>
<?php
	echo_mesaj();
	if(!isset($_GET['sayfa'])){ 
		echo '<li role="presentation" class="active"><a href="?">Anasayfa</a></li>';
		foreach ($sayfalar_ad as $key => $ad) {
			echo '<li role="presentation"><a href="?sayfa='.$sayfalar[$key].'">'.$ad.'</a></li>';
		}
		foreach ($vt_sayfalar_ad as $key => $ad) {
			echo '<li role="presentation"><a href="?sayfa='.$vt_sayfalar[$key].'">'.$ad.'</a></li>';
		}
	}
	else
	{
		echo '<li role="presentation"><a href="?">Anasayfa</a></li>';
		foreach ($sayfalar_ad as $key => $ad) {
			if($sayfalar[$key]==$_GET['sayfa'])
				echo '<li role="presentation" class="active"><a href="?sayfa='.$sayfalar[$key].'">'.$ad.'</a></li>';
			else
				echo '<li role="presentation"><a href="?sayfa='.$sayfalar[$key].'">'.$ad.'</a></li>';
		}
		foreach ($vt_sayfalar_ad as $key => $ad) {
			if($vt_sayfalar[$key]==$_GET['sayfa'])
				echo '<li role="presentation" class="active"><a href="?sayfa='.$vt_sayfalar[$key].'">'.$ad.'</a></li>';
			else
				echo '<li role="presentation"><a href="?sayfa='.$vt_sayfalar[$key].'">'.$ad.'</a></li>';
		}
	}

?>
</ul>

<script>
function sql_sorgu () {
	 sql_sor(prompt("Veritabanı Tabloları: <?php echo $vt_tables; ?>\nLütfen SQL sorgu komutunu giriniz", "SELECT * FROM "));
}
function sql_sor (sql) {
		document.getElementById("sql").value = sql
		document.getElementById("sqlform").submit();
	}	

</script>