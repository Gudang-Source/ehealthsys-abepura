<fieldset class="box">
    <legend class="rim">Ubah Klasifikasi Diagnosa</legend>
    <?php
    $this->breadcrumbs=array(
            'Saklasifikasidiagnosa Ms'=>array('index'),
            $model->klasifikasidiagnosa_id=>array('view','id'=>$model->klasifikasidiagnosa_id),
            'Update',
    );

    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form',array('model'=>$model)); ?>
</fieldset>