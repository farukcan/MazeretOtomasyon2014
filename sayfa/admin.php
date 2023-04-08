<br>
<blockquote>
	Gerekli/güncel düzenlemeleri aşağıdan yapabilirsiniz. Yapısal düzenlemeleri ayarlar.phpden yapın
</blockquote>
<?php
	$sor=$vt->sorhepsini('SELECT * FROM sabitler');
	foreach ($sor as $v) {
		echo "<form method='post' action='?yap=sabit&id=".$v['no'] ."'>".' <textarea name="deger" class="form-control" placeholder="'.$v['ad'].'">'.$v['deger']. "</textarea><button type='submit' class='btn btn-primary'>".$v['ad']."' degerini kaydet</button></form>";
	}
?>
<br>
<blockquote>
	Admin hesabı kullanıcı ve parolasını ayarlar.phpden değiştirebilirsiniz
</blockquote>
<blockquote>
	Excel dosyalarını .csv 'ye export(dışa aktarma) ederek Dersler Öğrenciler Fakülteler Öğretim Elemanları eklemesi yapabilirsiniz
	.csv'de satırlar satırla, sutunlar , (virgül) ile ayrılır.
</blockquote>
<blockquote>
	_id adresleri boş veya null bırakarak, veritabanı tarafından atanmasını sağlayabilirsiniz
</blockquote>
<blockquote>
	Yazılım :<a href='//farukcan.net'>Ömer Faruk CAN</a> Veritabanı : Enes Bilgehan Kağan & Issa Baban Chawai Abdoulaye tarafından geliştirildi.
</blockquote>
