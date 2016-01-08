<fieldset class="box">
    <legend class="rim">Tambah Kelas Pelayanan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkelaspelayanan Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>