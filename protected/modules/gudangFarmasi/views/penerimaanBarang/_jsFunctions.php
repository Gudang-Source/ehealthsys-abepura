<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
/** control accordion uang muka */
$('#form-uangmuka > div > .accordion-heading').click(function(){
    var is_uangmuka = $("#<?php echo CHtml::activeId($modPenerimaanBarang, "is_uangmuka"); ?>");
    if(is_uangmuka.val() > 0){ //hide
        is_uangmuka.val(0);
    }else{//show
        is_uangmuka.val(1);
		$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",true);
    }
    
//    $("#form-uangmuka :input").attr("readonly",false);
});

/** control accordion faktur pembelian */
$('#form-fakturpembelian > div > .accordion-heading').click(function(){
    var is_langsungfaktur = $("#<?php echo CHtml::activeId($modPenerimaanBarang, "is_langsungfaktur"); ?>");
    if(is_langsungfaktur.val() > 0){ //hide
        is_langsungfaktur.val(0);
    }else{//show
        is_langsungfaktur.val(1);
    }
    
//    $("input, select, textarea").attr("disabled",false);
//    $("#form-fakturpembelian :input").attr("readonly",false);
    
//    $("#<?php // echo CHtml::activeId($modPenerimaanBarang,'keteranganfaktur'); ?>").attr("readonly",false);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totharganetto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>").attr("readonly",true);
//    $("#<?php // echo CHtml::activeId($modFakturPembelian,'jmldiscount'); ?>").attr("readonly",true);
    
});

function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlah = $('#qty_input').val();
    var nobatch = $('#nobatch').val();
    var tgl_kadaluarsa = $('#<?php echo CHtml::activeId($modPenerimaanBarang,'tglkadaluarsa'); ?>').val()
    
    if(tgl_kadaluarsa != ''){
        if(obatalkes_id != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormPenerimaanBarang'); ?>',
                data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tgl_kadaluarsa:tgl_kadaluarsa, nobatch:nobatch},//
                dataType: "json",
                success:function(data){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name$="[ii][obatalkes_id]"]').val(obatalkes_id);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
                    );

                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    jQuery('input[name$="[tglkadaluarsa]"]').datetimepicker(
                            jQuery.extend(
                                {
                                    showMonthAfterYear:false
                                }, 
                                jQuery.datepicker.regional['id'],
                                {
//                                    'dateFormat':'dd M yy',
                                    'minDate':'d',
                                    'timeText':'Waktu',
                                    'hourText':'Jam',
                                    'minuteText':'Menit',
                                    'secondText':'Detik',
                                    'showSecond':true,
                                    'timeOnlyTitle':'Pilih Waktu',
                                    'timeFormat':'hh:mm:ss',
                                    'changeYear':true,
                                    'changeMonth':true,
                                    'showAnim':'fold',
                                    'yearRange':'-80y:+20y'
                                }
                            )
                        ).mask("99/99/9999 99:99:99");
                    
                    hitungTotal();
                    $("#table-obatalkespasien").find(".satuanobat").change();
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

/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
//        $(this).find('span').each(function(){ //element <input>
//            var old_name = $(this).attr("name").replace(/]/g,"");
//            var old_name_arr = old_name.split("[");
//            if(old_name_arr.length == 3){
//                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
//            }
//        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input[name$="[tglkadaluarsa]"]').each(function(){ //element <input>
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

function setPersenDiskon(obj){
    $(obj).parents("tr").find('input[name$="[persendiscount]"]').val(0);
}

function setJmlDiskon(obj){
    $(obj).parents("tr").find('input[name$="[jmldiscount]"]').val(0);
}

function setPersenDiskonFaktur(obj){
    var obj_persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>');
    obj_persen.val(0);
    if($(obj).is(':checked')){
        obj_persen.attr('readonly',false);
    }else{
        obj_persen.attr('readonly',true);
    }
    setPersenDiskonDetail();
        
}

function setPersenDiskonDetail(){
    var persen = $('#<?php echo CHtml::activeId($modFakturPembelian,'persendiscount'); ?>').val();
    
    $('#table-obatalkespasien tr').each(function(){
        $(this).find('input[name$="[persendiscount]"]').val(persen);
        $(this).find('input[name$="[jmldiscount]"]').val(0);
    });
    hitungTotal();
}
/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

function pilihSatuan(obj){
    unformatNumberSemua();
    var satuanobat = $(obj).val();
    
    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();
        $(obj).parents('tr').find('.netto').val($(obj).parents('tr').find('.netto').val() / $(obj).parents('tr').find('.kemasanbesar').val());
    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
        $(obj).parents('tr').find('.netto').val($(obj).parents('tr').find('.netto').val() * $(obj).parents('tr').find('.kemasanbesar').val());
    }
    formatNumberSemua();
    hitungTotal();
}

