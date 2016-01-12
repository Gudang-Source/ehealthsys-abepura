<script type="text/javascript">
/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            $("#ruangan_id").val(data.ruangan_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            $("#form-infopasien > legend > .judul").html('Data Pasien '+data.no_pendaftaran);
            $("#form-infopasien > legend > .tombol").attr('style','display:true;');
            $("#form-infopasien > .box").addClass("well").removeClass("box");
            
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });
}

function hitungSubTotal(obj){
    unformatNumberSemua();
	var asd = $(obj).parents('tr').find('input[name$="[subtotal]"]');
	$(asd).addClass("animation-loading-1");
	
    var harga = parseInt($(obj).parents('tr').find('input[name$="[hargajual_reseptur]"]').val());
    var qty = parseInt($(obj).parents('tr').find('input[name$="[qty_dilayani]"]').val());
    var subtotal = (harga*qty);
    var obj_subtotal = $(obj).parents('tr').find('input[name$="[subtotal]"]');
    obj_subtotal.val(subtotal);
    
    hitungTotal();
	
	setTimeout(function(){
		$(asd).removeClass("animation-loading-1");
	},300);
	
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
	var asd = $(obj_totalhargajual).parents('td');
	$(asd).addClass("animation-loading-1");
    totalharganetto = 0;
    totalhargajual = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_reseptur]"]').val() * $(this).find('input[name*="[qty_dilayani]"]').val() );
        totalhargajual += parseFloat($(this).find('input[name*="[subtotal]"]').val());
    });
    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
	
    setTimeout(function(){
		$(asd).removeClass("animation-loading-1");
	},300);
    formatNumberSemua();
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

/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php // echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
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

function batalObatAlkesPasienDetail(obj){
	var asd = $(obj).parents('tr');
	var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
	if(obatalkes_id != ''){
		myConfirm("Apakah anda akan membatalkan obat ini?",
		"Perhatian!",
		function(r){
			if(r){
				$(asd).addClass("animation-loading-1");
				setTimeout(function(){
					$(obj).parents('tr').detach();
					renameInputRowObatAlkes($("#table-obatalkespasien"));
					$(asd).removeClass("animation-loading-1");
				},400);
				setTimeout(function(){
					hitungTotal();
				},600);
			}
		}); 
	}else{
		$(obj).parents('tr').detach();
		renameInputRowObatAlkes($("#table-obatalkespasien"));
	}
}


function setDialogOA(obj,is_rowbaru){
    var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#tindakan_untuk").val(tindakan_untuk);
    $("#is_rowbaru").val(is_rowbaru);
    $("#dialogOa").dialog("open");
	var obatalkes_kode = '';
    $.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
        data:{
            "FAObatalkesM[obatalkes_kode]":obatalkes_kode,
        }
    });
}

/**
 * jika dipilih dari dialogbox
 */
