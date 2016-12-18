<?php $js = <<<'EOF'

$(".num").each(function() {
	$(this).maskMoney({
		defaultZero:true,
		allowZero:true,
		decimal:',',
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

$urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo');
$url = $this->createUrl('index');

?>

<script type="text/javascript">
	function cekJenisPinjaman() {
		if ($("#PermohonanpinjamanT_jenispinjaman_permohonan").val().toLowerCase() == 'barang') {
			$("#PermohonanpinjamanT_jasapinjaman_bln").val('0,00');
			$("#PermohonanpinjamanT_jasapinjaman_bln").prop('readonly', true);
		} else {
			$("#PermohonanpinjamanT_jasapinjaman_bln").val($("#persen_jasa").val());
			$("#PermohonanpinjamanT_jasapinjaman_bln").prop('readonly', false);
		}
	}

	function loadAnggotaAjax(id) {
		$.get('<?php echo $urlAnggota; ?>', {term:id}, function(data) {
			loadAnggotaPegawai(data[0].attr);
		}, 'json');
	}

	function loadAnggotaPegawai(item) {
		if (!item.sudahPinjam) {
			alert("Anggota yang dipilih masih dalam permohonan pinjaman");
			return false;
		}
		$('#KeanggotaanV_nokeanggotaan').val(item.nokeanggotaan);
		$("#PermohonanpinjamanT_keanggotaan_id").val(item.keanggotaan_id);
		$("#PegawaiM_nama_pegawai").val(item.pegawai.nama_pegawai);
		$("#PegawaiM_norekening").val(item.pegawai.norekening);
		$("#PegawaiM_tgl_lahirpegawai").val(item.pegawai.tgl_lahirpegawai);
		$("#PegawaiM_umur").val(item.pegawai.umur + " Tahun");
		if (item.pegawai.golonganpegawai != null) {
			$("#PegawaiM_golonganpegawai_id").val(item.pegawai.golonganpegawai.golonganpegawai_nama);
			$("#GolonganpegawaiM_jmlmaksimalplafon").val(formatNumber(item.pegawai.golonganpegawai.jmlmaksimalplafon));
			$("#GolonganpegawaiM_jmlmininalplafon").val(formatNumber(item.pegawai.golonganpegawai.jmlmininalplafon));
		} else {
			$("#PegawaiM_golonganpegawai_id").val('');
			$("#GolonganpegawaiM_jmlmaksimalplafon").val(0);
			$("#GolonganpegawaiM_jmlmininalplafon").val(0);
		}

		if (item.pegawai.unit != null) $("#PegawaiM_unit_id").val(item.pegawai.unit.namaunit);
		else $("#PegawaiM_unit_id").val('');

		if (item.pegawai.photopegawai != null) $("#photo_pegawai").prop("src", item.pegawai.photopegawai);
		else $("#photo_pegawai").prop("src", "");

		loadAnggotaTunggakan(item.keanggotaan_id);
	}

	function loadAnggotaTunggakan(id) {
		$.post('<?php echo $url; ?>', {ajax: true, f: 'loadTunggakanAnggota', param:{id:id}}, function(data) {
			//alert(data.sumber.gaji);
			$("#PermohonanpinjamanT_jmltunggakanuangpinj").val(formatNumber(data.pinjaman.uang));
			$("#PermohonanpinjamanT_jmltunggakanbrgpinj").val(formatNumber(data.pinjaman.barang));
			$("#v_gaji").val(data.sumber.gaji);
			$("#v_insentif").val(data.sumber.insentif);
			$("#v_simpanan").val(data.sumber.simpanan);

			$(".potongan").each(function() {
				$(this).prop('checked', true);
				cekPotonganInput(this);
			});
			//alert($("#jmlsimpanan").val());
		}, 'json');
	}

	function cekPotonganInput(obj) {
		var idx = $(obj).val();
		if ($(obj).is(":checked")) {
			if (idx == 1) $("#PermohonanpinjamanT_jmlgaji").val(formatNumber($("#v_gaji").val()));
			else if (idx == 2) $("#PermohonanpinjamanT_jmlinsentif").val(formatNumber($("#v_insentif").val()));
			else if (idx == 3) $("#PermohonanpinjamanT_jmlsimpanan").val(formatNumber($("#v_simpanan").val()));
		} else {
			if (idx == 1) $("#PermohonanpinjamanT_jmlgaji").val(0);
			else if (idx == 2) $("#PermohonanpinjamanT_jmlinsentif").val(0);
			else if (idx == 3) $("#PermohonanpinjamanT_jmlsimpanan").val(0);
		};
	}

	function cekValidasi() {
		if ($("#PermohonanpinjamanT_keanggotaan_id").val() == '') {
			alert("Anggota belum dipilih");
			return false;
		}


		if ($("#PermohonanpinjamanT_jenispinjaman_permohonan").val() == '') {
			alert ("Jenis pinjaman belum dipilih");
			return false;
		}

		if ($("#PermohonanpinjamanT_jmlpinjaman").val() == '0' || $("#PermohonanpinjamanT_jangkawaktu_pinj_bln").val() == '0') {
			alert("Jumlah pinjaman dan jangka waktu harus lebih dari 0");
			return false;
		}

		// cek validasi plafon
		if (!validasiPlafon()) {
			//alert("Pinjaman melebihi plafon anggota");
			return false;
		}

		if ($("#PermohonanpinjamanT_untukkeperluan").val().trim() == '') {
			alert("Keperluan pinjaman harus diisi.");
			return false;
		}

		// cek apakan ada potongan yang diceklis
		isChecked = false;
		isValid = true;
		$(".potongan").each(function() {
			if ($(this).is(":checked")) isChecked = true;
		});
		if (!isChecked) {
			alert("Potongan Sumber belum di pilih.");
			return false;
		}

		// cek apakah ada potongan yang melebihi bagi yang diceklis
		if(!validasiPotongan()) return false;


		//alert("Kick");
		return true;
	}

	function validasiPlafon() {
		var plafon = parseFloat(unformatNumber($("#GolonganpegawaiM_jmlmaksimalplafon").val()));
		var plafonMin = parseFloat(unformatNumber($("#GolonganpegawaiM_jmlmininalplafon").val()));
		var uang = parseFloat(unformatNumber($("#PermohonanpinjamanT_jmltunggakanuangpinj").val()));
		var barang = parseFloat(unformatNumber($("#PermohonanpinjamanT_jmltunggakanbrgpinj").val()));
		var jml = parseFloat(unformatNumber($("#PermohonanpinjamanT_jmlpinjaman").val()));
		var jenis = $("#PermohonanpinjamanT_jenispinjaman_permohonan").val();

		if (jenis == 'UANG') {
			if ((uang + jml) > plafon) {
				if (!confirm("Nominal pinjaman uang melebihi plafon. Anda yakin untuk melanjutkan ?")) return false;
			} else if ((uang + jml) < plafonMin) {
				if (!confirm("Nominal pinjaman uang di bawah plafon. Anda yakin untuk melanjutkan ?")) return false;
			}
		} else if (jenis == 'BARANG') {
			if ((barang + jml) > plafon) {
				if (!confirm("Nominal pinjaman barang melebihi plafon. Anda yakin untuk melanjutkan ?")) return false;
				return false;
			} else if ((barang + jml) < plafonMin) {
				if (!confirm("Nominal pinjaman barang di bawah plafon. Anda yakin untuk melanjutkan ?")) return false;
			}
		}

		return true;
	}

	function validasiPotongan() {
		var isValid = true;
		$(".potongan").each(function() {
			if ($(this).val() == 1 && $(this).is(":checked") && unformatNumber($("#PermohonanpinjamanT_jmlgaji").val()) > $("#v_gaji").val()) {
				alert("Potongan melebihi gaji pokok pegawai");
				isValid = false;
			}
			if ($(this).val() == 2 && $(this).is(":checked") && unformatNumber($("#PermohonanpinjamanT_jmlinsentif").val()) > $("#v_insentif").val()) {
				alert("Potongan melebihi insentif pegawai");
				isValid = false;
			}
			if ($(this).val() == 3 && $(this).is(":checked") && unformatNumber($("#PermohonanpinjamanT_jmlsimpanan").val()) > $("#v_simpanan").val()) {
				alert("Potongan melebihi jumlah simpanan pegawai");
				isValid = false;
			}
		});
                
                return isValid;
		
	}
</script>
