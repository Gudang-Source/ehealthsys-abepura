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

?>
<script type="text/javascript">

function loadAnggotaAjax(id) {
	$.get('<?php echo $urlAnggota; ?>', {term:id}, function(data) {
		$('#KeanggotaanT_nokeanggotaan').val(data[0].value);
		loadAnggotaPegawai(data[0].attr);
	}, 'json');
}

function loadAnggotaPegawai(item) {
$('#KeanggotaanT_nokeanggotaan').val(item.nokeanggotaan);
	$("#SimpananT_keanggotaan_id").val(item.keanggotaan_id);
	$("#PegawaiM_nama_pegawai").val(item.pegawai.nama_pegawai);
	$("#KeanggotaanT_tglkeanggotaaan").val(item.tglkeanggotaaan);
	$("#PegawaiM_norekening").val(item.pegawai.norekening);
	$("#PegawaiM_umur").val(item.pegawai.umur + " Tahun");
	if (item.pegawai.unit != null) $("#PegawaiM_unit_id").val(item.pegawai.unit.namaunit);
	if (item.pegawai.golonganpegawai != null) $("#PegawaiM_golonganpegawai_id").val(item.pegawai.golonganpegawai.golonganpegawai_nama);
	if (item.pegawai.photopegawai != null) $("#photo_pegawai").prop("src", item.pegawai.photopegawai);
	else $("#photo_pegawai").prop("src", "");
	
	if ($("#cek_simpanan_1").length != 0) {
		if (item.sudah_pokok) $("#cek_simpanan_1").prop('disabled', true);
		else $("#cek_simpanan_1").prop('disabled', false);
	}
	
	if (item.simpanan != null) {
		$(".jumlahsimpanan").each(function() {
			var nama = $(this).attr('name');
			if (nama.search('[1]') != -1) {
				$(this).data('sudah_pokok', item.sudah_pokok);
				$(this).val(item.simpanan.pokok);
			} else if (nama.search('[2]') != -1) {
				$(this).val(item.simpanan.wajib);
			}
		});
	}
	$(".jumlahsimpanan").each(function(index, el) {
		var nums = parseFloat(unformatNumber($(this).val()));
		var checked = $(this).parent().parent().find(".checkee").is(":checked");
		if (!checked) $(".jumlahsimpanan").eq(index).data('storage', nums);
	});
	hitungPembayaran();
$(".jumlahsimpanan").focus();
}

function hitungPembayaran() {
	jmlbayar = 0;
	var admin = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayaadministrasi]"]').val()));
	var materai = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayamaterai]"]').val()));
	
	$(".jumlahsimpanan").each(function(index, el) {
		var checked = $(this).parent().parent().find(".checkee").is(":checked");
		var disabled = $(this).parent().parent().find(".checkee").is(":disabled");
		var nums = parseFloat(unformatNumber($(this).val()));
		var storage = $(".jumlahsimpanan").eq(index).data('storage');
		//alert(storage);
		//alert(nums);
		if ($(this).parent().parent().find(".checkee")[0] != null) {
			if (checked) {
				if (storage != 0 && !isNaN(storage)) {
					nums = storage;
					$(".jumlahsimpanan:not(.no-storage)").eq(index).val(formatNumber(storage));
					$(".jumlahsimpanan:not(.no-storage)").eq(index).data('storage', 0);
				}
				jmlbayar += nums;
			} else {
				$(".jumlahsimpanan:not(.no-storage)").eq(index).val(0);
			}
		} else {
			jmlbayar += nums;
		}
	});
	
	var admin = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayaadministrasi]"]').val()));
	var materai = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayamaterai]"]').val()));
	
	var totalBayar = jmlbayar + admin + materai;
						
	$('input[name="BuktikasmasukT[jmlpembayaran]"]').val(formatNumber(jmlbayar));
	$('input[name="BuktikasmasukT[uangditerima]"]').val(formatNumber(totalBayar));
	$('input[name="BuktikasmasukT[uangkembalian]"]').val(0);
}

function hitungKembalian() {
	var jmlbayar = parseFloat(unformatNumber($('input[name="BuktikasmasukT[jmlpembayaran]"]').val()));
	var admin = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayaadministrasi]"]').val()));
	var materai = parseFloat(unformatNumber($('input[name="BuktikasmasukT[biayamaterai]"]').val()));
	
	jmlbayar = isNaN(jmlbayar)?0:jmlbayar;
	admin = isNaN(admin)?0:admin;
	materai = isNaN(materai)?0:materai;
	
	var totalBayar = jmlbayar + admin + materai;
	var terima = unformatNumber($('input[name="BuktikasmasukT[uangditerima]"]').val());
	
	$('input[name="BuktikasmasukT[uangkembalian]"]').val(formatNumber(terima - totalBayar));
}

