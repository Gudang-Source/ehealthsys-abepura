<fieldset class="box">
  <legend class="rim">Tambah Golongan Umur</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppgolonganumur Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>