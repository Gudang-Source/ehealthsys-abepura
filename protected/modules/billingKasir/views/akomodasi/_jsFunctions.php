<script type="text/javascript">
var row_tindakan_first = new String(<?php echo CJSON::encode($this->renderPartial('billingKasir.views.tindakanRawatJalan._rowTindakan',array('form'=>$form,'modTindakan'=>$modTindakan,'is_adatombolhapus'=>false),true));?>);
var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial('billingKasir.views.tindakanRawatJalan._rowTindakan',array('form'=>$form,'modTindakan'=>$modTindakan,'is_adatombolhapus'=>true),true));?>);
function tambahTindakan(obj=null,first = false){
    var table = $('#table_tindakanpelayanan');
    if(first == true){
        $(table).children('tbody').append(row_tindakan_first.replace());
    }else{
        $(table).children('tbody').append(row_tindakan.replace());
    }
    
    renameInputRow($(table));
    //masking input
    $(table).find(".un-integer").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
    ).removeClass("un-integer").addClass("integer");
    
    //set input datetime
    var inputdatetime = $(table).find('tbody tr:last').find('.datetimemask');
    $(inputdatetime).datetimepicker(
        jQuery.extend(
            {
                showMonthAfterYear:false
            }, 
            jQuery.datepicker.regional['id'],
            {
                'dateFormat':'dd/mm/yy',
                'maxDate':'d',
                'timeText':'Waktu',
                'hourText':'Jam',
                'minuteText':'Menit',
                'secondText':'Detik',
                'showSecond':true,
                'timeOnlyTitle':'Pilih Waktu',
                'timeFormat':'hh:mm:ss',
                'changeYear':true,
                'changeMonth':true,
                'showAnim':'fold',
                'yearRange':'-80y:+20y',
                'showOn': 'button',
            }
        )
    );
    $(inputdatetime).parent().find('.add-on').on('click',function(){$(inputdatetime).datetimepicker('show');});
    $(inputdatetime).parent().find('button').hide();
    $(inputdatetime).mask("99/99/9999 99:99:99");
    //== end set input datetime
    //== set autocomplete daftartindakan
    $(table).find('input[name$="[daftartindakan_nama]"]').each(function(){
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':2,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {
                    $(this).val(ui.item.value);
                    $(this).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val(ui.item.kategoritindakan_nama);
                    $(this).parents('tr').find('input[name$="[daftartindakan_id]"]').val(ui.item.daftartindakan_id);
                    $(this).parents('tr').find('input[name$="[tarif_satuan]"]').val(ui.item.harga_tariftindakan);
                    $(this).parents('tr').find('input[name$="[jenistarif_id]"]').val(ui.item.jenistarif_id);
                    $(this).parents('tr').find('input[name$="[persencyto_tindakan]"]').val(ui.item.persencyto_tind);
                    formatNumberSemua();
                    hitungTarifTindakan();
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteDaftarTindakan');?>",
                        dataType: "json",
                        data:{
                            daftartindakan_nama: request.term,
                            tipepaket_id: $("#tipepaket_id").val(),
                            kelaspelayanan_id: $("#kelaspelayanan_id").val(),
                            penjamin_id: $("#penjamin_id").val(),
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });
    $(table).find('.autocomplete-dokter').autocomplete(
        {
            'showAnim':'fold',
            'minLength':2,
            'focus':function(event, ui )
            {
                $(this).val("");
                return false;
            },
            'select':function( event, ui )
            {
                $(this).val(ui.item.value);
                $(this).parent().next('input').val(ui.item.pegawai_id);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteDokterPemeriksa');?>",
                    dataType: "json",
                    data:{
                        nama_pegawai: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
    //== end set autocomplete
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    window.scrollBy(0,2000);
}
/**
 * reset tabel tindakan
 */
function setTabelTindakanReset(){
    $('#table_tindakanpelayanan > tbody tr').detach();
    tambahTindakan(true);
}
/**
 * reset baris (tr)
 */
function setRowReset(obj){
    $(obj).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val("");
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val("");
    $(obj).parents('tr').find('input[name$="[daftartindakan_nama]"]').val("");
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(0);
    $(obj).parents('tr').find('input[name$="[jenistarif_id]"]').val("");
    $(obj).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val(0);
    $(obj).parents('tr').find('input[name$="[subtotal]"]').val(0);
    
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa1_nama]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa1_id]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa2_nama]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa2_id]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[keterangantindakan]"]').val("");
    
}
/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogTindakan(obj){
    var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#tindakan_untuk").val(tindakan_untuk);
    var ruangan_id = $(obj).parents('tr').find('select[name$="[ruangan_id]"]').val();
    var ruangan_nama = $(obj).parents('tr').find('select[name$="[ruangan_id]"] option:selected').text();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();
    var tipepaket_id = $("#tipepaket_id").val();
    var penjamin_id = $("#penjamin_id").val();
    $("#dialog_tindakan > div").addClass("animation-loading");
    $("#ui-dialog-title-dialog_tindakan").html("Daftar Tindakan "+ruangan_nama);
    $("#dialog_tindakan").dialog("open");
    $.fn.yiiGridView.update('daftartindakan-grid', {
        data:{
            "BKTariftindakanperdaruanganV[ruangan_id]":ruangan_id,
            "BKTariftindakanperdaruanganV[tipepaket_id]":tipepaket_id,
            "BKTariftindakanperdaruanganV[kelaspelayanan_id]":kelaspelayanan_id,
            "BKTariftindakanperdaruanganV[penjamin_id]":penjamin_id,
        }
    });
}
/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogDokter(obj,judul){
    var row = $(obj).parents('tr').prev('tr').find('input[name$="row"]').val();
    $("#untuk_row").val(row);
    var dokter_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#dialog_dokter #dokter_untuk").val(dokter_untuk);
    var ruangan_id = $(obj).parents('tr').prev('tr').find('select[name$="[ruangan_id]"]').val();
    $("#ui-dialog-title-dialog_dokter").html(judul);
    $("#dialog_dokter > div").addClass("animation-loading");
    $("#dialog_dokter").dialog("open");
    $.fn.yiiGridView.update('dokter-grid', {
        data:{
            "BKDokterV[ruangan_id]":ruangan_id,
        }
    });
}
function batalTindakan(obj){
    myConfirm("Apakah anda akan membatalkan tindakan ini?","Perhatian!",
    function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
            renameInputRow($(obj).parents('table'));
        }
    }); 
}
/**
 * hapus tindakan dari database
 */
