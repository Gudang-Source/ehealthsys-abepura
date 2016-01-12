<fieldset class="box">
    <legend class="rim">Ubah Peran Pemakai</legend>
    <?php
    $this->breadcrumbs=array(
            'Saperanpengguna Ks'=>array('index'),
            $model->peranpengguna_id=>array('view','id'=>$model->peranpengguna_id),
            'Update',
    );
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</fieldset>