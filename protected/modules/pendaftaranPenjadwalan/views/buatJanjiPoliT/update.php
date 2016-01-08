<div class="white-container">
    <legend class="rim2">Ubah Pasien <b>Janji Poli</b></legend>
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('modPPBuatJanjiPoli'=>$modPPBuatJanjiPoli)); ?>
</div>