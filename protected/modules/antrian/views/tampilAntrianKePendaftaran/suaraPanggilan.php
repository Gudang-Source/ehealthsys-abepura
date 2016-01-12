<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/js.sound/jquery.jplayer.min.js'); ?>
<?php 
$jenissuara = KonfigsystemK::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->jenissuaraantrian; 
$jenissuara = isset($jenissuara)?$jenissuara:'PEREMPUAN';
?>
<script type="text/javascript">
/**
 * untuk membuat element jplayer
 * @param {type} i
 * @param {type} ii
 * @param {type} file
 * @returns {undefined}
 */
function mainkanPertama(){
    $("#jquery_jplayer_0_antrian").jPlayer({
        ready: function () {
                $(this).jPlayer("setMedia", {
                        mp3: "<?php echo Yii::app()->request->baseUrl;?>/data/sounds/antrian/mp3/<?php echo $jenissuara ?>/noantrian.mp3",
                }).jPlayer("play");
        },
        play: function() { // To avoid both jPlayers playing together.
                $(this).jPlayer("pauseOthers");
        },
        repeat: function(event) { // Override the default jPlayer repeat event handler
                if(event.jPlayer.options.loop) {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
                                $(this).jPlayer("play");
                        });
                } else {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
                                $("#jquery_jplayer_0_kodeantri").jPlayer("play",0);
                        });
                }
        },
        swfPath: "<?php echo Yii::app()->request->baseUrl;?>/js/js.sound",
        supplied: "mp3",
        wmode: "window",
        autoPlay : true
    });
}   
    
    
/**
 * untuk membuat element jplayer yang dimainkan pertama
 * @param {type} i
 * @param {type} ii
 * @param {type} file
 * @returns {undefined}
 */    
function setPlaylist(i,id,file) {
    $("#jquery_jplayer_" +i+"_"+id).jPlayer( {
        ready: function () {
            jQuery(this).jPlayer("setMedia", {
                mp3: "<?php echo Yii::app()->request->baseUrl.'/data/sounds/antrian/mp3/'.$jenissuara.'/' ?>"+file+".mp3",
            });
        },
        play: function() { // To avoid both jPlayers playing together.
                $(this).jPlayer("pauseOthers");
        },
        repeat: function(event) { // Override the default jPlayer repeat event handler
                if(event.jPlayer.options.loop) {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
                                $(this).jPlayer("play");
                        });
                }else {
                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");
                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {
                            if(id === "antrian"){ //setelah antrian (bukan yg pertama)
                                $("#jquery_jplayer_"+i+"_kodeantri").jPlayer("play");
                            }else if(id === "kodeantri"){ //setelah kodeantri di play
                                $("#jquery_jplayer_"+i+"_0").jPlayer("play");
                            }else if(id === "diloket"){ //setelah diloket di play
                                $("#jquery_jplayer_"+i+"_loket").jPlayer("play");
                            }else if(id === "loket"){ //setelah loket di play
                                if(i == 0){//jika no antrian pertama yg di panggil
                                    var next_i = parseInt(i)+1;
                                    $("#jquery_jplayer_"+next_i+"_antrian").jPlayer("play");
                                }
                            }else{
                                var next_id = parseInt(id) + 1;
                                // if(next_id < 4<?php //echo strlen($modLokets[0]->loket_formatnomor); ?>){
                                var nomor = $('#jplayer_'+i).find('.nomor').length;
                                console.log(nomor);
                                if(next_id < nomor){
                                    $("#jquery_jplayer_"+i+"_"+next_id).jPlayer("play");
                                }else{ //setelah noantrian di play
                                    $("#jquery_jplayer_"+i+"_diloket").jPlayer("play");
                                }
                            }

                        });
                }
        },
        swfPath: "<?php echo Yii::app()->request->baseUrl;?>/js/js.sound",
        supplied: "mp3",
        wmode: "window",
        cssSelectorAncestor: "#jp_interface_"+i+"_"+ id,
    });
}
</script>

<?php
if(count($noantrians) > 0){
    foreach($noantrians AS $i => $noantrian){
?>
        <div id="jplayer_<?php echo $i;?>">
            <div id="jquery_jplayer_<?php echo $i;?>_antrian" class="jp-jplayer"></div>
            <div id="jquery_jplayer_<?php echo $i;?>_kodeantri" class="jp-jplayer"></div>
            <?php 
            $noantrian_split = explode(" ", strtolower(MyFormatter::formatNumberTerbilang((int)$noantrian)));
            if(count($noantrian_split) > 0){
                foreach($noantrian_split as $ii => $nomor){
            ?>
                <div id="jquery_jplayer_<?php echo $i;?>_<?php echo $ii; ?>" class="jp-jplayer nomor"></div>
            <?php 
                }
            }
            ?>
            <div id="jquery_jplayer_<?php echo $i;?>_diloket" class="jp-jplayer"></div>
            <div id="jquery_jplayer_<?php echo $i;?>_loket" class="jp-jplayer"></div>
        </div>

        <script type="text/javascript">

            
            <?php if($i > 0){?> //jika bukan noantrian pertama
                setPlaylist("<?php echo $i;?>","antrian","noantrian");
            <?php } ?>

            setPlaylist("<?php echo $i;?>","kodeantri","<?php echo strtolower(trim($modLokets[$i]->loket_singkatan)); ?>");
            setPlaylist("<?php echo $i;?>","diloket","diloket");
            setPlaylist("<?php echo $i;?>","loket","<?php echo strtolower(trim($modLokets[$i]->loket_nourut)); ?>");

            <?php 
            if(count($noantrian_split) > 0){
                foreach($noantrian_split as $ii => $nomor){
            ?>
                        setPlaylist("<?php echo $i;?>","<?php echo $ii ?>","<?php echo $nomor?>");
            <?php 
                    }
                }
            ?>
        </script>
        
<?php
    }
}
?>

<script type="text/javascript">
//$(document).ready(function(){
//    setTimeout(function(){
        mainkanPertama();
//    },5000);
//});
</script>
