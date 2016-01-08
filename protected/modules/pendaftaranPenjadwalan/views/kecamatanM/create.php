<fieldset class="box">
  <legend class="rim">Tambah Kecamatan</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppkecamatan Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>