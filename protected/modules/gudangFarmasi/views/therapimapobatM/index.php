<div class="white-container">
    <legend class="rim2">Tambah <b>Kelas Terapi Obat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gfobat Alkes Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>