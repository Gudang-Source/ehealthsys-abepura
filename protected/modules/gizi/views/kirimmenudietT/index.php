<?php
    $this->widget('bootstrap.widgets.BootAlert'); 
?>

<?php echo $this->renderPartial('_form', array(
            'model'=>$model, 
            'modPesan'=>$modPesan, 
            'modDetailPesan'=>$modDetailPesan,
            'modPendaftaran'=>$modPendaftaran,
            'modPasienPenunjang'=>$modPasienPenunjang,
            'modDetailKirim'=>$modDetailKirim
        )); ?>
