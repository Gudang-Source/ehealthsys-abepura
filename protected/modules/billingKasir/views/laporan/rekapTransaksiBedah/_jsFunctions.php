<script type="text/javascript">
	function checkPilihan(event){
		var namaPeriode = $('#PeriodeName').val();

		if(namaPeriode == ''){
			myAlert('Pilih Kategori Pencarian');
			event.preventDefault();
			$('#dtPicker3').datepicker("hide");
			return true;
			;
		}
	}
	
	function setPeriode(){
		namaPeriode = $('#PeriodeName').val();

			$.post('<?php echo $this->createUrl('GantiPeriode'); ?>',{namaPeriode:namaPeriode},function(data){
				$('#BKLaporanrekaptransaksiV_tgl_awal').val(data.periodeawal);
				$('#BKLaporanrekaptransaksiV_tgl_akhir').val(data.periodeakhir);
				$('#PPRuanganM_tgl_awal').val(data.periodeawal);
				$('#PPRuanganM_tgl_akhir').val(data.periodeakhir);
			},'json');
	}

	function tab(index){
		$(this).hide();
		if (index==0){
			$("#filter_tab").val('global');
			$("#div_global").show();
			$("#div_ugd").hide();
			$("#div_rj").hide();        
			$("#div_ri").hide();        
		} else if (index==1){
			$("#filter_tab").val('ugd');
			$("#div_global").hide();
			$("#div_ugd").show();
			$("#div_rj").hide();
			$("#div_ri").hide();
		} else if (index==2){
			$("#filter_tab").val('rj');
			$("#div_global").hide();
			$("#div_ugd").hide();
			$("#div_rj").show();  
			$("#div_ri").hide();  
		} else if (index==3){
			$("#filter_tab").val('ri');
			$("#div_global").hide();
			$("#div_ugd").hide();
			$("#div_rj").hide();        
			$("#div_ri").show();        
		}
	}
	function onReset()
	{
		setTimeout(
			function(){
				$.fn.yiiGridView.update('laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});
				$.fn.yiiGridView.update('ugd_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});
				$.fn.yiiGridView.update('rj_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});        
				$.fn.yiiGridView.update('ri_laporanrekaptransaksi-grid', {
					data: $("#caripasien-form").serialize()
				});        
			}, 2000
		);
		return false;
	}   

	$(document).ready(function() {
		$("#tabmenu").children("li").children("a").click(function() {
			$("#tabmenu").children("li").attr('class','');
			$(this).parents("li").attr('class','active');
			$(".icon-pencil").remove();
			$(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
		});

		$("#div_global").show();
		$("#div_ugd").hide();
		$("#div_rj").hide();
		$("#div_ri").hide();
	});
</script>