//
function pilihObatalkes(obatalkes_id,obatalkes_nama,stok,hargajual,harganetto,obatalkes_kode,sumberdana_id,sumberdana_nama,satuankecil_id,satuankecil_nama,baru){
	var tindakan_untuk = $("#tindakan_untuk").val();
	var asd = $('#'+tindakan_untuk).parents('tr');
	$(asd).addClass("animation-loading-1");
	var qty = 1;
	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setObatAlkesPasien'); ?>',
		data: {obatalkes_id:obatalkes_id,jumlah:qty,therapiobat_id:null},//
		dataType: "json",
		success:function(data){
			if(data.pesan !== ""){
				myAlert(data.pesan);
				var params = [];
				params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
				insert_notifikasi(params);
				$(asd).removeClass("animation-loading-1");
				return false;
			}

			var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
			if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
				myAlert("Obat sudah ada pada tabel obat alkes");
				$(asd).removeClass("animation-loading-1");
				return false;
			}
			
			$("#"+tindakan_untuk).val(obatalkes_id);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[obatalkes_id]"]').val(data.modObatAlkesPasien.obatalkes_id);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[obatalkes_nama]"]').val(obatalkes_nama);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[qty_dilayani]"]').val(qty); //akan diperbaiki nanti
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[jmlstok]"]').val(data.otherdata.stok);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[hargasatuan_reseptur]"]').val(data.modObatAlkesPasien.hargasatuan_oa); //
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[hargajual_reseptur]"]').val(hargajual);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[harganetto_reseptur]"]').val(harganetto);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[subtotal]"]').val(hargajual*qty);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[sumberdana_id]"]').val(sumberdana_id);
			$("#"+tindakan_untuk).parents('tr').find('span[name$="[sumberdana_nama]"]').html(sumberdana_nama);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[satuankecil_id]"]').val(satuankecil_id);
			$("#"+tindakan_untuk).parents('tr').find('span[name$="[satuankecil_nama]"]').html(satuankecil_nama);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[iter]"]').val(1);
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[stokobatalkes_id]"]').val(data.otherdata.stokobatalkes_id);
			if(baru==1){
				$("#"+tindakan_untuk).parents('tr').find('input[name$="[qty_reseptur]"]').val('-');
				$("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_kode]"]').html('- / ');
				$("#"+tindakan_untuk).parents('tr').find('span[name$="[obatalkes_nama_label]"]').html('-');
			}
			
			$("#"+tindakan_untuk).parents('tr').find('input[name$="[iter]"]').attr('readonly',false);
			
			$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
				{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			);
			renameInputRowObatAlkes($("#table-obatalkespasien"));                    
			hitungTotal();
			$(asd).removeClass("animation-loading-1");


	formatNumberSemua();
	renameInputRowObatAlkes($("#table-obatalkespasien")); 
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
	
}

function tambahObatalkes(obj){
    var table = $('#table-obatalkespasien');
	var racikan_id = <?php echo Params::RACIKAN_ID_NONRACIKAN; ?>;
	<?php $modDetail = new FAResepturDetailT(); ?>
	<?php $this->is_trracikan = false; ?>
	var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailKosong',array('modResepturDetail'=> $modDetail),true));?>);
    $(table).children('tbody').append(row_tindakan.replace());
    renameInputRowObatAlkes($(table));
	
	// menentukan default rke
	var rke_array = [];
	$('#table-obatalkespasien > tbody > tr').each(function(index){
		rke_array[index] = $(this).find('input[name$="[rke]"]').val();
	});
	var rke_array_max = Math.max.apply(Math, rke_array);
	var rke = rke_array_max+1;
	
	// masukin data ke tr baru sebelum autocomplite
	$(table).find('tr:last-child input[name$="[rke]"]').val(rke);
	$(table).find('tr:last-child input[name$="[rke]"]').focus();
	$(table).find('tr:last-child input[name$="[racikan_id]"]').val(racikan_id);
	//	$("#"+tindakan_untuk).parents('td').find('span > a').attr('onclick','setDialogOA(this,0);');
	
    //masking input
//    $(table).find(".un-integer").maskMoney(
//        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//    ).removeClass("un-integer").addClass("integer");
	
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
}

function tambahObatalkesRacikan(obj,new_r){
    var table = $('#table-obatalkespasien');
	var rke_old = $(obj).parents('tr').find('input[name$="[rke]"]').val();
	var racikan_id = <?php echo Params::RACIKAN_ID_RACIKAN; ?>;
	<?php $modDetail = new FAResepturDetailT(); ?>
	<?php $this->is_trracikan = true; ?>
	var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('_rowDetailKosong',array('modResepturDetail'=> $modDetail),true));?>);
	var asd = $(obj).parents('tr');
	
	// menentukan default rke
	var rke_array = [];
	$('#table-obatalkespasien > tbody > tr').each(function(index){
		rke_array[index] = $(this).find('input[name$="[rke]"]').val();
	});
	var rke_array_max = Math.max.apply(Math, rke_array);
	var rke = rke_array_max+1;
	
	if(new_r == 1){
		$(table).children('tbody').append(row_tindakan.replace());
		renameInputRowObatAlkes($(table));
		// masukin data ke tr baru sebelum autocomplite
		$(table).find('tr:last-child input[name$="[rke]"]').val(rke);
		$(table).find('tr:last-child input[name$="[rke]"]').focus();
		$(table).find('tr:last-child input[name$="[racikan_id]"]').val(racikan_id);
	}else{
		$("'"+row_tindakan+"'").insertAfter( asd );
		renameInputRowObatAlkes($(table));
		// masukin data ke tr baru sebelum autocomplite
		$(obj).parents('tr').next('tr').find('input[name$="[rke]"]').val(rke_old);
		$(obj).parents('tr').next('tr').find('input[name$="[rke]"]').focus();
		$(obj).parents('tr').next('tr').find('input[name$="[racikan_id]"]').val(racikan_id);
	}
    
	
    //masking input
