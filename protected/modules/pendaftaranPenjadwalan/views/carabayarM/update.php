<fieldset class="box">
  <legend class="rim">Ubah Cara Bayar</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppcarabayar Ms'=>array('index'),
            $model->carabayar_id=>array('view','id'=>$model->carabayar_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>