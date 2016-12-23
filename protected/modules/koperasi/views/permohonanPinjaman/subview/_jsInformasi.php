<?php

$urlSetuju = $this->createUrl('informasi');
$urlPrint = $this->createUrl('printInformasi');

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');

?>

<script type="text/javascript">

function updateWarnaStatus () {
	$(".setuju").each(function() {
		//alert(($(this).html() == "Disetujui"));
		if ($(this).html() == "Disetujui") $(this).css("color", "green");
		else if ($(this).html() == "Tidak Disetujui") $(this).css("color","red");
	});
}

function dialogPersetujuan(id) {

	$.post('<?php echo $urlSetuju; ?>', {ajax: true, f:'loadPermohonan', param:{id:id}}, function(data) {
		$("#dialog_persetujuan").modal("show");

		$(".btn-setuju").prop('disabled', false);

		$(".tanggal").val(data.tgl);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_nokeanggotaan").val(data.attr.nokeanggotaan);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_namaunit").val(data.attr.namaunit);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_golonganpegawai_nama").val(data.attr.golonganpegawai_nama);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_nama_pegawai").val(data.attr.nama_pegawai);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_tglpermohonanpinjaman").val(data.attr.tglpermohonanpinjaman);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_jenispinjaman_permohonan").val(data.attr.jenispinjaman_permohonan);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_jmlpinjaman").val(formatNumber(data.attr.jmlpinjaman));
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_permohonanpinjaman_id").val(data.attr.permohonanpinjaman_id);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_jangkawaktu_pinj_bln").val(data.attr.jangkawaktu_pinj_bln);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_jasapinjaman_bln").val(data.attr.jasapinjaman_bln);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_nopermohonan").val(data.attr.nopermohonan);
		$("#dialog_persetujuan #InformasipermohonanpinjamanV_untukkeperluan").val(data.attr.untukkeperluan);

		$("#dialog_persetujuan #ApprovalT_appr_diperiksaoleh_id").val(data.periksa.nama);
		$("#dialog_persetujuan #diperiksaoleh_id").val(data.periksa.id);

		$("#dialog_persetujuan #ApprovalT_appr_disetujuioleh_id").val(data.setujui.nama);
		$("#dialog_persetujuan #disetujuioleh_id").val(data.setujui.id);



	}, 'json');
}

function dialogSumberPotongan(id) {
	$.post('<?php echo $urlSetuju; ?>', {ajax: true, f:'loadSumberPotongan', param:{id:id}}, function(data) {
		$("#id_potongan").val(data.id);

		$(".checkPotongan").prop('checked', false);
		$(".potongan").val('0');
		$.each(data.res, function(idx, val) {
			$("input[name*='potongan[" + val.id + "][check]']").prop('checked', true);
			$("input[name*='potongan[" + val.id + "][text]']").val(val.val);
		});
		checkDisableInput()
		$("#dialog_sumberPotongan").modal("show");

	}, 'json');
}

function ubahSumber() {
	stream = $("#form-ubahSumber :input").serialize() + "&ajax=true&f=submitSumber&param=";
	$.post('<?php echo $urlSetuju; ?>', stream, function(data) {
		 if (data.ok == 1) {
			alert("Sumber Potongan telah diubah.");
			$("#dialog_sumberPotongan").modal("hide");
			$.fn.yiiGridView.update('pegawai-m-grid');
		} else {
			alert("Error. Sumber Potongan tidak dapat diubah.");
			$("#dialog_sumberPotongan").modal("hide");
		}
	}, "json");
}

function loadPengurusDariDialog(id, nama) {
	var switcher = $("#pengurus-switcher").val();
	$("#" + switcher + "_id").val(id);
	$("#ApprovalT_appr_" + switcher + "_id").val(nama);
}

function kirimPersetujuan() {
	$(".btn-setuju").prop('disabled', true);
	stream = $("#form-penyetujuan").serialize() + "&ajax=true&f=submitPersetujuan&param=";
	$.post('<?php echo $urlSetuju; ?>', stream, function(data) {
		if (data.ok == 1) {
			alert("Permintaan telah disetujui.");
			$("#dialog_persetujuan").modal("hide");
			$.fn.yiiGridView.update('pegawai-m-grid');
		} else {
			alert("Error. Permintaan tidak dapat disimpan.");
		}
	}, "json");
}

function batalPinjaman(id) {
    if (confirm("Anda yakin untuk membatalkan ?")) {
        var alasan = setPromptAlasanBatal();
        
        $.post('<?php echo $urlSetuju; ?>', {ajax: true, f:'batalPersetujuan', param:{id:id, alasan: alasan}}, function(data) {
		if (data.status == 1) {
                    alert("Permohonan berhasil dibatalkan");
                    $.fn.yiiGridView.update('pegawai-m-grid');
                } else {
                    alert("Permohonan gagal dibatalkan");
                }
	}, 'json');
    }
    return false;
}

function setPromptAlasanBatal() {
    var alasan = prompt("Alasan pembatalan permohonan");
    if (alasan.trim() == "") return setPromptAlasanBatal();
    return alasan;
}

// ============================================================================
function checkDisableInput() {
	$(".potongan").each(function() {
		$(this).prop('disabled', !$(this).parent().parent().find("input[type=checkbox]").is(":checked"));
	});
}

//$('#pegawai-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
//$('#pegawai-m-grid').find("table >thead >tr >th").hover(function() {
  //$(this).css("color","#818DA2");
//},function(){
  //$(this).css("color","#373E4A");
//});

$(document).ajaxSuccess(function() {
  // $('#pegawai-m-grid').find("table >thead >tr >th").css({ 'color': '#373E4A'});
//	$('#pegawai-m-grid').find("table >thead >tr >th").hover(function() {
//	  $(this).css("color","#818DA2");
  //   },function(){
//		  $(this).css("color","#373E4A");
//	  });
});

updateWarnaStatus();


// ============================================================================

function iPrint() {
	var url = ($(".search-form :input , #pegawai-m-grid :input").serialize()).split('&');
	url.shift();
	url = url.join('&');
	window.open('<?php echo $urlPrint; ?>&' + url, "_blank");
}

</script>
