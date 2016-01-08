<script type="text/javascript">
	
function loadTabelRekening(){
$('#table-rekening > tbody > tr').detach(); // set clear
$("#totalDebit").val(""); // set clear
$("#totalKredit").val(""); // set clear

var rekperiod_id = $('#rekperiod_id').val();
$("#table-rekening").addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('LoadTabelRekening'); ?>',
		data: {rekperiod_id:rekperiod_id},//
		dataType: "json",
		success:function(data){
			if(data.pesan == ""){
				alert("Rekening Periode tidak ada pada buku besar");
				return false;
			}else{
			$("#table-rekening").append(data.form);
			$("#table-rekening").removeClass("animation-loading");
			totalDebitKredit();
			}
		},
		 error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function totalDebitKredit(){
		var totalDebit = 0;
		var totalKredit = 0;
	$('#table-rekening  tbody  tr').each(function(){
		var debit = $(this).find('input[name$="debit"]').val();
		var kredit = $(this).find('input[name$="kredit"]').val();
			totalDebit = totalDebit + parseInt(debit);
			totalKredit = totalKredit + parseInt(kredit);
			$("#totalDebit").val(totalDebit);
			$("#totalKredit").val(totalKredit);
		formatNumberSemua();
	});
}

function verifikasi(){
	var jmlRekening = $('#table-rekening tbody tr').length;
    var is_rekeningbaru = $("#<?php echo CHtml::activeId($modRekPeriod, "is_rekeningbaru"); ?>").val();
	var deskripsi = $('#<?php echo CHtml::activeId($modRekPeriod, "deskripsi"); ?>').val();
	if(jmlRekening <= 0){
		myAlert('Isikan periode rekening terlebih dahulu.');
		return false;
	}else if(is_rekeningbaru === "1"){
		if (deskripsi == ""){
			alert('Isikan deskripsi terlebih dahulu');
			return false;
		}else{
			$('#perioderekening-t-form').submit();
		}
	}else{
			$('#perioderekening-t-form').submit();
	}
}

$('#form-rekeningbaru > div > .accordion-heading').click(function(){
    var is_rekeningbaru = $("#<?php echo CHtml::activeId($modRekPeriod, "is_rekeningbaru"); ?>");
    if(is_rekeningbaru.val() > 0){ //hide
        is_rekeningbaru.val(0);
    }else{//show
        is_rekeningbaru.val(1);
    }
});
</script>