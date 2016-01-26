<style>
    body{
        background-image:url("<?php echo Params::urlBackgroundAntrian().$modLayar->layarantrian_latarbelakang; ?>");
        background-repeat:no-repeat;
        /*width:980px;*/
        color:#000;
    }
	.content {
		margin: 136px 20px 20px 20px;
	}
    div{
        font-size: 20px;
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
    .judul{
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .ruangan,.dokter{
        color: #FFFF00;
        width: <?php echo $modLayar->layarantrian_itemwidth; ?>;
        height: 50px;
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
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }
    .no-antrian, .pasien-deskripsi{
        color:#fff;
        text-align: center;
        font-size: 120px;
        font-weight: bold;
        background-color:rgba(255,255,255,0.5);
        text-shadow:
             -2px -2px 0 #000,
             2px -2px 0 #000,
             -2px 2px 0 #000,
             2px 2px 0 #000,
             0px -2px 0 #000,
             0px 2px 0 #000,
             -2px 0px 0 #000,
             2px 0px 0 #000;
    }
    .no-antrian{
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }
    .pasien-deskripsi{
        /*font-size: 70%;*/
        width: <?php echo $modLayar ->layarantrian_itemwidth; ?>;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top:none;
        background-color: #020;
        /*height: 20px;*/
    }
    .statistik{
        color:#fff;
        text-shadow:
            -2px -2px 0 #000,
             2px -2px 0 #000,
             -2px 2px 0 #000,
             2px 2px 0 #000,
             0px -2px 0 #000,
             0px 2px 0 #000,
             -2px 0px 0 #000,
             2px 0px 0 #000;
        background-color:rgba(0,0,0,0.8);
    }
    
    .content {
        margin-top: 140px;
    }
</style>
<!--div class="row-fluid judul"><?php echo $modLayar->layarantrian_judul; ?></div-->
    <?php 
    if(count($modRuangans) > 0){
        foreach($modRuangans AS $i=>$ruangan){
            if(($i==0)||($i) % 3 == 0){
                echo '<div class="row-fluid">';
            }    ?>
            <div>
                <div id="ruangan_<?php echo $ruangan->ruangan_id; ?>" class="antrian" style="width:100%;height:150px;">
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
            if(($i+1>0)&&(($i+1) % 3 == 0)){
                echo '</div>';
            }
        }
    } 
    ?>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'modRuangans'=>$modRuangans,'modLayar'=>$modLayar,'konfig'=>$konfig)); ?>