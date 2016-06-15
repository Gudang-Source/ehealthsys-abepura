<script type="text/javascript">
var carapembayaran = "";
/**
 * set form penjualan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setPenjualan(penjualanresep_id, noresep, no_rekam_medik, pasienadmisi_id ){
    $("#form-datapenjualan > div").addClass("animation-loading");
    var jenispenjualan = $("#jenispenjualan").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataPenjualan'); ?>',
        data: {pendaftaran_id:pendaftaran_id, jenispenjualan:jenispenjualan, penjualanresep_id:penjualanresep_id, noresep:noresep, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#jenispenjualan").val(data.jenispenjualan);
            $("#penjualanresep_id").val(data.penjualanresep_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            if(data.ruangan_id){
                $("#ruangan_id").val(data.ruangan_id);
            }else{
                $("#ruangan_id").val(data.ruanganakhir_id);
            }
            $("#noresep").val(data.noresep);
            $("#tglpenjualan").val(data.tglpenjualan);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            $("#<?php echo CHtml::activeId($model, 'noresep') ?>").val(data.noresep);
            //uangmuka
            $("#<?php echo CHtml::activeId($modPemakaianuangmuka, 'totaluangmuka') ?>").val(data.jumlahuangmuka);

            setRincianObatalkes();
            setDataPembayar();

            $("#form-datapenjualan > legend > .judul").html('Data Penjualan '+data.noresep);
            $("#form-datapenjualan > legend > .tombol").attr('style','display:true;');
            $("#form-datapenjualan > .box").addClass("well").removeClass("box");
            
            carapembayaran = data.metode_pembayaran;

            $("#form-datapenjualan > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data penjualan tidak ditemukan !"); 
            console.log(errorThrown);
            setPenjualanReset();
            $("#form-datapenjualan > div").removeClass("animation-loading");
            $("#jenispenjualan").focus();
        }
    });

}
/**
 * untuk mereset form penjualan
 * @returns {undefined} */
function setPenjualanReset(){
    $("#penjualanresep_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#ruangan_id").val("");
    $("#noresep").val("");
    $("#tglpenjualan").val("");
    $("#ruangan_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datapenjualan > legend > .judul").html('Data Penjualan');
    $("#form-datapenjualan > legend > .tombol").attr('style','display:none;');
    $("#form-datapenjualan > .well").addClass("box").removeClass("well");
    
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val("");
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val("");
    
    carapembayaran = "";
    
    setRincianObatalkes();
}
/**
* menampilkan form verifikasi
* @returns {undefined}
*/
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var penjualanresep_id=$("#penjualanresep_id").val();
            if(penjualanresep_id === ""){
                myAlert("Silahkan cari data penjualan terlabih dahulu !");
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
                $("form").find('.integer').each(function(){
                    $(this).val(formatInteger($(this).val()));
                });
            }
    }
    return false;
}

/**
 * refresh dialog penjualan
 * @returns {undefined}
 */
function refreshDialogPenjualan(){
    var jenispenjualan = $("#jenispenjualan").val();
    $.fn.yiiGridView.update('datapenjualan-grid', {
        data: {
            "BKInformasipenjualanaresepV[jenispenjualan]":jenispenjualan,
        }
    });
}
/**
 * set form rincian tagihan apotek pasien
 * @returns {undefined}
 */
