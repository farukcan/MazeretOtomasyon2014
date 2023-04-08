<?php
class pdo_vt extends PDO{
	var $pdo;
	function pdo_vt(){
		global $vt_host,$vt_ad,$vt_hesap,$vt_parola;
		try{
		$this->pdo = new PDO('mysql:host='.$vt_host.';dbname='.$vt_ad.';charset=utf8', $vt_hesap, $vt_parola);
		$this->pdo->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
		}catch(PDOException $e){
			
		}		
	}
	function sorgu($sorgu,$degerler=null){// hatada FALSE
		$sorgut=$sorgu;
		$sorgu = $this->pdo->prepare($sorgu);
		$sonuc = $sorgu->execute($degerler);

		return $sonuc;
	}
	function sor($sorgu,$degerler=null){ // hatada FALSE
		$sorgut=$sorgu;
		$sorgu = $this->pdo->prepare($sorgu);
		$sorgu->execute($degerler);
		$sonuc = $sorgu->fetch(2);

		return $sonuc;
	}
	function sorhepsini($sorgu,$degerler=null){ //hatada EMPTY döner
		$sorgu = $this->pdo->prepare($sorgu);
		$sorgu->execute($degerler);
		$sonuc = $sorgu->fetchAll(2);
		return $sonuc;
	}
	function soneklenen(){
		return $this->pdo->lastInsertId();
	}
	// Sabitler veritabanı fonksiyonları
	function yaz($noveyaad,$deger){
		if(is_numeric($noveyaad)){
			if($deger==NULL)
				return $this->sorgu("DELETE FROM sabitler WHERE no=:no",array("no"=>$noveyaad));
			else
				return $this->sorgu("INSERT INTO sabitler (deger,no) VALUES (:deger,:no) ON DUPLICATE KEY UPDATE deger=:deger ;",array("deger"=>$deger,"no"=>$noveyaad));
			
		}
		else
		{
			if($deger==NULL)
				return $this->sorgu("DELETE FROM sabitler WHERE ad=:ad",array("ad"=>$noveyaad));
			else
				return $this->sorgu("INSERT INTO sabitler (deger,ad) VALUES (:deger,:ad) ON DUPLICATE KEY UPDATE deger=:deger ;",array("deger"=>$deger,"ad"=>$noveyaad));

		}
	
	}
	function oku($noveyaad){
		if(is_numeric($noveyaad))
			$a=$this->sor("SELECT deger FROM sabitler WHERE no=:no ; ",array("no"=>$noveyaad));
		else
			$a=$this->sor("SELECT deger FROM sabitler WHERE ad=:ad ; ",array("ad"=>$noveyaad));
		if($a)
			return $a["deger"];
		else
			return FALSE;
	}
	function sutunlar($tablo){
		$q = $this->pdo->prepare("DESCRIBE $tablo");
		$q->execute();
		return $q->fetchAll(PDO::FETCH_COLUMN);
	}
}

// BAŞLAYALIM !!!
global $vt;
$vt = new pdo_vt();
?>