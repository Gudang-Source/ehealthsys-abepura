<script>
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
            $(this).attr('name','cekList['+noUrut+']');
            $(this).parent().parent().find('input[name*="[pasien_id]"]').attr('name','Dokumen[pasien_id]'+'['+noUrut+']');
            $(this).parent().parent().find('input[name*="[tgl_rekam_medik]"]').attr('name','Dokumen[tgl_rekam_medik]'+'['+noUrut+']');
            $(this).parent().parent().find('input[name*="[pendaftaran_id]"]').attr('name','Dokumen[pendaftaran_id]'+'['+noUrut+']');
            $(this).parent().parent().find('input[name*="[no_rekam_medik]"]').attr('name','Dokumen[no_rekam_medik]'+'['+noUrut+']');
            $(this).parent().parent().find('input[name*="[ruangan_id]"]').attr('name','Dokumen[ruangan_id]'+'['+noUrut+']');
            $(this).parent().parent().find('select[name*="[warnadokrm_id]"]').attr('name','Dokumen[warnadokrm_id]'+'['+noUrut+']');
            $(this).parent().parent().find('input[name*="[kelengkapandokumen]"]').attr('name','Dokumen[kelengkapandokumen]'+'['+noUrut+']');
           noUrut++;
        });
    }
    
    $(document).ready(function(){
        $('form#ppdokrekammedis-m-form').submit(function(){
            var jumlah = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    $(this).parent().parent().find('input[name*="[pasien_id]"]').attr('name','Dokumen[pasien_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[tgl_rekam_medik]"]').attr('name','Dokumen[tgl_rekam_medik]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[pendaftaran_id]"]').attr('name','Dokumen[pendaftaran_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[no_rekam_medik]"]').attr('name','Dokumen[no_rekam_medik]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[ruangan_id]"]').attr('name','Dokumen[ruangan_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('select[name*="[warnadokrm_id]"]').attr('name','Dokumen[warnadokrm_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[kelengkapandokumen]"]').attr('name','Dokumen[kelengkapandokumen]'+'['+jumlah+']');
                    jumlah++;
                }else{
                    $(this).parent().parent().find('input[name*="[pasien_id]"]').attr('name','Dokumen[pasien_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[tgl_rekam_medik]"]').attr('name','Dokumen[tgl_rekam_medik]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[pendaftaran_id]"]').attr('name','Dokumen[pendaftaran_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[no_rekam_medik]"]').attr('name','Dokumen[no_rekam_medik]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[ruangan_id]"]').attr('name','Dokumen[ruangan_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('select[name*="[warnadokrm_id]"]').attr('name','Dokumen[warnadokrm_id]'+'['+jumlah+']');
                    $(this).parent().parent().find('input[name*="[kelengkapandokumen]"]').attr('name','Dokumen[kelengkapandokumen]'+'['+jumlah+']');
                    jumlah++; 
                }
                
            });
            if (jumlah < 1){
                myAlert('Pilih Dokumen yang akan dikirim');
                return false;
            }
            else if ($('#<?php echo CHtml::activeId($modDokRekamMedis, 'statusrekammedis'); ?>').val() == ''){
                myAlert('Isi Status Rekam Medis');
                return false;
            }
        });
        setUrutan();
    });
    
    function cekInputan(){
		if(requiredCheck($("form"))){
			var kosong=0;
			$('.cekList').each(function(){
				if ($(this).is(':checked')){
					var warnadokumen = $(this).parents("tr").find('select[name*="[warnadokrm_id]"]').val();
					if(warnadokumen == ''){
						kosong++;
					}
				}            
			});
			
			if(kosong > 0){
				myAlert('Isi Warna Dokumen Rekam Medis');
				return false;
			}else{
				$('#ppdokrekammedis-m-form').submit();
			}
			
			$(".animation-loading").removeClass("animation-loading");
			$("form").find('.float').each(function(){
				$(this).val(formatFloat($(this).val()));
			});
			$("form").find('.integer').each(function(){
				$(this).val(formatInteger($(this).val()));
			});			
		}
		return false;
    }
	
</script>