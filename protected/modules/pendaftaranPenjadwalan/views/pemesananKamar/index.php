<div class="white-container">
    <legend class="rim2">Pemesanan <b>Kamar</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai)); ?>
    <?php echo $this->renderPartial('_jsFunction', array('model'=>$model,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai)); ?>
</div>
