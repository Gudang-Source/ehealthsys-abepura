<div class="white-container">
    <legend class="rim2">Tambah <b>Gambar Tubuh</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sagambartubuh Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>