function setRincianObatalkes(){
    var jenispenjualan=$("#jenispenjualan").val();
    var penjualanresep_id=$("#penjualanresep_id").val();
    var pendaftaran_id=$("#pendaftaran_id").val();
    var pasienadmisi_id=$("#pasienadmisi_id").val();
    var kelaspelayanan_id=$("#kelaspelayanan_id").val();
    var penjamin_id=$("#penjamin_id").val();
    var pasien_id=$("#pasien_id").val();
    $("#form-rincianobatalkes").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetRincianObatalkes'); ?>',
        data: {pendaftaran_id:pendaftaran_id,jenispenjualan:jenispenjualan,penjualanresep_id:penjualanresep_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id},//
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

function setRincianTindakan(){
    //KARENA DISINI TIDAK ADA FORM OBAT ALKES
}
/**
 * menghitung total semua = total obat alkes
 * @returns {undefined}
 */
function hitungTotalSemua(){
    unformatNumberSemua();

    var tot_hargajual_oa = parseInt($("#form-rincianobatalkes #tot_hargajual_oa").val());
    var tot_tarifcyto = parseInt($("#form-rincianobatalkes #tot_tarifcyto").val());
    var tot_discount = parseInt($("#form-rincianobatalkes #tot_discount").val());
    var tot_biayalain = parseInt($("#form-rincianobatalkes #tot_biayalain").val());
    var tot_subsidiasuransi = parseInt($("#form-rincianobatalkes #tot_subsidiasuransi").val());
    var tot_subsidipemerintah = parseInt($("#form-rincianobatalkes #tot_subsidipemerintah").val());
    var tot_subsidirs = parseInt($("#form-rincianobatalkes #tot_subsidirs").val());
    var tot_iurbiaya = parseInt($("#form-rincianobatalkes #tot_iurbiaya").val());
    var total_oa = parseInt($("#form-rincianobatalkes #total_oa").val());

    $("#form-rinciansemua #tot_tarif_semua").val(tot_hargajual_oa);
    $("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto);
    $("#form-rinciansemua #tot_discount_semua").val(tot_discount);
    $("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi);
    $("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsidirs);
    $("#form-rinciansemua #tot_subsidipemerintah_semua").val(tot_subsidipemerintah);
    $("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya);
    $("#form-rinciansemua #total_semua").val(total_oa);

    $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_hargajual_oa);
    $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(0);
    $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(tot_hargajual_oa);
    $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount);
    $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi);
    $("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val(tot_subsidipemerintah);
    $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsidirs);
    $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya);
    $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(0);


    formatNumberSemua();
    hitungJmlpembulatan();
    hitungJmlpembayaran();
    hitungUangKembalian();

}
/**
 * set default / otomatis data pembayar
 * @returns {undefined}
 */
function setDataPembayar(){
    var darinama_bkm = $("#noresep").val()+"-"+$("#no_rekam_medik").val()+"-"+$("#namadepan").val()+" "+$("#nama_pasien").val();
    var alamat_bkm = $("#alamat_pasien").val();
    var jenispenjualan = $("#jenispenjualan option:selected").text();
    var sebagaipembayaran_bkm = "BIAYA PELAYANAN "+jenispenjualan.toUpperCase();
    $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
    $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
}

/**
 * print rincian 
 */ 
function printRincian(caraPrint)
{
    var tandabuktibayar_id = "<?php echo $modTandabukti->tandabuktibayar_id; ?>";
    var penjualanresep_id = "<?php echo $modPenjualan->penjualanresep_id; ?>";
    
    if(tandabuktibayar_id){
        window.open("<?php echo $this->createUrl('informasipenjualanresep/fakturPembayaranApotek') ?>&penjualanresep_id="+penjualanresep_id+"&tandabuktibayar_id="+tandabuktibayar_id+"&caraPrint="+caraPrint,'printwin','location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
 * print rincian sudah bayar
 */ 
function printBkm(caraPrint)
{
    var tandabuktibayar_id = "<?php echo $modTandabukti->tandabuktibayar_id; ?>";
    var penjualanresep_id = "<?php echo $modPenjualan->penjualanresep_id; ?>";
    
    if(tandabuktibayar_id){
        window.open("<?php echo $this->createUrl('informasipenjualanresep/buktiKasMasukFarmasi') ?>&penjualanresep_id="+penjualanresep_id+"&tandabuktibayar_id="+tandabuktibayar_id+"&caraPrint="+caraPrint,'printwin','location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
 * print rincian belum bayar (PERLU PENYESUAIAN LAGI)
 */ 
function printRincianPenunjangBelumBayar()
{
    var instalasi_id = $("#instalasi_id").val();
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(instalasi_id && pendaftaran_id){
        window.open("<?php echo $this->createUrl('printRincianPenunjangBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');
    }else{
        myAlert("Silahkan cari data penjualan terlabih dahulu !");
    }
}

/**
* print rincian sudah bayar (PERLU PENYESUAIAN LAGI)
* @returns {undefined} */ 
function printRincianSudahBayar()
{
   var pembayaranpelayanan_id = "<?php echo $model->pembayaranpelayanan_id?>";
   window.open("<?php echo $this->createUrl('printRincianSudahBayar') ?>&pembayaranpelayanan_id="+pembayaranpelayanan_id,"",'location=_new, width=1024px');
}


$( document ).ready(function(){
    <?php if(!empty($modPenjualan->penjualanresep_id)){ ?>
           setRincianObatalkes(); 
           setDataPembayar();
           $("#form-datapenjualan :input").attr("readonly",true);
           $("#form-datapenjualan .add-on").remove();
    <?php } ?>

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
    // Notifikasi Pegawai
    <?php 
        if(isset($_GET['smspegawai'])){
            if($_GET['smspegawai']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PEGAWAI', isinotifikasi:'dr. <?php echo PegawaiM::model()->findByPk($modPenjualan->pegawai_id)->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>