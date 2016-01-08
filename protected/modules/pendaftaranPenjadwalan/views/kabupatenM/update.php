<fieldset class="box">
  <legend class="rim">Ubah Kabupaten</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkabupaten Ms'=>array('index'),
            $model->kabupaten_id=>array('view','id'=>$model->kabupaten_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>