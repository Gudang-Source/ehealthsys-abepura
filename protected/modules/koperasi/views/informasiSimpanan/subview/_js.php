<?php $js = <<<'EOF'

$(".num").each(function() {
	$(this).maskMoney({
		defaultZero:true,
		allowZero:true,
		thousands:'',
		thousands:'.',
		precision:0
	});
});

$(".num").each(function() {
	if ($(this).val() == '') $(this).val(0);
});

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

$urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo');
$urlSimpanan = Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNoSimpanan');
$url = $this->createUrl('index');
?>

<script type="text/javascript">

function loadAnggotaAjax(no) {
  $.get('<?php echo $urlAnggota; ?>', {term:no}, function(data) {
		loadAnggotaPegawai(data[0].attr);
	}, 'json');
}
function loadAnggotaPegawai(item) {
	$("#KartusimpanananggotaV_nokeanggotaan").val(item.nokeanggotaan);
	//$("#KartusimpanananggotaV_nosimpanan").val(item.pegawai.simpanan.nosimpanan);
	$("#KartusimpanananggotaV_nama_pegawai").val(item.pegawai.nama_pegawai);
	if (item.pegawai.unit != null) $("#KartusimpanananggotaV_unit_id").val(item.pegawai.unit.unit_id);
	else $("#KartusimpanananggotaV_unit_id").val('');
	if (item.pegawai.golonganpegawai != null) $("#KartusimpanananggotaV_golonganpegawai_id").val(item.pegawai.golonganpegawai.golonganpegawai_id);
	else $("#KartusimpanananggotaV_golonganpegawai_id").val('');
}
function loadSimpananAjax(no) {
  $.get('<?php echo $urlSimpanan; ?>', {term:no}, function(data) {
		loadSimpananPegawai(data[0].attr);
	}, 'json');
}
function loadSimpananPegawai(item) {
	$('input:checkbox').attr("checked",false);
	$("#KartusimpanananggotaV_nokeanggotaan").val(item.nokeanggotaan);
	$("#KartusimpanananggotaV_nosimpanan").val(item.nosimpanan);
	$("#KartusimpanananggotaV_nama_pegawai").val(item.nama_pegawai);
	//$('input[name="KartusimpanananggotaV[jenissimpanan_id][]"]').attr("checked",false);
	var jenissimpanan_id = item.jenissimpanan_id;
	if (jenissimpanan_id !=null)
	{
		setInterval(function(){
			$('input[name="KartusimpanananggotaV[jenissimpanan_id][]"][value="'+jenissimpanan_id+'"]').attr("checked",true);
		}, 1000);
	}//else
	//$('input[name="KartusimpanananggotaV[jenissimpanan_id][]"][value='jenisimpanan_id']').attr("checked",true);

	if (item.pegawai.unit != null) $("#KartusimpanananggotaV_unit_id").val(item.unit_id);
	else $("#KartusimpanananggotaV_unit_id").val('');
	if (item.pegawai.golonganpegawai != null) $("#KartusimpanananggotaV_golonganpegawai_id").val(item.golonganpegawai_id);
	else $("#KartusimpanananggotaV_golonganpegawai_id").val('');
}
</script>
