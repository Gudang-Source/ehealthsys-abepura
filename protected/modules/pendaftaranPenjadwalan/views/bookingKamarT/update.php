<div class="white-container">
    <legend class="rim2">Ubah Data <b>Pesan Kamar</b></legend>
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
</div>