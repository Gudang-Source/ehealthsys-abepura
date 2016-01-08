<?php 
    $baseUrl = Yii::app()->createUrl("/");
    $gets = '';
?>
<script type='text/javascript'>

function setDataPegawai(params){
$("#form-pegawai > div").addClass("animation-loading");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#nomorindukpegawai").val(data.nomorindukpegawai);
        $("#KPPenilaianpegawaiT_pegawai_id").val(data.pegawai_id);
        $("#namapegawai").val(data.nama_pegawai);
        $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
        $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
        $("#jabatan").val(data.jabatan_nama);
        $("#jeniskelamin").val(data.jeniskelamin);
        $("#statusperkawinan").val(data.statusperkawinan);
        $("#alamat_pegawai").val(data.alamat_pegawai);
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pasien").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pasien").attr('src',url);
        }  
        
        $("#form-pegawai > legend > .judul").html('Data Pegawai '+data.nomorindukpegawai);
        $("#form-pegawai > legend > .tombol").attr('style','display:true;');
        $("#form-pegawai").removeClass("box").addClass("well");
        
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan !"); 
        console.log(errorThrown);
        setPegawaiReset();
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    }
});
}

function setPegawaiReset(){
    $("#nomorindukpegawai").val("");
    $("#KPPenilaianpegawaiT_pegawai_id").val("");
    $("#namapegawai").val("");
    $("#tempatlahir_pegawai").val("");
    $("#tgl_lahirpegawai").val("");
    $("#jabatan").val("");
    $("#jeniskelamin").val("");
    $("#statusperkawinan").val("");
    $("#alamat_pegawai").val("");
    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
    $("#photo_pasien").attr('src',url);
    $("#form-pegawai > legend > .judul").html('Data Pegawai');
    $("#form-pegawai > legend > .tombol").attr('style','display:none;');
	$("#form-pegawai").removeClass("well").addClass("box");
    $("#form-pegawai > div").removeClass("animation-loading");
    $("#nomorindukpegawai").focus();
}

function setDataPenilai(params){
$("#form-datapenilai").addClass("animation-loading-1");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#penilainama").val(data.nama_pegawai);
		$("#KPPenilaianpegawaiT_penilainip").val(data.nomorindukpegawai);
		$("#KPPenilaianpegawaiT_penilaijabatan").val(data.jabatan_nama);
		$("#KPPenilaianpegawaiT_penilaiunitorganisasi").val(data.unit_perusahaan);  
        $("#form-datapenilai .tombol").attr('style','display:true;');
        $("#form-datapenilai").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan !"); 
        console.log(errorThrown);
        setPenilaiReset();
        $("#form-datapenilai > div").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    }
});
}

function setPenilaiReset(){
	$("#form-datapenilai").addClass("animation-loading-1");
	$("#penilainama").val("");
	$("#KPPenilaianpegawaiT_penilainip").val("");
	$("#KPPenilaianpegawaiT_penilaijabatan").val("");
	$("#KPPenilaianpegawaiT_penilaiunitorganisasi").val("");
	$("#form-datapenilai .tombol").attr('style','display:none;');
	setTimeout(function(){
		$("#form-datapenilai").removeClass("animation-loading-1");
	},500);
}

function setDataPimpinan(params){
$("#form-datapimpinan").addClass("animation-loading-1");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#pimpinannama").val(data.nama_pegawai);
		$("#KPPenilaianpegawaiT_pimpinannip").val(data.nomorindukpegawai);
		$("#KPPenilaianpegawaiT_pimpinanjabatan").val(data.jabatan_nama);
		$("#KPPenilaianpegawaiT_pimpinanunitorganisasi").val(data.unit_perusahaan);  
        $("#form-datapimpinan .tombol").attr('style','display:true;');
        $("#form-datapimpinan").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan !"); 
        console.log(errorThrown);
        setPimpinanReset();
        $("#form-datapimpinan > div").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    }
});
}

function setPimpinanReset(){
	$("#form-datapimpinan").addClass("animation-loading-1");
	$("#pimpinannama").val("");
	$("#KPPenilaianpegawaiT_pimpinannip").val("");
	$("#KPPenilaianpegawaiT_pimpinanjabatan").val("");
	$("#KPPenilaianpegawaiT_pimpinanunitorganisasi").val("");
	$("#form-datapimpinan .tombol").attr('style','display:none;');
	setTimeout(function(){
		$("#form-datapimpinan").removeClass("animation-loading-1");
	},500);
}

