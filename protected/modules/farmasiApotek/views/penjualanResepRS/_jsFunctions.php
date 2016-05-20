<script type="text/javascript">
function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
	var therapiobat_id = $(obj).parents('fieldset').find('#therapiobat_id2').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,therapiobat_id:therapiobat_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
				var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='"+therapiobat_id+"']");
				if(therapiobatyangsama.val()){ //jika ada therapi obat sudah ada
					myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
				}
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-obatalkespasien > tbody').append(data.form);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
					addDataKeGridObat(obj,'nonracik',rke);
					renameInputRowObatAlkes($("#table-obatalkespasien"));                    
					hitungTotal();
				}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
			if(tambahkandetail){
				$('#table-obatalkespasien > tbody').append(data.form);
				$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				addDataKeGridObat(obj,'nonracik',rke);
				renameInputRowObatAlkes($("#table-obatalkespasien"));                    
				hitungTotal();
			}
		}
		$(obj).parents('fieldset').find('#obatalkes_id').val('');
		$('#namaObatNonRacik').val('');
		$('#qtyNonRacik').val(1);
		formatNumberSemua();
		renameInputRowObatAlkes($("#table-obatalkespasien")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();   
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyRacik').val();
    var rke = $(obj).parents('fieldset').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
						if(tambahkandetail){
							if (indexrke==0) {
									$('#table-obatalkespasien > tbody').append(data.form);
							}else{
								$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
								$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
							}
							$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
								{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
							);
							addDataKeGridObat(obj,'racik',rke);
							renameInputRowObatAlkes($("#table-obatalkespasien"));                    
							hitungTotal();
						}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
					$('#table-obatalkespasien > tbody > tr').each(function(){
						if($(this).find('input[name*="[rke]"]').val()==rke){
							if (marginrke==0) {
								if(statusmargin==0){
									marginrke=jmlrke;
									statusmargin = 1;
								}
							};
							indexrke++;
						}
						jmlrke++;
					});

					if(tambahkandetail){
						if (indexrke==0) {
								$('#table-obatalkespasien > tbody').append(data.form);
						}else{
							$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
							$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
						}
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
						addDataKeGridObat(obj,'racik',rke);
						renameInputRowObatAlkes($("#table-obatalkespasien"));                    
						hitungTotal();
					}
				}
                
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();  
	setTombolRacikanBaru();
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signaracikan').val();
		var iterRacik = $('#iter').val();
        var permintaan = $(obj).parents('fieldset').find('#permintaan').val();
        var kemasan = $(obj).parents('fieldset').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('fieldset').find('#kekuatanObat').val();
        var etiket = $(obj).parents('fieldset').find('#etiketracikan').val();
        var satuansediaan = $(obj).parents('fieldset').find('#satuansediaan').val();
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterRacik);
		var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuansediaan]"]');
        input_satuansediaan.val(satuansediaan);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa').val();
		var iterNonRacik = $('#iter').val();
		var etiket = $(obj).parents('fieldset').find('#etiketnonracikan').val();
		
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterNonRacik);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		
        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}


function tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket){
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
        data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
                return false;
            }
            var tambahkandetail = true;
            var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
            if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                function(r){
                    if(r){
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                            $(this).parents('tr').detach();
                        });
                    }else{
                        tambahkandetail = false;
                    }
                }); 
            }
            $('#table-obatalkespasien > tbody > tr').each(function(){
                if($(this).find('input[name*="[rke]"]').val()==rke){
                    if (marginrke==0) {
                        if(statusmargin==0){
                            marginrke=jmlrke;
                            statusmargin = 1;
                        }
                    };
                    indexrke++;
                }
                jmlrke++;
            });

            if(tambahkandetail){
                if (indexrke==0) {
                        $('#table-obatalkespasien > tbody').append(data.form);
                }else{
                    $('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
                    $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
                }
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                );
                addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke);
                renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                hitungTotal();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke){
    input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
    input_signa.val(signa);
    input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
    input_permintaan.val(permintaan);
    input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
    input_kemasan.val(kemasan);
    input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
    input_kekuatan.val(kekuatan);
    input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
    input_rke.val(rke);
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
            
            
            $(".ruangandokter_id").val(data.ruangan_id);
            $.fn.yiiGridView.update("pegawaiYangMengajukan-m-grid", {data: $("#dialogDokter :input").serialize()});
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
            "FAPasienM[idInstalasi]":instalasi_id,
            // "FAPasienM[instalasi_nama]":instalasi_nama,
        }
    });
}

