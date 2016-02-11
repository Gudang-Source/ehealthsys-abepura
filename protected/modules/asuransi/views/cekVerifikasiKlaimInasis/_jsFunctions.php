<script type="text/javascript">
function setTanggal(obj){
	if(obj.value == 'radio_tglmasuk'){
		$('#radio_tglmasuk').attr('checked',true);
		$('#radio_tglkeluar').removeAttr('checked',true);
		$('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglmasuk') ?>').removeAttr('disabled',true);
		$('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglkeluar') ?>').attr('disabled',true);
	}else{
		$('#radio_tglmasuk').removeAttr('checked',true);
		$('#radio_tglkeluar').attr('checked',true);
		$('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglmasuk') ?>').attr('disabled',true);
		$('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglkeluar') ?>').removeAttr('disabled',true);
	}
}	
/**
 * fungsi cek Verifikasi Klaim Inasis 5.3
 */
function cekVerifikasi(obj)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	var tglmasuk = $('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglmasuk') ?>').val();
	var tglkeluar = $('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_tglkeluar') ?>').val();
	var jnspelayanan = $('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_jnspelayanan') ?>').val();
	var klspelayanan = $('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_kelaspelayanan') ?>').val();
	var status = $('#<?php echo CHtml::activeId($modVerifikasiInasis,'verifikasiinasis_status') ?>').val();
	
	var aksi = 1;  // 1 untuk cek verifikasi klaim inasisi
	
    if (jnspelayanan=="") {myAlert('Isi data Jenis Pelayanan terlebih dahulu!'); return false;};
    if (klspelayanan=="") {myAlert('Isi data Kelas Pelayanan terlebih dahulu!'); return false;};
    if (status=="") {myAlert('Isi data Status terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&tglmasuk=' + tglmasuk + '&tglkeluar=' + tglkeluar + '&jnspelayanan=' + jnspelayanan + '&klspelayanan=' + klspelayanan + '&status=' + status,
        beforeSend: function(){
            $("#table-hasil-verifikasi").addClass("animation-loading");
        },
        success: function(data){
            $("#table-hasil-verifikasi").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var list = obj.response.list[0];
				$("#kdInacbg").text(list.Inacbg.kdInacbg);
				$("#kdSeverity").text(list.Inacbg.kdSeverity);
				$("#nmInacbg").text(list.Inacbg.nmInacbg);
				$("#byTagihan").text(list.byTagihan);
				$("#byTarifGruper").text(list.byTarifGruper);
				$("#byTarifRS").text(list.byTarifRS);
				$("#byTopup").text(list.byTopup);
				$("#jnsPelayanan").text(list.jnsPelayanan);
				$("#noMR").text(list.noMR);
				$("#noSep").text(list.noSep);
				$("#nama").text(list.peserta.nama);
				$("#noKartu").text(list.peserta.noKartu);
				$("#noMr").text(list.peserta.noMr);
				$("#kdStatSep").text(list.statSep.kdStatSep);
				$("#nmStatSep").text(list.statSep.nmStatSep);
				$("#tglPulang").text(list.tglPulang);
				$("#tglSep").text(list.tglSep);
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
            $("#table-hasil-verifikasi").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function print(caraPrint){
	var verifikasiinasis_id = '<?php echo isset($_GET['verifikasiinasis_id']) ? $_GET['verifikasiinasis_id'] : null; ?>';
	window.open('<?php echo $this->createUrl('PrintVerifikasi'); ?>&verifikasiinasis_id='+verifikasiinasis_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>