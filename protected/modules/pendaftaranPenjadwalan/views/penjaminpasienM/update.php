<fieldset class="box">
  <legend class="rim">Ubah Penjamin Pasien</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppenjaminpasien Ms'=>array('index'),
            $model->penjamin_id=>array('view','id'=>$model->penjamin_id),
            'Update',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
</fieldset>