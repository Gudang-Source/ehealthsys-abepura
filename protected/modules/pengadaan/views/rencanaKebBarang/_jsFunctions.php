<script type="text/javascript">
function tambahBarang()
{
    var idBarang = $('#idBarang').val();
    var jumlah = $('#jumlah').val();
    
        if(idBarang != '')
        {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('loadFormRencanaKebutuhan'); ?>',
                data: {idBarang:idBarang,jumlah:jumlah},//
                dataType: "json",
                success:function(data){
                    $('#table-barang > tbody').append(data.form);
                    $("#table-barang").find('input[name$="[ii][barang_id]"]').val(idBarang);
                    $("#table-barang").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowBarang($("#table-barang"));                    
                    hitungTotal();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            myAlert("Isikan item barang terlebih dahulu");
        }
}

function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    $('#table-barang tbody tr').each(function(){
        var jmlpermintaan  = parseInt($(this).find('input[name$="[jmlpermintaanbarangdet]"]').val());
        var harga  = parseInt($(this).find('input[name$="[harga_barang]"]').val());
        subtotal = harga * jmlpermintaan;
        
        if(subtotal <= 0){
            subtotal = 0;
        }
        
        total += subtotal;
        $(this).find('input[name$="[subtotal]"]').val(subtotal);
    });
    $('#total').val(total);    
    formatNumberSemua();
}

function cekBarang(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-barang tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan barang rencana kebutuhan terlebih dahulu.');
            return false;
        }else{
            $('#rencanakebutuhan-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

/**
* rename input grid
*/ 

function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){		
        $(this).find("#no_urut").val(row+1);
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
}

function batalBarang(obj){
    myConfirm('Apakah anda akan membatalkan rencana kebutuhan barang ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
        }
    });
    hitungTotal();
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var renkebbarang_id = '<?php echo isset($_GET['renkebbarang_id']) ? $_GET['renkebbarang_id'] : ""; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&renkebbarang_id='+renkebbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

</script>