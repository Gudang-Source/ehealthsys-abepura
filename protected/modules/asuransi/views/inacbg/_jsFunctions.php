<script type="text/javascript">
function setSEP(sep_id){
setSEPBaru();
$("#data-sep").addClass("animation-loading"); 
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('getDataSEP'); ?>',
		data: {sep_id:sep_id},
		dataType: "json",
		success:function(data){
			$('#<?php echo CHtml::activeId($modSEP,'nosep'); ?>').val(data.nosep);
			$('#<?php echo CHtml::activeId($modSEP,'tglsep'); ?>').val(data.tglsep);
			$('#<?php echo CHtml::activeId($modSEP,'nokartuasuransi'); ?>').val(data.nokartuasuransi);
			$('#<?php echo CHtml::activeId($modSEP,'nama_peserta'); ?>').val(data.nama_peserta);
			$('#<?php echo CHtml::activeId($modSEP,'jeniskelamin'); ?>').val(data.jeniskelamin);
			$('#<?php echo CHtml::activeId($modSEP,'tglrujukan'); ?>').val(data.tglrujukan);
			$('#<?php echo CHtml::activeId($modSEP,'norujukan'); ?>').val(data.norujukan);
			$('#<?php echo CHtml::activeId($modSEP,'politujuan'); ?>').val(data.politujuan);
			$('#<?php echo CHtml::activeId($modSEP,'jnspelayanan'); ?>').val(data.jnspelayanan);
			$('#<?php echo CHtml::activeId($modSEP,'klsrawat'); ?>').val(data.klsrawat);
			$('#<?php echo CHtml::activeId($modSEP,'diagnosaawal'); ?>').val(data.diagnosaawal);
			$('#<?php echo CHtml::activeId($modSEP,'tglpulang'); ?>').val(data.tglpulang);
			$('#<?php echo CHtml::activeId($modSEP,'catatansep'); ?>').val(data.catatansep);
			$('#<?php echo CHtml::activeId($modPendaftaran,'pendaftaran_id'); ?>').val(data.pendaftaran_id);
			$('#<?php echo CHtml::activeId($modSEP,'sep_id'); ?>').val(data.sep_id);
			$('#<?php echo CHtml::activeId($modSEP,'surat_rujukan'); ?>').val('');			
			setKunjunganPasien(data.pendaftaran_id);
			window.scrollBy(0,380); //<<RND-820 (custom)
			$("#data-sep").removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { myAlert("Data SEP tidak ditemukan !"); $("#data-sep").removeClass("animation-loading");}
	});	
}

