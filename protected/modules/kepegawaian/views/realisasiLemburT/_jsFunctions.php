<script type="text/javascript">
function submitPegawaiLembur(obj)
{
    var pegawailembur_id = $('#pegawailembur_id').val();   
    var nomorindukpegawai = $('#<?php echo CHtml::activeId($modRencanaLembur,"rencana_nip"); ?>').val();
    if(pegawailembur_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setPegawaiLembur'); ?>',
            data: {pegawailembur_id:pegawailembur_id,nomorindukpegawai:nomorindukpegawai},//
            dataType: "json",
            success:function(data){
                var tambahkanpegawai = true;
                var pegawaiyangsama = $("#table-pegawai input[name$='[pegawai_id]'][value='"+pegawailembur_id+"']");
                if(pegawaiyangsama.val()){ //jika ada obat sudah ada di table
                    if(confirm("Apakah anda akan input ulang pegawai ini?")){
                        $("#table-pegawai input[name$='[pegawai_id]'][value='"+pegawailembur_id+"']").each(function(){
                            $(this).parents('tr').detach();
                        });
                    }else{
                        tambahkanpegawai = false;
                    }
                }
                if(tambahkanpegawai){
                    $('#table-pegawai > tbody').append(data.tr);
                    $("#table-pegawai").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowRencanaLembur($("#table-pegawai"));          
                }
                $('#pegawailembur_id').val('');
                $('#<?php echo CHtml::activeId($modRencanaLembur,"nama_pegawai"); ?>').val('');
                renameInputRowRencanaLembur($("#table-pegawai")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih pegawai dahulu!");
    }
    $("#<?php echo CHtml::activeId($modRencanaLembur,"karlembur_nama"); ?>").focus();   
}

/**
* untuk print permintaan penawaran
 */
function print(caraPrint)
{
    var norealisasi = '<?php echo isset($_GET['norealisasi']) ? $_GET['norealisasi'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&norealisasi='+norealisasi+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
}

/**
* rename input grid
*/ 
function renameInputRowRencanaLembur(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find(".no_urut").val(row+1);
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
</script>