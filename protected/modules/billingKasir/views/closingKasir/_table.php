<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = false;
    $dataProvider = $mBuktBayar->searchTable();
    $dataProvider->sort->defaultOrder = 't.tglbuktibayar';
    $template = "{summary}\n{items}\n{pager}";
?>
<table id="tblBayarTind" class="table table-striped table-condensed">
    <thead>
        <tr>
            <th>Tanggal Bukti Bayar</th>
            <th>No. Bukti Bayar</th>
            <th>Dari Nama</th>
            <th>Cara Pembayaran</th>
            <th>Sebagai Pembayaran</th>
            <th>Jumlah Pembayaran</th>
            <th>Biaya Administrasi</th>
            <th>Biaya Materai</th>
            <th>Pilih<br>
                <?php 
                    echo CHtml::checkBox('checkPembayaran',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                    'class'=>'checkbox-column','onclick'=>'checkAllPembayaran(this)','checked'=>'checked'))
                ?>
            </th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(count($dataProvider->getData()) > 0)
    {
        $cols = '';
        $i=0;
        foreach($dataProvider->getData() as $data)
        {
    ?>
        <tr>
            <td><?php echo(MyFormatter::formatDateTimeForUser($data->tglbuktibayar)); ?></td>
            <td class="nobuktibayar">
                <?php echo($data->nobuktibayar); ?>
            </td>
            <td><?php echo($data->darinama_bkm); ?></td>
            <td class="carapembayaran"><?php echo($data->carapembayaran); ?></td>
            <td><?php echo($data->sebagaipembayaran_bkm); ?></td>
            <td class="jmlpembayaran currency_tbl"><?php echo($data->jmlpembayaran); ?></td>
            <td class="jmlAdministrasi currency_tbl"><?php echo($data->biayaadministrasi); ?></td>
            <td class="currency_tbl"><?php echo($data->biayamaterai); ?></td>
            <td>
                <?php echo(CHtml::checkBox("pilih[". $data->nobuktibayar ."]", true, array("onchange"=>"hitungTransaksi()"))); ?>
                <?php echo(CHtml::hiddenField("is_pelayanan[". $data->nobuktibayar ."]", (is_null($data->pembayaranpelayanan_id) ? 'xxx' : $data->pembayaranpelayanan_id))); ?>
                <?php
                    echo(CHtml::hiddenField("is_deposit[". $data->nobuktibayar ."]", (is_null($data->bayaruangmuka_id) ? 'xxx' : $data->bayaruangmuka_id)));
                    echo(CHtml::hiddenField("is_tunai[". $data->nobuktibayar ."]", $data->carapembayaran));
                ?>
                <?php echo CHtml::hiddenField("BKClosingkasirT[nobuktibayar][$i]", "", array('readonly'=>true,'class'=>'inputFormTabel')); ?>
            </td>
        </tr>
    <?php
            $i++;
        }
    }else{
        echo('<tr><td align="center" colspan="10">Data Tidak Ditemukan</td></tr>');
    }
    ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.currency_tbl').each(
            function(){
                $(this).text(formatNumber($(this).text()));
                $(this).attr('style', 'text-align:right');
            }
        );
    });
    
        
    // setTimeout(
    //     function(){
    //         hitungTransaksi();
    //     }, 1000
    // );


    function cekInputTindakan(){
        $('.currency').each(function(){this.value = unformatNumber(this.value)});
        $('.currency').each(function(){this.value = unformatNumber(this.value)});
        $('.integer').each(function(){this.value = unformatNumber(this.value)});
        
        var closingsaldoawal = unformatNumber($('#BKClosingkasirT_closingsaldoawal').val());
        if(parseInt(closingsaldoawal) > 0)
        {
            var totalsetoran = unformatNumber($('#BKClosingkasirT_totalsetoran').val());
            if(parseInt(totalsetoran) > 0)
            {
                var total_recehan = unformatNumber($('#total_recehan').val());
                if(total_recehan != totalsetoran)
                {
                    myAlert("Total Setoran dengan Total Recehan berbeda, coba cek ulang");
                    $('#BKClosingkasirT_totalsetoran').focus();
                    return false;
                }
            }else{
                myAlert("Total setoran tidak boleh kosong");
                $('#BKClosingkasirT_totalsetoran').focus();
                return false;                
            }
        }else{
            $('#BKClosingkasirT_closingsaldoawal').focus();
            myAlert("Saldo awal tidak boleh kosong");
            return false;
        }
    }
    
    function hitungTransaksi(){
    unformatNumberSemua();
        var jumTrans = 0, totPembayaran=0, jumPelayanan=0, totPembayaranTunai=0, jumDeposit=0, totAdministrasi = 0, jumTunai = 0;
        var jmlPiutang = 0;
        $('#tblBayarTind tbody').find('tr').each(
            function(){
                if($(this).find('input[type="checkbox"]').is(':checked')){
                    jumTrans++;
                    var jmlpembayaran = unformatNumber($(this).find('.jmlpembayaran').text());
                    var jmlAdministrasi = unformatNumber($(this).find('.jmlAdministrasi').text());
                    
                    totAdministrasi += parseFloat(jmlAdministrasi);
                    totPembayaran += parseFloat(jmlpembayaran);
                    
                    var nobuktibayar = $(this).find('.nobuktibayar').text();
                    $(this).find('input[name*="nobuktibayar"]').val(nobuktibayar);
                    
                    var is_pelayanan = $(this).find('input[name*="is_pelayanan"]').val();
                    if(is_pelayanan != 'xxx'){
                        jumPelayanan += parseFloat(jmlpembayaran);
                    }
                    
                    var is_deposit = $(this).find('input[name*="is_deposit"]').val();
                    if(is_deposit != 'xxx'){
                        jumDeposit += parseFloat(jmlpembayaran);
                    }
                    
                    var is_tunai = $(this).find('input[name*="is_tunai"]').val();
                    if(is_tunai == 'TUNAI')
                    {
                        jumTunai += parseFloat(jmlpembayaran);
                    } else if (is_tunai == 'PIUTANG') {
                        jmlPiutang += parseFloat(jmlpembayaran);
                    }
                    
                    
                    var carapembayaran = $(this).find('.carapembayaran').text();
                    if($(this).find('.carapembayaran').text() == 'TUNAI')
                    {
                        totPembayaranTunai += parseFloat(jmlpembayaran);
                    }
                }else{
                    $(this).find('input[name*="nobuktibayar"]').removeAttr("value");
                }
            }
        );
            
        $("#BKClosingkasirT_jmltransaksi").val(jumTrans);
        $("#BKClosingkasirT_terimauangpelayanan").val(jumPelayanan);
        $("#BKClosingkasirT_terimauangmuka").val(jumDeposit);
        $("#BKClosingkasirT_piutang").val(jmlPiutang);
        
        console.log(jmlPiutang);
        
        var terimauangmuka = jumDeposit;
        var jum_penerimaan_umum = $("#jum_penerimaan_umum").val();
        var jum_pengeluaran_umum = $("#jum_pengeluaran_umum").val();
        var jum_penerimaan_tunai = parseInt(jumPelayanan) + parseInt(terimauangmuka) + parseInt(jum_penerimaan_umum);
        var jum_tutup_kasir = parseInt(jumTunai) + parseInt(totAdministrasi);
        if(parseInt(jum_pengeluaran_umum) > 0)
        {
            jum_tutup_kasir = parseInt(jumTunai) + parseInt(totAdministrasi) - parseInt(jum_pengeluaran_umum);
        }
        $("#jum_penerimaan_tunai").val(parseInt(jumTunai));
        $("#BKClosingkasirT_nilaiclosingtrans").val(jum_tutup_kasir);
        $("#BKClosingkasirT_totalsetoran").val(0);
        // $("#BKClosingkasirT_piutang").val(0);
        $("#BKSetorbankT_jumlahsetoran").val(jum_tutup_kasir);
        
        $('.currency').each(
            function(){
                this.value = formatInteger(this.value)
            }
        );
    formatNumberSemua();
    }
    

    function checkAllPembayaran()
    {
        if ($("#checkPembayaran").is(":checked")) {
            $('#tblBayarTind input[name*="pilih"]').each(function(){
               $(this).attr('checked',true);
            })
        } else {
           $('#tblBayarTind input[name*="pilih"]').each(function(){
               $(this).removeAttr('checked');
            })
        }
        hitungTransaksi();
    }
    
    function hitungPiutang(param)
    {
        var terimauangpelayanan = unformatNumber($("#BKClosingkasirT_terimauangpelayanan").val());
        var terimauangmuka = unformatNumber($("#BKClosingkasirT_terimauangmuka").val());
        var jum_penerimaan_umum = unformatNumber($("#jum_penerimaan_umum").val());
        var jum_pengeluaran_umum = unformatNumber($("#jum_pengeluaran_umum").val());
        var total = parseInt(terimauangpelayanan) + parseInt(terimauangmuka) + parseInt(jum_penerimaan_umum);
        if(parseInt(jum_pengeluaran_umum) > 0)
        {
            total = total - jum_pengeluaran_umum;
        }
        $("#jum_penerimaan_tunai").val(formatInteger(total));
        
        
        /* SEMENTARA DI NON AKTIFKAN DULU SEBELUM ADA KONFIRMASI ALUR YG BENAR DARI RS
         * 
         * 
        var totalClosing = unformatNumber($("#BKClosingkasirT_nilaiclosingtrans").val());
        var uangMuka = unformatNumber($(param).val());
        var totPiutang = 0;
        if(uangMuka > 0)
        {
            if(totalClosing > 0)
            {
                totPiutang = totalClosing - uangMuka;
            }else{
                myAlert('Biaya masing kosong, coba cek lagi !');
                $(param).val(0);
            }            
            totPiutang = totalClosing - uangMuka;
        }
        $("#BKClosingkasirT_piutang").val(formatInteger(totPiutang));
        */
    }

    // tambah fungsi Total Setoran = Total Tutup Kasir + Saldo Awal
    function hitungTotalSetoran(){
    unformatNumberSemua();
        var clossaldoawal = unformatNumber($('#BKClosingkasirT_closingsaldoawal').val());
        var totClosing = unformatNumber($("#BKClosingkasirT_nilaiclosingtrans").val());
        if (parseInt(totClosing) > 0){
        var totsetoran = parseInt(clossaldoawal) + parseInt(totClosing);
        $("#BKClosingkasirT_totalsetoran").val(totsetoran);
        }
    formatNumberSemua();
    }
    
    function hitungRecehan()
    {
       var total = 0, tot_receh=0,tot_lembar=0;
       $('#tblClosing input[name*="jum_recehan"]').each(function(){
           var xxx = $(this).attr('recehan_val');
           var xx = unformatNumber($(this).val());
           total += (xxx * xx);
           
           var is_receh = $(this).attr('is_receh');
           if(is_receh == 1 && xx != 0){
               tot_receh += xx;
           }else if(is_receh == 0 && xx != 0){
               tot_lembar += xx;
           }
        })
        $('#BKClosingkasirT_jmluanglogam').val(tot_receh);
        $('#BKClosingkasirT_jmluangkertas').val(tot_lembar);
        $('#total_recehan').val(formatInteger(total));
    }
    
    function setorBankEnable(params)
    {
        if ($(params).is(":checked")){
            $('#setor_bank').slideDown();
        } else {
            $('#setor_bank').slideUp();
        }
        
    }
     
    $(document).ready(function(){
                hitungTransaksi();
    })
/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
/*
function setVerifikasi(){
    if(requiredCheck($("form"))){
        var jum_penerimaan_umum=$("#jum_penerimaan_umum").val();
        if(jum_penerimaan_umum === ""){
            myAlert("Silahkan cari data informasi pembayaran terlabih dahulu !");
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
*/
</script>