function setKunjunganPasien(pendaftaran_id){
$("#data-kunjungan-pasien").addClass("animation-loading"); 
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('getDataKunjunganPasien'); ?>',
		data: {pendaftaran_id:pendaftaran_id},
		dataType: "json",
		success:function(data){
			$('#<?php echo CHtml::activeId($modPendaftaran,'no_pendaftaran'); ?>').val(data.no_pendaftaran);
			$('#<?php echo CHtml::activeId($modPendaftaran,'tgl_pendaftaran'); ?>').val(data.tgl_pendaftaran);
			$('#<?php echo CHtml::activeId($modPasien,'no_rekam_medik'); ?>').val(data.no_rekam_medik);
			$('#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>').val(data.nama_pasien);
			$('#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>').val(data.jeniskelamin);
			$('#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>').val(data.tanggal_lahir);
			$('#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>').val(data.pasien_id);
			$('#<?php echo CHtml::activeId($modPendaftaran,'instalasi_nama'); ?>').val(data.instalasi_nama);
			$('#<?php echo CHtml::activeId($modPendaftaran,'ruangan_nama'); ?>').val(data.ruangan_nama);
			$('#<?php echo CHtml::activeId($modPasienAdmisi,'tgladmisi'); ?>').val(data.tgladmisi);
			$('#<?php echo CHtml::activeId($modPasienAdmisi,'ruangan_nama'); ?>').val(data.ruangan_admisi);
			$('#<?php echo CHtml::activeId($modPendaftaran,'kelaspelayanan_nama'); ?>').val(data.kelaspelayanan_nama);
			$('#<?php echo CHtml::activeId($modPasienAdmisi,'kamarruangan_nama'); ?>').val(data.kamarruangan_nama);
			$('#<?php echo CHtml::activeId($modPasienAdmisi,'tglpulang'); ?>').val(data.tglpulang);
			$('#<?php echo CHtml::activeId($modPasienPulang,'carakeluar_nama'); ?>').val(data.carakeluar_nama);
			$('#<?php echo CHtml::activeId($modPasienPulang,'kondisikeluar_nama'); ?>').val(data.kondisikeluar_nama);
			$('#<?php echo CHtml::activeId($modPendaftaran,'keterangan'); ?>').val(data.keterangan_pendaftaran);			
			$('#<?php echo CHtml::activeId($modPasienAdmisi,'pasienadmisi_id'); ?>').val(data.pasienadmisi_id);			
			$('#<?php echo CHtml::activeId($modPasienPulang,'pasienpulang_id'); ?>').val(data.pasienpulang_id);			
			$('#<?php echo CHtml::activeId($model,'totaltarif'); ?>').val(data.tarif_tindakan);			
			$('#table-diagnosa tbody').append(data.tr);			
//			setDiagnosa(data.pendaftaran_id);
			renameInputRowObatAlkes($("#table-diagnosa"));
			formatNumberSemua();
			window.scrollBy(0,380); //<<RND-820 (custom)
			$("#data-kunjungan-pasien").removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Kunjungan Pasien tidak ditemukan !"); $("#data-sep").removeClass("animation-loading");}
	});	
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function checkAll(){
    $("#table-diagnosa > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#check_semua").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
    });
}

function refreshDiagnosa(){
	
}

function lihatRincianPasien(){
	var pendaftaran_id = $('#<?php echo CHtml::activeId($modPendaftaran,'pendaftaran_id'); ?>').val();
	var pasienadmisi_id = $('#<?php echo CHtml::activeId($modPasienAdmisi,'pasienadmisi_id'); ?>').val();
	$('#dialogRincian').dialog('open');
	$("#divRincian").addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('PrintRincianTagihanPasien'); ?>',
		data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,frame:1},
		dataType: "json",
		success:function(data){		
			$('#dialogRincian div.divForForm').append(data.rincian);
			window.scrollBy(0,380); //<<RND-820 (custom)
			$("#divRincian").removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { myAlert("Rincian Tagihan Pasien tidak ditemukan !"); $("#divRincian").removeClass("animation-loading");}
	});
}
/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}
function setSEPBaru(){
	$('#<?php echo CHtml::activeId($modSEP,'nosep'); ?>').val('');
	$('#<?php echo CHtml::activeId($modSEP,'barcode_sep'); ?>').val('');
}

function grouping(){
	var katakunci = $('#inacbg-t-form').serialize();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(katakunci != ''){
		var isi = katakunci;
		var aksi = 7; // 7 untuk grouping data 
	}
	
    if (isi=="") {myAlert('Isi Data SEP terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#pencarian-grouper").addClass("animation-loading");
        },
        success: function(data){
            $("#pencarian-grouper").removeClass("animation-loading");
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
            $("#pencarian-grouper").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function updateFinalisasi(sep_id){
	$("#inacbg-t-form").addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('updateFinalisasi'); ?>',
		data: {sep_id:sep_id},
		dataType: "json",
		success:function(data){	
			if(data.pesan != ''){
				myAlert(data.status);
			}
			$("#inacbg-t-form").removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { myAlert("Rincian Tagihan Pasien tidak ditemukan !"); $("#divRincian").removeClass("animation-loading");}
	});
}

$(document).ready(function(){
	var sep_id = '<?php isset($model->sep_id) ? $model->sep_id : null; ?>';
	var pendaftaran_id = '<?php isset($model->pendaftaran_id) ? $model->pendaftaran_id : null; ?>';
	setSEP(sep_id);
});
</script>