<fieldset class="box">
    <?php
    $this->breadcrumbs=array(
            'Sajenispemeriksaanlab Ms'=>array('index'),
            'Create',
    );
    ?>
    <legend class="rim">Tambah Jenis Pemeriksaan Lab</legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>