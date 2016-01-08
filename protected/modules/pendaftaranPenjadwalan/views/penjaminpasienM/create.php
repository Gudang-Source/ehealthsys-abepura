<fieldset class="box">
  <legend class="rim">Tambah Penjamin Pasien</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppenjaminpasien Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>