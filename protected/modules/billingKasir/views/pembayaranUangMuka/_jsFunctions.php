<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id ){
    $("#form-datakunjungan > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
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
            if(data.ruangan_id){
                $("#ruangan_id").val(data.ruangan_id);
                $("#<?php echo CHtml::activeId($model,'ruangan_id'); ?>").val(data.ruangan_id);
            }else{
                $("#ruangan_id").val(data.ruanganakhir_id);
				$("#<?php echo CHtml::activeId($model,'ruangan_id'); ?>").val(data.ruanganakhir_id);
			}
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
			$("#BKTandabuktibayarT_carapembayaran").val(data.metode_pembayaran);
			
            //uangmuka
            $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'totaluangmuka') ?>").val(data.jumlahuangmuka);

            setRincianTindakan();
            setDataPembayar();
            
            $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#cari_pendaftaran_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#jeniskasuspenyakit_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#penanggungjawab_id").val("");
    $("#kelaspelayanan_id").val("");
    $("#ruangan_id").val("");
    $("#no_pendaftaran").val("");
    $("#tgl_pendaftaran").val("");
    $("#ruangan_nama").val("");
    $("#jeniskasuspenyakit_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#nama_pj").val("");
    $("#pengantar").val("");
    $("#kelaspelayanan_nama").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
    
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val("");
    
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogKunjungan(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "BKInformasikasirrawatjalanV[instalasi_id]":instalasi_id,
            "BKInformasikasirrawatjalanV[instalasi_nama]":instalasi_nama,
        }
    });
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
 * menghitung total semua = total tindakan + total obat alkes
 * @returns {undefined}
 */
function hitungTotalSemua(){
    unformatNumberSemua();
    var tot_tarif_tindakan = parseInt($("#form-rinciantindakan #tot_tarif_tindakan").val());
    var tot_tarifcyto_tindakan = parseInt($("#form-rinciantindakan #tot_tarifcyto_tindakan").val());
    var tot_discount_tindakan = parseInt($("#form-rinciantindakan #tot_discount_tindakan").val());
    var tot_pembebasan_tindakan = parseInt($("#form-rinciantindakan #tot_pembebasan_tindakan").val());
    var tot_subsidiasuransi_tindakan = parseInt($("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val());
    var tot_subsisidirumahsakit_tindakan = parseInt($("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val());
    var tot_iurbiaya_tindakan = parseInt($("#form-rinciantindakan #tot_iurbiaya_tindakan").val());
    var total_tindakan = parseInt($("#form-rinciantindakan #total_tindakan").val());
    
    var tot_hargajual_oa = parseInt($("#form-rincianobatalkes #tot_hargajual_oa").val());
    var tot_tarifcyto = parseInt($("#form-rincianobatalkes #tot_tarifcyto").val());
    var tot_discount = parseInt($("#form-rincianobatalkes #tot_discount").val());
    var tot_biayalain = parseInt($("#form-rincianobatalkes #tot_biayalain").val());
    var tot_subsidiasuransi = parseInt($("#form-rincianobatalkes #tot_subsidiasuransi").val());
    var tot_subsidirs = parseInt($("#form-rincianobatalkes #tot_subsidirs").val());
    var tot_iurbiaya = parseInt($("#form-rincianobatalkes #tot_iurbiaya").val());
    var total_oa = parseInt($("#form-rincianobatalkes #total_oa").val());
    
    $("#form-rinciansemua #tot_tarif_semua").val(tot_tarif_tindakan+tot_hargajual_oa);
    $("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto_tindakan+tot_tarifcyto);
    $("#form-rinciansemua #tot_discount_semua").val(tot_discount_tindakan+tot_discount);
    $("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi_tindakan+tot_subsidiasuransi);
    $("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsisidirumahsakit_tindakan+tot_subsidirs);
    $("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya_tindakan+tot_iurbiaya);
    $("#form-rinciansemua #total_semua").val(total_tindakan+total_oa);
    
    $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_tarif_tindakan+tot_hargajual_oa);
    $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(tot_tarif_tindakan);
    $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(tot_hargajual_oa);
    $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount_tindakan+tot_discount);
    $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi_tindakan+tot_subsidiasuransi);
    $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsisidirumahsakit_tindakan+tot_subsidirs);
    $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya_tindakan+tot_iurbiaya);
    $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(tot_pembebasan_tindakan);
    
    
    formatNumberSemua();
    hitungJmlpembulatan();
    hitungJmlpembayaran();
    hitungUangKembalian();

}
/**
 * menentukan pembulatan
 * @returns {undefined}
 */
function hitungJmlpembulatan(){
    unformatNumberSemua();
    var totalbiayapelayanan = parseInt($("#<?php echo CHtml::activeId($model,'jumlahuangmuka');?>").val());
    var biayaadministrasi = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val());
    var biayamaterai = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val());
    var jmlpembulatan = 0;
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanharga'); ?>;
    if(konfig_pembulatan > 0){
        jmlpembulatan = konfig_pembulatan - ((totalbiayapelayanan+biayaadministrasi+biayamaterai) % konfig_pembulatan);
        if(konfig_pembulatan == jmlpembulatan){
            jmlpembulatan = 0;
        }
    }
    $("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val(jmlpembulatan);
    formatNumberSemua();
}
/**
 * menghitung jumlah pembayaran
 * @returns {undefined}
 */
function hitungJmlpembayaran(){
    unformatNumberSemua();
    var jmluangmuka = parseInt($("#<?php echo CHtml::activeId($model,'jumlahuangmuka');?>").val());
    var biayaadministrasi = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val());
    var biayamaterai = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val());
    var jmlpembulatan = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val());
    var jmlpembayaran = jmluangmuka + biayaadministrasi + biayamaterai + jmlpembulatan;
    $("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val(jmlpembayaran);
    $("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(jmlpembayaran);
    formatNumberSemua();
    
    hitungUangKembalian();
}    
/**
 * menghitung uang kembalian
 * @returns {undefined}
 */
function hitungUangKembalian(){
    unformatNumberSemua();
    var uangditerima = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val());
    var jmlpembayaran = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val());
    var totalbiayapelayanan = parseInt($("#<?php echo CHtml::activeId($model,'jumlahuangmuka');?>").val());
    var uangmasuk = uangditerima;
    var uangkembalian = uangmasuk-jmlpembayaran;
    var totalsisatagihan = 0;
    var sisauangmuka = 0;
    var nilaiterendah = Math.min(jmlpembayaran);

	if(uangditerima < jmlpembayaran){
		myAlert('Uang terima tidak boleh lebih kecil dari jumlah pembayaran!');
		$("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val(jmlpembayaran);
		formatNumberSemua();
		return false;
	}
    $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_TUNAI; ?>");
    if(uangmasuk == 0){
        uangkembalian = 0;
        totalsisatagihan = jmlpembayaran;
        if(jmlpembayaran == 0){
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_PIUTANG; ?>");
        }else{
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_HUTANG; ?>");
        }
    }else if(uangmasuk < jmlpembayaran){
        uangkembalian = 0;
        totalsisatagihan = jmlpembayaran - uangmasuk;
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_CICILAN; ?>");
    }

    $("#<?php echo CHtml::activeId($modTandabukti,'uangkembalian');?>").val(uangkembalian);
    formatNumberSemua();
    
}

