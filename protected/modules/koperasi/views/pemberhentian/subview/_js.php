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

$urlAnggota = Yii::app()->createUrl('/ActionAutoComplete/getAnggotaByNo/');
$url = $this->createUrl('index');
?>

<script type="text/javascript">

function loadAnggotaAjax(no) {
	$.get('<?php echo $urlAnggota; ?>', {term:no}, function(data) {               
		loadAnggotaPegawai(data[0]);                         
	}, 'json');
}

function loadAnggotaPegawai(item) {
    
	$("#KeanggotaanV_nokeanggotaan").val(item.nokeanggotaan);
	$("#KeanggotaanV_nama_pegawai").val(item.pegawai.nama_pegawai);
	$("#KeanggotaanV_tgl_lahirpegawai").val(item.pegawai.tgl_lahirpegawai);
	$("#KeanggotaanV_tglkeanggotaaan").val(item.tglkeanggotaaan);
	$("#PemintaanberhentiT_keanggotaan_id").val(item.keanggotaan_id);
	$("#PemintaanberhentiT_pegawai_id").val(item.pegawai_id);
	$("#umur").val(item.pegawai.umur_lengkap);

	if (item.pegawai.photopegawai != null) $("#photo_pegawai").prop("src", item.pegawai.photopegawai);
		else $("#photo_pegawai").prop("src", "");

	//if (item.pegawai.unit != null) $("#KeanggotaanV_unit_id").val(item.pegawai.unit.namaunit);
	//else $("#KeanggotaanV_unit_id").val('');
        
	//loadAngsuran(item.keanggotaan_id);
}

function loadAngsuran(id) {
	$.post('<?php echo $url; ?>', {ajax:true, f:'loadAngsuran', param:{id:id}}, function(data) {
		var tarik = data.simpanan.total - data.angsuran.total;

		$("#area-print-detail").html(data.print);
		$("#content-simpanan").html(data.simpanan.tab);
		$("#content-angsuran").html(data.angsuran.tab);
		$("#total-content-simpanan, #total-simpanan").html(formatNumber(data.simpanan.total));
		$("#total-content-angsuran, #total-angsuran").html(formatNumber(data.angsuran.total));
		$("#penarikan").html(formatNumber(tarik));

		$("#PemintaanberhentiT_jmlsimpanan_berhenti").val(data.simpanan.total);
		$("#PemintaanberhentiT_jmltunggakan_berhenti").val(data.angsuran.total);
		$("#PemintaanberhentiT_jmlkasmasuk_keluar").val(Math.abs(tarik));

		if (tarik < 0) $("#penarikan").css('color', 'red');
		else $("#penarikan").css('color', 'green');
	}, 'json');
}


function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#PemintaanberhentiT_" + attr, "#" + attr);
}

function loadPengurus(id, nama, inama, iid) {
	$(inama).val(nama);
	$(iid).val(id);
}

function cekValidasi() {
	if ($("#PemintaanberhentiT_keanggotaan_id").val() == '') {
		alert("Anggota harus dipilih.");
		return false;
	}
	if ($("#PemintaanberhentiT_sebabberhenti").val() == '') {
		alert("Sebab Pemberhentian harus diisi.");
		return false;
	}
	if ($("#PemintaanberhentiT_tgldibuatpermintaan").val() == '') {
		alert("Tanggal dibuat harus diisi.");
		return false;
	}
	if ($("#dibuatolehperm_id").val() == '') {
		alert("Pegawai yang membuatnya harus diisi.");
		return false;
	}

	// untuk validasi pecat
	var tglBerhenti = $("#PemintaanberhentiT_tglberhenti_dipecat").val().trim();
	var tglPeriksa = $("#PemintaanberhentiT_tgldiperiksaperm").val().trim();
	var tglSetujui = $("#PemintaanberhentiT_tgldisetujuiperm").val().trim();

	var periksa = $("#diperiksaprmint_id").val();
	var setujui = $("#disetuuiolehperm_id").val();

	var sisa = unformatNumber($("#penarikan").html());

	if (tglBerhenti != '' || tglPeriksa != '' || tglSetujui != '' || periksa != '' || setujui != '') {
		/*if (tglBerhenti == '' && ) {
			alert('Tanggal Perhenti Harus Diisi.'); return false;
		}*/
		if (periksa == '') {
			alert('Pegawai yang Memeriksa Harus Diisi.'); return false;
		}
		if (tglPeriksa == '') {
			alert('Tanggal Periksa Harus Diisi.'); return false;
		}
		if (setujui == '') {
			alert('Pegawai yang Menyetujui Harus Diisi.'); return false;
		}
		if (tglSetujui == '') {
			alert('Tanggal Penyetujuan Harus Diisi.'); return false;
		}
		// alert(sisa);
		if (sisa < 0) {
			if (!confirm("Total Sisa Angsuran lebih besar dari Total Simpanan, anda yakin untuk melanjukan ?")) return false;
		}
		return true;
	}





	// untuk validasi pinjaman

	return false;
}

</script>
