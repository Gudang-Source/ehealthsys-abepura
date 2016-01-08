<fieldset class="box">
    <legend class="rim">Tambah Tugas Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'Satugaspengguna Ks'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
</fieldset>