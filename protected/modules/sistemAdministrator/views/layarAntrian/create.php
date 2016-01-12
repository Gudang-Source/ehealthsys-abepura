<div class="white-container">
    <legend class="rim2">Tambah <b>Layar Antrian</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Salayarantrian Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</div>