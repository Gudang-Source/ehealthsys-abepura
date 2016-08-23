<script type="text/javascript">
/**
 * Override setKarcis di view pendaftaranRawatJalan._jsFunctions
 */
function setKarcisAll(){
    <?php  
    if(count($modPasienMasukPenunjangs) > 0){
        foreach($modPasienMasukPenunjangs AS $i=>$modPasienMasukPenunjang){
    ?>
            var is_adakarcis = $("#form-karcis-<?php echo $i; ?>").parent().find('input[name$="[is_adakarcis]"]').val();
            if(is_adakarcis == 1){
                setKarcisPenunjang(<?php echo $i ?>);
            }
    <?php
        }
    }
    ?>
}    
/**
 * menampilkan karcis berdasarkan index form penunjang
 */
function setKarcisPenunjang(form_index)
{
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var ruangan_id = $("#form-masukpenunjang-"+form_index).find('input[name$="[ruangan_id]"]').val();
    var kelaspelayanan_id = $("#form-masukpenunjang-"+form_index).find('input[name$="[kelaspelayanan_id]"]').val();
    
    if(ruangan_id !== "" && kelaspelayanan_id !=="" && penjamin_id !== "") {
        $("#form-karcis-"+form_index).addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {form_index:form_index, kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-karcis-"+form_index+" #content-karcis-html").html(data.listKarcis[form_index]);
                $("#form-karcis-"+form_index).removeClass("animation-loading");
                $("#form-karcis-"+form_index+" #content-karcis-html table > tbody a").click();
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
       $("#form-karcis-"+form_index).find("#content-karcis-html").html("");
    }
       
}
    
    
<?php  
if(count($modPasienMasukPenunjangs) > 0){
    foreach($modPasienMasukPenunjangs AS $i=>$modPasienMasukPenunjang){
?>
        /** control accordion penunjang */
        $('#form-masukpenunjang-<?php echo $i; ?> > div > .accordion-heading').click(function(){
            var is_pilihpenunjang = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, "[".$i."]is_pilihpenunjang"); ?>");
            if(is_pilihpenunjang.val() > 0){ //hide
                is_pilihpenunjang.val(0);
            }else{//show
                is_pilihpenunjang.val(1);
            }
        });
        /** control accordion karcis lab klinik*/
        $('#form-karcis-<?php echo $i; ?> > div > .accordion-heading').click(function(){
            var is_adakarcis = $("#form-karcis-<?php echo $i; ?>").parent().find('input[name$="[is_adakarcis]"]');
            if(is_adakarcis.val() > 0){ //hide
                is_adakarcis.val(0);
            }else{//show
                is_adakarcis.val(1);
            }
        });
<?php
    }
}
?>
/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 */
function pilihKarcis(obj){
    var is_pilihkarcis = $(obj).parents('tr').find('input[name$="[is_pilihkarcis]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihkarcis]"]').val(0);
        $(this).removeClass('checked');
    });
    if(is_pilihkarcis.val() > 0){
        is_pilihkarcis.val(0);
        $(obj).parents('tr').removeClass('checked');
    }else{
        is_pilihkarcis.val(1);
        $(obj).parents('tr').addClass('checked');
    }
}



function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}

/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcisPenunjang',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}


$(document).ready(function() {
    $("#form-masukpenunjang-3 a").click(function() {
        $("#form-karcis-3 a").click();
    });
	$("#form-masukpenunjang-4 a").click(function() {
        $("#form-karcis-4 a").click();
    });
});
</script>
    