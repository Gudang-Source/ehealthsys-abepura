<script>
    var ekt = document.body;
    if (ekt.requestFullscreen) {
      ekt.requestFullscreen();
    } else if (ekt.msRequestFullscreen) {
      ekt.msRequestFullscreen();
    } else if (ekt.mozRequestFullScreen) {
      ekt.mozRequestFullScreen();
    } else if (ekt.webkitRequestFullscreen) {
      ekt.webkitRequestFullscreen();
    }
</script>

<style>
    body{
        background-image:url("<?php echo Params::urlBackgroundAntrian().$modLayar->layarantrian_latarbelakang; ?>");
        background-repeat:no-repeat;
        /*width:100%;*/
        color:#000;
    }
    div{
        font-size: 10px;
        font-weight:bold;
        letter-spacing:2px;
        color: #fff;
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
    }
    td{
        text-align: right;
        padding-right: 20px;
    }
    .content {
        /*margin: 0;*/
        margin: 125px 20px 20px 20px;
    }
    .judul{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .ruangan,.dokter{
        color: #FFFF00;
        width: <?php echo $modLayar->layarantrian_itemwidth; ?>;
        height: 15px;
        /*font-size: 85%;*/
        overflow: hidden;
        text-align: center;
        background-color: #020;
    }
    .ruangan{
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
        border: 1px solid #fff;
        border-bottom: none;
    }
    .dokter{
        /*font-size: 70%;*/
        color: #3F3;
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }
    .no-antrian, .pasien-deskripsi{
        color:#fff;
        text-align: center;
        font-size: 45px;
        font-weight: bold;
        background-color:rgba(255,255,255,0.5);
        text-shadow:
            -1.5px -1.5px 0 #000,  
             1.5px -1.5px 0 #000,
             -1.5px 1.5px 0 #000,
              1.5px 1.5px 0 #000;
    }
    .no-antrian{
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }
    .pasien-deskripsi{
        /*font-size: 70%;*/
        width: <?php echo $modLayar->layarantrian_itemwidth; ?>;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top:none;
        background-color: #020;
        
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        /*height: 20px;*/
    }
    .statistik{
        color:#fff;
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        background-color:rgba(0,0,0,0.8);
    }
    .pasien-deskripsi span {
        font-size: 10px !important;
    }
    
    .w1 {
        width: 25%;
        float: left;
        padding-left: 5px;
    }
</style>
<div class="row-fluid judul"><?php echo $modLayar->layarantrian_judul; ?></div>
    <?php 
    if(count($modRuangans) > 0){
        foreach($modRuangans AS $i=>$ruangan){
            if(($i==0)||($i) % 4 == 0){
                echo '<div class="row-fluid">';
            }    ?>
            <div class="w1">
                <div id="ruangan_<?php echo $ruangan->ruangan_id; ?>" class="antrian" style="width:230px;height:80px;">
                    <div class="ruangan" id="ruangan_<?php echo $i; ?>">
                        <span><?php echo strtoupper($ruangan->ruangan->ruangan_nama); ?></span>
                    </div>
                    <div class="dokter" id="dokter_<?php echo $i; ?>">
                        <span>Nama Dokter</span>
                    </div>
                    <div class="no-antrian">
                        <?php echo $ruangan->ruangan->ruangan_singkatan; ?>-000
                    </div>
                    <div class="pasien-deskripsi" id="pasien-deskripsi_<?php echo $i; ?>">
                        <span>Nama Pasien</span>
                    </div>
                    <?php echo $this->renderPartial('_formKunjungan',array('model'=>$model)); ?>
                    <br>
                    <iframe id="suarapanggilan" src="" style="display:none;">
                    </iframe>
                </div>
            </div>
    <?php
            if(($i+1>0)&&(($i+1) % 4 == 0)){
                echo '</div>';
            }
        }
    } 
    ?>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'modRuangans'=>$modRuangans,'modLayar'=>$modLayar,'konfig'=>$konfig)); ?>