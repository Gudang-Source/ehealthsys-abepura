<script type="text/javascript">
/**
 * set karcis admisi
 * override setKarcis() di pendaftaranPenjadwalan/views/pendaftaranRawatJalan/_jsFunctions.php
 * @returns {undefined}
 */
function setKarcis()
{
    var kelaspelayanan_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"kelaspelayanan_id");?>").val();
    var ruangan_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"ruangan_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val();
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    
    if(kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
        $("#form-karcis").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#content-karcis-html").html(data.listKarcis);
                $("#form-karcis").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        $("#content-karcis-html").html("");
    }
       
}

/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianRuanganAdmisi(){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianRuangan'); ?>',
        data: {ruangan_id:ruangan_id},
        dataType: "json",
        success:function(data){
            if(data.maxantrianruangan != null){
                if(data.no_urutantri > data.maxantrianruangan){
                    myAlert("Pasien Sudah Mencapai Maksimal Antrian Poliklinik "+data.maxantrianruangan+" Pasien"); 
                }
                $('#max-antrian-ruangan').val(data.maxantrianruangan);
            }else{
                $('#max-antrian-ruangan').val(0);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set antrian ruangan
 * @param {type} obj
 * @returns {undefined} */
function setAntrianDokterAdmisi(ruangan_id){
    var ruangan_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'ruangan_id') ?>").val();
    var pegawai_id = $("#<?php echo CHtml::activeId($modPasienAdmisi, 'pegawai_id') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAntrianDokter'); ?>',
        data: {ruangan_id:ruangan_id, pegawai_id:pegawai_id},
        dataType: "json",
        success:function(data){
             $('#max-antrian-dokter').val(data.maxantriandokter);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set dropdown dokter ruangan
 * override setDropdownDokter() di pendaftaranPenjadwalan/views/pendaftaranRawatJalan/_jsFunctions.php
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropdownDokter(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownDokter'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienAdmisi,"pegawai_id");?>").html(data.listDokter);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set dropdown dokter ruangan
 * override setDropDownKelasPelayanan() di pendaftaranPenjadwalan/views/pendaftaranRawatInap/_jsFunctions.php
 * @param {type} ruangan_id
 * @param {type} pegawai_id
 * @returns {undefined}
 */
function setDropDownKelasPelayanan(ruangan_id)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownKelasPelayananRI'); ?>',
       data: {ruangan_id : ruangan_id},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasienAdmisi,"kelaspelayanan_id");?>").html(data.listKelas);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setAsuransiBadakAdmisi(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
		$("#form-asubadak").addClass("animation-loading");
		$("#form-asudepartemen").addClass("animation-loading");
		$("#form-asupekerja").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
			data: {pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
			dataType: "json",
			success:function(data){
				setAsuransiBadakReset();
				if(data != null){
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val(data.hubkeluarga);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val(data.alamat_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val(data.notelp_pegawai);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
				}
				
				$("#form-asubadak").removeClass("animation-loading");
				$("#form-asudepartemen").removeClass("animation-loading");
				$("#form-asupekerja").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
	
}

/**
 * checking validasi penjamin (This Function Dedicate For LNG Projects Only)
 * @returns {undefined}
 * LNG-3
 */
function cekValiditasPenjaminAdmisi(penjamin_id){
	var carabayar_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	if(carabayar_id == <?= Params::CARABAYAR_ID_BADAK; ?>){
		
		if((penjamin_id == <?= Params::PENJAMIN_ID_PISA; ?> ) || (penjamin_id == <?= Params::PENJAMIN_ID_PROKESPEN; ?> )){
			var pasien_id = $("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
				data: {type:"badak", pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
				dataType: "json",
				success:function(data){
					if((data.status == 'Empty') || (data.status == 'Fail')){
						myAlert(data.pesan);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(data.html);
					}else{

						if(data.penj == <?= Params::PENJAMIN_ID_PISA; ?> ){
							if(data.status == 'Tidak Tetap'){
								myAlert(data.pesan);
								$("#PPPendaftaranT_penjamin_id").html(data.html);
							}
						}else{
							myAlert("Prokespen hanya menjamin Pensiunan dan Istri/Suami Pensiunan");
						}
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
		setDropdownStatushubungankeluarga(penjamin_id);
		
	}else if(carabayar_id == <?= Params::CARABAYAR_ID_DEP_BADAK; ?>){
	
		
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('cekValiditasPenjamin'); ?>',
			data: {type:"departemen", penjamin_id: penjamin_id},
			dataType: "json",
			success:function(data){
				$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,"namaperusahaan");?>").val(data.data.penjamin_nama);
				$(".judulasuransi").html("Asuransi "+data.data.penjamin_nama);
				
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}
	
}

function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}
/**
 * print status rawat inap dan karcis
 */
function printStatusRI()
{
    window.open('<?php echo $this->createUrl('printStatusRI',array('pasienadmisi_id'=>$model->pasienadmisi_id,'pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
    <?php if($modPasienAdmisi->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){ ?>
                window.open('<?php echo $this->createUrl('printKarcisRI',array('pasienadmisi_id'=>$model->pasienadmisi_id)); ?>','','left=600,top=100,width=480,height=640');
    <?php } ?>
}
/**
 * override function yang di pendaftaranRawatJalan
 */
function autoPrint(){
    printStatusRI();
}

/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcis',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function cekAsuransi(){
  var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
  var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();

  if(pasien_id==""){
    myAlert('Masukan terlebih dahulu data pasien!');
  }else if(penjamin_id==""){
    myAlert('Masukan terlebih dahulu penjamin!');
  }else{
    $.fn.yiiGridView.update('asuransi-m-grid', {
        data: {
            "<?php echo get_class($modAsuransiPasien); ?>[pasien_id]":pasien_id,
            "<?php echo get_class($modAsuransiPasien); ?>[penjamin_id]":penjamin_id,
        }
    });
    $("#dialogAsuransi").dialog('open');
  }
  return false;
}

/**
 * load otomatis asuransi pasien terakhir (untuk RI)
 * @returns {undefined}
 */
function setAsuransiPasienLama(pasien_id){
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetAsuransiPasienLama'); ?>',
        data: { pasien_id: pasien_id},
        dataType: "json",
        success:function(data){
			if(data != null){
				if(confirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?")){
//				myConfirm("Apakah pasien ini akan menggunakan penjamin "+data.penjamin_nama+"?","Konfirmasi!",function(r) {
//					if(r){
						
						var datacarabayar_id = data.carabayar_id;
						var datalistPenjamin = data.listPenjamin;
						var datapenjamin_id = data.penjamin_id;
						var datanopeserta = data.nopeserta;
						var dataasuransipasien_id = data.asuransipasien_id;
						var datanokartuasuransi = data.nokartuasuransi;
						var datanamapemilikasuransi = data.namapemilikasuransi;
						var datanomorpokokperusahaan = data.nomorpokokperusahaan;
						var datakelastanggunganasuransi_id = data.kelastanggunganasuransi_id;
						var datanamaperusahaan = data.namaperusahaan;
						var datastatus_konfirmasi = data.status_konfirmasi;
						var datatgl_konfirmasi = data.tgl_konfirmasi;
						
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val(data.carabayar_id);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(data.listPenjamin);
						$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val(data.penjamin_id);
						
						$.ajax({
							type:'POST',
							url:'<?php echo $this->createUrl('CekCaraBayarBadak'); ?>',
							data: {pasien_id: pasien_id,pegawai_id:pegawai_id},
							dataType: "json",
							success:function(data){
								if(data.status === true){
									
									setFormAsuransi(datacarabayar_id);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val(datacarabayar_id);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").html(datalistPenjamin);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val(datapenjamin_id);
									if(datacarabayar_id == <?php echo Params::CARABAYAR_ID_BPJS ?>){
										getAsuransiNoKartu(datanopeserta);
									}else if((datacarabayar_id == <?php echo Params::CARABAYAR_ID_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_DEP_BADAK; ?>) || (datacarabayar_id == <?php echo Params::CARABAYAR_ID_PEKERJA; ?>)){
										setAsuransiBadak(data);
									}else{
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nopeserta') ?>").val(datanopeserta);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'asuransipasien_id') ?>").val(dataasuransipasien_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nokartuasuransi') ?>").val(datanokartuasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namapemilikasuransi') ?>").val(datanamapemilikasuransi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan') ?>").val(datanomorpokokperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id') ?>").val(datakelastanggunganasuransi_id);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'namaperusahaan') ?>").val(datanamaperusahaan);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'status_konfirmasi') ?>").val(datastatus_konfirmasi);
										$("#<?php echo CHtml::activeId($modAsuransiPasien,'tgl_konfirmasi') ?>").val(datatgl_konfirmasi);
									}
									
								}else{
									myAlert(data.pesan);
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"penjamin_id");?>").val("");
									$("#<?php echo CHtml::activeId($modPasienAdmisi,"carabayar_id");?>").val("");
								}
							},
							error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
						});
						
						
					} 
//				}); 
			}
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setAsuransiBadak(){
	var pasien_id = $("#<?php echo CHtml::activeId($modPasien,'pasien_id') ?>").val();
	var penjamin_id = $("#<?php echo CHtml::activeId($modPasienAdmisi,'penjamin_id') ?>").val();
	var pegawai_id = $("#PPPasienM_pegawai_id").val();
		$("#form-asubadak").addClass("animation-loading");
		$("#form-asudepartemen").addClass("animation-loading");
		$("#form-asupekerja").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetAsuransiBadak'); ?>',
			data: {pasien_id: pasien_id, penjamin_id: penjamin_id,pegawai_id:pegawai_id},
			dataType: "json",
			success:function(data){
				setAsuransiBadakReset();
				if(data != null){
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienBadak,'hubkeluarga') ?>").val(data.hubkeluarga);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namaperusahaan') ?>").val(data.namaperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nomorpokokperusahaan') ?>").val(data.nomorpokokperusahaan);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modAsuransiPasienDepartemen,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
					
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'asuransipasien_id') ?>").val(data.asuransipasien_id);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'nopeserta') ?>").val(data.nopeserta);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'namapemilikasuransi') ?>").val(data.namapemilikasuransi);
					$("#<?php echo CHtml::activeId($modPegawai,'alamat_pegawai') ?>").val(data.alamat_pegawai);
					$("#<?php echo CHtml::activeId($modPegawai,'notelp_pegawai') ?>").val(data.notelp_pegawai);
					$("#<?php echo CHtml::activeId($modAsuransiPasienPekerja,'kelastanggunganasuransi_id') ?>").val(data.kelastanggunganasuransi_id);
				}
				
				$("#form-asubadak").removeClass("animation-loading");
				$("#form-asudepartemen").removeClass("animation-loading");
				$("#form-asupekerja").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
		});
	
}

/**
 * print Label Gelang
 */
function printLabelGelang()
{       
    window.open('<?php echo $this->createUrl('PendaftaranRawatInap/printLabelGelang',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

$(document).ready(function() {
    $("#cari_loket_id").val(13).change();
});

var hidables = null;
function setEDBpjs(val) {
    if (val == 8) {
        hidables = $("#form-bpjs .hidables-content").detach();
    } else {
        if (hidables != null) hidables.appendTo("#form-bpjs .hidables");
    }
}

</script>
    