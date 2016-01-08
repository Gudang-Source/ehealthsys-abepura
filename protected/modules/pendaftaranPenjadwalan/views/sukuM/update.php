<fieldset class="box">
  <legend class="rim">Ubah Suku</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppsuku Ms'=>array('index'),
            $model->suku_id=>array('view','id'=>$model->suku_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>