<?php $urlAjax = $this->createUrl('index'); ?>
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

EOF;

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END);

// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');
Yii::app()->clientScript->registerScript('numMasker', $js, CClientScript::POS_READY);

?>
<script type="text/javascript">

var dialog_t = 0;
function tampilDialogPegawai(tipe, dialog) {
	dialog_t = tipe;
	$(dialog).dialog("open");
}

function pilihPegawai(nilai) {
	console.log(dialog_t);
	switch (dialog_t) {
		case 1: loadPegawai(nilai); break;
		case 2: $("#KeanggotaanT_disetujuioleh").val(nilai.namaLengkap); break;
	}
}

function loadPegawai(nilai) {
	console.log(nilai);
	$("#NIP").val(nilai.nomorindukpegawai);
	$("#PegawaiM_nama_pegawai").val(nilai.namaLengkap);
	$("#tempatlahir_pegawai").val(nilai.tempatlahir_pegawai);
	$("#tgl_lahirpegawai").val(nilai.tgl_lahirpegawai);
	$("#jeniskelamin").val(nilai.jeniskelamin);
	$("#statusperkawinan").val(nilai.statusperkawinan);
	$("#gajipokok").val(formatNumber(nilai.gajipokok));
	$("#kategoripegawaiasal").val(nilai.kategoripegawaiasal);
	$("#kategoripegawai").val(nilai.kategoripegawai);
	$("#jabatan").val(nilai.jabatan.jabatan_nama);
	$("#pangkat").val(nilai.pangkat.pangkat_nama);
	$("#pendidikan").val(nilai.pendidikan.pendidikan_nama);
	$("#kelompokpegawai").val(nilai.kelompokpegawai.kelompokpegawai_nama);
	$("#pegawai_id").val(nilai.pegawai_id);
}


$(document).ready(function() {
    $(".uc").keyup(function() {
        console.log("Kick");
        $(this).val($(this).val().toUpperCase());
    });
});

function cekSimpananGolongan() {
	id = $("#PegawaiM_golonganpegawai_id").val();
	$.post('<?php echo $urlAjax ?>', {ajax: true, ajaxF:"cariSimpananGolongan", param:{id:id}}, function(data) {
		$("#SimpananT_jumlahsimpanan").val(data.simpanan);
		checkPanelSimpanan();
	}, "json");
}

function loadKeInputPegawai(data) {
	$.each(data, function(attr, value) {
		// set input
		$("input[name*='PegawaiM[" + attr + "]']:not([type=radio], [type=file])").val(value);
		
		// set select
		$("select[name*='PegawaiM[" + attr + "]']").val(value);
		
		// textarea
		$("textarea[name*='PegawaiM[" + attr + "]']").html(value);
	});
	
	// set radio
	if (data.jeniskelamin.toLowerCase() == 'laki-laki') {
		$("#jk_laki").prop('checked', 'checked');
		$("#jk_perempuan").prop('checked', null);
	} else if (data.jeniskelamin.toLowerCase() == 'perempuan') {
		$("#jk_laki").prop('checked', null);
		$("#jk_perempuan").prop('checked', 'checked');
	} else {
		$("#jk_laki").prop('checked', null);
		$("#jk_perempuan").prop('checked', null);
	}
	if (data.rhesus.toLowerCase() == 'rh+') {
		$("#rh_plus").prop('checked', 'checked');
		$("#rh_minus").prop('checked', null);
	} else if (data.rhesus.toLowerCase() == 'rh-') {
		$("#rh_plus").prop('checked', null);
		$("#rh_minus").prop('checked', 'checked');
	} else {
		$("#rh_plus").prop('checked', null);
		$("#rh_minus").prop('checked', null);
	}
	
	// set img file
	$("#photo_pegawai").prop("src", data.photopegawai);
}

function setPengurus(id, nama) {
	$('#pengurus_nama').val(nama);
	$('#pengurus_id').val(id);
}

function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        $('#photo_pegawai')
        .attr('src', e.target.result)
        .width(150)
        .height(200);
    };
        reader.readAsDataURL(input.files[0]);
    }
}

function checkPanelSimpanan() {
	if (!$("#is_simpanan").is(":checked")) {
		$(".panel-simpanan input:not(#is_simpanan)").attr('disabled', true);
		$(".panel-simpanan .row-fluid").slideUp();
	} else {
		$(".panel-simpanan input:not(#is_simpanan)").attr('disabled', false);
		$(".panel-simpanan .row-fluid").slideDown();
		hitungSimpanan();
	}
}

function hitungSimpanan() {
	if ($("#terima_kas").is(":checked")) {
	console.log("Kick");
		$('input[type="text"].bkm').prop('disabled', false);
		$('input[name="BuktikasmasukkopT[jmlpembayaran]"]').val($('input[name="SimpananT[jumlahsimpanan]"]').val());
		
		var jmlbayar = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[jmlpembayaran]"]').val()));
		var admin = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[biayaadministrasi]"]').val()));
		var materai = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[biayamaterai]"]').val()));
		
		jmlbayar = isNaN(jmlbayar)?0:jmlbayar;
		admin = isNaN(admin)?0:admin;
		materai = isNaN(materai)?0:materai;
		
		var totalBayar = jmlbayar + admin + materai;
						
		$('input[name="BuktikasmasukkopT[uangditerima]"]').val(formatNumber(totalBayar));
		$('input[name="BuktikasmasukkopT[uangkembalian]"]').val(0);
	} else {
		$('input[type="text"].bkm').val(0);
		$('input[type="text"].bkm').prop('disabled', true);
	}
}

function hitungKembalian() {
	var jmlbayar = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[jmlpembayaran]"]').val()));
	var admin = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[biayaadministrasi]"]').val()));
	var materai = parseFloat(unformatNumber($('input[name="BuktikasmasukkopT[biayamaterai]"]').val()));
	
	jmlbayar = isNaN(jmlbayar)?0:jmlbayar;
	admin = isNaN(admin)?0:admin;
	materai = isNaN(materai)?0:materai;
	
	var totalBayar = jmlbayar + admin + materai;
	var terima = unformatNumber($('input[name="BuktikasmasukkopT[uangditerima]"]').val());
	
	$('input[name="BuktikasmasukkopT[uangkembalian]"]').val(formatNumber(terima - totalBayar));
}

function resetInput() {
	$("#PegawaiM_pegawai_id").val(null);
	$("#PegawaiM_gelarbelakang").val('-');
	$('#photo_pegawai').prop('src', "");
	$("#terima_kas").prop('checked', false);
	hitungSimpanan();
}

$(document).ready(function() {
	$('input[type="text"].bkm:not([name="BuktikasmasukkopT[uangditerima]"])').blur(hitungSimpanan);
	$('input[name="BuktikasmasukkopT[uangditerima]"]').blur(hitungKembalian);
	$('input[type="checkbox"].bkm').change(hitungSimpanan);
	$('#SimpananT_jumlahsimpanan').blur(hitungSimpanan);
});

</script>
