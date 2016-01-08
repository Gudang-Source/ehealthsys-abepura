<fieldset class="box">
  <legend class="rim">Tambah Cara Bayar</legend>
    <?php
    $this->breadcrumbs=array(
            'Ppcarabayar Ms'=>array('index'),
            'Create',
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>