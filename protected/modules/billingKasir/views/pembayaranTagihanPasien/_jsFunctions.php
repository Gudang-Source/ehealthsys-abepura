<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
var carapembayaran = "";

/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id ){
    $("#form-datakunjungan > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    carapembayaran = "";
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
            if(data.ruangan_id)
                $("#ruangan_id").val(data.ruangan_id);
            else
                $("#ruangan_id").val(data.ruanganakhir_id);
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
            //uangmuka
            $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'totaluangmuka') ?>").val(data.jumlahuangmuka);

            carapembayaran = data.metode_pembayaran;

            setRincianTindakan();
            setRincianObatalkes();
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
    
    carapembayaran = "";
    
    setRincianTindakan();
    setRincianObatalkes();
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
            $("#form-rinciantindakan").html(data.form);
            $("#form-rinciantindakan").removeClass("animation-loading");
            $("#form-rinciantindakan .integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-rinciantindakan").find('input:checkbox[name$="is_proporsitindakan"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            hitungTotalSemua();
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rinciantindakan").removeClass("animation-loading");console.log(errorThrown);}
    });
}
/**
 * set form rincian tagihan tindakan
 * @returns {undefined}
 */
function setRincianObatalkes(){
    var pendaftaran_id=$("#pendaftaran_id").val();
    var pasienadmisi_id=$("#pasienadmisi_id").val();
    var kelaspelayanan_id=$("#kelaspelayanan_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
    $("#form-rincianobatalkes").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianObatalkes'); ?>',
        data: {pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id},//
        dataType: "json",
        success:function(data){
            $("#form-rincianobatalkes").html(data.form);
            $("#form-rincianobatalkes").removeClass("animation-loading");
            $("#form-rincianobatalkes .integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );
            $("#form-rincianobatalkes").find('input:checkbox[name$="is_proporsioa"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
            hitungTotalSemua();
        },
         error: function (jqXHR, textStatus, errorThrown) { $("#form-rincianobatalkes").removeClass("animation-loading");console.log(errorThrown);}
    });
}
/** control accordion menggunakan kartu */
$('#form-kartupembayaran > div > .accordion-heading').click(function(){
//    console.log("Rujukan Di Klik!");
    var is_menggunakankartu = $("#<?php echo CHtml::activeId($modTandabukti, "is_menggunakankartu"); ?>");
    if(is_menggunakankartu.val() > 0){ //hide
        is_menggunakankartu.val(0);
    }else{//show
        is_menggunakankartu.val(1);
    }
});
/**
 * set checked/unchecked semua is_pilihtindakan
 * @returns {undefined}
 */
function setPilihTindakanChecked(){
    if($("#is_pilihsemuatindakan").is(':checked')){
        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    }
    hitungTotalTindakan();
}
/**
 * set checked/unchecked semua is_pilihoa
 * @returns {undefined}
 */
function setPilihOaChecked(){
    if($("#is_pilihsemuaoa").is(':checked')){
        $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    }
    hitungTotalOa();
}
/**
 * menghitung total tindakan
 * @returns {undefined}
 */
function hitungTotalTindakan(){
    unformatNumberSemua();
    var tot_tarif_tindakan = 0;
    var tot_tarifcyto_tindakan = 0;
    var tot_discount_tindakan = 0;
    var tot_pembebasan_tindakan = 0;
    var tot_subsidiasuransi_tindakan = 0;
    var tot_subsisidirumahsakit_tindakan = 0;
    var tot_subsidipemerintah_tindakan = 0;
    var tot_iurbiaya_tindakan = 0;
    var tot_sisatagihan = 0;
    var total_tindakan = 0;
    var subiurbiaya = 0;
    var subtotal = 0;
    var sisatagihan = 0;
    $("#form-rinciantindakan").find("input[name$='[is_pilihtindakan]'][type='checkbox']").each(function(){
        var qty_tindakan = parseInt($(this).parents('tr').find("input[name$='[qty_tindakan]']").val());
        var tarif_satuan = parseInt($(this).parents('tr').find("input[name$='[tarif_satuan]']").val());
        var tarifcyto_tindakan = parseInt($(this).parents('tr').find("input[name$='[tarifcyto_tindakan]']").val());
        var discount_tindakan = parseInt($(this).parents('tr').find("input[name$='[discount_tindakan]']").val());
        var pembebasan_tindakan = parseInt($(this).parents('tr').find("input[name$='[pembebasan_tindakan]']").val());
        var subsidiasuransi_tindakan = parseInt($(this).parents('tr').find("input[name$='[subsidiasuransi_tindakan]']").val());
        var subsisidirumahsakit_tindakan = parseInt($(this).parents('tr').find("input[name$='[subsisidirumahsakit_tindakan]']").val());
        var subsidipemerintah_tindakan = parseInt($(this).parents('tr').find("input[name$='[subsidipemerintah_tindakan]']").val());
        subtotal = (tarif_satuan * qty_tindakan)+tarifcyto_tindakan-discount_tindakan;
        subiurbiaya = subtotal-pembebasan_tindakan-subsidiasuransi_tindakan-subsisidirumahsakit_tindakan - subsidipemerintah_tindakan;
        sisatagihan = ((qty_tindakan * tarif_satuan) - discount_tindakan - subsidiasuransi_tindakan - subsisidirumahsakit_tindakan - pembebasan_tindakan - subsidipemerintah_tindakan);
        
        if($(this).is(":checked")){
            $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
            $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(subiurbiaya);
            tot_tarif_tindakan += (tarif_satuan * qty_tindakan);
            tot_tarifcyto_tindakan += tarifcyto_tindakan;
            tot_discount_tindakan += discount_tindakan;
            tot_iurbiaya_tindakan += subiurbiaya;
            tot_pembebasan_tindakan += pembebasan_tindakan;
            tot_subsidiasuransi_tindakan += subsidiasuransi_tindakan;
            tot_subsidipemerintah_tindakan += subsidipemerintah_tindakan;
            tot_subsisidirumahsakit_tindakan += subsisidirumahsakit_tindakan;            
            tot_sisatagihan += sisatagihan;            
            total_tindakan += subtotal;
        }else{
            $(this).parents('tr').find("input[name$='[subtotal]']").val(0);
            $(this).parents('tr').find("input[name$='[iurbiaya_tindakan]']").val(0);
        }
    });
	
	if($("#is_proporsitindakan").is(":checked")){
		var tot_discount_tindakan = $("#form-rinciantindakan #tot_discount_tindakan").val();
		var tot_pembebasan_tindakan = $("#form-rinciantindakan #tot_pembebasan_tindakan").val();
		var tot_subsidiasuransi_tindakan = $("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val();
		var tot_subsisidirumahsakit_tindakan = $("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val();
                var tot_subsidipemerintah_tindakan = $("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val();
		total_tindakan = tot_tarif_tindakan + tot_tarifcyto_tindakan - tot_discount_tindakan;
		tot_iurbiaya_tindakan = total_tindakan - tot_pembebasan_tindakan - tot_subsidiasuransi_tindakan - tot_subsisidirumahsakit_tindakan - tot_subsidipemerintah_tindakan;
	}else{
		$("#form-rinciantindakan #tot_discount_tindakan").val(tot_discount_tindakan);
		$("#form-rinciantindakan #tot_pembebasan_tindakan").val(tot_pembebasan_tindakan);
		$("#form-rinciantindakan #tot_subsidiasuransi_tindakan").val(tot_subsidiasuransi_tindakan);
                $("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val(tot_subsidipemerintah_tindakan);
		$("#form-rinciantindakan #tot_subsisidirumahsakit_tindakan").val(tot_subsisidirumahsakit_tindakan);
	}
	$("#form-rinciantindakan #tot_tarif_tindakan").val(tot_tarif_tindakan);
    $("#form-rinciantindakan #tot_tarifcyto_tindakan").val(tot_tarifcyto_tindakan);
    $("#form-rinciantindakan #tot_iurbiaya_tindakan").val(tot_iurbiaya_tindakan);
    $("#form-rinciantindakan #total_tindakan").val(total_tindakan);
    $("#<?php echo CHtml::activeId($model,'totalsisatagihan');?>").val(tot_sisatagihan);
    formatNumberSemua();
    hitungTotalSemua();
}
/**
 * menghitung total obat alkes
 * @returns {undefined}
 */
function hitungTotalOa(){
    unformatNumberSemua();
    var tot_hargajual_oa = 0;
    var tot_tarifcyto = 0;
    var tot_discount = 0;
    var tot_biayalain = 0;
    var tot_subsidiasuransi = 0;
    var tot_subsidipemerintah = 0;
    var tot_subsidirs = 0;
    var tot_iurbiaya = 0;
    var total_oa = 0;
    var subtotaloa = 0;
    var subiurbiayaoa = 0;
    $("#form-rincianobatalkes").find("input[name$='[is_pilihoa]'][type='checkbox']").each(function(){
        var qty_oa = parseInt($(this).parents('tr').find("input[name$='[qty_oa]']").val());
        var hargasatuan_oa = parseInt($(this).parents('tr').find("input[name$='[hargasatuan_oa]']").val());
        var tarifcyto = parseInt($(this).parents('tr').find("input[name$='[tarifcyto]']").val());
        var discount = parseInt($(this).parents('tr').find("input[name$='[discount]']").val());
        var biayalain = parseInt($(this).parents('tr').find("input[name$='[biayalain]']").val());
        var subsidiasuransi = parseInt($(this).parents('tr').find("input[name$='[subsidiasuransi]']").val());
        var subsidipemerintah = parseInt($(this).parents('tr').find("input[name$='[subsidipemerintah]']").val());
        var subsidirs = parseInt($(this).parents('tr').find("input[name$='[subsidirs]']").val());
        subtotaloa = (hargasatuan_oa * qty_oa)+tarifcyto-discount+biayalain;
        subiurbiayaoa = subtotaloa-subsidiasuransi-subsidirs-subsidipemerintah;
        
        
        if($(this).is(":checked")){
            $(this).parents('tr').find("input[name$='[subtotaloa]']").val(subtotaloa);
            $(this).parents('tr').find("input[name$='[iurbiaya]']").val(subiurbiayaoa);
            tot_hargajual_oa += (hargasatuan_oa * qty_oa);
            tot_iurbiaya += subiurbiayaoa;
            tot_tarifcyto += tarifcyto;
            tot_discount += discount;
            tot_biayalain += biayalain;
            tot_subsidiasuransi += subsidiasuransi;
            tot_subsidipemerintah += subsidipemerintah;
            tot_subsidirs += subsidirs;
            total_oa += subtotaloa;
        }else{
            $(this).parents('tr').find("input[name$='[subtotaloa]']").val(0);
            $(this).parents('tr').find("input[name$='[iurbiaya]']").val(0);
        }
    });
	// console.log(tot_iurbiaya);
	if($("#is_proporsioa").is(":checked")){
		var tot_discount = $("#form-rincianobatalkes #tot_discount").val();
		var tot_biayalain = $("#form-rincianobatalkes #tot_biayalain").val();
		var tot_subsidiasuransi = $("#form-rincianobatalkes #tot_subsidiasuransi").val();
                var tot_subsidipemerintah = $("#form-rincianobatalkes #tot_subsidipemerintah").val();
		var tot_subsidirs = $("#form-rincianobatalkes #tot_subsidirs").val();
		total_oa = tot_hargajual_oa+tot_tarifcyto-tot_discount+tot_biayalain;
		tot_iurbiaya = parseFloat(total_oa-(parseFloat(tot_subsidiasuransi)+parseFloat(tot_subsidirs)+parseFloat(tot_subsidipemerintah)));
	}else{
		$("#form-rincianobatalkes #tot_discount").val(tot_discount);
		$("#form-rincianobatalkes #tot_biayalain").val(tot_biayalain);
		$("#form-rincianobatalkes #tot_subsidiasuransi").val(tot_subsidiasuransi);
                $("#form-rincianobatalkes #tot_subsidipemerintah").val(tot_subsidipemerintah);
		$("#form-rincianobatalkes #tot_subsidirs").val(tot_subsidirs);
	}
	$("#form-rincianobatalkes #tot_hargajual_oa").val(tot_hargajual_oa);
	$("#form-rincianobatalkes #tot_tarifcyto").val(tot_tarifcyto);
	$("#form-rincianobatalkes #tot_iurbiaya").val(tot_iurbiaya);
	$("#form-rincianobatalkes #total_oa").val(total_oa);

    formatNumberSemua();
    hitungTotalSemua();
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
    var tot_subsidipemerintah_tindakan = parseInt($("#form-rinciantindakan #tot_subsidipemerintah_tindakan").val());
    var tot_iurbiaya_tindakan = parseInt($("#form-rinciantindakan #tot_iurbiaya_tindakan").val());
    var total_tindakan = parseInt($("#form-rinciantindakan #total_tindakan").val());
    
    var tot_hargajual_oa = parseInt($("#form-rincianobatalkes #tot_hargajual_oa").val());
    var tot_tarifcyto = parseInt($("#form-rincianobatalkes #tot_tarifcyto").val());
    var tot_discount = parseInt($("#form-rincianobatalkes #tot_discount").val());
    var tot_biayalain = parseInt($("#form-rincianobatalkes #tot_biayalain").val());
    var tot_subsidiasuransi = parseInt($("#form-rincianobatalkes #tot_subsidiasuransi").val());
    var tot_subsidipemerintah = parseInt($("#form-rincianobatalkes #tot_subsidipemerintah").val());
    var tot_subsidirs = parseInt($("#form-rincianobatalkes #tot_subsidirs").val());
    var tot_iurbiaya = parseInt($("#form-rincianobatalkes #tot_iurbiaya").val());
    var total_oa = parseInt($("#form-rincianobatalkes #total_oa").val());
    var tot_tarif_semua = tot_tarif_tindakan+tot_hargajual_oa;
    var tot_tarifcyto_semua = tot_tarifcyto_tindakan+tot_tarifcyto;
    var tot_discount_semua = tot_discount_tindakan+tot_discount;
    var tot_subsidiasuransi_semua = tot_subsidiasuransi_tindakan+tot_subsidiasuransi;
    var tot_subsidirumahsakit_semua = tot_subsisidirumahsakit_tindakan+tot_subsidirs;
    var tot_subsidipemerintah_semua = tot_subsidipemerintah_tindakan+tot_subsidipemerintah;
    var tot_iurbiaya_semua = tot_iurbiaya_tindakan+tot_iurbiaya;
    
    var total_semua = total_tindakan+total_oa;
	if($("#is_proporsisemua").is(":checked")){
		tot_discount_semua = $("#form-rinciansemua #tot_discount_semua").val();
		tot_subsidiasuransi_semua = $("#form-rinciansemua #tot_subsidiasuransi_semua").val();
		tot_subsidirumahsakit_semua = $("#form-rinciansemua #tot_subsidirumahsakit_semua").val();
		tot_iurbiaya_semua = total_semua - tot_discount_semua - tot_subsidiasuransi_semua - tot_subsidirumahsakit_semua - tot_subsidipemerintah_semua;
	}
	$("#form-rinciansemua #tot_tarif_semua").val(tot_tarif_semua);
	$("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto_semua);
	$("#form-rinciansemua #tot_discount_semua").val(tot_discount_semua);
	$("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi_semua);
	$("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsidirumahsakit_semua);
        $("#form-rinciansemua #tot_subsidipemerintah_semua").val(tot_subsidipemerintah_semua);
	$("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya_semua);
	$("#form-rinciansemua #total_semua").val(total_semua);
    $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_tarif_semua);
    $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(tot_tarif_tindakan);
    $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(tot_hargajual_oa);
    $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount_semua);
    $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi_semua);
    $("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val(tot_subsidipemerintah_semua);
    $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsidirumahsakit_semua);
    $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya_semua);
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
    var totaliurbiaya = parseInt($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val());
    var totaldiscount = parseInt($("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val());
    var biayaadministrasi = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val());
    var biayamaterai = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val());
    var jmlpembulatan = 0;
    var konfig_pembulatan = <?php echo Yii::app()->user->getState('pembulatanharga'); ?>;
    if(konfig_pembulatan > 0){
        jmlpembulatan = konfig_pembulatan - ((totaliurbiaya+biayaadministrasi+biayamaterai) % konfig_pembulatan);
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
    var totaliurbiaya = parseInt($("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val());
    var biayaadministrasi = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayaadministrasi');?>").val());
    var biayamaterai = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'biayamaterai');?>").val());
    var jmlpembulatan = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembulatan');?>").val());
    var jmlpembayaran = totaliurbiaya + biayaadministrasi + biayamaterai + jmlpembulatan;
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
    var totaluangmuka = parseInt($("#<?php echo CHtml::activeId($modPemakaianuangmuka,'totaluangmuka');?>").val());
    var pemakaianuangmuka = parseInt($("#<?php echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val());
    var uangditerima = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'uangditerima');?>").val());
    var jmlpembayaran = parseInt($("#<?php echo CHtml::activeId($modTandabukti,'jmlpembayaran');?>").val());
    var totalbiayapelayanan = parseInt($("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val());
    var totalsubsidiasuransi = parseInt($("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val());
    var totalsubsidirs = parseInt($("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val());
    var uangmasuk = uangditerima + pemakaianuangmuka;
    var uangkembalian = uangmasuk-jmlpembayaran;
    var totalsisatagihan = 0;
    var sisauangmuka = 0;
    var nilaiterendah = Math.min(totaluangmuka,jmlpembayaran);
    if(pemakaianuangmuka > nilaiterendah){ //tidak boleh lebih besar dari jmlpembayaran dan totaluangmuka
        pemakaianuangmuka = nilaiterendah;
        $("#<?php echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").val(pemakaianuangmuka);
        myAlert("Pemakaian uang muka tidak boleh lebih besar dari jumlah harus bayar atau total uang muka!");
        setTimeout(function(){$("#<?php echo CHtml::activeId($modPemakaianuangmuka,'pemakaianuangmuka');?>").focus();},1000);
    }
    sisauangmuka = totaluangmuka-pemakaianuangmuka;
    
    if (carapembayaran.trim() !== "") {
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val(carapembayaran);
    } else {
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_TUNAI; ?>");
    }
    if(uangmasuk == 0){
        uangkembalian = 0;
        totalsisatagihan = jmlpembayaran;
        /*
        if((totalsubsidiasuransi+totalsubsidirs) > 0 && jmlpembayaran == 0){
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_PIUTANG; ?>");
        }else{
            $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_HUTANG; ?>");
        }
            */
    }else if(uangmasuk < jmlpembayaran){
        uangkembalian = 0;
        totalsisatagihan = jmlpembayaran - uangmasuk;
        $("#<?php echo CHtml::activeId($modTandabukti,'carapembayaran');?>").val("<?php echo Params::CARAPEMBAYARAN_CICILAN; ?>");
    }
    var totalbayartindakan = 0;
    if(totalbiayapelayanan < uangditerima){
        totalbayartindakan = totalbiayapelayanan; 
    }else{
        totalbayartindakan = uangditerima;
    }
    $("#<?php echo CHtml::activeId($model,'totalbayartindakan');?>").val(totalbayartindakan);
    $("#<?php echo CHtml::activeId($modPemakaianuangmuka,'sisauangmuka');?>").val(sisauangmuka);
    $("#<?php echo CHtml::activeId($modTandabukti,'uangkembalian');?>").val(uangkembalian);
    $("#<?php echo CHtml::activeId($model,'totalsisatagihan');?>").val(totalsisatagihan);
    formatNumberSemua();
    
}
/**
 * set default / otomatis data pembayar
 * @returns {undefined}
 */
function setDataPembayar(){
    var darinama_bkm = 
            //$("#no_pendaftaran").val()+"-"+
            $("#no_rekam_medik").val()+" - "+$("#namadepan").val()+" "+$("#nama_pasien").val();
    var alamat_bkm = $("#alamat_pasien").val();
    var sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT TANGGAL "+($("#tgl_pendaftaran").val());
    //if($("#instalasi_id").val() == <?php echo Params::INSTALASI_ID_RI; ?>){
    //    sebagaipembayaran_bkm = "BIAYA PELAYANAN RUMAH SAKIT DARI TANGGAL "+($("#tgl_pendaftaran").val())+" SAMPAI DENGAN "+($("#tglselesaiperiksa").val());
    //}
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
        $("#tot_subsidipemerintah_tindakan").removeAttr("readonly");
    }else{
        $("#tot_discount_tindakan").attr("readonly", true);
        $("#tot_pembebasan_tindakan").attr("readonly", true);
        $("#tot_subsidiasuransi_tindakan").attr("readonly", true);
        $("#tot_subsisidirumahsakit_tindakan").attr("readonly", true);
        $("#tot_subsidipemerintah_tindakan").attr("readonly", true);
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
        $("#tot_subsidipemerintah").removeAttr("readonly");
        $("#tot_subsidirs").removeAttr("readonly");
    }else{
        $("#tot_discount").attr("readonly", true);
        $("#tot_biayalain").attr("readonly", true);
        $("#tot_subsidiasuransi").attr("readonly", true);
        $("#tot_subsidipemerintah").attr("readonly", true);
        $("#tot_subsidirs").attr("readonly", true);
        hitungTotalOa();
    }
}
/**
 * set proporsi dari seluruh total (semua)
 */
function setProporsiSemua(){
    if($("#is_proporsisemua").is(":checked")){
        $("#is_proporsitindakan").attr("checked", false);
        setProporsiTindakan();
        $("#is_proporsioa").attr("checked", false);
        setProporsiOa();
        $("#tot_discount_semua").removeAttr("readonly");
        $("#tot_subsidiasuransi_semua").removeAttr("readonly");
        $("#tot_subsidirumahsakit_semua").removeAttr("readonly");
        $("#tot_subsidipemerintah_semua").removeAttr("readonly");
    }else{
        $("#tot_discount_semua").attr("readonly", true);
        $("#tot_subsidiasuransi_semua").attr("readonly", true);
        $("#tot_subsidirumahsakit_semua").attr("readonly", true);
        $("#tot_subsidipemerintah_semua").attr("readonly", true);
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
 * menghitung proporsi subsidi pemerintah
 */
function proporsiSubsidiPemerintahTindakan(){
    unformatNumberSemua();
    var tot_subsisidirumahsakit_tindakan = parseInt($("#tot_subsidipemerintah_tindakan").val());
    var tot_tarif_tindakan = parseInt($("#tot_tarif_tindakan").val());
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto)/ tot_tarif_tindakan) * tot_subsisidirumahsakit_tindakan);
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(0);
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
 * menghitung proporsi subsidi pemerintah obat alkes
 */
function proporsiSubsidiPemerintahOa(){
    unformatNumberSemua();
    var tot_subsidirs = parseInt($("#tot_subsidipemerintah").val());
    var tot_hargajual_oa = parseInt($("#tot_hargajual_oa").val());
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_hargajual_oa) * tot_subsidirs);
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(0);
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
 * menghitung proporsi subsidi pemerintah semua
 */
function proporsiSubsidiPemerintahSemua(){
    unformatNumberSemua();
    var tot_subsidipemerintah_semua = parseInt($("#tot_subsidipemerintah_semua").val());
    var tot_tarif_semua = (parseInt($("#tot_tarif_tindakan").val()) + parseInt($("#tot_hargajual_oa").val()));
    $("#form-rinciantindakan").find("input:checkbox[name$='[is_pilihtindakan]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_tindakan]"]').val());
            var tarifsatuan = parseInt($(this).parents('tr').find('input[name$="[tarif_satuan]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val());
            var proporsi = Math.round(((tarifsatuan * qty + tarifcyto) / tot_tarif_semua) * tot_subsidipemerintah_semua);
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(0);
        }
    });
    hitungTotalTindakan();
    unformatNumberSemua();
    $("#form-rincianobatalkes").find("input:checkbox[name$='[is_pilihoa]']").each(function(){
        if($(this).is(":checked")){
            var qty = parseInt($(this).parents('tr').find('input[name$="[qty_oa]"]').val());
            var hargasatuan = parseInt($(this).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
            var tarifcyto = parseInt($(this).parents('tr').find('input[name$="[tarifcyto]"]').val());
            var proporsi = Math.round(((hargasatuan * qty + tarifcyto)/ tot_tarif_semua) * tot_subsidipemerintah_semua);
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(proporsi);
        }else{
            $(this).parents('tr').find('input[name$="[subsidipemerintah]"]').val(0);
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
            $("form").find('.float2').each(function(){
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
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    window.open("<?php echo $this->createUrl('printRincianSudahBayar') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}
/**
 * print rincian sudah bayar untuk rumah sakit >> RND-3114
 * @returns {undefined} */ 
function printRincianRSSudahBayar()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    window.open("<?php echo $this->createUrl('printRincianRSSudahBayar') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printBuktiKasMasuk()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('/billingKasir/daftarPasien/printdetailKasMasuk') ?>&idPembayaran="+pembayaranpelayanan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
}
/**
 * print bukti kas masuk  (PERLU PENYESUAIAN LAGI)
 * @returns {undefined} */
function printKuitansi()
{
    var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
    //harusnya menggunakan controller yang sama
    window.open("<?php echo $this->createUrl('printKuitansi') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id+"&caraPrint=PRINT","",'location=_new, width=1024px');
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
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $model->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($model->pembayaranpelayanan_id)){
            if(isset($modKunjungan->nama_pasien)){
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembayaran Tagihan', isinotifikasi:'Telah dibayarkan tagihan atas nama <?php echo $modKunjungan->nama_pasien ?>  dengan  <?php echo $modKunjungan->no_rekam_medik ?>  pada <?php echo $model->tglpembayaran ?>'};
            insert_notifikasi(params);
    <?php
            }
        }
    ?>

    <?php 
        if(isset($model->pembayaranpelayanan_id)){
            if(isset($modPenjualan->nama_pasien)){
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEUANGAN ?>, judulnotifikasi:'Pembayaran Penjualan Apotek', isinotifikasi:' Telah dilakukan pembayaran atas penjualan resep pada <?php echo $model->tglpembayaran ?>'}; 
            insert_notifikasi(params);
    <?php
            }
        }
    ?>
});
</script>