function cekValiditas(){
	if(requiredCheck($("form"))){
		var cekrating = true;
		var cekscore = true;
		$(".tablepenilaian > tbody > tr").each(function(){
			var rating = $(this).find('input[type=radio]:checked').val();
				if(rating){
					cekrating &= true;
				}else{
					cekrating &= false;
				}
			var score = $(this).find('input[name*="[penilaianpegdet_socre]"]').val();
				if(score == ''){
					cekscore &= false;
				}
		});
		if((cekrating == true)&&(cekscore == true)){
			$('#sapegawai-m-form').submit();
			$(".animation-loading").removeClass("animation-loading");
			$("form").find('.float').each(function(){
				$(this).val(formatFloat($(this).val()));
			});
			$("form").find('.integer').each(function(){
				$(this).val(formatInteger($(this).val()));
			});
		}else{
			myAlert('Rating dan Score tidak boleh kosong');
		}
		
        
    }
    return false;
}

function setPlaceholder(obj){
	var awal = $(obj).parents('td').find('input[name*="[kolomrating_uraian]"]').val();
	var akhir = $(obj).parents('td').find('input[name*="[kolomrating_deskripsi]"]').val();
	var placeholder = "("+awal+"~"+akhir+")";
	var obj_score = $(obj).parents('tr').find('input[name*="[penilaianpegdet_socre]"');
	obj_score.attr('readonly',false);
	obj_score.val('');
	obj_score.attr('placeholder',placeholder);
	obj_score.focus();
}

function setKolomRating(obj,trke){
	var point = $(obj).parents('td').find('input[name*="[kolomrating_point]"]').val();
	var total_point = 0;
	var jmlrow = $(".tablepenilaian > tbody > tr").length;
	$('#KPPenilaianpegawaidetT_'+trke+'_kolomrating_id').val(obj.value);
	$('#KPPenilaianpegawaidetT_'+trke+'_penilaianpegdet_socre').val(point);
	
	$(".tablepenilaian > tbody > tr").each(function(){
		var score = parseFloat($(this).find('input[name*="[penilaianpegdet_socre]"]').val());
		if(isNaN(score)){ score = 0; }
		total_point += score;
	});
	$("#<?php echo CHtml::activeId($model, 'jumlahpenilaian') ?>").val(total_point);
	$("#<?php echo CHtml::activeId($model, 'nilairatapenilaian') ?>").val((total_point/jmlrow).toFixed(2));
}



