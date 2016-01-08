<fieldset class="box">
    <legend class="rim">Tambah Akses Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'saaksespengguna Ks'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model,'modPeran'=>$modPeran)); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
</fieldset>