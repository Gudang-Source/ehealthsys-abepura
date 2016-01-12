<script type="text/javascript">
/**
 * memanggil antrian ke poliklinik
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            if(data.smspasien==0){
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                insert_notifikasi(params);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:pendaftaran_id});
            <?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function ubahKasusPenyakit(obj,pendaftaran_id, jeniskasuspenyakit_id){
	var pendaftaran_id = pendaftaran_id;
	var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
			$(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
			$(obj).parents('td').find('.kasus_penyakit').hide();			
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}

function saveKasusPenyakit(obj,pendaftaran_id){
	var jeniskasuspenyakit_id = $(obj).val();
	var pendaftaran_id = pendaftaran_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
		   if(data.pesan == 'berhasil'){
				myAlert('Data Kasus Penyakit berhasil di ubah');
				$.fn.yiiGridView.update('daftarpasien-v-grid', {
					data: $(this).serialize()
				});
		   }else{
			   myAlert('Data Kasus Penyakit gagal di ubah');
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}
/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePoliklinik/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

function ubahDokterPeriksa(pendaftaran_id)
{
    $('#temp_idPendaftaranDP').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa')?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
            }else{
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('form').serialize()
                });
                setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}

function setStatus(obj,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
    
    myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pendaftaran_id:pendaftaran_id}, function(data){
                if(data.status == 'proses_form'){
					$('#dialogUbahStatusPasien div.divForForm').html(data.div);
					$.fn.yiiGridView.update('daftarpasien-v-grid');
					setTimeout("$('#dialogUbahStatus').dialog('close')",1000);
                }else{
                    $('#alertDiv').show(); 
                }
            }, 'json');
        }else{
			preventDefault();
        }
    });    
}
</script>