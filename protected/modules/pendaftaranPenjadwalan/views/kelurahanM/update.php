<fieldset class="box">
  <legend class="rim">Ubah Kelurahan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkelurahan Ms'=>array('index'),
            $model->kelurahan_id=>array('view','id'=>$model->kelurahan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>