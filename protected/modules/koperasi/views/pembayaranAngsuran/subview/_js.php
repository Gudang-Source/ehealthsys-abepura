<?php

$urlPinjaman = $this->createUrl('index');
$urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getPeminjamAnggota');

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
var totalAngsuran = 0;
var totalAngsuranJT = 0;

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BuktikasmasukT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}


function loadPinjamanAjax(id) {
	$.get('<?php echo $urlAnggota; ?>', {term:id, pinjaman:true}, function(data) {
		loadAnggotaPegawai(data[0].attr);
	}, 'json');
}

function loadAnggotaPegawai(item) {
	$("#KeanggotaanV_keanggotaan_id").val(item.anggota.keanggotaan_id);
	$("#KeanggotaanV_nokeanggotaan").val(item.anggota.nokeanggotaan);
	$("#PinjamanT_no_pinjaman").val(item.no_pinjaman);
	$("#KeanggotaanV_nama_pegawai").val(item.anggota.nama_pegawai);
	$("#KeanggotaanV_namaunit").val(item.anggota.namaunit);

	if (item.golonganpegawai != null) $("#status_pegawai").val(item.golonganpegawai.golonganpegawai_nama);
	else $("#status_pegawai").val('');

	if (item.anggota.photopegawai != '')  $("#photo_pegawai").prop('src', item.anggota.photopegawai);
	else $("#photo_pegawai").prop('src', null);
	var ket = '<?php echo $ke; ?>';
	$('#BuktikasmasukT_keterangan_pembayaran').val('Pembayaran Angsuran Ke-'+ ket +' '+ item.no_pinjaman +' - '+ item.tglpinjaman);

	loadAngsuran(item.pinjaman_id, idAngsuran);
}

function loadAngsuran(id, ida) {
	$.post('<?php echo $urlPinjaman ?>', {ajax:true, f:'loadAngsuran', param:{id:id, idAngsuran:ida}}, function(data) {
		$("#content-angsuran").html(data.tab);
		registerCeklis();
		updateAngsuran();
	}, 'json');
}

function updateAngsuran() {
	totalAngsuran = 0;
	totalAngsuranJT = 0;
	//alert("Kick");
	$("#content-angsuran > tr").each(function(){
		var pinjam = parseFloat(unformatNumber($(this).find("input[name*='[jmlpokok_byrangsuran]']").val()));
		var jasa = parseFloat(unformatNumber($(this).find("input[name*='[jmljasa_byrangsuran]']").val()));
		var sisa = parseFloat(unformatNumber($(this).find("input[name*='[sisa]']").val()));
		var bayar = parseFloat(unformatNumber($(this).find("input[name*='[jml_bayar]']").val()));
		var persenDenda = parseFloat(unformatNumber($("#persen_denda").val()));
		var denda = ((pinjam + jasa) * persenDenda)/100;
		//alert(bayar);
		//alert(sisa);
		if ($(this).find("input[type=checkbox]").is(":checked") && $(this).find("input[type=checkbox]").prop('disabled') != true) {
			if ($(this).find("input[name*='[jthTempo]']").val() == 1) {
				$(this).find("input[name*='[jmldenda_byrangsuran]']").val(formatNumber(denda));
				totalAngsuranJT += pinjam + jasa;
				sisa += denda;
			}
			if (bayar > sisa) {
				bayar = sisa;
				$(this).find("input[name*='[jml_bayar]']").val(formatNumber(bayar));
			}

			$(this).find("input[name*='[jmlsisa_pembangsuran]']").val(formatNumber(sisa - bayar));
			totalAngsuran += pinjam + jasa;
		} else {
			$(this).find("input[name*='[jml_bayar]']").val(0);
			$(this).find("input[name*='[jmlsisa_pembangsuran]']").val(0);
		}
	});
	updateKasMasuk();
}

function registerCeklis() {
	$("#content-angsuran input[type=checkbox]").change(updateAngsuran);
	$("#content-angsuran input[name*='[jml_bayar]']").blur(updateAngsuran);

	$("#content-angsuran .num").each(function() {
		$(this).maskMoney({
			defaultZero:true,
			allowZero:true,
			thousands:'',
			thousands:'.',
			precision:0
		});
	});
}

function updateKasMasuk() {
	var total = 0;
	// var totalAngsuran = 0;
	$("input[name*='[jml_bayar]']").each(function() {
		total += parseFloat(unformatNumber($(this).val()));
		$(this).parent().parent().find();
	});
	var admin = total * (parseFloat(unformatNumber($("#persen_admin").val())) / 100);
	var denda = totalAngsuranJT * (parseFloat(unformatNumber($("#persen_denda").val())) / 100);


	$("#BuktikasmasukT_jmlpembayaran").val(formatNumber(total));
	$("#BuktikasmasukT_biayaadministrasi").val(formatNumber(admin));
	$("#BuktikasmasukT_biayadenda").val(formatNumber(denda));

	$("#BuktikasmasukT_uangditerima").val(formatNumber(total + admin + denda));

}

$("#persen_denda, #persen_admin").blur(updateAngsuran);
$("#BuktikasmasukT_uangditerima").blur(function() {
	var total = parseFloat(unformatNumber($("#BuktikasmasukT_jmlpembayaran").val()));
	var admin = parseFloat(unformatNumber($("#BuktikasmasukT_biayaadministrasi").val()));
	var denda = parseFloat(unformatNumber($("#BuktikasmasukT_biayadenda").val()));
	var bayar = parseFloat(unformatNumber($(this).val()));

	$("#BuktikasmasukT_uangkembalian").val(formatNumber(bayar - (total + admin + denda)));
});


// ==============================

function cekValidasi() {
	if ($("#KeanggotaanV_nama_pegawai").val() == '') {
		alert("Anggota Pinjaman Belum Dipilih");
		return false;
	}

	var okCeklis = true;
	$(".cekAngsuran").each(function() {
	if ($(this).is(":checked") && $(this).prop('disabled') != true){
			var jmlByr = $(this).parent().parent().find('.jmlBayar').val();
			if(jmlByr <= 0){
				alert("Jumlah bayar pada angsuran tidak boleh kosong");
				okCeklis = false;
			}
		}
	});

	if (!okCeklis) return false;

	if ($("#BuktikasmasukT_jmlpembayaran").val() == '0') {
		alert("Jumlah bayar tidak boleh kosong");
		return false;
	}

	//alert("Kick");

	return true;
}

var idAngsuran = 0;

</script>

<?php if (!empty($no) && !empty($idAngsuran)) : ?>
<script type="text/javascript">
	idAngsuran = '<?php echo $idAngsuran; ?>';
	loadPinjamanAjax('<?php echo $no; ?>');
</script>
<?php endif; ?>
