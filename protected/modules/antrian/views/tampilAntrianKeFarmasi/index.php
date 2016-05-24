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
    .antrian {
        margin-left: 5px;
    }
    .judul{
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .ruangan,.dokter{
        color: #FFFF00;
        width: 100%;
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
        font-size: 35px;
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
        width: 100%;
        font-size: 35px;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top:none;
        background-color: #020;
        /*height: 20px;*/
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
    
    .block-footer-antrian {
        position: absolute;
        bottom: 0px;
        width: 100%;
        background-color: white;
        
    }
    
    #textrunning {
        color: #007;
        text-shadow: none;
        font-size: 20px;
    }
    
    #clock {
        position: absolute;
        bottom: 0px;
        right: 0px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 20px;
        padding: 0px;
        padding-left: 6px;
        padding-right: 6px;
        background-color: white;
    }
    
    .content {
        margin-left: 0px !important;
    }
    
</style>
<div class="row-fluid judul">NO. ANTRIAN PENGAMBILAN OBAT FARMASI</div>
<div class="row-fluid">
    <?php $i = "apotek"; ?>
    <div>
        <div id="ruangan_<?php echo $i; ?>" class="antrian" style="width:100%;height:150px;">
            <div class="ruangan" id="ruangan_<?php echo $i; ?>">
                <span>< Ruangan Apotek ></span>
            </div>
            <?php /*
            <div class="dokter" id="dokter_<?php echo $i; ?>">
                <span>Nama Dokter</span>
            </div>
             * 
             */ ?>
            <div class="no-antrian">
                0-000
            </div>
            <div class="pasien-deskripsi" id="pasien-deskripsi_<?php echo $i; ?>">
                <span>< Nama Pasien > - < No Resep ></span>
            </div>
            <br>
            <iframe id="suarapanggilan" src="" style="display:none;">
            </iframe>
        </div>
    </div>
    <?php /*
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
    /*
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
     * 
     */
    ?>
</div>

<?php $profil = ProfilrumahsakitM::model()->find(); ?>
<div class="block-footer-antrian">
    <div id="footerAntrian">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php echo $profil->nama_rumahsakit." - ".$profil->motto; ?>
        </marquee>
    </div> 
    <div id="footerClock">
        <div id="clock"></div>
    </div>
</div>
<script>
            var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
            function updateClock ( )
            {
                
                
                var currentTime = new Date ( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );
                
                var currentDate = currentTime.getDate();
                var currentMonth = currentTime.getMonth();
                var currentYear = currentTime.getFullYear();
                
                // Pad the minutes and seconds with leading zeros, if required
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
                
                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
                
                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
                
                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                
                // Compose the string for display
                var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " - " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                
                $("#clock").html(currentTimeString);
                
            }
            
            $(document).ready(function()
            {
                setInterval('updateClock()', 1000);
            });
            
 </script>

<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'konfig'=>$konfig)); ?>
<div id="suarapanggilan" ></div>
