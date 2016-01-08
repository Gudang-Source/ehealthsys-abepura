<fieldset class="box">
  <legend class="rim">Ubah Golongan Umur</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppgolonganumur Ms'=>array('index'),
            $model->golonganumur_id=>array('view','id'=>$model->golonganumur_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>