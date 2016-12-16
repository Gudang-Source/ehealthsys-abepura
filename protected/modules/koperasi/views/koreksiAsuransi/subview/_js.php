<?php
$url = $this->createUrl('index');
$urlAC = Yii::app()->createUrl('ajaxAutoComplete/getPemohonPinjamanApprove');

$js = <<<'EOF'

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

?>

<script type="text/javascript">

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BukitkaskeluarT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}

function hitungKasKeluar() {
	var tot = 0;
	$("#peminjam-m-grid > table > tbody > tr").each(function() {
		if ($(this).find(".checker").is(":checked")) tot += parseFloat(unformatNumber($(this).find(".biaya").html()));
	});

	$("#BukitkaskeluarT_jmlkaskeluar").val(formatNumber(tot));
}

function pilihSemua() {
	$(".checker").prop("checked", $("#check_all").is(":checked"));
	hitungKasKeluar();
}

function cekValidasi() {
	if ($(".checker").length == 0) {
		alert("Peminjam belum ditampilkan.");
		return false;
	}

	isCheck = false;
	$(".checker").each(function() {
		if ($(this).is(":checked")) isCheck = true;
	});

	if (!isCheck) {
		alert("Peminjam belum dipilih.");
		return false;
	}

	if ($("#BukitkaskeluarT_namapenerima").val().trim() == '') {
		alert("Nama Penerima harus diisi.");
		return false;
	}
	if ($("#BukitkaskeluarT_alamatpenerima").val().trim() == '') {
		alert("Alamat Penerima harus diisi.");
		return false;
	}

	return true;
}

$("#btn-cari").click(function() {
	$.fn.yiiGridView.update('peminjam-m-grid', {data:$("#panel-pencarian :input").serialize()});
});

</script>

<?php if (empty($kaskeluar->bukitkaskeluar)) :?>
<script type="text/javascript">
	hitungKasKeluar();
</script>
<?php endif; ?>
