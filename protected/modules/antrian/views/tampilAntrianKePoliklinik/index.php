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
    .content {
        /*margin: 0;*/
        margin: 125px 20px 20px 20px;
    }
    .judul{
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: black;
        padding-bottom: 0px;
        text-shadow: none;
    }
    .ruangan,.dokter{
        color: #FFFF00;
        width: <?php echo $modLayar->layarantrian_itemwidth; ?>;
        height: 20px;
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
        font-size: 50px;
        font-weight: bold;
        color: black;
        background-color:rgba(255,255,255,0.5);
        
        text-shadow:
            -1.5px -1.5px 0 #aaa,  
             1.5px -1.5px 0 #aaa,
             -1.5px 1.5px 0 #aaa,
              1.5px 1.5px 0 #aaa;
        
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
        color: white;
        
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
        font-size: 15px !important;
    }
    
    .w1 {
        width: 25%;
        float: left;
        padding-left: 5px;
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
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'modRuangans'=>$modRuangans,'modLayar'=>$modLayar,'konfig'=>$konfig)); ?>

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