/**
 * set form rincian tagihan tindakan
 * @returns {undefined}
 */
function setRincianTindakan(){
    var pendaftaran_id=$("#pendaftaran_id").val();
    var pasienadmisi_id=$("#pasienadmisi_id").val();
    var kelaspelayanan_id=$("#kelaspelayanan_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
    $("#form-rinciantindakan").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianTindakan'); ?>',
        data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id},//
        dataType: "json",
        success:function(data){
            $("#BKBayaruangmukaT_totbiayasementara").val(formatNumber(data.tagihan));
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rinciantindakan").removeClass("animation-loading");console.log(errorThrown);}
    });
}
/**
 * set default / otomatis data pembayar
 * @returns {undefined}
 */
function setDataPembayar(){
    var darinama_bkm = $("#no_pendaftaran").val()+"-"+$("#no_rekam_medik").val()+"-"+$("#namadepan").val()+" "+$("#nama_pasien").val();
    var alamat_bkm = $("#alamat_pasien").val();
    var sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT TANGGAL "+($("#tgl_pendaftaran").val());
    if($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RI; ?>){
        sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT DARI TANGGAL "+($("#tgl_pendaftaran").val())+" SAMPAI DENGAN "+($("#tglselesaiperiksa").val());
    }
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
}
/**
 * set proporsi dari total tindakan
 */
function setProporsiTindakan(){
    if($("#is_proporsitindakan").is(":checked")){
        $("#tot_discount_tindakan").removeAttr("readonly");
        $("#tot_pembebasan_tindakan").removeAttr("readonly");
        $("#tot_subsidiasuransi_tindakan").removeAttr("readonly");
        $("#tot_subsisidirumahsakit_tindakan").removeAttr("readonly");
    }else{
        $("#tot_discount_tindakan").attr("readonly", true);
        $("#tot_pembebasan_tindakan").attr("readonly", true);
        $("#tot_subsidiasuransi_tindakan").attr("readonly", true);
        $("#tot_subsisidirumahsakit_tindakan").attr("readonly", true);
        hitungTotalTindakan();
    }
}
/**
 * set proporsi dari total obat alkes
 */
