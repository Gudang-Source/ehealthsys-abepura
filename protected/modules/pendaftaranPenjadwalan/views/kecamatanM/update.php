<fieldset class="box">
  <legend class="rim">Ubah Kecamatan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkecamatan Ms'=>array('index'),
            $model->kecamatan_id=>array('view','id'=>$model->kecamatan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>