//======================================================================

function cekEditSimpanan() {
	if ($(this).is(":checked")) {
		$(this).parent().parent().find(".jumlahsimpanan").prop('disabled',false);
		$(this).parent().parent().find(".jumlahsimpanan").focus();
	}
	else {
		$(this).parent().parent().find(".jumlahsimpanan").data('storage', formatNumber($(this).parent().parent().find(".jumlahsimpanan").val()));
		$(this).parent().parent().find(".jumlahsimpanan").prop('disabled',true);
	}
	
	hitungPembayaran();
}

//======================================================================

function loadPengurusDariDialog(id, nama) {
	attr = $("#target_attr").val();
	loadPengurus(id, nama, "#BuktikasmasukT_" + attr, "#" + attr);
}
function loadPengurus(id, nama, id_nama, id_id) {
	$(id_nama).val(nama);
	$(id_id).val(id);
}

//======================================================================

function cekValidasi() {
	// cek id pegawai
	if ($("#SimpananT_keanggotaan_id").val() == "") {
		alert("Anggota belum dipilih");
		return false;
	}
	
	if ($(".checkee").length != 0) {
		var ischecked = false;
		$(".checkee").each(function() {
			ischecked = ischecked || $(this).is(":checked");
		});
		
		if (!ischecked) {
			alert("Simpanan belum dipilih");
			return false;
		}
	}
	
	if ($("#SimpananT_satuan").length != 0) {
		if ($("#SimpananT_satuan").val() == "") {
			alert("Satuan belum dipilih");
			return false;
		}
	}
	if ($("#SimpananT_jangkawaktusimpanan").length != 0) {
		if ($("#SimpananT_jangkawaktusimpanan").val() == '0') {
			alert("Jangka waktu belum diinput");
			return false;
		}
	}
	
	// cek ceklisan simpanan

	return true;
}

function cekJenisSimpanan(obj){
    var jenissimpanan = $(obj).val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('cekJenisSimpanan'); ?>',
        data: {jenissimpanan:jenissimpanan},
        dataType: "json",
        success:function(data){           
            if (data.pesan == 'sukses'){                
                clearSimpanan();
                $(".detail-simpanan").show();
                setSimpanan(data);
            }else{
                clearSimpanan();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);            
    }
    });
}

function clearSimpanan(){
    $("#SimpananT_nosimpanan").val('');
    $("#SimpananT_jumlahsimpanan").val('0');
    $("#SimpananT_jangkawaktusimpanan").val('0');
    $("#SimpananT_persenjasa_thn").val('');
    $("#SimpananT_satuan").val('');    
}

function setSimpanan(data){
    $("#SimpananT_nosimpanan").val(data.nosimpanan);            
    $("#SimpananT_persenjasa_thn").val(data.persenjasathn);    
    
    if ( data.jenissimpanan_id == '<?php echo Params::ID_SIMPANAN_POKOK ?>' || data.jenissimpanan_id == '<?php echo Params::ID_SIMPANAN_WAJIB ?>'){                        
        $("#SimpananT_persenjasa_thn").prop("readonly", true );
        $("#SimpananT_satuan").prop("disabled", true ); 
        $("#SimpananT_jangkawaktusimpanan").prop("readonly", true );
    }else if( data.jenissimpanan_id == '<?php echo Params::ID_SIMPANAN_SUKARELA ?>'){
        $("#SimpananT_persenjasa_thn").prop("readonly", false );
        $("#SimpananT_satuan").prop("disabled", true ); 
        $("#SimpananT_jangkawaktusimpanan").prop("readonly", true );    
    }else if (data.jenissimpanan_id == '<?php echo Params::ID_SIMPANAN_DEPOSITO ?>'){
        $("#SimpananT_persenjasa_thn").prop("readonly", false );
        $("#SimpananT_satuan").prop("disabled", false );     
        $("#SimpananT_jangkawaktusimpanan").prop("readonly", false );   
    }else{
        $("#SimpananT_persenjasa_thn").prop("readonly", true );
        $("#SimpananT_satuan").prop("disabled", true );    
        $("#SimpananT_jangkawaktusimpanan").prop("readonly", true );
        $("#SimpananT_jumlahsimpanan").prop("readonly", true );
    }
}

//======================================================================
$("input.num:not(#BuktikasmasukT_uangditerima)").blur(hitungPembayaran);
$('input[name="BuktikasmasukT[uangditerima]"]').blur(hitungKembalian);
$(".checkee").change(cekEditSimpanan);

</script>