function setProporsiOa(){
    if($("#is_proporsioa").is(":checked")){
        $("#tot_discount").removeAttr("readonly");
        $("#tot_biayalain").removeAttr("readonly");
        $("#tot_subsidiasuransi").removeAttr("readonly");
        $("#tot_subsidirs").removeAttr("readonly");
    }else{
        $("#tot_discount").attr("readonly", true);
        $("#tot_biayalain").attr("readonly", true);
        $("#tot_subsidiasuransi").attr("readonly", true);
        $("#tot_subsidirs").attr("readonly", true);
        hitungTotalOa();
    }
}
/**
 * set proporsi dari seluruh total (semua)
 */
function setProporsiSemua(){
    if($("#is_proporsisemua").is(":checked")){
        $("#is_proporsitindakan").attr("checked", true);
        setProporsiTindakan();
        $("#is_proporsioa").attr("checked", true);
        setProporsiOa();
        $("#tot_discount_semua").removeAttr("readonly");
        $("#tot_subsidiasuransi_semua").removeAttr("readonly");
        $("#tot_subsidirumahsakit_semua").removeAttr("readonly");
    }else{
        $("#tot_discount_semua").attr("readonly", true);
        $("#tot_subsidiasuransi_semua").attr("readonly", true);
        $("#tot_subsidirumahsakit_semua").attr("readonly", true);
    }
}

/**
 * menghitung proporsi diskon tindakan
 */
function proporsiDiskonTindakan(){
    unformatNumberSemua();
    var tot_discount_tindakan = parseInt($("#tot_discount_tindakan").val());
    var tot_tarif_tindakan = parseInt($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_tindakan) * tot_discount_tindakan);
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    formatNumberSemua();
}
/**
 * menghitung proporsi pembebasan tindakan
 */
