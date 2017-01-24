<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    var tgl_kadaluarsa = $('#tgl_kadaluarsa').val();
    
    if(tgl_kadaluarsa != ''){
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPenerimaanBarang'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tgl_kadaluarsa:tgl_kadaluarsa},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item obat terlebih dahulu");
        }
    }else{
        myAlert("Isikan tanggal kadaluarsa terlebih dahulu");
    }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    var persenppn = 0;
    var persenpph = 0;
    var totnetto = 0;
    var totdisc = 0;
    var totbruto = 0;
    $('#table-obatalkespasien tbody tr').each(function(){
        var jmlterima  = parseInt($(this).find('input[name$="[jmlterima]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoper]"]').val());
        var persendis  = parseInt($(this).find('input[name$="[persendiscount]"]').val());
        var jmldis  = parseInt($(this).find('input[name$="[jmldiscount]"]').val());
        
        subtotal = harganetto * jmlterima;
        totnetto += subtotal;
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        var ppn = 0;
        var rpppn = 0;
        var pph = 0;
        var rppph = 0;
        
        if ($('#diskonSemua').is(":checked")) {
            persendis = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val();
            $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val(persendis);
            $(this).find('input[name$="[persendiscount]"]').val(persendis);
        } else {
            persendis = jmldis = 0;
            $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val(0);
            $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(0);
        }
        
        if($('#termasukPPN').is(':checked')){
            ppn = '<?php echo Yii::app()->user->getState('persenppn'); ?>';
            rpppn = harganetto * (ppn/100);          
        }
        persenppn += (rpppn * jmlterima);
        
        if($('#termasukPPH').is(':checked')){
            pph = '<?php echo Yii::app()->user->getState('persenpph'); ?>';
            rppph = harganetto * (pph/100);   
			console.log(pph);
        }
        
        subtotal = (harganetto + rppph + rpppn) * jmlterima;
        
        persenpph += (rppph * jmlterima);
        
        if(persendis > 0){
            jmldis = subtotal * (persendis/100);
            totdisc += jmldis;
            $(this).find('input[name$="[jmldiscount]"]').val(jmldis);
            subtotal = subtotal - (subtotal * (persendis/100));
        }else{
            totdisc += jmldis;
            $(this).find('input[name$="[persendiscount]"]').val((jmldis/subtotal) * 100);
            subtotal = subtotal - jmldis;
        }    
        
        total += subtotal;
        
        
        totbruto += subtotal;
        
        $(this).find('input[name$="[subtotal]"]').val(Math.floor(subtotal));
        $(this).find('input[name$="[jmldiscount]"]').val(Math.floor(jmldis));
        $(this).find('input[name$="[persenppn]"]').val(Math.floor(ppn));
        $(this).find('input[name$="[persenpph]"]').val(Math.floor(pph));
    });
    $('#<?php echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>').val(Math.floor(totdisc));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>').val(Math.floor(totnetto));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(Math.floor(persenppn));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(Math.floor(persenpph));
    $('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val(Math.floor(totbruto));
    $('#total').val(Math.floor(total));    
    formatNumberSemua();
}

function persenPpn(obj){
    if(obj.checked == true){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);        
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr('checked',true);
        $('#termasukPPN').val(1);
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').removeAttr('checked');
        $('#termasukPPN').val(0);
    }    
    hitungTotal();
}

function persenPph(obj){
    if(obj.checked == true){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr('checked',true);
        $('#termasukPPH').val(1);
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').removeAttr('checked');
        $('#termasukPPH').val(0);
    }    
    hitungTotal();
}

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
 /*
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
} */
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
 /*
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}
*/

function setJmlDiscountNol(obj) 
{
    $(obj).parents("tr").find(".jmldisc").val(0);
}

function setPersenDiscountNol(obj) 
{
    $(obj).parents("tr").find(".persendisc").val(0);
}

function pilihSatuan(obj){
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}

function persenPpn(obj){
    if($(obj).is(":checked")){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);        
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
    }   
    hitungTotal();
}

function persenPph(obj){
    if($(obj).is(":checked")){
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
        
    }else{
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function checkAll(obj){
   if($("#checklist").is(':checked')){
        $("#table-obatalkespasien").find("input[name$='[checklist]'][type='checkbox']").each(function(){
            $(this).attr('checked',true);
        });
    }else{
        $("#table-obatalkespasien").find("input[name$='[checklist]'][type='checkbox']").each(function(){
            $(this).removeAttr('checked');
        });
    } 
    hitungTotal();
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var fakturpembelian_id = $('#fakturpembelian_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&fakturpembelian_id='+fakturpembelian_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function tombolSimpan(){
	if(requiredCheck($("form"))){
        $(".animation-loading").removeClass("animation-loading");
		$(".currency").each(function(){this.value = unformatNumber(this.value)});
		$(".integer2").each(function(){this.value = unformatNumber(this.value)});
		$('#fakturpembelian-form').submit();
    }
    return false;
}

function setFakturObatAlkes(penerimaanbarang_id){
	$('#table-obatalkespasien').addClass('animation-loading');
	$('#table-obatalkespasien > tbody > tr').detach();
	if(penerimaanbarang_id != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('loadPenerimaanBarang'); ?>',
			data: {penerimaanbarang_id:penerimaanbarang_id},//
			dataType: "json",
			success:function(data){
				if(data.pesan == ''){
					$('#table-obatalkespasien > tbody').append(data.form);
					$("#table-obatalkespasien").find('input[name$="[ii][penerimaanbarang_id]"]').val(penerimaanbarang_id);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
					);
					renameInputRowObatAlkes($("#table-obatalkespasien"));                    
					hitungTotal();
				}else{
					myAlert(data.pesan);
				}
				$('#table-obatalkespasien').removeClass('animation-loading');
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
    }else{
        myAlert("Isikan tanggal kadaluarsa terlebih dahulu");
    }
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var satuanobat = $('#GFRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
	
	$("#GFFakturpembelianT_biayamaterai").val(formatNumber($("#GFFakturpembelianT_biayamaterai").val()));
	
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    var penerimaanbarang_id = '<?php echo $modPenerimaanBarang->penerimaanbarang_id; ?>';
    var penerimaanbarang_id = '<?php echo $modFakturPembelian->fakturpembelian_id; ?>';
    if(penerimaanbarang_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    if(fakturpembelian_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    $("#diskonSemua").change(function()
    {
        $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').prop("readonly", !$(this).is(":checked")).val(0);
        hitungTotal();
    });
});
</script>