<fieldset class="box">
  <legend class="rim">Tambah Propinsi</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppropinsi Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>