function persenPpn(obj){
    if(obj.checked==true){
        var ppn = '<?php echo Yii::app()->user->getState('persenppn'); ?>';
//        $('#<?php //echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(ppn);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').val(0);
        $('#ppn').val(ppn);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakppn'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function persenPph(obj){
    if(obj.checked==true){
        var pph = '<?php echo Yii::app()->user->getState('persenpph'); ?>';
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(pph);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",false);
    }else{
//        $('#<?php // echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').val(0);
        $('#pph').val(pph);
        $('#<?php echo CHtml::activeId($modFakturPembelian,'totalpajakpph'); ?>').attr("readonly",true);
    }
    hitungTotal();
}

function batalObat(obj){
    myConfirm('Apakah anda akan membatalkan penerimaan barang obat ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach(); 
        }
    }); 
    hitungTotal();
}

function persenUangMuka(obj){
    if(obj.checked==true){
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",false);
		$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').attr("readonly",true);
    }else{
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(0);
        $('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').attr("readonly",false);
    }
}

function setUangMuka(obj){
	unformatNumberSemua();
	
	var persen_uang_muka = parseFloat($(obj).val());
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_uang_muka = 0;
	if(persen_uang_muka > 100){
		myAlert('Total persen uang muka tidak boleh lebih dari 100');
		$(obj).val(0);
		return false;
	}
	
	if(persen_uang_muka > 0){
		total_uang_muka = total_harga_bruto * (persen_uang_muka / 100);
	}else{
		total_uang_muka = 0;
	}
		
	$('#<?php echo CHtml::activeId($modUangMuka,'jumlahuang'); ?>').val(total_uang_muka);      
	formatNumberSemua();
}
function setPersenUangMuka(obj){
	unformatNumberSemua();
	
	var uang_muka = parseFloat($(obj).val());
	var total_harga_bruto = parseFloat($('#<?php echo CHtml::activeId($modFakturPembelian,'totalhargabruto'); ?>').val());  
	var total_persen_uang_muka = 0;
	
	if(uang_muka > 0){
		total_persen_uang_muka = Math.round((uang_muka * 100) / (total_harga_bruto));
	}
	
	$('#<?php echo CHtml::activeId($modUangMuka,'persenuangmuka'); ?>').val(total_persen_uang_muka);      
	formatNumberSemua();
}
/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var penerimaanbarang_id = $('#penerimaanbarang_id').val();
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaanbarang_id='+penerimaanbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}


function validasi(obj) {
	if ($("#table-obatalkespasien tbody tr").length == 0) {
		myAlert("Harus ada Obat / Alat Kesehatan yang ditambahkan.");
		return false;
	}
	
	return requiredCheck(obj);
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var satuanobat = $('#GFRencDetailkebT_satuanobat').val();
    $('#satuankecil').hide();
    $('#satuanbesar').hide();
    
    if(satuanobat == 'SATUANKECIL'){
        $('#satuankecil').show();
        $('#satuanbesar').hide();
    }else{
        $('#satuanbesar').show();
        $('#satuankecil').hide();
    }
    
    var penerimaanbarang_id = '<?php echo $modPenerimaanBarang->penerimaanbarang_id; ?>';
    var permintaanpembelian_id = '<?php echo isset($modPermintaanPembelian->permintaanpembelian_id) ? $modPermintaanPembelian->permintaanpembelian_id : null; ?>';
    if(penerimaanbarang_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#penerimaanbarang-form :input").attr("readonly",true);
        $("#penerimaanbarang-form .dtPicker3").attr("readonly",true);
        $("#penerimaanbarang-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);
        
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }
    
    if(permintaanpembelian_id != ""){
        renameInputRowObatAlkes($("#table-obatalkespasien")); 
        hitungTotal();
    }

    // Notifikasi supplier 1
    <?php 
        if(isset($_GET['smscp1'])){
            if($_GET['smscp1']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi supplier 2
    <?php 
        if(isset($_GET['smscp2'])){
            if($_GET['smscp2']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS SUPPLIER 2', isinotifikasi:'<?php echo $modPenerimaanBarang->supplier->supplier_nama; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPenerimaanBarang->penerimaanbarang_id)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Permintaan Pembelian', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
        insert_notifikasi(params);

        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AKUNTANSI ?>, judulnotifikasi:'Permintaan Pembelian', isinotifikasi:'Telah dilakukan penerimaan obat alkes dengan <?php echo $modPenerimaanBarang->nosuratjalan ?> pada <?php echo $modPenerimaanBarang->tglterima ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
			
	$(".alphanumber").keyup(function()
	{
		$(this).val($(this).val().replace(/[^\w\s]/gi, ''));
	});
    
});
</script>