/**
 * menghapus detail obat alkes pasien berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalObatAlkesPasienDetail(obj){
    myConfirm("Apakah anda akan membatalkan penjualan obat alkes ini?","Perhatian!",
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
        }
    }); 
}
//TIDAK DIGUNAKAN ?
function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    
    totaliurbiaya = ((harga*qty) - ((harga*qty) * (diskon/100)));
    iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
        
    subtotal = $(obj).parents('tr').find('input[name$="[hargajual_oa]"]');
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    if(totaliurbiaya <=0 ){
        totaliurbiaya = 0;
    }
    
    if(totalsubtotal <= 0){
        totalsubtotal = 0;
    }
    
    subtotal.val(totalsubtotal);
    iurbiaya.val(totaliurbiaya);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
    totalharganetto = 0;
    totalhargajual = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalhargajual += parseFloat($(this).find('input[name*="[hargajual_oa]"]').val());
    });
    
    
    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
    
    formatNumberSemua();
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
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * set form obat dari reseptur detail
 * @returns {undefined}
 */
function setFormObatReseptur(){
    $('#tabel-detailreseptur tbody').find('tr').each(function(){
        var obatalkes_id = $(this).find('input[name*="[obatalkes_id]"]').val();
        var signa = $(this).find('input[name*="[signa_reseptur]"]').val();
        var permintaan = $(this).find('input[name*="[permintaan_reseptur]"]').val();
        var kemasan = $(this).find('input[name*="[jmlkemasan_reseptur]"]').val();
        var kekuatan = $(this).find('input[name*="[kekuatan_reseptur]"]').val();
        var jumlah = $(this).find('input[name*="[qty_reseptur]"]').val();
        var rke = $(this).find('input[name*="[rke]"]').val();
        var etiket = $(this).find('input[name*="[etiket]"]').val();
        var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket);
    });
}

