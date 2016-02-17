<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function inputPemakaianBahan(obj)
{
//    var daftartindakan_id = $('#daftartindakanPemakaianBahan').val();
    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
	var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var jumlah = $(obj).parents('fieldset').find('#qty_input').val();
    if (jumlah == ''){
        $('#qty_input').val(1);
    }
//    if(daftartindakan_id == null){
//        myAlert('Belum ada Tindakan');
//        return false;
//    }
        
   if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,pendaftaran_id:pendaftaran_id},
            dataType: "json",
            success:function(data){
			   if(data.pesan !== ""){
				   myAlert(data.pesan);
				   return false;
			   }
			   $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
			   var tambahkandetail = true;
			   var obatalkesyangsama = $("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
			   if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
				   myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",function(r) {
					   if(r){
						   $("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
							   $(this).parents('tr').detach();
						   });
					   }else{
						   tambahkandetail = false;
					   }
				   });
			   }
			   if(tambahkandetail){
				   $('#tblInputPemakaianBahan > tbody').append(data.form);
				   $("#tblInputPemakaianBahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					   {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				   );
				   renameInputRowObatAlkes($("#tblInputPemakaianBahan"));  
			   }			

//						$('#tblInputPemakaianBahan > tbody').append(data.form);

			   $('#namaObatNonRacik').val('');
			   $('#qty_input').val(1);
			   $('#obatalkes_id').val('');						
			   $('.integer').each(function(){this.value = formatNumber(this.value)});
			   renameInputRowObatAlkes($("#tblInputPemakaianBahan"));
			   hitungTotal();
			   $('.qty').each(function(){
				   hitungSubTotal(this);
			   });
		},
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
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
}

function removeObat(obj)
{
    myConfirm("Apakah anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
			renameInputRowObatAlkes($("#tblInputPemakaianBahan"));
            hitungTotal();
        }
    });
}

function renameInputAfterRemove(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPemakaianBahan tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}
    
function hitungSubTotal(obj)
{
    var qty = obj.value;
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual_oa]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[iurbiaya]"]').val(formatNumber(subtotal));
    hitungTotal(); 
}
    
function hitungTotal()
{
    var total = 0;
    var totalQty = 0;
//    $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function(){
//        total = total + unformatNumber(this.value);
//    });
    $('#tblInputPemakaianBahan').find('input[name$="[qty_oa]"]').each(function(){
        totalQty = totalQty + unformatNumber(this.value);
    });
//    $('#totPemakaianBahan').val(formatNumber(total));
    $('#totQtyPemakaianBahan').val(formatNumber(totalQty));
}
function validasi(){
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlahObat = $('#qty_input').val();
    if (obatalkes_id == ''){
        myAlert('Obat Belum Diisi');
    } else if (jumlahObat == ''){
        myAlert('jumlah Obat Belum Diisi')
    } else if (jumlahObat < 1){
        myAlert('jumlah Obat Tidak Sesuai')
    } else {
        inputPemakaianBahan(obatalkes_id);
    }
    
}

function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}

</script>