<script type="text/javascript">
    /**
     * refresh dialog kunjungan
     * @returns {undefined}
     */
    function refreshDialogKunjungan(){
        var instalasi_id = $("#instalasi_id").val();
        $.fn.yiiGridView.update('datakunjungan-grid', {
            data: {
                "BKRinciantagihanpasienpenunjangV[instalasi_id]":instalasi_id,
            }
        });
    }
    /**
     * set form rincian tagihan tindakan penunjang
     * @returns {undefined}
     */
    function setRincianTindakan(){
        var instalasi_id=$("#instalasi_id").val();
        var pendaftaran_id=$("#pendaftaran_id").val();
        var pasienadmisi_id=$("#pasienadmisi_id").val();
        var kelaspelayanan_id=$("#kelaspelayanan_id").val();
        var penjamin_id=$("#penjamin_id").val();
        var pasien_id=$("#pasien_id").val();
        $("#form-rinciantindakan").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetRincianTindakanPenunjang'); ?>',
            data: {instalasi_id:instalasi_id,pendaftaran_id:pendaftaran_id,pasienadmisi_id:pasienadmisi_id,kelaspelayanan_id:kelaspelayanan_id,penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-rinciantindakan").html(data.form);
                $("#form-rinciantindakan").removeClass("animation-loading");
                $("#form-rinciantindakan .integer2").maskMoney (
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                );
                $("#form-rinciantindakan").find('input:checkbox[name$="is_proporsitindakan"]').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                hitungTotalTindakan();
                hitungTotalSemua();
            },
             error: function (jqXHR, textStatus, errorThrown) { $("#form-rinciantindakan").removeClass("animation-loading");console.log(errorThrown);}
        });
    }
    function setRincianObatalkes(){
        //KARENA DISINI TIDAK ADA FORM OBAT ALKES
    }
    /**
     * menghitung total semua = total tindakan
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

        $("#form-rinciansemua #tot_tarif_semua").val(tot_tarif_tindakan);
        $("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto_tindakan);
        $("#form-rinciansemua #tot_discount_semua").val(tot_discount_tindakan);
        $("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi_tindakan);
        $("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsisidirumahsakit_tindakan);
        $("#form-rinciansemua #tot_subsidipemerintah_semua").val(tot_subsidipemerintah_tindakan);
        $("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya_tindakan);
        $("#form-rinciansemua #total_semua").val(total_tindakan);

        $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_tarif_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(tot_tarif_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(0);
        $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalsubsidipemerintah');?>").val(tot_subsidipemerintah_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalsubsidirs');?>").val(tot_subsisidirumahsakit_tindakan);
        $("#<?php echo CHtml::activeId($model,'totaliurbiaya');?>").val(tot_iurbiaya_tindakan);
        $("#<?php echo CHtml::activeId($model,'totalpembebasan');?>").val(tot_pembebasan_tindakan);


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
        var darinama_bkm = $("#no_rekam_medik").val()+" - "+$("#namadepan").val()+" "+$("#nama_pasien").val();
        var alamat_bkm = $("#alamat_pasien").val();
        var instalasi_nama = $("#instalasi_id option:selected").text();
        var sebagaipembayaran_bkm = "BIAYA PELAYANAN "+instalasi_nama.toUpperCase();
        $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
    }
    /**
     * print rincian belum bayar (PERLU PENYESUAIAN LAGI)
     */ 
    function printRincianPenunjangBelumBayar()
    {
        var instalasi_id = $("#instalasi_id").val();
        var pendaftaran_id = $("#pendaftaran_id").val();
        //if(instalasi_id && pendaftaran_id){
            window.open("<?php echo $this->createUrl('printRincianPenunjangBelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id,"",'location=_new, width=1024px');
        //}else{
        //    myAlert("Silahkan cari data kunjungan terlabih dahulu !");
        //}
    }
    
</script>