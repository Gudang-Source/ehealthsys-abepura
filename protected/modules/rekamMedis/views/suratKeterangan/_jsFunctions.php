<?php

$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<script type='text/javascript'>
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
   
        if(!requiredCheck($("#form-rekam-medik"))){
            myAlert('Inputan bertanda <font style = "color:red;">*</font> harap di isi !!');
            return false;
        }
   
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame");
    var pendaftaran_id = $('#RKPendaftaranT_pendaftaran_id').val();
    var pasienadmisi_id = $('#RKPendaftaranT_pasienadmisi_id').val();
    var caramasuk_id = $('#RKPendaftaranT_caramasuk_id').val();
	var jeniskelamin  = $('#RKPasienM_jeniskelamin').val();
    var tab2 = $('.active').text();
    if (requiredCheck($("#")))
    
    if(tab2 == 'Opname (Sudah Pulang)1' || tab2 == 'Opname (Sedang Dirawat)1' || tab2 == 'Indikasi Rawat Inap1'){       
        if(pasienadmisi_id == '' && pendaftaran_id != '' || caramasuk_id != <?php echo Params::CARAMASUK_ID_LANGSUNG_RI; ?>){
            myAlert('Pasien bukan dari ruangan Rawat Inap');
            setTab($('#default-tab'));
            return false;
        }
    }
    if(tab2 == 'Cuti Hamil1' || tab2 == 'Cuti Melahirkan1'){       
        if(jeniskelamin == 'LAKI-LAKI' && pendaftaran_id != ''){
            myAlert('Pasien bukan berjenis kelamin Perempuan');
            setTab($('#default-tab'));
            return false;
        }
    }
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendaftaran_id="+pendaftaran_id+"");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}
</script>