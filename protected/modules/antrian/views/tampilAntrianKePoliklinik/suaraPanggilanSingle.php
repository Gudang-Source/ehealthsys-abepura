<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/js.sound/jquery.jplayer.min.js'); ?>
<?php 
$jenissuara = KonfigsystemK::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->jenissuaraantrian; 
$jenissuara = isset($jenissuara)?$jenissuara:'PEREMPUAN';

?>
<script>
    
$(document).ready(function() {
    setJenisSuaraAntrian("<?php echo Yii::app()->request->baseUrl;?>/data/sounds/antrian/mp3/<?php echo $jenissuara ?>/");
    registerSuaraAntrian([
        {'name': 'noantrian'},
        
        <?php  foreach (str_split(trim($modRuangan->ruangan_singkatan)) as $item) : ?>
        {'name': '<?php echo strtolower($item); ?>'},
        <?php endforeach; ?>
            
        <?php $noantrian_split = explode(" ", strtolower(MyFormatter::formatNumberTerbilang((int)$noantrian)));
        if(count($noantrian_split) > 0){
            foreach($noantrian_split as $ii => $nomor){
        ?>
        {'name': '<?php echo strtolower($nomor); ?>'}, 
        <?php 
            }
        } ?>
                    
        {'name': 'poliklinik'},
         
        <?php if (!empty($modRuangan->ruangan_filesuara) && (trim($modRuangan->ruangan_filesuara) != "")) : ?>{'name': '<?php echo strtolower(trim($modRuangan->ruangan_filesuara)); ?>'},<?php endif; ?>
    ]);
});

</script>
