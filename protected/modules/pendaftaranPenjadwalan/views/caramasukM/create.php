<fieldset class="box">
  <legend class="rim">Tambah Cara Masuk</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppcaramasuk Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>