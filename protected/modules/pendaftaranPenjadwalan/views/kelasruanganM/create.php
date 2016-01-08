<fieldset class="box">
    <legend class="rim">Tambah Kelas Ruangan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppruangan Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form',array('model'=>$model,'modRuangan'=>$modPelayanan)); ?>
</fieldset>