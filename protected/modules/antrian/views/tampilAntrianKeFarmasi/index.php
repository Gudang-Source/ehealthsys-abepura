<style>
    body{
        background-image:url("images/antrian/bg_antrian.jpg");
        background-repeat:no-repeat;
        /*width:980px;*/
        color:#000;
    }
	.content {
		margin: 146px 20px 20px 20px;
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
    thead th{
        text-align: center;
        padding-right: 20px;
    }
    .judul{
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .loket-nama{
        font-size: 20px;
        text-align: center;
        background-color:rgba(0,0,0,1);
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #FFF;
        margin-bottom: 15px;
    }
    .no-antrian{
        color:#fff;
        text-align: center;
        font-size: 60px;
        font-weight: bold;
        background-color:rgba(0,0,0,0.7);
        text-shadow:
            -2px -2px 0 #000,  
             1px -2px 0 #000,
             -2px 2px 0 #000,
              2px 2px 0 #000;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #FFF;
    }
    .statistik{
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        background-color:rgba(0,0,0,0.7);
        height: 320px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #FFF;
    }
    .daftar-judul{
        color:#fff;
        text-align: center;
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }
    .daftar-isi td, th{
        color:#fff;
        background-color:rgba(0,0,0,0.8) !important;
        font-size: 11px;
        text-align: left;
        font-weight: bold;
    }
    
</style>
<div class="row-fluid judul">NO. ANTRIAN PENGAMBILAN OBAT</div>
<div class="row-fluid">
    <div class="span4">
        <div class="loket-nama" style="background-color:#005500">
            LOKET <?php echo strtoupper(RuanganM::model()->findByPk(Params::RUANGAN_ID_APOTEK_1)->ruangan_nama); ?>
        </div>
    <?php  
        if(count($modLokets) > 0){
            foreach($modLokets AS $i => $loket){
        ?>
                <div id="loket_<?php echo $loket->racikan_id ?>" class="antrian">
                    <div class="no-antrian">
                        <?php echo $loket->racikan_singkatan; ?>-0000
                    </div>
                    <?php echo $this->renderPartial('_formAntrian',array('model'=>$model,'loket'=>$loket)); ?>
                   
                </div>
        <?php
            }
        }
        ?>
    </div>

    <?php  
    if(count($modLokets) > 0){
        foreach($modLokets AS $i => $loket){
    ?>
        <div id="daftarantrian_<?php echo $loket->racikan_id ?>" class="span4">
            <div class="statistik">
                <div class="daftar-judul" style="background-color:#550000"><?php echo strtoupper($loket->racikan_nama."(".$loket->racikan_singkatan.")") ?></div>
                <div class="daftar-isi">
                    <?php echo $this->renderPartial('_daftarAntrian',array('data'=>array())); ?>
                </div>
            </div>
        </div>
    <?php
        }
    }
    ?>
</div>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'konfig'=>$konfig)); ?>
<div id="suarapanggilan" ></div>
