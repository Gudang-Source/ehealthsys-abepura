<?php
$url = $this->createUrl('index');
$urlPrint = $this->createUrl('print');
?>
<?php $js = <<<'EOF'

$(".sidebar-collapse > a").click();

EOF;

Yii::app()->clientScript->registerScript('collapser', $js, CClientScript::POS_READY);

?>
<script type="text/javascript">

$("#btn-cari").click(function() {
	$.fn.yiiGridView.update('pengajuanpemotongan-m-grid', {data:$("#panel-pencarian :input").serialize()});
});

function lihatDetail(id) {
	$.post('<?php echo $url; ?>', {ajax:true, f:'detailPinjaman', param:{id:id}}, function(data) {
		$("#detail_pinjaman_body").html(data);
		$("#detail_pinjaman").modal("show");
	});
}

function optionalCheck() {
	var checked = $('#chk').is(":checked");
			$('#KartuangsurananggotaV_a_tglAwal').prop('disabled',!checked);
			$('#KartuangsurananggotaV_a_tglAkhir').prop('disabled',!checked);
			$('#KartuangsurananggotaV_unit_id').prop('disabled',checked);
			$('#KartuangsurananggotaV_golonganpegawai_id').prop('disabled',checked);
			$('#KartuangsurananggotaV_nokeanggotaan').prop('disabled',checked);
			$('#KartuangsurananggotaV_nama_anggota').prop('disabled',checked);
			$('#KartuangsurananggotaV_no_pinjaman').prop('disabled',checked);
			//$('#KartuangsurananggotaV_status_pinjaman').prop('disabled',checked);
}

function iPrint() {
	var url = ($("#informasi-kartuangsuran-form").serialize()).split('&');
	url.shift();
	url = url.join('&');
	window.open('<?php echo $urlPrint; ?>&' + url, '_blank');
}
</script>