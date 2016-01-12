<fieldset class="box">
    <legend class="rim">Tambah Peran Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'Saperanpengguna Ks'=>array('index'),
            'Create',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</fieldset>