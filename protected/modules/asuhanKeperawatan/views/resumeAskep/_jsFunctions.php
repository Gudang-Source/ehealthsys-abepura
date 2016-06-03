<script type="text/javascript">
	
	function loadDiagnosaMedis(pasien_id)
	{
		if (pasien_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadDiagnosaMedis'); ?>',
				data: {pasien_id: pasien_id},
				dataType: "json",
				success: function (data) {
					console.log(data);
					$('#ASDiagnosaM_diagnosa_nama').val(data.diagnosa_nama);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadDiagnosaTindakanKeperawatan(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadDiagnosaTindakanKeperawatan'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					console.log(data);
					$('#ASResumeaskepR_tindakankeperawatan').val(data.tindakankeperawatan);
					$('#ASResumeaskepR_diagnosakeperawatan').val(data.diagnosakeperawatan);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	
</script>