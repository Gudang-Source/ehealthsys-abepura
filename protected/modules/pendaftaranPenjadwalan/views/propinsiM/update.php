<fieldset class="box">
  <legend class="rim">Ubah Propinsi</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppropinsi Ms'=>array('index'),
            $model->propinsi_id=>array('view','id'=>$model->propinsi_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>