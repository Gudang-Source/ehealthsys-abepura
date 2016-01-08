<fieldset class="box">
  <legend class="rim">Tambah Kelurahan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkelurahan Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>