<fieldset class="box">
  <legend class="rim">Ubah Pekerjaan</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppekerjaan Ms'=>array('index'),
            $model->pekerjaan_id=>array('view','id'=>$model->pekerjaan_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>