<?php
$url = $this->createUrl('index');
$urlAnggota = Yii::app()->createUrl('ajaxAutoComplete/getAnggotaSimpananSDByNo');

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
	var jenis_id = null;
	var simpanan_id = null;

	function loadPengurusDariDialog(id, nama) {
		attr = $("#target_attr").val();
		loadPengurus(id, nama, "#BukitkaskeluarT_" + attr, "#" + attr);
	}

	function loadPengurus(id, nama, inama, iid) {
		$(inama).val(nama);
		$(iid).val(id);
	}


	function loadAnggotaAjax(id) {
		$.get('<?php echo $urlAnggota; ?>', {term:id}, function(data) {
			$('#KeanggotaanV_nokeanggotaan').val(data[0].value);
			loadAnggotaPegawai(data[0].attr);
		}, 'json');
	}

	function loadAnggotaPegawai(item) {
		$('#KeanggotaanV_nokeanggotaan').val(item.nokeanggotaan);
		$("#PengambilansimpananT_keanggotaan_id").val(item.keanggotaan_id);
		$("#KeanggotaanV_nama_pegawai").val(item.pegawai.nama_pegawai);
		$("#KeanggotaanV_tglkeanggotaaan").val(item.tglkeanggotaaan);
		$("#KeanggotaanV_norekening").val(item.pegawai.norekening);
		$("#KeanggotaanV_umur").val(item.pegawai.umur + " Tahun");
		if (item.pegawai.unit != null) $("#KeanggotaanV_unit_id").val(item.pegawai.unit.namaunit);
		if (item.pegawai.golonganpegawai != null) $("#KeanggotaanV_golonganpegawai_id").val(item.pegawai.golonganpegawai.golonganpegawai_nama);
		if (item.pegawai.photopegawai != null) $("#photo_pegawai").prop("src", item.pegawai.photopegawai);

		loadSimpanan();
	}


	function loadSimpanan() {
		id = $("#PengambilansimpananT_keanggotaan_id").val();
		jenis = $("#jenis_simpanan").val();
		$.post("<?php echo $url; ?>", {ajax:true, f:"loadSimpananAnggota", param:{id:id, jenis:jenis}}, function(data) {
			$("#no_simpanan").html(data);
			cleanSimpanan();
			//alert(data);
		});
	}

	function loadSimpananPilihan() {
		id = $("#no_simpanan").val();
		$.post("<?php echo $url; ?>", {ajax:true, f:"loadSimpananPilihan", param:{id:id}}, function(data) {
			if (data.simpanan_id != 0) {

				var jasa_simpanan = data.persenjasa_thn * data.jumlahsimpanan / 100;
				var jumlah = jasa_simpanan * (Math.ceil(data.lama_simpanan/12));
				var keterangan = "Penarikan Simpanan -- " + data.tglsimpanan + ", " + data.nosimpanan + " --";

				$("#tgl_simpanan").val(data.tglsimpanan);
				$("#PengambilansimpananT_lamasimpanan_bln").val(data.lama_simpanan);
				$("#PengambilansimpananT_jml_pokok_pengambilan").val(formatNumber(data.jumlahsimpanan));
				$("#persen").val(data.persenjasa_thn);
				$("#PengambilansimpananT_jml_jasa_pengambilan").val(formatNumber(data.persenjasa_thn * data.jumlahsimpanan / 100));
				$("#PengambilansimpananT_jml_pengambilan").val(formatNumber(parseFloat(data.jumlahsimpanan) + jumlah));

				$("#BukitkaskeluarT_keterangan_bkk").html(keterangan);
                                
                                if (data.jenissimpanan_id == <?php echo Params::JENISSIMPANAN_ID_DEPOSITO; ?>) {
                                    $("#PengambilansimpananT_jml_pokok_pengambilan").val(0);
                                    $("#PengambilansimpananT_jml_pengambilan").val(formatNumber(jumlah));
                                }

			} else {
				cleanSimpanan();
			}
			hitungBKK();
		}, 'json');

	}

	function cleanSimpanan() {
		$("#tgl_simpanan").val('');
		$("#PengambilansimpananT_lamasimpanan_bln").val(0);
		$("#PengambilansimpananT_jml_pokok_pengambilan").val(0);
		$("#persen").val(0);
		$("#PengambilansimpananT_jml_jasa_pengambilan").val(0);
		$("#PengambilansimpananT_jml_pengambilan").val(0);
		$("#BukitkaskeluarT_keterangan_bkk").html("");

		hitungBKK();
	}

	function hitungBKK() {
		jumlah = parseFloat(unformatNumber($("#PengambilansimpananT_jml_pengambilan").val()));
		admin = parseFloat(unformatNumber($("#BukitkaskeluarT_biayaadministrasi").val()));
		materai = parseFloat(unformatNumber($("#BukitkaskeluarT_biayaamaterai").val()));

		$("#BukitkaskeluarT_jmlkaskeluar").val(formatNumber(jumlah - (admin + materai)));
	}

	function cekValidasi() {
		if ($("#PengambilansimpananT_keanggotaan_id").val().trim() == '') {
			alert("Anggota Belum Dipilih"); return false;
		}

		if ($("#no_simpanan").val().trim() == '') {
			alert("Simpanan belum dipilih"); return false;
		}

		//alert("Kick");
		//return false;
		return true;
	}
</script>

<?php if (!empty($sp)) { ?>

<script type="text/javascript">
	var keanggotaan_id = $("#PengambilansimpananT_keanggotaan_id").val();

	jenis_id = <?php echo $sp->jenissimpanan_id; ?>;
	simpanan_id = <?php echo $sp->simpanan_id; ?>;

	$("#jenis_simpanan").val(jenis_id);

	$.post("<?php echo $url; ?>", {ajax:true, f:"loadSimpananAnggota", param:{id:keanggotaan_id, jenis:jenis_id}}, function(data) {
		$("#no_simpanan").html(data);
		cleanSimpanan();

		$("#no_simpanan").val(simpanan_id);
		loadSimpananPilihan();
	});

</script>

<?php } ?>