function cekScore(obj){
	var nilai = obj.value;
	var kolomrating_id = $(obj).parents('td').find('input[name*="[kolomrating_id]"').val();
	var obj_totalscore = $(obj).parents('table').find('input[name*="[jumlahpenilaian]"');
	var obj_ratarata = $(obj).parents('table').find('input[name*="[nilairatapenilaian]"');
	var totalscore = 0;
	var ratarata = 0;
	var jumlahrows = $(".tablepenilaian > tbody > tr").length;
	$(".tablepenilaian > tfoot > tr").find('input[name*="[jumlahpenilaian]"').addClass("animation-loading-1");
	$(".tablepenilaian > tfoot > tr").find('input[name*="[nilairatapenilaian]"').addClass("animation-loading-1");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('CekScore'); ?>',
		data: {nilai : nilai,kolomrating_id:kolomrating_id},
		dataType: "json",
		success:function(data){
			if(data.pesan != ''){
				myAlert(data.pesan);
				$(obj).val('');
				$(obj).focus();
			}else{
				$(".tablepenilaian > tbody > tr").each(function(){
					var score = parseFloat($(this).find('input[name*="[penilaianpegdet_socre]"]').val());
					if(isNaN(score)){ score = 0; }
					totalscore += score;
				});
				obj_totalscore.val(totalscore);
				obj_ratarata.val(totalscore/jumlahrows);
			}
			$(".tablepenilaian > tfoot > tr").find('input[name*="[jumlahpenilaian]"').removeClass("animation-loading-1");
			$(".tablepenilaian > tfoot > tr").find('input[name*="[nilairatapenilaian]"').removeClass("animation-loading-1");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

$("input[type=radio]").on("click",function() {
	var obj_kolomrating_id = $(this).parents('tr').find('input[name*="[kolomrating_id]"');
	$(this).parents('tr').find("input[type=radio]:checked").each(function() {
		obj_kolomrating_id.val(this.value);
	});
});

function loadDataAfterSave(penilaianpegawai_id){
	var table = $(".tablepenilaian > tbody > tr");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('LoadDataAfterSave'); ?>',
		data: {penilaianpegawai_id : penilaianpegawai_id},
		dataType: "json",
		success:function(data){
			setDataPegawai(data.modPenilaianPegawai.pegawai_id);
			setDataPenilai(data.penilai.pegawai_id);
			setDataPimpinan(data.modPenilaianPegawai.pegawai_id);
			table.each(function(index){
				var kolomrating_id = data.modPenilaianPegawaiDet[index].kolomrating_id;
				var penilaianpegdet_socre = data.modPenilaianPegawaiDet[index].penilaianpegdet_socre;
				var obj_radio = $(this).find("input[type=radio]");
				var obj_score = $(this).find('input[name*="[penilaianpegdet_socre]"]');
				if ((penilaianpegdet_socre-1) > 0) {
					var element_id = 'radiorating['+index+']['+(penilaianpegdet_socre-1)+']';
					document.getElementById(element_id).checked = true;
					obj_score.val(penilaianpegdet_socre);
					obj_radio.attr('disabled',true);
				}
			});
			$('#KPPenilaianpegawaiT_jumlahpenilaian').val(data.modPenilaianPegawai.jumlahpenilaian);
			$('#KPPenilaianpegawaiT_nilairatapenilaian').val(data.modPenilaianPegawai.nilairatapenilaian);
			
			$('#KPPenilaianpegawaiT_periodepenilaian').val(data.modPenilaianPegawai.periodepenilaian);
			$('#KPPenilaianpegawaiT_sampaidengan').val(data.modPenilaianPegawai.sampaidengan);
			$('#KPPenilaianpegawaiT_keterangan_score').val(data.modPenilaianPegawai.keterangan_score);
			$('#KPPenilaianpegawaiT_performanceindex').val(data.modPenilaianPegawai.performanceindex);
			$('#KPPenilaianpegawaiT_tanggal_tanggapanpejabat').val(data.modPenilaianPegawai.tanggal_tanggapanpejabat);
			$('#KPPenilaianpegawaiT_tanggapanpejabat').val(data.modPenilaianPegawai.tanggapanpejabat);
			$('#KPPenilaianpegawaiT_tanggal_keputusanatasan').val(data.modPenilaianPegawai.tanggal_keputusanatasan);
			$('#KPPenilaianpegawaiT_keputusanatasan').val(data.modPenilaianPegawai.keputusanatasan);
			$('#KPPenilaianpegawaiT_tanggal_keberatanpegawai').val(data.modPenilaianPegawai.tanggal_keberatanpegawai);
			$('#KPPenilaianpegawaiT_keberatanpegawai').val(data.modPenilaianPegawai.keberatanpegawai);
			$('#KPPenilaianpegawaiT_penilaianpegawai_keterangan').val(data.modPenilaianPegawai.penilaianpegawai_keterangan);
			$('#KPPenilaianpegawaiT_diterimatanggalpegawai').val(data.modPenilaianPegawai.diterimatanggalpegawai);
			$('#KPPenilaianpegawaiT_diterimatanggalatasan').val(data.modPenilaianPegawai.diterimatanggalatasan);
			$('#fieldset-tabelpenilaian').addClass('well');
			$('#fieldset-datapenilaian').addClass('well');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function hitungMundur(durasi, tampil) {
    var timer = durasi, menit, detik;
    setInterval(function () {
        menit = parseInt(timer / 60, 10)
        detik = parseInt(timer % 60, 10);

        menit = menit < 10 ? "0" + menit : menit;
        detik = detik < 10 ? "0" + detik : detik;

        tampil.text(menit + ":" + detik);

        if (--timer < 0) {
			alert('Waktu pengisian habis, halaman ini akan reload otomatis.');
			location.reload();
			timer = durasi;
        }
    }, 1000);
}
// Diset 30menit LNG-2306
jQuery(function ($) {
	<?php if(!isset($_GET['sukses'])){ ?>
		myConfirm("Pengisian Form ini hanya diberi waktu selama 30 menit?","Perhatian!",function(r) {
			if (r){
				var setelahJam = 60 * 30,
				tampil = $('#time');
				hitungMundur(setelahJam, tampil);
			}else{
				location.reload();
			}
		});
	<?php } ?>
});

function print(caraPrint){
    var penilaianpegawai_id = '<?php echo isset($_GET['penilaianpegawai_id']) ? $_GET['penilaianpegawai_id'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penilaianpegawai_id='+penilaianpegawai_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640,scrollbars=1');
}

<?php if(isset($_GET['penilaianpegawai_id'])){ ?>
	loadDataAfterSave(<?php echo $_GET['penilaianpegawai_id'] ?>);
<?php } ?>

function setReadOnly(){
	$('#nomorindukpegawai').attr('readonly',true);
	$('#namapegawai').attr('readonly',true);
	$('#KPPenilaianpegawaiT_tglpenilaian').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['id'])){ ?>
            $("#form-pegawai .add-on").remove();
//            $("#fieldset-datapenilaian .add-on").remove();
			setReadOnly();
    <?php } ?>
});	
</script>