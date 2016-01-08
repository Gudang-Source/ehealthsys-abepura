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
            $("#<?php echo CHtml::activeId($modPemesanan,'norekammedis'); ?>").val(data.no_rekam_medik);
            $("#<?php echo CHtml::activeId($modPemesanan,'noidentitas'); ?>").val(data.no_identitas_pasien);
            $("#<?php echo CHtml::activeId($modPemesanan,'namapasien'); ?>").val(data.nama_pasien);
            $("#<?php echo CHtml::activeId($modPemesanan,'pasien_id'); ?>").val(data.pasien_id);
            $("#<?php echo CHtml::activeId($modPemesanan,'pendaftaran_id'); ?>").val(data.pendaftaran_id);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
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
            "AMInfokunjunganrjV[instalasi_id]":instalasi_id,
            "AMInfokunjunganrjV[instalasi_nama]":instalasi_nama,
        }
    });
}    

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
function inputKendaraan(idAmbulans,noPol,jenis,kode,kmAwal,isiBbm)
{
    $("#AMPemakaianambulansT_mobilambulans_id").val(idAmbulans);
    $("#AMPemakaianambulansT_mobilambulans_nama").val(kode);
    $("#AMPemakaianambulansT_nopolisi").val(noPol);
    $("#AMPemakaianambulansT_jeniskendaraan").val(jenis);
    $("#AMPemakaianambulansT_kmawal").val(kmAwal);
    $("#AMPemakaianambulansT_jmlbbmliter").val(isiBbm);
    $("#dialogKendaraan").dialog('close');
    $('.integer').each(function(){this.value = formatNumber(this.value)});
    $('.number').each(function(){this.value = formatNumber(this.value)});
}
function inputParamedis(idPegawai,namaPegawai)
{
    var paramedisKe = $('#dialogParamedis #paramedisKe').val();
    $("#AMPemakaianambulansT_paramedis"+paramedisKe+"_id").val(idPegawai);
    $("#AMPemakaianambulansT_paramedis"+paramedisKe+"_nama").val(namaPegawai);
    $("#dialogParamedis").dialog('close');
}
function inputPelaksana(idPegawai,namaPegawai)
{
    $("#AMPemakaianambulansT_pelaksana_id").val(idPegawai);
    $("#AMPemakaianambulansT_pelaksana_nama").val(namaPegawai);
    $("#dialogPelaksana").dialog('close');
}
function inputSupir(idSupir,namaSupir)
{
    $("#AMPemakaianambulansT_supir_id").val(idSupir);
    $("#AMPemakaianambulansT_supir_nama").val(namaSupir);
    $("#dialogSupir").dialog('close');
}
function inputTarifAmbulans(jmlKM,tarifKM,tarif,propinsi,kabupaten,kecamatan,kelurahan,daftatindakanId)
{
    var tr = '<tr><td><input type="text" value="'+propinsi+'" name="tarif[propinsi][]" class="span2"></td>'+
                '<td><input type="text" value="'+kabupaten+'" name="tarif[kabupaten][]" class="span2"></td>'+
                '<td><input type="text" value="'+kecamatan+'" name="tarif[kecamatan][]" class="span2"></td>'+
                '<td><input type="text" value="'+kelurahan+'" name="tarif[kelurahan][]" class="span2"></td>'+
                '<td><input type="text" value="'+jmlKM+'" name="tarif[jmlKM][]" onblur="hitungTarif(this);" class="span1 number">'+
                '    <input type="hidden" value="'+daftatindakanId+'" name="tarif[daftartindakanId][]" class="span1 number"></td>'+
                '<td><input type="text" value="'+tarifKM+'" name="tarif[tarifKM][]" onblur="hitungTarif(this);" class="span1 integer"></td>'+
                '<td><input type="text" value="'+tarif+'" name="tarif[tarifAmbulans][]" onblur="hitungTarif(this);" readonly="readonly" class="span2 integer"></td>'+
            '</tr>';
    $("#dialogTarif").dialog('close');
    
    $("#tblTarifAmbulans > tbody").append(tr);
    $("#tblTarifAmbulans > tbody > tr:last .integer").maskMoney({"symbol":"Rp. ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
    $('.integer').each(function(){this.value = formatNumber(this.value)});
    $("#tblTarifAmbulans > tbody > tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
    $('.number').each(function(){this.value = formatNumber(this.value)});
}

function hitungTarif(obj)
{
    var km = $(obj).parent().parent().find('input[name$="[jmlKM][]"]');
    var tarifkm = $(obj).parent().parent().find('input[name$="[tarifKM][]"]');
    var tarif = $(obj).parent().parent().find('input[name$="[tarifAmbulans][]"]');
    
    tarif.val(formatNumber(unformatNumber(km.val()) * unformatNumber(tarifkm.val())) );
}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
        });
        $(this).find('span[name$="[tindakan_nama]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 2){
                $(this).attr("name","["+row+"]["+old_name_arr[1]+"]");
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
function renameInput(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPemakaianBahan tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function removeObat(obj)
{
    myConfirm("Apakah anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
        }
    });
    hitungTotal();
}
    
function hitungSubTotal(obj)
{
    var qty = obj.value;
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[qty]"]').val(formatNumber(subtotal));
    hitungTotal(); 
}
    
function hitungTotal()
{
    var total = 0;
    $('#tblInputPemakaianBahan').find('input[name$="[qty]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totPemakaianBahan').val(formatNumber(total));
}
function validasi(){
    var idObat = $('#idObat').val();
    var jumlahObat = $('#qty').val();
    if (idObat == ''){
        
        myAlert('Obat Belum Diisi');
    } else if (jumlahObat == ''){
        myAlert('jumlah Obat Belum Diisi')
    } else if (jumlahObat < 1){
        myAlert('jumlah Obat Tidak Sesuai')
    } else {
        inputPemakaianBahan(idObat);
    }
    
}

function cekInput()
{
    $('.integer').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}
function clearDataPasien()
{

    $("#<?php echo CHtml::activeId($modPemesanan, 'noidentitas') ?>").val('');
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("readonly",true);
		$(".btn-mini, .add-on").detach();
		var pendaftaran_id = $("#pendaftaran_id").val();
		setKunjungan(pendaftaran_id);
    <?php } ?>

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPemesanan->namapasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    
});
</script>