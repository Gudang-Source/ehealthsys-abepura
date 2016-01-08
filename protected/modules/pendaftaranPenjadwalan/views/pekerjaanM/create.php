<fieldset class="box">
  <legend class="rim">Tambah Pekerjaan</legend>
    <?php
    $this->breadcrumbs=array(
            'Pppekerjaan Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>