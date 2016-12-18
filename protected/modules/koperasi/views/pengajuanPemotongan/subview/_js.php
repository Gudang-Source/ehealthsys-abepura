<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php $url = $this->createUrl('index'); ?>

<?php $js = <<<'EOF'

$(".sidebar-collapse > a").click();

EOF;

Yii::app()->clientScript->registerScript('collapser', $js, CClientScript::POS_READY);

?>


<script type="text/javascript">

	$("#btn-cari").click(function() {
		if ($("#PengajuanpembangsuranV_potongansumber_id").val().trim() == '') {
			alert("Sumber Potongan Harus diinput pada pencarian");
			return false;
		};
		$.fn.yiiGridView.update('permintaan-m-grid', {data:$("#panel-pencarian :input").serialize()});
	});

	function loadPengurusDariDialog(id, nama) {
		attr = $("#target_attr").val();
		loadPengurus(id, nama, "#PengajuanpembayaranT_" + attr, "#" + attr);
	}

	function loadPengurus(id, nama, inama, iid) {
		$(inama).val(nama);
		$(iid).val(id);
	}

	function pilihSemua() {
		$("#permintaan-m-grid input[type=checkbox]:not(:disabled)").prop('checked', $("#pilih_semua").is(":checked"));
		//updateAngsuran();
	}

	function cekValidasi() {
		if ($("#PengajuanpembangsuranV_tglAwal").val().trim() == '' || $('#PengajuanpembangsuranV_tglAkhir').val().trim() == '') {
			alert("Tanggal Jatuh Tempo harus diisi.");
			return false;
		}


		var cekok = false;
		$(".ceklis").each(function() {
			if ($(this).is(":checked")) cekok = true;
		});

		if (!cekok) {
			alert("Angsuran harus dipilih.");
			return false;
		}


		if ($("#dibuatoleh_id_pengpemb").val() == '') {
			alert("Pegawai yang membuat harus disi.");
			return false;
		}
		//alert("Kick");
		//return false;

		return true;
	}

	function hitungTotalAngsuran() {
		$("#permintaan-m-grid > table > tbody > tr").each(function() {
			var angsuran = parseFloat(unformatNumber($(this).find(".jmlpokok_angsuran").val()));
			var jasa = parseFloat(unformatNumber($(this).find(".jmljasa_angsuran").val()));
			var sisa = parseFloat(unformatNumber($(this).find(".jmlsisa_angsuran").val()));
			var wajib = parseFloat(unformatNumber($(this).find("input[name*='[simpananwajib]']").val()));
			var sukarela = parseFloat(unformatNumber($(this).find("input[name*='[simpanansukarela]']").val()));

			$(this).find(".jumlah_angsuran").val(formatNumber(sisa));
			//if ($(this).find(".bayar").val() != "") {
				$(this).find("input[name*='[jmlpengajuan_pengangsuran]']").val(formatNumber(wajib + sukarela + sisa));
			//}
		});
	}

	function registerNum() {
		$("#pilih_semua").prop("checked", false);
		$(".num:text").each(function() {
			$(this).maskMoney({
				defaultZero:true,
				allowZero:true,
				thousands:'',
				thousands:'.',
				precision:0
			});
		});
	}

function dialogInformasi(id) {
		$("#dialog_informasi_angsuran").modal("show");
		$("#KartuangsurananggotaV_no_pinjaman").val(id);
		$.post('<?php echo $url; ?>', {ajax:true, f:'loadInformasi', param:{id:id}}, function(data) {
			$("#KartuangsurananggotaV_nama_pegawai").val(data.nama);
			$("#KartuangsurananggotaV_nokeanggotaan").val(data.nokeanggotaan);
			$("#KartuangsurananggotaV_namaunit").val(data.namaunit);
			$("#KartuangsurananggotaV_golonganpegawai_nama").val(data.golonganpegawai_nama);
			$("#KartuangsurananggotaV_tglpinjaman").val(data.tglpinjaman);
			$("#KartuangsurananggotaV_jml_pinjaman").val(data.jml_pinjaman);
			$("#KartuangsurananggotaV_jasapinjaman").val(data.jasapinjaman);
		}, 'json');
		$.fn.yiiGridView.update('kartuangsuran-m-grid', {data:$("#dialog_informasi_angsuran :input").serialize()});
}

//registerNum();
hitungTotalAngsuran();

</script>
