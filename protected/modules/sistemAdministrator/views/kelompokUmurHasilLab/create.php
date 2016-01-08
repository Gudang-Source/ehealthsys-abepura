<fieldset class="box">
    <legend class="rim">Tambah Kelompok Umur Hasil Lab</legend>
    <?php
    $this->breadcrumbs=array(
            'Lbkelkumurhasillab Ms'=>array('index'),
            'Create',
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
</fieldset>