<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tabel-diagnosa">
	<tr>
		<td style="font-weight: bold;">Kode Diagnosa</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kodeDiagnosa"></td>
		
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama Diagnosa</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="namaDiagnosa"></td>
		
	</tr>
</table>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tabel-cbg">
	<tr>
		<td style="font-weight: bold;">Kode Prosedur</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kodeProsedur"></td>
		
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama Prosedur</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="nmProsedur"></td>
		
	</tr>
</table>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="table table-bordered table-striped" id="tabel-cmg">
	<tr>
		<td style="font-weight: bold;">Kode CMG</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kodeCMG"></td>
		
	</tr>
	<tr>
		<td style="font-weight: bold;">Kode Grup</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="kodeGrup"></td>
		
	</tr>
	<tr>
		<td style="font-weight: bold;">Nama CMG</td>
		<td style="font-weight: bold;text-align:center;">:</td>
		<td id="namaCMG"></td>
		
	</tr>
</table>
<script type="text/javascript">
function cariDataDiagnosa(){
	var katakunci = '<?php echo $_GET['diagnosa']; ?>';
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 4; // 1 untuk mencari data peserta diagnosa
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-diagnosa").addClass("animation-loading");
        },
        success: function(data){
            $("#data-diagnosa").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeDiagnosa").text(peserta.kodeDiagnosa);
				$("#namaDiagnosa").text(peserta.namaDiagnosa);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);			
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-diagnosa").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function cariDataCBG(){
	var katakunci = '<?php echo $_GET['cbg']; ?>';
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 5; // 1 untuk mencari data peserta CBG
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-cbg").addClass("animation-loading");
        },
        success: function(data){
            $("#data-cbg").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeProsedur").text(peserta.kodeProsedur);
				$("#namaProsedur").text(peserta.namaProsedur);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);			
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-cbg").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function cariDataCMG(){
	var katakunci = '<?php echo $_GET['cmg']; ?>';
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 6; // 1 untuk mencari data peserta CMG
	}
	
    if (isi=="") {myAlert('Isi Kata Kunci terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-cmg").addClass("animation-loading");
        },
        success: function(data){
            $("#data-cmg").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response;
				$("#kodeCMG").text(peserta.kodeCMG);
				$("#kodeGrup").text(peserta.kodeGrup);
				$("#namaCMG").text(peserta.namaCMG);
				$("#pencarian-diagnosa-cbg-cmg-form .btn-primary-blue").removeAttr('disabled',true);
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#data-cmg").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

$(document).ready(function(){
	var cbg = '<?php echo $_GET['cbg']; ?>';
	var cmg = '<?php echo $_GET['cmg']; ?>';
	var diagnosa = '<?php echo $_GET['diagnosa']; ?>';
	if(cbg != ''){
		cariDataCBG();
		$('#tabel-cbg').show();
		$('#tabel-cmg').hide();
		$('#tabel-diagnosa').hide();
	}
	if(cmg != ''){
		cariDataCMG();
		$('#tabel-cbg').hide();
		$('#tabel-cmg').show();
		$('#tabel-diagnosa').hide();
	}
	if(diagnosa != ''){
		cariDataDiagnosa();
		$('#tabel-cbg').hide();
		$('#tabel-cmg').hide();
		$('#tabel-diagnosa').show();
	}
});
</script>