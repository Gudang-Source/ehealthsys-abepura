<script type="text/javascript">

/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(antrian_id){
    ruangan_id = $('#ruangan').val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {antrian_id:antrian_id,ruangan_id:ruangan_id},
        dataType: "json",
        success:function(data){
            var i = 0;
            var noantrians = [];
            var loket_ids = [];
            var antrian_ids = [];
            if(data.a.antrian_id !== null){
                var antrian_id = $("#loket_1 #<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
                if(antrian_id != data.a.antrian_id){
                    noantrians[i] = data.a.noantrian;
                    loket_ids[i] = data.a.loket_id;
                    antrian_ids[i] = data.a.antrian_id;
                    i++;
                    setFormAntrian($("#data-antrian"),data.a);
                }
            }
            if(i > 0){ //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilan(noantrians,loket_ids,antrian_ids);
            }
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
//    console.log(data);
    $(obj).find(".no-antrian").html(data.ruangan_singkatan+"-"+data.noantrian);
    $(obj).find(".loket").html(data.loket_nama);
    $(obj).find(".pasien").html(data.nama_pasien);

}

/**
 * set tabel statistik
 * @param {type} obj
 * @param {type} data
 * @returns {undefined}
 */
// function setTableStatistik(obj, data){
//     $(obj).find("#label_jmlpasien").html("JUMLAH PASIEN "+data.loket_nama);
    
//     $(obj).find("#jmlpasien").html(data.jmlpasien);
//     $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
//     $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
// }

/**
 * 
 * @param {type} param
 */
function setSuaraPanggilan(noantrians, loket_ids, antrian_ids){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('suaraPanggilan'); ?>',
        data: {noantrians:noantrians, loket_ids:loket_ids,antrian_ids:antrian_ids},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


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