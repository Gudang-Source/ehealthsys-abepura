<script type="text/javascript">
	function setLookup(lookup_type){
		$("#table-lookup").addClass("animation-loading");
		$('#table-lookup > tbody').html("");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('GetLookup'); ?>',
			data: {intervensi_id : intervensi_id},//
			dataType: "json",
			success:function(data){
				$('#table-lookup > tbody').append(data.form);
				jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				renameInputRow($("#table-lookup"));
				$(".integer").maskMoney(
			        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			    );
				$("#table-lookup").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}

	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
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

		//====button visibility
		//init
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
		$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj_table).find('tbody tr').length;
		if(rowCount==1){
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
			if(id!=""){
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

	function hapusLookup(obj){
		var intervensidet_id = $(obj).parents("tr").find("input[name$='[intervensidet_id]']").val();
		if(intervensidet_id !== ""){
			myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
			function(r){
				if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('Delete'); ?>&id='+intervensidet_id,
						data: {id : intervensidet_id},//
						dataType: "json",
						success:function(data){
							if(data.sukses == 1){
								$(obj).parents('tr').detach();
								renameInputRow($("#table-lookup"));
							}
							myAlert(data.pesan);
							var rowCount = $("#table-lookup").find('tbody tr').length;
							if(rowCount==0){
								tambahLookup();
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
			});
		}else{
			$(obj).parents('tr').detach();
			renameInputRow($("#table-lookup"));
		}
	}

	function tambahLookup(){
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view. '_rowLookup',array('model'=>$modDetail),true));?>'
		$('#table-lookup').append(row);
		renameInputRow($("#table-lookup"));
		$("#table-lookup tr:last .integer").maskMoney(
	        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
	    );
	}
	
	function cek(obj) {
		if ($(obj).is(':checked')) {
			$(obj).parents("tr").find("input[name$='[intervensidet_aktif]']").val(1);
		} else {
			$(obj).parents("tr").find("input[name$='[intervensidet_aktif]']").val(0);
		}
	}

	function refreshTable() {
		var diagnosakep_id = $("#<?php echo CHtml::activeId($model, 'diagnosakep_id') ?>").val();
		var intervensi_nama = $("#<?php echo CHtml::activeId($model, 'intervensi_nama') ?>").val();

		if (diagnosakep_id !== '' && intervensi_nama !== '') {
			$('#table-lookup').addClass('animation-loading');

			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('getLookup'); ?>',
				data: {diagnosakep_id: diagnosakep_id, intervensi_nama: intervensi_nama},
				dataType: "json",
				success: function (data) {
					$("#table-lookup > tbody").find('tr').detach();
					$("#table-lookup > tbody").append(data.form);
					$('#table-lookup').removeClass('animation-loading');
					renameInputRow($("#table-lookup"));
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	$(document).ready(function(){
		tambahLookup();
		<?php if(!empty($model->intervensidet_id)){ ?>
				setLookup('<?php echo $model->intervensi_id; ?>');
		<?php } ?>
		
		<?php if(!empty($model->intervensi_id)){ ?>
				refreshTable();
		<?php } ?>
	})


</script>