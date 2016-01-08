<?php 
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Susunan Keluarga', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->createUrl('RiwayatSusunanKeluarga/SusunanKeluarga'))),
        array('label'=>'Pendidikan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->createUrl('RiwayatPendidikan/Pendidikan'))),
        array('label'=>'Pengalaman Kerja', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->createUrl('RiwayatPengalamanKerja/PengalamanKerja'))),
        array('label'=>'Pengalaman Organisasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->createUrl('RiwayatPengalamanOrganisasi/PengalamanOrganisasi'))),
	),
));
?>
    <div>
    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll"  width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);" ></iframe>
    </div>
<script type="text/javascript">
	
function setTab(obj){
    var pegawai_id = <?php echo $pegawai; ?>;
    if(pegawai_id !== ""){
        $(obj).parents("ul").find("li").each(function(){
            $(this).removeClass("active");
            $(this).attr("onclick","setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick","setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src",tab+"&pegawai_id="+pegawai_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }else{
        myAlert("Silahkan pilih data pegawai !");
    }
    return false;

}

function resetIframe(obj) {
    obj.style.height = 150 + 'px';
}

function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
//    obj.style.height = 400 + 'px';
}

</script>
    