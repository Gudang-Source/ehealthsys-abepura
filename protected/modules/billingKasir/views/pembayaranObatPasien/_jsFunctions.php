<script type="text/javascript">
    
    function setRincianTindakan(){
        //KARENA DISINI TIDAK ADA FORM TINDAKAN
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
        var tot_subsidirs = parseInt($("#form-rincianobatalkes #tot_subsidirs").val());
        var tot_iurbiaya = parseInt($("#form-rincianobatalkes #tot_iurbiaya").val());
        var total_oa = parseInt($("#form-rincianobatalkes #total_oa").val());

        $("#form-rinciansemua #tot_tarif_semua").val(tot_hargajual_oa);
        $("#form-rinciansemua #tot_tarifcyto_semua").val(tot_tarifcyto);
        $("#form-rinciansemua #tot_discount_semua").val(tot_discount);
        $("#form-rinciansemua #tot_subsidiasuransi_semua").val(tot_subsidiasuransi);
        $("#form-rinciansemua #tot_subsidirumahsakit_semua").val(tot_subsidirs);
        $("#form-rinciansemua #tot_iurbiaya_semua").val(tot_iurbiaya);
        $("#form-rinciansemua #total_semua").val(total_oa);

        $("#<?php echo CHtml::activeId($model,'totalbiayapelayanan');?>").val(tot_hargajual_oa);
        $("#<?php echo CHtml::activeId($model,'totalbiayatindakan');?>").val(0);
        $("#<?php echo CHtml::activeId($model,'totalbiayaoa');?>").val(tot_hargajual_oa);
        $("#<?php echo CHtml::activeId($model,'totaldiscount');?>").val(tot_discount);
        $("#<?php echo CHtml::activeId($model,'totalsubsidiasuransi');?>").val(tot_subsidiasuransi);
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
        var darinama_bkm = $("#no_pendaftaran").val()+"-"+$("#no_rekam_medik").val()+"-"+$("#namadepan").val()+" "+$("#nama_pasien").val();
        var alamat_bkm = $("#alamat_pasien").val();
        var sebagaipembayaran_bkm = "BIAYA PELAYANAN OBAT / ALAT KESEHATAN";
        $("#<?php echo CHtml::activeId($modTandabukti, 'darinama_bkm') ?>").val(darinama_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'alamat_bkm') ?>").val(alamat_bkm);
        $("#<?php echo CHtml::activeId($modTandabukti, 'sebagaipembayaran_bkm') ?>").val(sebagaipembayaran_bkm);
    }
    
    /**
     * print rincian obat alkes belum bayar
     * @returns {undefined} */ 
    function printRincianOABelumBayar()
    {
        var instalasi_id = $("#instalasi_id").val();
        var pendaftaran_id = $("#pendaftaran_id").val();
        var pasienadmisi_id = $("#pasienadmisi_id").val();
        if(instalasi_id && pendaftaran_id){
            window.open("<?php echo $this->createUrl('printRincianOABelumBayar') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id,"",'location=_new, width=1024px');
        }else{
            myAlert("Silahkan cari data kunjungan terlabih dahulu !");
        }
    }
</script>