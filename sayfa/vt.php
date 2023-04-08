<table class="table table-striped">
	<tr><th>#</th><?php
	$sutunlar = $vt->sutunlar($aktif_vt);
	foreach ($sutunlar as $sutun) {
		echo "<th>$sutun</th>";
	}
	$degerler = $vt->sorhepsini("SELECT * FROM $aktif_vt");
	?></tr>

	<?php

	foreach ($degerler as $satir) {
		$m = array_values($satir);
		$n = array_keys($satir);
		echo "<tr><td>".deletelink("?yap=vtsil&from=$aktif_vt&id=".$m[0]."&sutun=".$n[0])."</td>";
		foreach ($satir as $sutun) {
			echo "<td>$sutun</td>";
		}
		echo "</tr>";
	}
	?>
</table>

<hr>
<form >
<p class="text-right"><button onclick="document.getElementById('uploadfile').click();" type="button" class="btn btn-success">.csv Dosyasından Yükle</button>
<input type="file" id='uploadfile' name='uploadfile'><p/>
</form>
<form class="form-inline" role="form">
	<?php $i=0;foreach ($sutunlar as $sutun){
		echo '<input id="sut'.$i++.'"type="text" class="form-control" placeholder="'.$sutun.'"/>';
	}
	echo '<script type="text/javascript">m='.$i.';</script>'
	?>
<button onclick="add();" type="button" class="btn btn-default">Ekle</button>
</form>
<form action="?yap=insert&from=<?php echo $aktif_vt; ?>" method="post">
<textarea id="alan" name="veriler" class="form-control" rows="5"></textarea>
<button type="submit" class="btn btn-info">Ekle & Kaydet</button>
</form>

<script type="text/javascript">
function add () {
	for(var i=0;i<m;i++){
		if(i==m-1)
			document.getElementById('alan').innerHTML += document.getElementById('sut'+i).value;
		else
			document.getElementById('alan').innerHTML += document.getElementById('sut'+i).value+",";
		document.getElementById('sut'+i).value="";
	}
		
	document.getElementById('alan').innerHTML += "\n";
	return false;
}


    window.onload = function () {
    var fileInput = document.getElementById('uploadfile');
    var fileDisplayArea = document.getElementById('alan');
    fileInput.addEventListener('change', function (e) {
        var file = fileInput.files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                fileDisplayArea.innerText = reader.result;
                alert("csv dosyası yüklendi");
            };
            reader.readAsText(file,'utf8');
    });
};
</script>