<?php

$urlPinjaman = $this->createUrl('index');
//$urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getPeminjamAnggota');

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

$(".num").each(function() {
	if ($(this).val() == '') $(this).val(0);
});

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

?>

<script>

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BukitkaskeluarT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}

function hitungBKK() {
	var total = parseFloat($("#total_simpanan").val());
	var admin = parseFloat(unformatNumber($("#BukitkaskeluarT_biayaadministrasi").val()));
	var materai = parseFloat(unformatNumber($("#BukitkaskeluarT_biayaamaterai").val()));

	$("#BukitkaskeluarT_jmlkaskeluar").val(formatNumber(total - (admin - materai)));
}
</script>

<?php if ($kaskeluar->isNewRecord) : ?>
<script>

hitungBKK();

</script>
<?php endif; ?>