function hapusTindakan(obj){
    myConfirm("Apakah anda akan menghapus tindakan dan pemakaian bahan ini?","Perhatian!",
    function(r){
        if(r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
                data: {tindakanpelayanan_id:tindakanpelayanan_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        $(obj).parents('tr').detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                }
            });
        }
    }); 
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find("#row").val(row);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
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
        if($(this).find("#row").length){ //untuk index tr baris ke-2 dianggap 1 baris dengan atasnya (karena berisi keterangan lanjutan)
            row--; 
        }
    });
    
}
/**
 * jika dipilih dari dialogbox
 */
function pilihTindakan(daftartindakan_id, daftartindakan_nama, kategoritindakan_nama, harga_tariftindakan, jenistarif_id, persencyto_tindakan){
    var tindakan_untuk = $("#tindakan_untuk").val();
    $("#"+tindakan_untuk).val(daftartindakan_nama);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[daftartindakan_id]"]').val(daftartindakan_id);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val(kategoritindakan_nama);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[tarif_satuan]"]').val(harga_tariftindakan);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[jenistarif_id]"]').val(jenistarif_id);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[persencyto_tindakan]"]').val(persencyto_tindakan);
    formatNumberSemua();
    hitungTarifTindakan();
}

/**
 * jika dipilih dari dialogbox
 */
function pilihDokter(pegawai_id, nama_pegawai){
    var untuk_id = $("#dokter_untuk").val();
    $("#"+untuk_id).val(nama_pegawai);
    $("#"+untuk_id).parent().next('input').val(pegawai_id);
}

/**
 * hitung tarif tindakan dan total 
 **/
function hitungTarifTindakan(){
    unformatNumberSemua();
    var totaltarif = 0;
    $("#table_tindakanpelayanan > tbody input[name$='[qty_tindakan]']").each(function(){
        var qty_tindakan = $(this).val();
        var tarif_satuan = $(this).parents('tr').find("input[name$='[tarif_satuan]']").val();
        var persencyto_tindakan = $(this).parents('tr').find("input[name$='[persencyto_tindakan]']").val();
        var tarifcyto_tindakan = 0;
        if($(this).parents('tr').find("select[name$='[cyto_tindakan]']").val() == 1){
            tarifcyto_tindakan = (qty_tindakan * tarif_satuan * persencyto_tindakan / 100);
        }
        var subtotal = (qty_tindakan * tarif_satuan) + tarifcyto_tindakan;
        $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
        $(this).parents('tr').find("input[name$='[tarifcyto_tindakan]']").val(tarifcyto_tindakan);
        totaltarif += subtotal;
    });
    $("#table_tindakanpelayanan > tfoot").find("#totaltariftindakan").val(totaltarif);
    formatNumberSemua();
}
/**
 * untuk menampilkan dokter / pemeriksa lengkap
 */
function tampilkanPemeriksaLain(obj){
    $(obj).parents('tr').find(".dokter-lengkap").toggle('500');
}
    

/**
 * fungsi ready ini posisinya harus tetap paling bawah
 */
$(document).ready(function(){
    renameInputRow($("#table_tindakanpelayanan"));
    setTimeout(function(){tambahTindakan(null,true);},1000);
});
</script>
