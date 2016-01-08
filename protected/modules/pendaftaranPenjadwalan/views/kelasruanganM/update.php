<fieldset class="box">
    <legend class="rim">Ubah Kelas Ruangan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppruangan Ms'=>array('index'),
            $model->ruangan_id=>array('view','id'=>$model->ruangan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model, 'modRuangan'=>$modPelayanan)); ?>
</fieldset>