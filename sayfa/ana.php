<form class="form-horizontal" role="form" action="?girisyap" method="POST">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-1 control-label">Öğrenci No</label>
    <div class="col-sm-10">
      <input type="username" class="form-control" name="no" placeholder="<?php echo $oto_ogrenci_no_ornek; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-1 control-label">Şifre</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="parola" placeholder="Şifre">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-1 col-sm-10">
      <button type="submit" class="btn btn-default">Giriş Yap</button>
    </div>
  </div>
</form>
<hr>
  <?php echo $vt->oku(1);?>
<hr>
<table class="table table-striped">
	<tr><th>#Tarih Y/A/G</th><th>Öğrenci</th><th>Rapor/Mazeret</th><th>Durum</th></tr>
<?php
  $liste = $vt->sorhepsini('SELECT tarih,ad_soyad,"Rapor",kabul FROM rapor INNER JOIN ogrenci ON rapor.ogrenci_id=ogrenci.ogrenci_id union all SELECT tarih,ad_soyad,"Mazeret",kabul FROM mazeret INNER JOIN ogrenci ON mazeret.ogrenci_id=ogrenci.ogrenci_id ORDER BY tarih DESC LIMIT 30');
    foreach ($liste as $sat) {
      echo "<tr>";
      foreach ($sat as $key => $value) {
        if($key == 'kabul'){
          if($value==-1){
            echo xml(html_renk("Reddedildi",-1),"td");
          }
          elseif ($value==1) {
            echo xml(html_renk("Onaylandı",1),"td");
          }
          else
          {
            echo xml("Onay Bekliyor","td");
          }
        }
        else
        echo "<td>$value</td>";
      }
      echo "</tr>";
  }
?>

</table>