function proporsiPembebasanTindakan(){
    unformatNumberSemua();
    var tot_pembebasan_tindakan = parseInt($("#tot_pembebasan_tindakan").val());
    var tot_tarif_tindakan = parseInt($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_tindakan) * tot_pembebasan_tindakan);
            $(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[pembebasan_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi asuransi tindakan
 */
function proporsiSubsidiAsuransiTindakan(){
    unformatNumberSemua();
    var tot_subsidiasuransi_tindakan = parseInt($("#tot_subsidiasuransi_tindakan").val());
    var tot_tarif_tindakan = parseInt($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsidiasuransi_tindakan);
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi asuransi tindakan
 */
function proporsiSubsidiRsTindakan(){
    unformatNumberSemua();
    var tot_subsisidirumahsakit_tindakan = parseInt($("#tot_subsisidirumahsakit_tindakan").val());
    var tot_tarif_tindakan = parseInt($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsisidirumahsakit_tindakan);
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    formatNumberSemua();
}
/**
 * menghitung proporsi diskon obat alkes
 */
function proporsiDiskonOa(){
    unformatNumberSemua();
    var tot_discount = parseInt($("#tot_discount").val());
    var tot_hargajual_oa = parseInt($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_discount);
            $(this).parents('tr').find('input[name$="[discount]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi biaya admin/lain obat alkes
 */
function proporsiBiayaAdminOa(){
    unformatNumberSemua();
    var tot_biayalain = parseInt($("#tot_biayalain").val());
    var tot_hargajual_oa = parseInt($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_biayalain);
            $(this).parents('tr').find('input[name$="[biayalain]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[biayalain]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi asuransi obat alkes
 */
function proporsiSubsidiAsuransiOa(){
    unformatNumberSemua();
    var tot_subsidiasuransi = parseInt($("#tot_subsidiasuransi").val());
    var tot_hargajual_oa = parseInt($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidiasuransi);
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi rumah sakit obat alkes
 */
function proporsiSubsidiRsOa(){
    unformatNumberSemua();
    var tot_subsidirs = parseInt($("#tot_subsidirs").val());
    var tot_hargajual_oa = parseInt($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidirs);
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi diskon semua
 */
function proporsiDiskonSemua(){
    unformatNumberSemua();
    var tot_discount_semua = parseInt($("#tot_discount_semua").val());
    var tot_tarif_semua = (parseInt($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_discount_semua);
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_discount_semua);
            $(this).parents('tr').find('input[name$="[discount]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[discount]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi asuransi semua
 */
function proporsiSubsidiAsuransiSemua(){
    unformatNumberSemua();
    var tot_subsidiasuransi_semua = parseInt($("#tot_subsidiasuransi_semua").val());
    var tot_tarif_semua = (parseInt($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidiasuransi_semua);
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_subsidiasuransi_semua);
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidiasuransi]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}
/**
 * menghitung proporsi subsidi rumah sakit semua
 */
function proporsiSubsidiRsSemua(){
    unformatNumberSemua();
    var tot_subsidirumahsakit_semua = parseInt($("#tot_subsidirumahsakit_semua").val());
    var tot_tarif_semua = (parseInt($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidirumahsakit_semua);
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_subsidirumahsakit_semua);
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidirs]"]').val(0);
        }
    });
    hitungTotalOa();
    formatNumberSemua();
}


/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var pendaftaran_id=$("#pendaftaran_id").val();
        if(pendaftaran_id === ""){
            myAlert("Silahkan cari data kunjungan terlabih dahulu !");
		} else if ($("#BKBayaruangmukaT_jumlahuangmuka").val().trim() == "0") {
			myAlert("Uang muka tidak boleh nol.");
        }else{
            $('#dialog-verifikasi').dialog("open");
            $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl('verifikasi'); ?>',
               data: $("form").serialize(),
               dataType: "json",
               success:function(data){
                    $('#dialog-verifikasi > .dialog-content').html(data.content);
               },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
            });
            //untuk verifikasi hilangkan srbac loading
            $(".animation-loading").removeClass("animation-loading");
            $("form").find('.float').each(function(){
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer2').each(function(){
                $(this).val(formatInteger($(this).val()));
            });
        }
    }
    return false;
}
/**
 * tombol batal pada dialogbox
 * @param {type} dialog_id
 * @returns {undefined} 
 */
function batalDialog(dialog_id){
   myConfirm("Apakah anda yakin akan membatalkan ini?","Perhatian!",function(r){if(r){$('#'+dialog_id).dialog("close");}}); 
}
/**
 * print rincian belum bayar >> RND-3122
 * @returns {undefined} */ 
function printRincianBelumBayar()
{
    var instalasi_id = $("#instalasi_id").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    var pasienadmisi_id = $("#pasienadmisi_id").val();
    if(instalasi_id && pendaftaran_id){
        window.open("<?php echo $this->createUrl('printRincianBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id,"",'location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data kunjungan terlabih dahulu !");
    }
}
/**
 * print rincian sudah bayar >> RND-3122
 * @returns {undefined} */ 
function printRincianSudahBayar()
{
    var bayaruangmuka_id = "<?php echo $model->bayaruangmuka_id?>";
    window.open("<?php echo $this->createUrl('printRincianSudahBayar') ?>&bayaruangmuka_id="+bayaruangmuka_id,"",'location=_new, width=1024px');
}
/**
 * print rincian sudah bayar untuk rumah sakit >> RND-3114
 * @returns {undefined} */ 
function printRincianRSSudahBayar()
{
    var bayaruangmuka_id = "<?php echo $model->bayaruangmuka_id?>";
    window.open("<?php echo $this->createUrl('printRincianRSSudahBayar') ?>&bayaruangmuka_id="+bayaruangmuka_id,"",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printBuktiKasMasuk()
{
    var bayaruangmuka_id = "<?php echo $model->bayaruangmuka_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('/billingKasir/pembayaranUangMuka/printdetailKasMasuk') ?>&idPembayaran="+bayaruangmuka_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printKuitansi()
{
    var bayaruangmuka_id = "<?php echo $model->bayaruangmuka_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('printKuitansi') ?>&bayaruangmuka_id="+bayaruangmuka_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}


/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($modKunjungan->pendaftaran_id)){ ?>
            var pendaftaran_id = $("#pendaftaran_id").val();
            var pasienadmisi_id = $("#pasienadmisi_id").val();
            setKunjungan(pendaftaran_id,"","",pasienadmisi_id);
            $("#form-datakunjungan :input").attr("readonly",true);
            $("#form-datakunjungan .add-on").remove();
    <?php } ?>
    <?php if(!$model->isNewRecord){ ?>
                $("input, select, textarea").attr("disabled",true);
                window.scrollBy(0,10000);
                formatNumberSemua();
    <?php } else {?>
            hitungTotalSemua();
    <?php }?>

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($model->bayaruangmuka_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembayaran Uang Muka ', isinotifikasi:'<?php echo $modKunjungan->nama_pasien ?>  dengan  <?php echo $modKunjungan->no_rekam_medik ?>  telah melakukan pembayaran uang muka pada <?php echo $model->tgluangmuka ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
});
</script>