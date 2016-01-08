<fieldset class="box">
    <legend class="rim">Ubah Kelas Pelayanan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkelaspelayanan Ms'=>array('index'),
            $model->kelaspelayanan_id=>array('view','id'=>$model->kelaspelayanan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model,'modRuangan'=>$modRuangan)); ?>
</fieldset>