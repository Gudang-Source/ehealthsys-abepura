<div class="white-container">
    <fieldset class="box">
        <legend class="rim">Ubah Jadwal Dokter</legend>
        <?php
        $this->breadcrumbs=array(
                'Rdjadwaldokter Ms'=>array('index'),
                $model->jadwaldokter_id=>array('view','id'=>$model->jadwaldokter_id),
                'Update',
        );

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model,'listHari'=>$listHari)); ?>
    </fieldset>
</fieldset>