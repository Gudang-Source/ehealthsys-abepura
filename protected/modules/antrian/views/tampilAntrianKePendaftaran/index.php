<style>
    body{
        background-image: url("images/antrian/bg_antrian.jpg");
		background-repeat: no-repeat;
		background-position: center top;
		background-size: 100% auto;
		/* width: 980px; */
		color: #000;
		height: 0;
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
    td{
        text-align: right;
        padding-right: 20px;
    }
    .judul{
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .loket-nama{
        font-size: 20px;
        text-align: center;
        background-color:rgba(0,0,0,1);
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
        border: 1px solid #fff;
        border-bottom: none;
    }
    .no-antrian{
        color:#fff;
        text-align: center;
        font-size: 80px;
        font-weight: bold;
        background-color:rgba(255,255,255,0.5);
        text-shadow:
            -2px -2px 0 #000,  
             1px -2px 0 #000,
             -2px 2px 0 #000,
              2px 2px 0 #000;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top: none;
    }
	.box-antrian{
		margin-top: 40px;
	}
    .statistik{
        font-size: 15px;
        color:#fff;
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        background-color: rgba(34, 86, 11, 0.8);
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        padding: 2px 7px;
        border: 1px solid #fff;
    }
    #loket_2 .loket-nama{
        background-color:#000099 !important; 
    }
	#loket_3 .loket-nama{
        background-color:#bb0c0c !important; 
    }
</style>
<div class="row-fluid judul">NO. ANTRIAN PENDAFTARAN RAWAT JALAN</div>
<?php echo CHtml::hiddenField('jamsekarang',"",array('readonly'=>true,'class'=>'realtime')) ;?>
<div class="row-fluid">
    <?php  
    if(count($modLokets) > 0){
        foreach($modLokets AS $i => $loket){
    ?>
            <div class="span4">
                <div id="loket_<?php echo $loket->loket_id;?>" class="antrian">
                    <div class="loket-nama" style="background-color:#484848;">
                        <?php echo strtoupper($loket->loket_nama); ?><br/>DI LOKET <?php echo $loket->loket_nourut; ?>
                    </div>
                    <div class="no-antrian">
                        <?php echo $loket->loket_singkatan; ?>-000
                    </div>
                    <?php echo $this->renderPartial('_formAntrian',array('model'=>$model)); ?>
                    <div class="statistik">
                        <?php echo $this->renderPartial('_statistik',array('loket'=>$loket)); ?>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'konfig'=>$konfig)); ?>
<div id="suarapanggilan" ></div> <!-- >
