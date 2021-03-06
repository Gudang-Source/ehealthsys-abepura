<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qtyObat').val();
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormDetailPemesanan'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-detailpemesanan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah anda akan input ulang obat ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-detailpemesanan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-detailpemesanan > tbody').append(data.form);
					renameInputRowObatAlkes($("#table-detailpemesanan"));                    
				}
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }else{
			if(tambahkandetail){
				$('#table-detailpemesanan > tbody').append(data.form);
				// $("#table-detailpemesanan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
				//     {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				// );
				renameInputRowObatAlkes($("#table-detailpemesanan"));               
			}
		}
                $('#obatalkes_id').val('');
                $('#namaObat').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat alkes terlebih dahulu!");
    }
    $("#obatalkes_nama").focus();   
}



/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
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
/**
 * menghapus detail mutasi berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalPemesananDetail(obj){
    myConfirm('Apakah anda akan membatalkan pemberian obat alkes ini?', 'Perhatian!', function(r)
    {
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
        }
    });
}

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
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
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
    $("#form-infopasien > legend > .judul").html('Data Pasien');
    $("#form-infopasien > legend > .tombol").attr('style','display:none;');
    $("#form-infopasien > .well").addClass("box").removeClass("well");
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoPasien(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "PCPasienM[idInstalasi]":instalasi_id,
            // "FAPasienM[instalasi_nama]":instalasi_nama,
        }
    });
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
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
   
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
        var pendaftaran_id = <?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id']:'' ?>;
        var instalasi_id = <?php echo isset($_GET['instalasi_id']) ? $_GET['instalasi_id']:'' ?>;
        $('#instalasi_id').val(instalasi_id);
        if(pendaftaran_id != ''){
            setInfoPasien(pendaftaran_id,'','','');
        }
    <?php } ?>
        
    <?php if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])){ ?>
        var penjualanresep_id = <?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id']:'' ?>;
        $("#table-obatalkespasien :input").removeAttr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();        
        
        $("#penjualanresep-form :input").attr("readonly",true);
        $("#penjualanresep-form .dtPicker3").attr("readonly",true);
        $("#penjualanresep-form .add-on").remove();
        $("#penjualanresep-form .btn-mini").remove();
        
        $("input, select, textarea").attr("disabled",true);  
    <?php } ?>
});
</script>