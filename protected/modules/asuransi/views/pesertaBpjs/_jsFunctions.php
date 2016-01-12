<script type="text/javascript">
$("#pencarian-peserta-bpjs-form .btn-nomorkartu").attr('disabled',true);
$("#pencarian-peserta-bpjs-form .btn-nik").attr('disabled',true);
function setPencarian(obj){
	if($(obj).val() == 'radio_nomorkartu'){
		$('#radio_nomorkartu').attr('checked',true);
		$('#radio_nik').attr('checked',false);
		$('#nomorkartupeserta').removeAttr('disabled',true);
		$('#nik').attr('disabled',true);
		$("#pencarian-peserta-bpjs-form .btn-nomorkartu").removeAttr('disabled',true);
		$("#pencarian-peserta-bpjs-form .btn-nik").attr('disabled',true);
		$('#nik').val('');
		clearDataPeserta();
	}else{
		$('#radio_nomorkartu').removeAttr('checked',true);
		$('#radio_nik').attr('checked',true);
		$('#nomorkartupeserta').attr('disabled',true);
		$('#nik').removeAttr('disabled',true);
		$("#pencarian-peserta-bpjs-form .btn-nomorkartu").attr('disabled',true);
		$("#pencarian-peserta-bpjs-form .btn-nik").removeAttr('disabled',true);
		$('#nomorkartupeserta').val('');
		clearDataPeserta();
	}
}	

/**
 * fungsi pencarian peserta BPJS berdasarkan Nomor Kartu
 */
