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
	loadPengurus(id, nama, "#BuktikasmasukT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}

function hitungBKM() {
  var jumlah = parseFloat(unformatNumber($("#BuktikasmasukT_jmlpembayaran").val()));
  var admin = parseFloat(unformatNumber($("#BuktikasmasukT_biayaadministrasi").val()));
  var materai = parseFloat(unformatNumber($("#BuktikasmasukT_biayamaterai").val()));

  $("#BuktikasmasukT_uangditerima").val(formatNumber(jumlah + admin + materai));
  $("#BuktikasmasukT_uangkembalian").val(0);
}

function hitungKembalian() {
  var jumlah = parseFloat(unformatNumber($("#BuktikasmasukT_jmlpembayaran").val()));
  var admin = parseFloat(unformatNumber($("#BuktikasmasukT_biayaadministrasi").val()));
  var materai = parseFloat(unformatNumber($("#BuktikasmasukT_biayamaterai").val()));
  var bayar = parseFloat(unformatNumber($("#BuktikasmasukT_uangditerima").val()));

  $("#BuktikasmasukT_uangkembalian").val(formatNumber(bayar - (jumlah + admin + materai)));
}

$(".bkm").blur(hitungBKM);
$(".bayar").blur(hitungKembalian);
</script>

<?php if ($kasmasuk->isNewRecord) : ?>
<script>

hitungBKM();

</script>
<?php endif; ?>
