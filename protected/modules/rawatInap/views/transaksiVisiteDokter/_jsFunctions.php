<script type="text/javascript">

function searchVisite()
{
	//unformatNumberSemua();
    var pegawai_id = $('#<?php echo CHtml::activeId($model, "pegawai_id"); ?>').val();
    var pilih = $('#<?php echo CHtml::activeId($model,'is_dokter'); ?>');

//	if($(obj).is(':checked')){
//		if(nama_pegawai == ''){
//			myAlert('Pilih Dokter terlebih dahulu !');
//			$(obj).attr('checked', false);
//			pilih.val(0);
//		}
//		pilih.val(1);
//	}else{
//		pilih.val(0);
//	}
			if(pegawai_id ==''){
				myAlert('Isi yang bertanda bintang!');
				return false;
			}else{
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('LoadFormVisiteDokter'); ?>',
				data: {pegawai_id:pegawai_id},
				dataType: "json",
				success:function(data){
					if(data.pesan !== ""){
						myAlert(data.pesan);
						return false;
					}
					$('#table-visite > tbody').html(data.form);

				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
			}
		
}
</script>
