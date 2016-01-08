<script type="text/javascript">
	function getRuanganForCheckBox(obj){
		var instalasi_id = obj.value;
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('getRuanganForCheckBox'); ?>',
			data: {instalasi_id:instalasi_id},
			dataType: "json",
			success:function(data){
				$('#ruangan > #tabel-ruangan > tbody').html(data.form);
				$("#ruangan > #tabel-ruangan > tbody").find('.integer').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
				$("#ruangan > #tabel-ruangan > tbody").find('.all-caps').keyup(function() {
					var allcaps = $(this).val().toUpperCase();
					$(this).val(allcaps);
					
					var searchTerm = $(this).parents('tr').find("input[name*='shiftygdiperbolehkan']").val();
					var pola = $(this).val();
					var originalPola = pola;
					var formasi = new RegExp("["+searchTerm+"]*","g");
					var formasi_new = new RegExp("[^"+searchTerm+"].*","g");
					pola = pola.replace(formasi, "");
					var msg = "Inputkan Pola berdasarkan Shift";
					
					if (pola != '') {
						originalPola = originalPola.replace(formasi_new, "")
						$(this).val(originalPola);
					}
				});
//				renameInput($("#tabel-ruangan")); 
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	
	function checkSemua(obj){
		if($("#check_all").is(':checked')){
			 $("#tabel-ruangan tbody tr").find("input[name*='pilihruangan'][type='checkbox']").each(function(){
				 $(this).attr('checked',true);
			 });
		 }else{
			 $("#tabel-ruangan tbody tr").find("input[name*='pilihruangan'][type='checkbox']").each(function(){
				 $(this).removeAttr('checked');
			 });
		 } 
	 }
	function checkSemuaPegawai(obj){
		if($("#check_semua").is(':checked')){
			$("#tabel-penjadwalan tbody tr").find("input[name*='checklist'][type='checkbox']").each(function(){
				$(this).attr('checked',true);
			});
		}else{
			$("#tabel-penjadwalan tbody tr").find("input[name*='checklist'][type='checkbox']").each(function(){
				$(this).removeAttr('checked');
			});
		} 
	}
	function setNolPegawai(obj){
		if($(obj).is(":checked")){
			obj.value = 1;
		}else{
			obj.value = 0;
		}
	}
	
	function getPenjadwalan(){
		$("#tabel-penjadwalan").addClass("animation-loading");
		var periodebuatjadwal = $('#<?php echo CHtml::activeId($model,'periodebuatjadwal'); ?>').val();
		var sampaidengan = $('#<?php echo CHtml::activeId($model,'sampaidengan'); ?>').val();
		var kelompokpegawai_id = $('#<?php echo CHtml::activeId($model,'kelompokpegawai_id'); ?>').val();
		var instalasi_id = $('#<?php echo CHtml::activeId($model,'instalasi_id'); ?>').val();		
		var pegawai_id = $('#<?php echo CHtml::activeId($model,'pegawai_id'); ?>').val();	//dari autocomplete	
		$('#tabel-ruangan tbody').find('tr').each(function(){
			var checklist = $(this).find('input[name*="pilihruangan"]');
			if(checklist.is(':checked')){
				var ruangan_id = $(this).find('input[name*="[ruangan_id]"]').val();
				var pola_shift = $(this).find('input[name*="[pola_shift]"]').val();
				var jmlpegawais = [];
				var shift_kode = "";
				var i = 0;
				$(this).find('input[name*="[jmlpegawai]"]').each(function(){
					shift_kode = $(this).parent().find('input[name*="[shift_kode]"]').val();
					jmlpegawais[i] = $(this).val();
					i ++;
				});	

				$.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('getPenjadwalan'); ?>',
					data: {
						periodepenjadwalan:periodebuatjadwal, 
						sampaidengan:sampaidengan, 
						kelompokpegawai_id:kelompokpegawai_id, 
						instalasi_id:instalasi_id,
						ruangan_id:ruangan_id, 
						pola_shift:pola_shift, 
						jmlpegawais:jmlpegawais,
						pegawai_id:pegawai_id,
					},
					dataType: "json",
					success:function(data){
						$('#tabel-penjadwalan > tbody').append(data.form);
						$('#tabel-penjadwalan > thead #bulan').removeAttr('rowspan','2');
						$('#tabel-penjadwalan > thead #bulan').attr('colspan',(data.jumlah_hari+1));
						$('#tabel-penjadwalan > thead #bulan-tgl').html(data.kolom_tanggal);
						renameInput($("#tabel-penjadwalan")); 
						$("#tabel-penjadwalan").removeClass("animation-loading");
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
			}
		});
	}
	
	/**
	* rename input grid
	*/ 
	function renameInput(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find('input,select,textarea').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
					$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
				}
			});
			
			//RenameInputShift
			var row_3 = 0;
			$(this).find('select[name*="shift_id"]').parent('td').each(function(){ //element <input>
				var select	= $(this).find('select[name*="shift_id"]');
				var input	= $(this).find('input[name*="tgljadwalpegawai"]');
				var old_name_input = input.attr("name").replace(/]/g,"");
				var old_name_input_arr = old_name_input.split("[");
				
				var old_name_select = select.attr("name").replace(/]/g,"");
				var old_name_select_arr = old_name_select.split("[");
				if(old_name_select_arr.length == 5){
					select.attr("id",old_name_select_arr[0]+"_"+row+"_"+old_name_select_arr[2]+"_"+row_3+"_"+old_name_select_arr[4]);
					select.attr("name",old_name_select_arr[0]+"["+row+"]["+old_name_select_arr[2]+"]["+row_3+"]["+old_name_select_arr[4]+"]");
				}
				if(old_name_input_arr.length == 5){
					input.attr("id",old_name_input_arr[0]+"_"+row+"_"+old_name_input_arr[2]+"_"+row_3+"_"+old_name_input_arr[4]);
					input.attr("name",old_name_input_arr[0]+"["+row+"]["+old_name_input_arr[2]+"]["+row_3+"]["+old_name_input_arr[4]+"]");
				}
				row_3++;
			});
			row++;
		});
	}
	
	 
</script>