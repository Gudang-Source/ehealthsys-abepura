<script type="text/javascript">
/**
* untuk print pemesanan ambulans pasien luar
 */
function print(caraPrint)
{
    var pesanambulans_t = '<?php echo isset($modPemesanan->pesanambulans_t) ? $modPemesanan->pesanambulans_t : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pesanambulans_t='+pesanambulans_t+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($smspasien)){
            if($smspasien==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPemesanan->namapasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>

    <?php 
        if(isset($modPemesanan->pesanambulans_t)){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_AMBULANS ?>, judulnotifikasi:'Pemesanan Ambulans', isinotifikasi:'Telah dilakukan pemesanan ambulans atas nama <?php echo $modPemesanan->pasien->nama_pasien ?> dengan <?php echo $modPemesanan->pasien->no_rekam_medik ?> pada <?php echo $modPemesanan->tglpemesananambulans ?> untuk pemakaian pada <?php echo $modPemesanan->tglpemakaianambulans ?>'}; // 16 
        insert_notifikasi(params);
    <?php
        }
    ?>
})


$('#resetbtn').click(function(){
    window.location = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Pemesanan'); ?>';
});

function clearDataPasien()
{
    $("#<?php echo CHtml::activeId($modPemesanan, 'pasien_id') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemesanan, 'norekammedis') ?>").val('');
    $("#<?php echo CHtml::activeId($modPemesanan, 'pendaftaran_id') ?>").val('');
}
</script>