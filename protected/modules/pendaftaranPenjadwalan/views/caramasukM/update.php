<fieldset class="box">
  <legend class="rim">Ubah Cara Masuk</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppcaramasuk Ms'=>array('index'),
            $model->caramasuk_id=>array('view','id'=>$model->caramasuk_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>