
<script type="text/javascript">

function tip () {
	if(!document.getElementById('raporck').checked){
		document.getElementById("yer").innerHTML = '<textarea name="mazeret" class="form-control" rows="5" placeholder="Mazeretin Açıklaması"></textarea>';
	}
	else
	{
		document.getElementById("yer").innerHTML = '<input name="kacgun" id="kacgun" type="text" class="form-control" placeholder="Kaç Gün?">Raporun Taratılmış Resmi<input type="file" name="uploadField" />';
	}
	
}
</script>
  <script src="jquery-1.10.2.js"></script>
  <script src="jquery-ui.js"></script>
  <link rel="stylesheet" href="jquery-ui.css">
<form id="sqlform" action="?yap=parola" method="POST"><input type="hidden" id="parola" name="parola" value=""></form>
<p class="text-right">Hesap : <b><?php echo $_SESSION['bilgiler']['okul_no']?></b>  <a href="#" onClick="parola();" class="btn btn-primary">Parola Değiştir</a> <a href="?yap=cikis" class="btn btn-danger">Çıkış</a></p>
Merhaba <?php echo $_SESSION['bilgiler']['ad_soyad']." (".$_SESSION['bilgiler']['sinif'].")";echo_mesaj();?>

<script type="text/javascript">
function parola (argument) {
	pw1=prompt("Yeni Parola (min:4kar)", "");
	pw2=prompt("Yeni Parola (Tekrar)", "");
	if(pw1==pw2){
		document.getElementById("parola").value = pw1;
		document.getElementById("sqlform").submit();
	}
	else
	{
		alert("Parolalar aynı değil");
	}
}
</script>

<hr>
<blockquote>
<form id="form" action="?sayfa=raporla" method="POST" enctype="multipart/form-data">
	<blockquote class="blockquote-reverse">
<b>Mazeret Türü  : </b>
<label class="radio-inline">
  <input type="radio" onChange="tip();" name="tur" id="tur" value="1"> Sınav Mazeret
</label>
<label class="radio-inline">
  <input type="radio" onChange="tip();" name="tur" id="raporck" value="0" checked> Devamsızlık Mazereti
</label>

 <div class="col-xs-6 col-sm-3">
      <input name="tarih" id="tarih" type="text" class="form-control" placeholder="Rapor/Mazeret Tarihi" readonly>
</div>
</blockquote>



<blockquote><div id="yer"></div></blockquote>

<table width="100%"><tr><td><blockquote><br><center>Ders Ekleme</center>
<input autocomplete="off" id="ders" class="form-control" type="text" placeholder="Ders Adı - Adı girin devamını biz getiriz">
<select id="hoca" class="form-control">
	<option>Dersin Hocası</option>
</select>
 <p class="text-right"><a href="#" onClick="addDers();" class="btn btn-success">Ders Ekle <span class="glyphicon glyphicon-chevron-right"></span></a></p>
 </blockquote>
</td>
<td>
	<blockquote>
<center><br>Raporlu/Mazeretli Dersler : 
<select id="dersler" name="dersler[]" multiple="multiple" class="form-control">
</select>
</center>
</blockquote>
</td>
</tr>
</table>
 <button type="button"  onClick="send();" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Gönder!</button>


</form>
</blockquote>






	<?php echo $vt->oku(2);?>
	
  <script>
 Array.prototype.pushUnique = function (item){
    if(this.indexOf(item) == -1) {
    //if(jQuery.inArray(item, this) == -1) {
        this.push(item);
        return true;
    }
    return false;
}  
  var dersler = <?php $dersler=$vt->sorhepsini("SELECT ders_id,ders_ad FROM verilenders INNER JOIN ders ON verilenders.ders_kodu=ders.ders_kodu ORDER BY ders_id");
$hocalar=$vt->sorhepsini("SELECT ders_id,ad FROM verilenders INNER JOIN ogretimelemani ON verilenders.tc=ogretimelemani.tc ORDER BY ders_id");
echo str_replace("\r", "", json_encode($dersler/*,JSON_UNESCAPED_UNICODE*/));
?>;


	var hocalar = <?php echo str_replace("\r", "", json_encode($hocalar/*,JSON_UNESCAPED_UNICODE*/));?>;
    var dersadlari = [];
    dersler.forEach( function(al){
        	dersadlari.pushUnique(al.ders_ad);
    });
  $(function() {
  	tip();
    $( "#ders" ).autocomplete({
      source: dersadlari
    });
	 $( "#tarih" ).datepicker({
showOtherMonths: true,
selectOtherMonths: true
});
	 $( "#tarih" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  });


val = document.getElementById("ders").value;
setInterval(function() {
	if(document.getElementById("ders").value!=val){
		val = document.getElementById("ders").value;
		hocayukle();
	}
}, 500);
 function hocayukle () {
      var x = document.getElementById("hoca");
      for(var i=0;i<x.length;i++)
        x.remove(i) 
    dersler.forEach( function(a,i){
      if(compare(document.getElementById("ders").value,a.ders_ad)){
            var option = document.createElement("option");
            option.text = hocalar[i].ad;
            option.value = hocalar[i].ad;
            x.add(option);
      }
      //alert(document.getElementById("ders").value+"=="+a.ders_ad);
    });
  }

  function compare (a,b) {
    if(a==b || (a+'\r')==b || a==(b+'\r')){
      return true;
    }
    return false;
  }

  function addDers () {
    dersler.forEach( function(ders,i){
          if(compare(hocalar[i].ad,document.getElementById("hoca").value) && compare(ders.ders_ad,document.getElementById("ders").value)){
          var x = document.getElementById("dersler");
      var option = document.createElement("option");
      option.text = ders.ders_ad+" - "+hocalar[i].ad;
      option.value = dersler[i].ders_id;
      x.add(option); 
      document.getElementById("ders").value="";
          }
    });
  }

  function send () {
    $('#dersler option').each(function(){
        if($(this).attr('something') != 'omit parameter')
        {
            $(this).attr('selected', 'selected');
        }
    });
  	document.getElementById("form").submit();
  	}


  </script>