function cekObat(){
    if(requiredCheck($("form"))){
        if ($("#FAPenjualanResepT_pegawai_id").val() == "") {
            alert("Dokter harus diisi");
            return false;
        }
        var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
        if(jumlah_obat <= 0){
                myAlert('Isikan obat alkes terlebih dahulu.');
            return false;
        }else{
            $('#penjualanresep-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}
/**
 * ubah takaran resep
 * @returns {undefined}
 */
function ubahTakaranResep(obj){
	var takaran = $(obj).val();
	var takarantext = $(obj).find("[value='"+takaran+"']").text();
	myConfirm('Proses perhitungan takaran resep hanya bisa dilakukan satu kali. Apakah anda ingin mengubah takaran semua obat menjadi '+takarantext+' dari resep?', 'Perhatian!', function(r){
		if(r){
			proporsiTakaranResep(takaran);
			$(obj).attr('readonly',true);
			$(obj).click(function(){
				$('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>').focus();
			});
		}else{
			$(obj).val(1);
		}
	});
}

/**
 * menghitung proporsi semua obat berdasarkan takaran
 * @returns {undefined}
 */
function proporsiTakaranResep(takaran){
	$('#table-obatalkespasien > tbody').addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetProporsiTakaranResep'); ?>',
		data: {takaran : takaran, data:$("input[name*='FAObatalkesPasienT']").serialize()},//
		dataType: "json",
		success:function(data){
			$('#table-obatalkespasien > tbody tr').detach();
			$('#table-obatalkespasien > tbody').append(data.form);
			renameInputRowObatAlkes($("#table-obatalkespasien"));                    
			hitungTotal();
			$('#table-obatalkespasien > tbody').removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}


function terapiobat_reset(){
	$("#form-nonracikan").addClass("animation-loading");
	var ruangantujuan_id = $('#ruanganapotek_id').val();
		$('#therapiobat_id').val('');
		$('#therapiobat_nama').val('');
		$('#FAObatAlkesM_therapiobat_id').val('');
		clearInputan();
		$('#ruanganapotek_id').val($('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val());
	setTimeout(function(){
		$("#form-nonracikan").removeClass("animation-loading");
	},500);
}

function clearInputan()
{
    $('#obatalkes_id').val('');
    $('#obatalkes_kode').val('');
    $('#ruanganapotek_id').val('');
    $('#namaObatNonRacik').val('');
	$('#therapiobat_id2').val('');
}

// function untuk men set dialog oa agar berelasi dengan therapiobatmap_m
function setOAJoinTerapi(){
	var therapiobat_id = $('#therapiobat_id').val();
	$("#namaObatNonRacik").addClass("animation-loading-1");
		$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
			data: {
				"FAObatAlkesM[therapiobat_id]":therapiobat_id,
			}
		});
	setTimeout(function(){
		$("#namaObatNonRacik").removeClass("animation-loading-1");
	},500);
}

$('#tombolDialogOa').click(function(){
	var therapiobat_id = $('#therapiobat_id').val();
	$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
		data: {
			"FAObatalkesM[therapiobat_id]":therapiobat_id,
		}
	});
});
function setThreapiobat_id(obatalkes_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setTherapiobatid'); ?>',
		data: {obatalkes_id : obatalkes_id},//
		dataType: "json",
		success:function(data){
			if(data){
				$("#therapiobat_id2").val(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function formjenisresep(jenisresep){
	$(".formjenisresep").addClass("animation-loading");
	setTimeout(function(){
		if(jenisresep==1){
			$("#form-nonracikan").hide();
			$("#form-racikan").show();
		}else{
			$("#form-nonracikan").show();
			$("#form-racikan").hide();
		}
		$(".formjenisresep").removeClass("animation-loading");
	},500);
}

function hitungJumlahObat(){
        unformatNumberSemua();
	$("#qtyRacik").addClass("animation-loading-1");
	var jmlkemasanobat = $('#jmlKemasanObat').val();
	var permintaan = $('#permintaan').val();
	var kekuatanobat = $('#kekuatanObat').val();
	setTimeout(function(){
		if((jmlkemasanobat != '')&&(permintaan != '')&&(kekuatanobat != '')){
			var jmlobat = permintaan*jmlkemasanobat/kekuatanobat;
			$("#tomboltambahracikan").attr("disabled",false);
		}else{
			var jmlobat = 0;
			$("#tomboltambahracikan").attr("disabled",true);
		}
		$("#qtyRacik").val(jmlobat);
		$("#qtyRacik").removeClass("animation-loading-1");
	},500);
        
}

function setTombolRacikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',false);
		$("#racikanKe").attr('disabled',true);
		$("#signaracikan").attr('disabled',true);
		$("#etiketracikan").attr('disabled',true);
		$("#jmlKemasanObat").attr('disabled',true);
		$("#satuansediaan").attr('disabled',true);
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function racikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',true);
		$("#racikanKe").attr('disabled',false);
		$("#signaracikan").attr('disabled',false);
		$("#etiketracikan").attr('disabled',false);
		$("#jmlKemasanObat").attr('disabled',false);
		$("#satuansediaan").attr('disabled',false);
		$("#jmlKemasanObat").val('');
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		setDropDownRke();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function setDropDownRke(){
	var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownRke'); ?>',
		data: {rmax : rmax++},//
		dataType: "json",
		success:function(data){
			$('#racikanKe').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function hitungPecahanDosisRacikan() {
    var pembilang = $("#dosis_pembliang").val();
    var penyebut = $("#dosis_penyebut").val();
    var kekuatan = $("#kekuatanObat").val();
    var hasil = 0;
    
    if (penyebut == 0) {
        myAlert("Penyebut tidak boleh 0.");
        return false;
    }
    
    if (kekuatan.trim() == "") {
        myAlert("Kekuatan obat belum ada.");
        return false;
    }
    
    hasil = Math.round((pembilang / penyebut) * kekuatan);
    
    $("#dosis_pembliang").val("");
    $("#dosis_penyebut").val("");
    
    $("#permintaan").val(hasil).blur();
    $("#dialogPecahanDosis").dialog("close");
}



/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-obatalkespasien")); 
    hitungTotal();
    var seconds = 0;
    setInterval(function()
    {
        seconds++;
        if(seconds >= 999999) {
            seconds = 0;
        }
        $('#<?php echo CHtml::activeId($modPenjualan,"lamapelayanan") ?>').val(seconds);
    }, 1000);
    
    <?php if(isset($_GET['reseptur_id'])){ ?>
    var reseptur_id = <?php echo isset($_GET['reseptur_id'])?$_GET['reseptur_id']:'' ?>;
    var pendaftaran_id = <?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran_id:'' ?>;

    if(reseptur_id != ''){
        if(pendaftaran_id != ''){
            setInfoPasien(pendaftaran_id,'','','');
            setFormObatReseptur();
        }
    }
    <?php } ?>
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

    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPenjualan->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
	formjenisresep(0); // load awal form non racikan yang dimunculkan
});
// function cekInput(){
//     var kosong = 0;
//     if($('#pendaftaran_id').val()==''){
//         myAlert('Input data pasien terlebih dahulu');
//         kosong++;
//     }
//     if($('#<?php // echo CHtml::activeId($modPenjualan,"pegawai_id");?>').val()==''){
//         myAlert('Input data dokter reseptur terlebih dahulu');
//         kosong++;
//     }
//     if(kosong>0){
//         return false;
//     }else{
//         return true;
//     }
// }
</script>