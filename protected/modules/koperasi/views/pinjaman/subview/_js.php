
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

$(".num").each(function() {
	if ($(this).val() == '') $(this).val(0);
});

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

?>

<script type="text/javascript">

var premi = <?php echo $arrAs; ?>

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BukitkaskeluarT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}


function hitungPremi() {
	var umur = parseFloat($("#umur").val());
	var cicilan = Math.ceil(parseFloat($("#PinjamanT_jangka_waktu_bln").val())/12);
	var pinjaman = parseFloat(unformatNumber($("#PinjamanT_jml_pinjaman").val()));
	$("#premiasuransi").val(premi[umur][cicilan].replace('.', ','));

	return premi[umur][cicilan] * pinjaman / 1000;
}

function hitungBKK() {
	// alert("Kick");
	var premi = hitungPremi();
	var pinjaman = $("#PinjamanT_jml_pinjaman").val();
	var admin = $("#PinjamanT_biaya_administrasi").val();
	var materai = $("#PinjamanT_biaya_materai").val();
	var jasa = parseFloat(unformatNumber($("#PinjamanT_persen_jasa_pinjaman").val()));
	var persenProvisi = parseFloat($("#persen_provisi").val());
	var provisi;

	$("#jumlah_pinjaman").val(pinjaman);

	// alert(parseFloat(unformatNumber(pinjaman)));

	if (pinjaman == '') pinjaman = 0;
	else pinjaman = parseFloat(unformatNumber(pinjaman));

	if (admin == '') admin = 0;
	else admin = parseFloat(unformatNumber(admin));

	if (materai == '') materai = 0;
	else materai = parseFloat(unformatNumber(materai));

	provisi = (persenProvisi/100) * pinjaman;

	$("#rupiah_jasa").val(formatNumber((jasa/100) * pinjaman));
	$("#biaya_provisi").val(formatNumber(provisi));
	$("#biaya_asuransi").val(formatNumber(premi));
	$("#BukitkaskeluarT_jmlkaskeluar").val(formatNumber(pinjaman - (provisi + admin + materai + premi)));
}

// =========================================================================================

function loadCicilan() {
	//$("#btn-hitung").prop('disabled', true);
	$.post('<?php echo $url; ?>', {
		ajax:true,
		f:'hitungCicilan',
		param: {
			tglPinjam:$("#PinjamanT_tglpinjaman").val(),
			jatuhTempo:$("#PinjamanT_jatuh_tempo").val(),
			jmlpinjaman:unformatNumber($("#PinjamanT_jml_pinjaman").val()),
			jasaPinjaman:unformatNumber($("#PinjamanT_persen_jasa_pinjaman").val()),
			jangkaWaktu:$("#PinjamanT_jangka_waktu_bln").val(),
			cicil:$("#PinjamanT_jml_kali_angsur").val(),
		}
	}, function(data) {
		$("#tab-content-angsuran").empty();
		$("#tab-content-angsuran").html(data.tabel);
		$(".date-able").datepicker({'format':'dd/mm/yyyy','language':'id'});
		//$("#btn-hitung").prop('disabled', false);
	}, 'json');
}

// ==========================================================================================

function loadPemohonAjax(no) {
	$.get('<?php echo $urlAC; ?>', {term:no}, function(data) {
		$("#InformasipermohonanpinjamanV_nokeanggotaan").val(no);
		loadAnggotaPegawai(data[0].attr);
	}, 'json');
}