function cariPesertaBpjsNoKartu()
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	var nokartu = $('#nomorkartupeserta').val();
	var nonik = $('#nik').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(nokartu != ''){
		var isi = nokartu;
		var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu Peserta
	}else{
		var isi = nonik;
		var aksi = 2;  // 2 untuk mencari data peserta berdasarkan NIK
	}
    if (isi=="") {myAlert('Isi data Nomor Kartu Peserta terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-peserta").addClass("animation-loading");
        },
        success: function(data){
            $("#data-peserta").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
				var peserta = obj.response.peserta;
				$("#noKartu").text(peserta.noKartu);
				$("#nama").text(peserta.nama);
				$("#tglLahir").text(peserta.tglLahir);
				$("#nik").text(peserta.nik);
				$("#sex").text(peserta.sex);
				$("#kdProvider").text(peserta.provUmum.kdProvider);
				$("#nmProvider").text(peserta.provUmum.nmProvider);
				$("#kdCabang").text(peserta.provUmum.kdCabang);
				$("#nmCabang").text(peserta.provUmum.nmCabang);
				$("#kdKelas").text(peserta.kelasTanggungan.kdKelas);
				$("#nmKelas").text(peserta.kelasTanggungan.nmKelas);
				$("#kdJenisPeserta").text(peserta.jenisPeserta.kdJenisPeserta);
				$("#nmJenisPeserta").text(peserta.jenisPeserta.nmJenisPeserta);
				//RND-9239 $("#keterangan").text(peserta.statusPeserta.keterangan);
				$("#tglCetakKartu").text(peserta.tglCetakKartu);
				$("#tglTAT").text(peserta.tglTAT);
				$("#tglTMT").text(peserta.tglTMT);
				$("#noMr").text(peserta.noMr);
				//RND-9239 $("#umurSekarang").text(peserta.umur.umurSekarang);
				//RND-9239 $("#umurSaatPelayanan").text(peserta.umur.umurSaatPelayanan);
				$("#pencarian-peserta-bpjs-form .btn-primary-blue").removeAttr('disabled',true);
				$("#pencarian-peserta-bpjs-form .btn-riwayat").removeAttr('disabled',true);				
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
            $("#data-peserta").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

/**
 * fungsi pencarian peserta BPJS berdasarkan NIK
 */
function cariPesertaBpjsNIK()
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	var nokartu = $('#nomorkartupeserta').val();
	var nonik = $('#nik').val();
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
	
	if(nokartu != ''){
		var isi = nokartu;
		var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu Peserta
	}else{
		var isi = nonik;
		var aksi = 2;  // 2 untuk mencari data peserta berdasarkan NIK
	}
    if (isi=="") {myAlert('Isi data Nomor Kartu Peserta terlebih dahulu!'); return false;};
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi,
        beforeSend: function(){
            $("#data-peserta").addClass("animation-loading");
        },
        success: function(data){
            $("#data-peserta").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response.list[0]!=null){
				var list = obj.response.list[0];
				$("#noKartu").text(list.noKartu);
				$("#nama").text(list.nama);
				$("#tglLahir").text(list.tglLahir);
				$("#nik").text(list.nik);
				$("#sex").text(list.sex);
				$("#kdProvider").text(list.provUmum.kdProvider);
				$("#nmProvider").text(list.provUmum.nmProvider);
				$("#kdCabang").text(list.provUmum.kdCabang);
				$("#nmCabang").text(list.provUmum.nmCabang);
				$("#kdKelas").text(list.kelasTanggungan.kdKelas);
				$("#nmKelas").text(list.kelasTanggungan.nmKelas);
				$("#kdJenisPeserta").text(list.jenisPeserta.kdJenisPeserta);
				$("#nmJenisPeserta").text(list.jenisPeserta.nmJenisPeserta);
				//RND-9239 $("#keterangan").text(list.statusPeserta.keterangan);
				$("#tglCetakKartu").text(list.tglCetakKartu);
				$("#tglTAT").text(list.tglTAT);
				$("#tglTMT").text(list.tglTMT);
				$("#noMr").text(list.noMr);
				//RND-9239 $("#umurSekarang").text(list.umur.umurSekarang);
				//RND-9239 $("#umurSaatPelayanan").text(list.umur.umurSaatPelayanan);
				$("#pencarian-peserta-bpjs-form .btn-primary-blue").removeAttr('disabled',true);
				$("#pencarian-peserta-bpjs-form .btn-riwayat").removeAttr('disabled',true);
				
				// OVERWRITES old selecor
				jQuery.expr[':'].contains = function(a, i, m) {
				  return jQuery(a).text().toUpperCase()
					  .indexOf(m[3].toUpperCase()) >= 0;
				};
            }else{
//              myAlert(obj.metaData.message);
              myAlert('Data Not Found');
            }
        },
        error: function(data){
            $("#data-peserta").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

/**
* untuk set ulang form data peserta
* */
function clearDataPeserta(){
	$("#noKartu").text('');
	$("#nama").text('');
	$("#tglLahir").text('');
	$("#nik").text('');
	$("#sex").text('');
	$("#kdProvider").text('');
	$("#nmProvider").text('');
	$("#kdCabang").text('');
	$("#nmCabang").text('');
	$("#kdKelas").text('');
	$("#nmKelas").text('');
	$("#kdJenisPeserta").text('');
	$("#nmJenisPeserta").text('');
	$("#keterangan").text('');
	$("#tglCetakKartu").text('');
	$("#tglTAT").text('');
	$("#tglTMT").text('');
	$("#noMr").text('');
	$("#pencarian-peserta-bpjs-form .btn-primary-blue").attr('disabled',true);
	$("#pencarian-peserta-bpjs-form .btn-riwayat").attr('disabled',true);
}

/**
 * fungsi pencarian peserta BPJS
 */
function lihatRiwayat()
{   
    $('#dialogRiwayatPesertaBpjs').dialog('open');
	$("#data-peserta").removeClass("animation-loading");
}

function printPesertaBpjs(caraPrint){
	var nokartu = $('#nomorkartupeserta').val();
	var nonik = $('#nik').val();
	window.open('<?php echo $this->createUrl('PrintPesertaBpjs'); ?>&nokartu='+nokartu+'&nonik='+nonik+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>