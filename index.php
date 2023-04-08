<?php
require_once 'ayarlar.php'; // gerekli sabitler
require_once 'pdo.php'; // vt kütüphanesi
session_start(); // oturum sistemi

?>
<html>
<head>
<meta charset='utf-8'/>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<title<?php echo $oto_ad; ?> </title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<style type="text/css">
	body {
		font-size: 15px;
		font-family: Helvetica,Arial,sans-serif;
		padding: 20px,0;
		background: #e1e1e1;
	}
	#merkez{
		margin: 0 auto;
		max-width: 1280px;
		background: #ffffff;
		border: 1px solid #cccccc;
		padding: 20px;
		border-radius: 25px;
		box-shadow: 4px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
</style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
	<center><h1><span class="glyphicon glyphicon-calendar"></span> <?php echo $oto_ad; ?> <span class="label label-info"><?php echo $oto_year; ?></span></center>
	</h1>
</nav>
<div id="merkez">
<?php 
	if(isset($_GET['girisyap']) && !isset($_SESSION['LOGIN'])){ // giriş yapma
		if(isset($_POST['no']) && isset($_POST['parola'])){
			if(girisyap($_POST['no'],$_POST['parola']))
				yonlendir("?");
			else
			{
				exit(html_renk("<center><h2>Yanlış no veya şifre <br><br>",-1).linkle("?","Giriş sayfasına dönmek için tıklayınız..."));
			}	
		}
		else
		{
			exit("Form yapısı hatalı");
		}



	}

	if(!isset($_SESSION['LOGIN']))
		include 'sayfa/ana.php'; // giriş yapılmadıysa anasayfa
	else
	{
			if(isset($_GET['yap'])){ // iş yapıcı sayfalar
					switch ($_GET['yap']) {
						case 'cikis':
							cikisyap();
							yonlendir("?");
							break;
						case 'vtsil':
							sadece_admin();
							$sonuc=$vt->sorgu("DELETE FROM ".$_GET["from"]." WHERE ".$_GET["sutun"]."=:id",array(
								"id" => $_GET["id"]
								));
							if($sonuc)
								mesaj( $_GET["from"]." dan ".$_GET["id"]. " nolu eleman silindi");
							else
							 	mesaj("HATA # Silinmedi");
							break;
						case 'sabit':
							sadece_admin();
							if($vt->yaz($_GET['id'],$_POST['deger'])){
								mesaj('değişkenler güncellendi');
							}
							else
							{
								mesaj('hata değer değiştirilemedi');
							}
							break;
						case 'r_reddet':
							sadece_admin();
							if($vt->sorgu('UPDATE rapor SET kabul=-1 WHERE rapor_id='.$_GET['id']))
								mesaj("Reddedildi");
							else
								mesaj("HATA");
							break;
						case 'r_onayla':
							sadece_admin();
							if($vt->sorgu('UPDATE rapor SET kabul=1 WHERE rapor_id='.$_GET['id']))
								mesaj("Onaylandı");
							else
								mesaj("HATA");
							break;
						case 'm_reddet':
							sadece_admin();
							if($vt->sorgu('UPDATE mazeret SET kabul=-1 WHERE mazeret_id='.$_GET['id']))
								mesaj("Reddedildi");
							else
								mesaj("HATA");
							break;
						case 'm_onayla':
							sadece_admin();
							if($vt->sorgu('UPDATE mazeret SET kabul=1 WHERE mazeret_id='.$_GET['id']))
								mesaj("Onaylandı");
							else
								mesaj("HATA");
							break;
						case 'parola':
							if(isset($_POST['parola']) && isset($_POST['parola'][3])){
								$sonuc=$vt->sorgu('UPDATE ogrenci SET parola=:parola WHERE ogrenci_id=:id',array(
									"parola" => $_POST['parola'],
									"id" => $_SESSION["id"]
									));
								if($sonuc){
									 mesaj("parola değişti");
								}
								else
									 mesaj("HATA # parola değişmedi");
							}
							else
							 mesaj("HATA # parola değişmedi");
							break;
						case 'dersekle':
							sadece_admin();
							$sonuc=$vt->sorgu("INSERT INTO verilenders VALUES(NULL,:ders,:hoca)",array(
								"ders" => $_POST["ders"], 
								"hoca" => $_POST["hoca"]
								));
							if($sonuc)
								mesaj( $_POST["ders"]." - ".$_POST["hoca"]. " dersi eklendi");
							else
							 	mesaj("HATA # ders eklenemdi");
							break;
						case 'insert':
							sadece_admin();
							$sutunlar = $vt->sutunlar($_GET["from"]);
							$satirlar= explode("\n",$_POST['veriler']);
							if(!isset($satirlar[0])) {mesaj("Sintaks hatası");break;}
							foreach ($satirlar as $key => $satir) {
								$satirlar[$key] = explode(",", $satir);
								
							}
							foreach ($satirlar as $key => $satir) {
								if(count($satirlar[$key])!=count($sutunlar)){
									array_splice($satirlar, $key);
								}
							}
							$mesajlar="";
							foreach ($satirlar as $key => $satir) {
								$val="";
								foreach ($satir as $sutun) {
									if(is_numeric($sutun)){
										$val.=$sutun.",";
									}
									else
									{
										$val.="'$sutun',";
									}
								}
								$val = substr($val, 0, -1);
								$sonuc=$vt->sorgu("INSERT INTO ".$_GET["from"]." VALUES(".$val.")");
								if($sonuc){
									$mesajlar.="<br>$val degerleri eklendi";
								}
								else
								{
									$mesajlar.="<br>$val degerleri eklendi";
								}
							}
							mesaj($mesajlar);
							break;
					}			
					if(!isset($_GET['dur'])) // geri yönlendirme durdurulmamışsa
						yonlendir("?sayfa=".$_SESSION['sonsayfa']);
			}
			else
			{ // görünen sayfalar
				if(!isset($_GET['sayfa'])){ // sayfa yoksa panele
					if(isset($_SESSION['ADMIN'])){ // admin paneli
						include 'sayfa/menu.php';
						include 'sayfa/admin.php';
						$_SESSION['sonsayfa'] = "?";
					}
					else
					{ // öğrenci kısmı
						include 'sayfa/ogrenci.php';
					}
				}
				else{ // var sa panelin bir sayfasına
					if(is_numeric(array_search($_GET['sayfa'], $sayfalar))){ // included sayfalar
						sadece_admin();
						include 'sayfa/menu.php';
						include 'sayfa/'.$_GET['sayfa'].'.php';
					}
					else if(is_numeric(array_search($_GET['sayfa'], $vt_sayfalar))){ // vt sayfaları
						sadece_admin();
						$aktif_vt = $_GET['sayfa'];
						include 'sayfa/menu.php';
						include 'sayfa/vt.php';
					}
					else
					{
						switch ($_GET['sayfa']) {
							case 'sorgu':
								sadece_admin();
								include 'sayfa/menu.php';
								include 'sayfa/sorgu.php';
								break;
								case 'raporla':
									if(isset($_POST['tarih']) && $_POST['tarih']!='' && isset($_POST['tur'])){
										if($_POST['tur']==0){ //rapor
											if(isset($_POST['kacgun']) && is_numeric($_POST['kacgun'])){
												if(isset($_POST['dersler']) && count($_POST['dersler'])>0){
													foreach ($_POST['dersler'] as $o) {
														if(!is_numeric($o)) exit(hata);
													}
													// kontroller buarada biter
													 require 'class.upload.php';
													 $image = new Upload( $_FILES[ 'uploadField' ] );
													 $resimad = $_POST['tarih'].'_rapor_'.$_SESSION['id'].'_'.rand(1000000, 99999999);
													 $image->file_new_name_body = $resimad;
													 $image->image_convert = 'jpg';
													if ( $image->uploaded ) {
														$image->Process('raporlar');
														if ( $image->processed ){
															$sql = "INSERT INTO rapor (rapor_id,resim,tarih,kac_gun,kabul,ogrenci_id) VALUES (NULL,:resim,:tarih,:kacgun,0,:ogrenci);";
															$sql .= "SET @t = LAST_INSERT_ID();";
															foreach ($_POST['dersler'] as $o) {
																$sql .= "INSERT INTO raporalma (ders_id,rapor_id) VALUES ($o,@t);";
															}
															$sonuc=$vt->sorgu($sql,array(
																"resim"=>("raporlar/" . $image->file_dst_name),
																"tarih"=>$_POST['tarih'],
																"kacgun"=>$_POST['kacgun'],
																"ogrenci"=>$_SESSION['id']
																));
															if($sonuc){
																echo "<h1>Rapor Başarıyla Alındı. Anasayfadan kabul durumunu kontrol edebilirsiniz. <a href='?yap=cikis' class='btn btn-danger'>Çıkış</a></h1>";
																
															}
															else
															{
																echo "Raporunuzu alamadık :(";
															}
															print '<img src="' . "raporlar/" . $image->file_dst_name . '" alt="" />';
															var_dump($_POST);
														} else {
														print 'Bir sorun oluştu: '.$image->error;
														}
													}
												}
												else echo "Ders girmediniz";
											}
											else  echo "Raporun kaç gün oldugu giriniz";

										}
										else if($_POST['tur']==1) //mazeret
										{
											if(isset($_POST['dersler']) && count($_POST['dersler'])>0){
												foreach ($_POST['dersler'] as $o) {
													if(!is_numeric($o)) exit(hata);
												}
												// kontroller buarada biter SET @t1 = LAST_INSERT_ID( ) 
												$sql = "INSERT INTO mazeret (mazeret_id,aciklama,tarih,kabul,ogrenci_id) VALUES (NULL,:mazeret,:tarih,0,:ogrenci);";
												$sql .= "SET @t = LAST_INSERT_ID();";
												foreach ($_POST['dersler'] as $o) {
													$sql .= "INSERT INTO mazeretalma (ders_id,mazeret_id) VALUES ($o,@t);";
												}
												$sonuc=$vt->sorgu($sql,array(
													"mazeret"=>$_POST['mazeret'],
													"tarih"=>$_POST['tarih'],
													"ogrenci"=>$_SESSION['id']
													));
												if($sonuc){
													echo "<h1>Mazeret Başarıyla Alındı. Anasayfadan kabul durumunu kontrol edebilirsiniz. <a href='?yap=cikis' class='btn btn-danger'>Çıkış</a></h1>";
													var_dump($_POST);
												}
												else
												{
													echo "Mazeretinizi alamadık :(";
												}

											}
											else echo "Ders girmediniz";

											
										}
										else echo "hata";

									}
									else
									{
										echo "Tarih girmediniz";
									}
									echo '<br><a href="?" class="btn btn-warning">Geri dön</a>';
									break;
							default:
								yonlendir("?");
								break;
						}
					}


					$_SESSION['sonsayfa'] = $_GET['sayfa']; // son sayfamızı kaydediver
				}
			}
	}