//    $(table).find(".un-integer").maskMoney(
//        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
//    ).removeClass("un-integer").addClass("integer");
	
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
}


function cekValiditas(){
    if(requiredCheck($("form"))){
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
		$('#penjualanresep-form').submit();
    }
    return false;
    
}

function ubahTakaranResep(obj){
	var takaran = $(obj).val();
	var takarantext = $(obj).find("[value='"+takaran+"']").text();
	myConfirm('Apakah anda ingin mengubah takaran semua obat menjadi '+takarantext+' dari resep?', 'Perhatian!', function(r){
		if(r){
			proporsiTakaranResep(takaran);
			$(obj).click(function(){
				$('#<?php echo CHtml::activeId($modReseptur,"totalhargajual") ?>').focus();
			});
		}else{
			$(obj).val(1);
		}
	});
}

/**
 * menghitung proporsi semua obat berdasarkan takaran
 * @returns {undefined}
 */
function proporsiTakaranResep(takaran){
	$('#table-obatalkespasien > tbody').addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetProporsiTakaranResep'); ?>',
		data: {takaran : takaran, data:$("input[name*='FAResepturDetailT']").serialize()},//
		dataType: "json",
		success:function(data){
			if(data.pesan==''){
				$('#table-obatalkespasien > tbody tr').detach();
				$('#table-obatalkespasien > tbody').append(data.form);
				renameInputRowObatAlkes($("#table-obatalkespasien"));                    
				$('#table-obatalkespasien > tbody > tr').each(function(){
					var harga = parseInt($(this).find('input[name$="[hargajual_reseptur]"]').val());
					var qty = parseInt($(this).find('input[name$="[qty_dilayani]"]').val());
					var subtotal = (harga*qty);
					var obj_subtotal = $(this).find('input[name$="[subtotal]"]');
					obj_subtotal.val(subtotal);
					hitungTotal();
				});
			}else{
				myAlert(data.pesan);
			}
			
			$('#table-obatalkespasien > tbody').removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-obatalkespasien")); 
    hitungTotal();
	
	<?php if(!$this->ada_penjualan){ ?>
		var seconds = 0;
		setInterval(function()
		{
			seconds++;
			if(seconds >= 999999) {
				seconds = 0;
			}
			$('#<?php echo CHtml::activeId($modPenjualan,"lamapelayanan") ?>').val(seconds);
		}, 1000);
	<?php } ?>
	
    <?php if(isset($_GET['reseptur_id'])){ ?>
    var reseptur_id = <?php echo isset($_GET['reseptur_id'])?$_GET['reseptur_id']:'' ?>;
    var pendaftaran_id = <?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran_id:'' ?>;
    var no_pendaftaran = '<?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran->no_pendaftaran:'' ?>';
    var no_rekam_medik = '<?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran->pasien->no_rekam_medik:'' ?>';
    var instalasi_id = <?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran->instalasi_id:'' ?>;
	$('#instalasi_id').val(instalasi_id);
    if(reseptur_id != ''){
        if(pendaftaran_id != ''){
            setInfoPasien(pendaftaran_id,no_pendaftaran,no_rekam_medik,'');
			formatNumberSemua();
        }
    }
    <?php } ?>
});

</script>