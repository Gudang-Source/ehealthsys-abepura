<?php 
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

<script type="text/javascript">

function ubahTeksBKM(no, tgl) {
	$("#BuktikasmasukT_keterangan_pembayaran").val("Pengajuan Potongan - " + no + " - " + tgl);
}


function cekSemua() {
	$(".check").prop("checked", $("#cekSemua").is(":checked"));
	hitungAngsuran();
}

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BuktikasmasukT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}


$("#btn-cari").click(function() {
	$.fn.yiiGridView.update('permintaan-m-grid', {data:$("#panel-pencarian :input").serialize()});
});

function hitungAngsuran() {
	$("#permintaan-m-grid > table > tbody > tr").each(function() {
		var wajib = parseFloat($(this).find(".wajib").val());
		var sukarela = parseFloat($(this).find(".sukarela").val());
		var jmlpokok = parseFloat($(this).find(".jmlpokok").val());
		var jmljasa = parseFloat($(this).find(".jmljasa").val());
		var jmlpengajuan = parseFloat($(this).find(".jmlpengajuan").val())
		var denda = parseFloat(unformatNumber($(this).find(".denda").val()));
		
		//$(this).find(".subtotal").val(formatNumber(wajib + sukarela + jmlpokok + jmljasa + denda));
		if ($(this).find(".check").is(":checked")) $(this).find(".subtotal").val(formatNumber(jmlpengajuan + denda));
		else $(this).find(".subtotal").val(0);
	});
	
	hitungBKM();
}

function hitungBKM() {
	var total = 0;
	$(".subtotal").each(function() {
		if ($(this).parent().parent().find(".check").is(":checked"))
			total += parseFloat(unformatNumber($(this).val()));
	});
	
	var admin = parseFloat(unformatNumber($("#BuktikasmasukT_biayaadministrasi").val()));
	$("#BuktikasmasukT_jmlpembayaran").val(formatNumber(total));
	$("#BuktikasmasukT_uangditerima").val(formatNumber(admin + total));
	$("#BuktikasmasukT_uangkembalian").val(0);
}

function registerNum() {
	$("#permintaan-m-grid .num:text").each(function() {
		$(this).maskMoney({
			defaultZero:true,
			allowZero:true,
			thousands:'',
			thousands:'.',
			precision:0
		});
	});
	$(".denda").blur(hitungAngsuran);
	$(".check").change(hitungAngsuran);
	$("#cekSemua").change(cekSemua);
}

function cekValidasi() {
	return true;
}

$("#BuktikasmasukT_biayaadministrasi").blur(hitungBKM);
$("#BuktikasmasukT_uangditerima").blur(function() {
	var total = parseFloat(unformatNumber($("#BuktikasmasukT_jmlpembayaran").val()));
	var admin = parseFloat(unformatNumber($("#BuktikasmasukT_biayaadministrasi").val()));
	var terima = parseFloat(unformatNumber($("#BuktikasmasukT_uangditerima").val()));
	
	$("#BuktikasmasukT_uangkembalian").val(formatNumber(terima - (total + admin)));
});
$("#cekSemua").change(cekSemua);



</script>