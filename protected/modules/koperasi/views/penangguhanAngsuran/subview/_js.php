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
$(".num-des").each(function() {
	$(this).maskMoney({
		defaultZero:true,
		allowZero:true,
		decimal:',',
		thousands:'.',
		precision:2
	});
});

$(".num, .num-des").each(function() {
	if ($(this).val() == '') $(this).val(0);
});

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

// $urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo'); 

?>

<script type="text/javascript">

function hitungSisa() {
	var angsuran = parseFloat(unformatNumber($("#PermohonanpenangguhanT_jumlahpinjaman").val()));
	var sanggup = parseFloat(unformatNumber($("#PermohonanpenangguhanT_kesanggupanbayar").val()));
	
	if (sanggup > angsuran) sanggup = angsuran;
	$("#PermohonanpenangguhanT_kesanggupanbayar").val(formatNumber(sanggup));
	$("#PermohonanpenangguhanT_sisapinjaman").val(formatNumber(angsuran - sanggup));
}

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BukitkaskeluarT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}

function cekValidasi() {
	
	var dipilih = false;
	$(".check").each(function() {
		if ($(this).is(":checked")) dipilih = true;
	});
	if (!dipilih) {
		alert("Jenis Penangguhan Harus Dipilih");
		return false;
	}
	/*
	if ($("#preparedby").val() == '') {
		alert("Pegawai yang membuatnya harus diisi");
		return false;
	}*/
	
	//alert("Kick");
	//return false;
	
	return true;
}

</script>