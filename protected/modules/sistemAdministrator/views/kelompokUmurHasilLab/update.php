<fieldset class="box">
    <legend class="rim">Ubah Kelompok Umur Hasil Lab</legend>
    <?php
    $this->breadcrumbs=array(
            'Lbkelkumurhasillab Ms'=>array('index'),
            $model->kelkumurhasillab_id=>array('view','id'=>$model->kelkumurhasillab_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>