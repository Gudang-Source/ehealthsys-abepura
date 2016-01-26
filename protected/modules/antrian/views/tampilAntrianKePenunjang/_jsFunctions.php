<script type="text/javascript">
/************************************************************************************************************
(C) www.dhtmlgoodies.com, October 2005

This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	

Terms of use:
You are free to use this script as long as the copyright message is kept intact. However, you may not
redistribute, sell or repost it without our permission.

Thank you!

www.dhtmlgoodies.com
Alf Magne Kalleland

************************************************************************************************************/	
var fitTextInBox_maxWidth = false;
var fitTextInBox_maxHeight = false;
var fitTextInBox_currentWidth = false;
var fitTextInBox_currentBox = false;
var fitTextInBox_currentTextObj = false;
function fitTextInBox(boxID,maxHeight)
{
        if(maxHeight)fitTextInBox_maxHeight=maxHeight; else fitTextInBox_maxHeight = 10000;
        var obj = document.getElementById(boxID);
        fitTextInBox_maxWidth = obj.offsetWidth;	
        fitTextInBox_currentBox = obj;
        fitTextInBox_currentTextObj = obj.getElementsByTagName('SPAN')[0];
        fitTextInBox_currentTextObj.style.fontSize = '1px';
        fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;
        fitTextInBoxAutoFit();

}	

function fitTextInBoxAutoFit()
{
        var tmpFontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px','')/1;
        fitTextInBox_currentTextObj.style.fontSize = tmpFontSize + 1 + 'px';
        var tmpWidth = fitTextInBox_currentTextObj.offsetWidth;
        var tmpHeight = fitTextInBox_currentTextObj.offsetHeight;
        if(tmpWidth>=fitTextInBox_currentWidth && tmpWidth<fitTextInBox_maxWidth && tmpHeight<fitTextInBox_maxHeight && tmpFontSize<300){		
                fitTextInBox_currentWidth = fitTextInBox_currentTextObj.offsetWidth;	
                fitTextInBoxAutoFit();
        }else{
                fitTextInBox_currentTextObj.style.fontSize = fitTextInBox_currentTextObj.style.fontSize.replace('px','')/1 - 1 + 'px';
        }		
}

/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(pasienmasukpenunjang_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {layarantrian_id:<?php echo $_GET['layarantrian_id']; ?>,pasienmasukpenunjang_id:pasienmasukpenunjang_id},
        dataType: "json",
        success:function(data){
            <?php 
            if(count($modRuangans) > 0){
                foreach($modRuangans AS $i=>$ruangan){
            ?>
                    if(data.r_<?php echo $ruangan->ruangan_id;?>.pasien_id !== null){

                        var pasienmasukpenunjang_id = $("#ruangan_<?php echo $ruangan->ruangan_id;?>  #<?php echo CHtml::activeId($model, 'pasienmasukpenunjang_id'); ?>").val();
                        //if(data.r_<?php echo $ruangan->ruangan_id;?>.pasienmasukpenunjang_id != pasienmasukpenunjang_id){
                        //    console.log('tes');
                            setFormAntrian($("#ruangan_<?php echo $ruangan->ruangan_id;?>"),data.r_<?php echo $ruangan->ruangan_id;?>);
                            var kodeantrian = data.r_<?php echo $ruangan->ruangan_id;?>.ruangan_singkatan;
                            var noantrian = data.r_<?php echo $ruangan->ruangan_id;?>.no_urutperiksa;
                            var ruangan_id = data.r_<?php echo $ruangan->ruangan_id;?>.ruangan_id;
                            setSuaraPanggilanSingle(kodeantrian,noantrian,ruangan_id);

                        //}
                    }
                    fitTextInBox('ruangan_'+<?php echo $i; ?>,50);
                    fitTextInBox('dokter_'+<?php echo $i; ?>,50);
                    fitTextInBox('pasien-deskripsi_'+<?php echo $i; ?>,50);
            <?php
                }
            }
            ?>
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set div antrian
 * @param {type} obj
 * @param {type} data
 * @returns {undefined} */
function setFormAntrian(obj, data){

    $(obj).find("#<?php echo CHtml::activeId($model, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'pasienmasukpenunjang_id'); ?>").val(data.pasienmasukpenunjang_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(data.ruangan_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_id'); ?>").val(data.carabayar_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val(data.antrian_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'pegawai_id'); ?>").val(data.pegawai_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_nama'); ?>").val(data.ruangan_nama);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_singkatan'); ?>").val(data.ruangan_singkatan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'tgl_pendaftaran'); ?>").val(data.tgl_pendaftaran);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_pendaftaran'); ?>").val(data.no_pendaftaran);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_urutperiksa'); ?>").val(data.no_urutperiksa);
    $(obj).find("#<?php echo CHtml::activeId($model, 'no_rekam_medik'); ?>").val(data.no_rekam_medik);
    $(obj).find("#<?php echo CHtml::activeId($model, 'namadepan'); ?>").val(data.namadepan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'nama_pasien'); ?>").val(data.nama_pasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'gelardepan'); ?>").val(data.gelardepan);
    $(obj).find("#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>").val(data.nama_pegawai);
    $(obj).find("#<?php echo CHtml::activeId($model, 'gelarbelakang_nama'); ?>").val(data.gelarbelakang_nama);
    $(obj).find("#<?php echo CHtml::activeId($model, 'statuspasien'); ?>").val(data.statuspasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'panggilantrian'); ?>").val(data.panggilantrian);
    var gelarbelakang = "";
    if(data.gelarbelakang_nama !== null)
        gelarbelakang = ", "+data.gelarbelakang_nama;
        gelardepan = data.gelardepan;
        if(gelardepan==null){
            gelardepan = '';
        }
    $(obj).find(".dokter").html("<span>"+gelardepan+" "+data.nama_pegawai+gelarbelakang+"</span>");
    $(obj).find(".no-antrian").html(data.ruangan_singkatan+"-"+data.no_urutperiksa);
    $(obj).find(".pasien-deskripsi").html("<span>"+data.namadepan+" "+data.nama_pasien+"<span>");

}


function setTableStatistik(obj, data){
    $(obj).find("#label_jmlpasien").html("JUMLAH PASIEN "+data.statuspasien);
    
    $(obj).find("#jmlpasien").html(data.jmlpasien);
    $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
    $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
}

/**
 * suara panggilan per ruangan
 * @param {type} param
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){

    $("#ruangan_"+ruangan_id+" #suarapanggilan").attr("src","<?php echo $this->createUrl('suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

/**
 * fungsi .ready() harus tetap di bawah
 * @param {type} param */
$( document ).ready(function(){
    setAntrians('');
    <?php if($konfig->is_nodejsaktif){ ?>
    var chatServer='<?php echo $konfig->nodejs_host ?>';
    if (chatServer == ''){
     chatServer='http://localhost';
    }
    var chatPort='<?php echo $konfig->nodejs_port ?>';
    socket = io.connect(chatServer+':'+chatPort);
    socket.emit('subscribe', 'antrian');
    socket.on('antrian', function(data){
        setAntrians(data.antrian_id);
    });
    <?php }else{ ?>
    setInterval(function(){setAntrians('');},4000);
    <?php } ?>
    //DINONAKTIF KAN KARENA BERAT JIKA DI EKSEKUSI DI SMART TV BOX (TARAKAN) >> setInterval(function(){reloadHalaman();},1000);
});    
</script>