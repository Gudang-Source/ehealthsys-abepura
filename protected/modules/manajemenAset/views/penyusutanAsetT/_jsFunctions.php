<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function setAutoLoad(barang_id){
	setClear();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setAutoLoad'); ?>',
		data: {barang_id:barang_id},//
		dataType: "json",
		success:function(data){
			if(data.pesan !== ""){
				myAlert(data.pesan);
				return false;
			}
			$('#<?php echo CHtml::activeId($model,"kodeInventarisasi"); ?>').val(data.kodeInventarisasi);
			$('#<?php echo CHtml::activeId($model,"tglPerolehanBarang"); ?>').val(data.tglguna);
			$('#<?php echo CHtml::activeId($model,"noRegister"); ?>').val(data.noRegister);
			$('#<?php echo CHtml::activeId($model,"umurekonomis"); ?>').val(data.umurEkonomis);
			$('#inv_id').val(data.inv_id);
			$('#nama_inv').val(data.nama_inv);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function setClear(){
	$('#<?php echo CHtml::activeId($model,"tglPerolehanBarang"); ?>').val('');
	$('#<?php echo CHtml::activeId($model,"kodeInventarisasi"); ?>').val('');
	$('#<?php echo CHtml::activeId($model,"noRegister"); ?>').val('');
	$('#<?php echo CHtml::activeId($model,"umurekonomis"); ?>').val('');
	$('#inv_id').val('');
	$('#nama_inv').val('');
	$('#table-detailpenyusutan > tbody > tr').detach();
	$('#table-detailpenyusutan > tfoot > tr').detach();
}

function loadDetailPenyusutan(){
	var tglguna = $('#<?php echo CHtml::activeId($model,"tglPerolehanBarang"); ?>').val();
	var umurEkonomis = $('#<?php echo CHtml::activeId($model,"umurekonomis"); ?>').val();
	var hargaPerolehan = $('#<?php echo CHtml::activeId($model,"hargaperolehan"); ?>').val();
	var nilairesidu = $('#<?php echo CHtml::activeId($model,"residu"); ?>').val();
	var residu = unformatNumber(nilairesidu);
        
        hargaPerolehan = unformatNumber(hargaPerolehan);
	
	if (tglguna == ""){
		myAlert('Tanggal perolehan barang tidak boleh kosong');
		return false;
	}else if(umurEkonomis == ""){
		myAlert('Umur Ekonomis tidak boleh kosong');
		return false;
	}else if(hargaPerolehan == ""){		
		myAlert('Harga perolehan barang tidak boleh kosong');
		return false;
	}else if(residu == ""){
		myAlert('Nilai Residu tidak boleh kosong');
		return false;
	}else{
		$('#table-detailpenyusutan').addClass('animation-loading'); 
		$('#table-detailpenyusutan > tbody > tr').detach();
		$('#table-detailpenyusutan > tfoot > tr').detach();
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('loadDetailPenyutusan'); ?>',
			data: {tglguna:tglguna,umurEkonomis:umurEkonomis,hargaPerolehan:hargaPerolehan,residu:residu},
			dataType: "json",
			success:function(data){
				$('#table-detailpenyusutan > tbody').append(data.form);
				$('#table-detailpenyusutan > tfoot').append(data.foot);
				$('#table-detailpenyusutan').removeClass('animation-loading');
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function renameRowRekening()
{
    var idx = 0;
    $("#tblInputRekening > tbody").find('tr').each(
        function()
        {
            unMaskMoneyInput(this);
            maskMoneyInput(this);
            $(this).find('input').each(
                function()
                {
                    var name_field = $(this).attr('name');
                    var id_field = $(this).attr('id');
                    $(this).attr('name', name_field.replace('99', idx));
                    $(this).attr('id', id_field.replace('99', idx));
                    
                }
            );
            idx++;
        }
    );
}

function unMaskMoneyInput(tr)
{
    $(tr).find('input.integer2:text').unmaskMoney();
}

function maskMoneyInput(tr)
{
    $(tr).find('input.integer2:text').maskMoney(
        {
            "symbol":"Rp. ",
            "defaultZero":true,
            "allowZero":true,
            "decimal":",",
            "thousands":".",
            "precision":0
        }
    );
}

</script>