function loadAnggotaPegawai(item) {
	$.each(item, function(i, v) {
		$("#panel-anggota input[name*='[" + i + "]']:not(.ui-autocomplete-input)").val(v);
	});
	$("#InformasipermohonanpinjamanV_nokeanggotaan").val(item.nokeanggotaan);
	$("#InformasipermohonanpinjamanV_nama_pegawai").val(item.nama_pegawai);
	$("#PinjamanT_keanggotaan_id").val(item.keanggotaan_id);
	$("#PinjamanT_permohonanpinjaman_id").val(item.permohonanpinjaman_id);
	$("#PinjamanT_untuk_keperluan").val(item.untukkeperluan);
	$("#panel-anggota input[name*='[appr_disetujuioleh_id]']").val(item.setujui.nama_pegawai);
	$("#PinjamanT_jml_pinjaman").val(item.jmlpinjaman);
	$("#PinjamanT_jaminan_berupa").val(item.namapotongan);
	$("#PinjamanT_cara_bayar").val(item.approval.cara_bayar);
	$("#PinjamanT_jangka_waktu_bln").val(item.jangkawaktu_pinj_bln);
	$("#PinjamanT_jml_kali_angsur").val(item.jangkawaktu_pinj_bln);
	$("#PinjamanT_persen_jasa_pinjaman").val(item.jasapinjaman_bln);
	$("#umur").val(item.umur);

	$("#tab-content-angsuran").empty();

	$(".checkPotongan").each(function() {
		$(this).prop('checked', false);
	});
	$.each(item.potongan, function(i, v) {
		$("input[type=checkbox][name*='[" + v + "][check]']").prop('checked', true);
                // console.log(item.jmlsimpanan);
                // console.log($("input[type=text][name*='[" + v + "][text]']"));
                if (v == 3) $("input[type=text][name*='[" + v + "][text]']").val(item.jmlsimpanan);
                if (v == 2) $("input[type=text][name*='[" + v + "][text]']").val(item.jmlinsentif);
                if (v == 1) $("input[type=text][name*='[" + v + "][text]']").val(item.gajipokok);
	});
	checkDisableInput();
	hitungJatuhTempo();
	hitungBKK();
}

function hitungJatuhTempo() {
	var arrPinjam = $("#PinjamanT_tglpinjaman").val().split('/');
	var offset = parseFloat($("#PinjamanT_jangka_waktu_bln").val());

	if (offset == '') offset = 0;

	var addedMonth = parseFloat(arrPinjam[1]) + offset;

	//alert(Math.floor((offset + 1)/12));

	arrPinjam[1] = padder((((addedMonth - 1)%12)+1).toString(), "00");
	arrPinjam[2] = parseFloat(arrPinjam[2]) + Math.floor((addedMonth-1)/12);

	// str = arrPinjam.join("/");

	$("#PinjamanT_jatuh_tempo").val(arrPinjam.join("/"));

}

function padder(str, pad) {
	return pad.substring(0, pad.length - str.length) + str;
}

function checkDisableInput() {
	$(".potongan").each(function() {
		$(this).prop('disabled', !$(this).parent().parent().find("input[type=checkbox]").is(":checked"));
	});
}

$("#PinjamanT_tglpinjaman").change(hitungJatuhTempo);
$("#PinjamanT_jangka_waktu_bln").blur(hitungJatuhTempo);


function cekValidasi() {
	// cek pemohon sudah dipilih
	if ($("#PinjamanT_permohonanpinjaman_id").val() == '') {
		alert("Anggota pemohon belum dipilih");
		return false;
	}

	if ($("#PinjamanT_jangka_waktu_bln").val() == '0') {
		alert("Jangka waktu pinjaman harus lebih dari 0");
		return false;
	}

	if ($("PinjamanT_jml_kali_angsur").val() == '0') {
		alert("Jumlah Cicilan harus lebih dari 0");
		return false;
	}

	if ($("#PinjamanT_jml_kali_angsur").val() != $("#tab-content-angsuran > tr").length) {
		if (confirm("Jumlah cicilan tidak sama dengan ada pada tabel, apakah anda mau menyesuaikan ?")) loadCicilan();
		return false;
	}


	isChecked = false;
	isPotonganAda = false;
	$(".potongan").each(function() {
		if ($(this).parent().parent().find("input[type=checkbox]").is(":checked")) isChecked = true;
		if ($(this).val() != 0) isPotonganAda = true;
	});
	if (!isChecked) {
		alert("Potongan Sumber belum di pilih.");
		return false;
	}
	if (!isPotonganAda) {
		alert("Potongan yang dipilih tidak boleh 0");
		return false;
	}
	$("#dialog_konfirmasi").modal('show');

	loadKonfirmasi();

	return true;
}

<?php if(!empty($permohonanId)) :?>
	loadPemohonAjax("<?php echo $permintaan->nokeanggotaan; ?>");
<?php endif; ?>

</script>
<?php $this->renderPartial('subview/_jsKonfirmasi'); ?>