?>
</div>
</body>
</html>




<?php
	// FONKSİYONLAR
	// not globalleri unutma

	function girisyap($no,$parola)
	{
		global $admin_hesap,$admin_parola,$vt,$_SESSION;

		if($no==$admin_hesap && $parola==$admin_parola){ // admin girişi
			$_SESSION['LOGIN'] = true;
			$_SESSION['ADMIN'] = true;
			$_SESSION['sonsayfa'] = "?";
			$_SESSION['mesaj'] = "Hoşgeldin ". $admin_hesap;
			return true;
		}
		else{ // öğrenci girişi
			$sonuc = $vt->sor("SELECT count(*) as durum FROM ogrenci  WHERE okul_no=:no AND parola=:parola",array(
				"no" => $no,
				"parola" => $parola
				));
			if($sonuc['durum']==1){
				$_SESSION['LOGIN'] = true;
				$_SESSION['sonsayfa'] = "?";
				$bilgiler = $vt->sor("SELECT * FROM ogrenci WHERE okul_no=:no AND parola=:parola",array(
					"no" => $no,
					"parola" => $parola
					));			
				$_SESSION['id']	= $bilgiler["ogrenci_id"];
				$_SESSION['bilgiler']	= $bilgiler;
				$_SESSION['mesaj'] = "Hoşgeldin ";
				return true;
			}
			else
				return false;
		}
		
	}

	function cikisyap(){
		global $_SESSION;
		unset($_SESSION);
		session_destroy();
	}
	function sadece_admin(){
		global $_SESSION;
		if(!isset($_SESSION['ADMIN']))
			yonlendir($_SESSION['sonsayfa']);
	}
	function echo_mesaj(){
		global $_SESSION;
		if(isset($_SESSION['mesaj'])){
			echo '<div class="alert alert-info" role="alert">'.$_SESSION['mesaj'].'</div>';
			unset($_SESSION['mesaj']);
		}
			
	}
	function mesaj($mesaj){
		$_SESSION['mesaj'] = $mesaj;
	}

	// HTML FONKSiYONLARI
	function htmlyoket($html){ // html koduları ekleyip sayfa bozma engelleme
    $html = strip_tags($html, ''); // izin verilenler
    return $html;
	}

	function deletelink($link){
	    return "<a href='$link'><img border='0' src='resimler/false.png' /></a>";
	}
	function html_renk($kod,$renk){
	    $rnk="".$renk;
	    if ($renk==-1) $rnk="red";
	    elseif ($renk==1) $rnk="green";
	    return "<font color='$rnk'>$kod</font>";
	}

	function xml($text,$tag,$att=""){
		return  "<" . $tag ."$att>" . $text . "</" . $tag .">";
	}
	function linkle($link,$text="tıklayınız"){
		return "<a href='".$link."'>".$text."</a>";
	}
	function strtoupperTR($str)
	{
	$str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), $str);
	return strtoupper($str);
	}
	function yonlendir($url){
	    if (!headers_sent()){  
	        header('Location: '.$url); exit; 
	    }else{ 
	        echo'<script type="text/javascript">'; 
	        echo 'window.location.href="'.$url.'";'; 
	        echo '</script>'; 
	        echo '<noscript>'; 
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />'; 
	        echo '</noscript>'; exit; 
	    }
	}
?>